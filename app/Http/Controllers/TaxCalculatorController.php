<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxCalculatorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->current_date_time = \Carbon\Carbon::now()->toDateTimeString();
    }

    public function index(){
        $general_parameters = array();

        $general_params_query = DB::table('input_parameters')
        ->join('input_param_options', 'input_param_options.param_id', '=', 'input_parameters.id')
        ->where([['input_parameters.is_active','=','1'],['input_parameters.type','=','general'],['input_param_options.is_active','=','1']])
        ->select('input_parameters.id as param_id', 'input_parameters.param_name', 'input_param_options.option_value')
        ->get();

        foreach($general_params_query as $params){
            $general_parameters[$params->param_id]['id'] = $params->param_id;
            $general_parameters[$params->param_id]['param_name'] = $params->param_name;
            $general_parameters[$params->param_id]['options'][] = $params->option_value;
        }

        $income_parameters = DB::table('input_parameters')->where([['is_active','=','1'],['type','=','income']])->get();

        $deduction_parameters = DB::table('input_parameters')->where([['is_active','=','1'],['type','=','deduction']])->get();

        return view('calculate-tax', ['general_parameters'=>$general_parameters,'income_parameters'=>$income_parameters,'deduction_parameters'=>$deduction_parameters]);
    }

    public function calculate_tax(Request $request){
        $all_request_params = $request->all();
        unset($all_request_params['_token']);
        $filtered_request_params = $param_ids = $tax_insert_array = array();
        $total_income = $total_deduction = $income_after_deduction = $total_tax = 0;
        
        foreach($all_request_params as $key => $value){
            $temp1 = explode('_', $key);
            $param_ids[] = (int)$temp1[1];
            $filtered_request_params[$temp1[1]] = (!empty($value)) ? $value : 0;
        }

        $reference_no = time().auth()->user()->id;

        $request_id = DB::table('payer_requests')->insertGetId([
            'user_id' => auth()->user()->id,
            'reference_no' => $reference_no,
            'created_at' => $this->current_date_time,
            'is_active' => '1'
        ]);

        if($request_id){
            $db_params = DB::table('input_parameters')->whereIn('id', $param_ids)->get();

            foreach($db_params as $row){
                $tax_insert_array[] = array('request_id'=>$request_id, 'parameter'=>$row->param_name, 'value'=>$filtered_request_params[$row->id], 'created_at' => $this->current_date_time, 'is_active' => '1');

                if($row->type == 'income'){
                    $total_income += (float)$filtered_request_params[$row->id];
                }

                if($row->type == 'deduction'){
                    if((float)$filtered_request_params[$row->id] > 0){
                        if((float)$filtered_request_params[$row->id] > (float)$row->max_deduct_amt){
                            $total_deduction += (float)$row->max_deduct_amt;
                        } else {
                            $total_deduction += (float)$filtered_request_params[$row->id];
                        }
                    }
                }
            }

            $income_after_deduction = (float)$total_income - (float)$total_deduction;

            $tax_insert_array[] = array('request_id'=>$request_id, 'parameter'=>'Total Income', 'value'=>(float)$total_income, 'created_at' => $this->current_date_time, 'is_active' => '1');

            $tax_insert_array[] = array('request_id'=>$request_id, 'parameter'=>'Total Deduction', 'value'=>(float)$total_deduction, 'created_at' => $this->current_date_time, 'is_active' => '1');

            $tax_insert_array[] = array('request_id'=>$request_id, 'parameter'=>'Total Income After Deduction', 'value'=>(float)$income_after_deduction, 'created_at' => $this->current_date_time, 'is_active' => '1');

            $tax_slabs = DB::table('tax_slabs')->where('is_active', '=', '1')->orderBy('min_amount')->get();

            $previous_max_amt = 0;
            $remaining_income = $income_after_deduction;

            foreach($tax_slabs as $slab){
                if((float)$income_after_deduction > (float)$slab->max_amount){
                    $taxable_amount = (float)$slab->max_amount - (float)$previous_max_amt;
                    $remaining_income = (float)$remaining_income - (float)$taxable_amount;
                    $total_tax += (float)$slab->tax_percent * ((float)$taxable_amount / 100);
                } else {
                    $total_tax += (float)$slab->tax_percent * ((float)$remaining_income / 100);

                    break;
                }
                $previous_max_amt = (float)$slab->max_amount;
            }

            $tax_insert_array[] = array('request_id'=>$request_id, 'parameter'=>'Total Tax', 'value'=>(float)$total_tax, 'created_at' => $this->current_date_time, 'is_active' => '1');

            DB::table('payer_income_tax_details')->insert($tax_insert_array);
        } else {
            return back()->with(['status'=>'Unable to calculate tax']);
        }

        return redirect('/dashboard/request/'.$reference_no);
    }
}
