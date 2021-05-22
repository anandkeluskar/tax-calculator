<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->current_date_time = \Carbon\Carbon::now()->toDateTimeString();
    }

    public function index(){
        $parameters = DB::table('input_parameters')->where('is_active','=','1')->get();

        $parameter_options = DB::table('input_param_options')->where('is_active','=','1')->get();

        $tax_slabs = DB::table('tax_slabs')->where('is_active','=','1')->get();

        return view('admin', ['parameters'=>$parameters, 'parameter_options'=>$parameter_options, 'tax_slabs'=>$tax_slabs]);
    }

    public function add_parameters(Request $request){
        $param_name_key = $request->param_type."_param_name";
        $this->validate($request, [
            'param_type' => 'required|max:255|min:4',
            $param_name_key => 'required|max:255|min:4'
        ]);

        $max_deduct_amt = 0;

        if($request->has('max_deduction_amount')){
            $max_deduct_amt = $request->max_deduction_amount;
        }

        DB::table('input_parameters')->insert([
            'type' => $request->param_type,
            'param_name' => $request->$param_name_key,
            'max_deduct_amt' => $max_deduct_amt,
            'created_at' => $this->current_date_time,
            'created_by' => auth()->user()->id,
            'is_active' => '1'
        ]);

        return back();
    }

    public function update_parameters(Request $request){
        $response = array('status'=>0, 'message'=>'Missing Parameters');

        if(!empty($request->param_id) && !empty($request->param_name)){
            $max_deduct_amt = 0;

            if($request->has('max_deduct_amt')){
                $max_deduct_amt = $request->max_deduct_amt;
            }

            $update_param_query = DB::table('input_parameters')->where('id', $request->param_id)->update(['param_name' => $request->param_name,'max_deduct_amt' => $max_deduct_amt,'updated_at' => $this->current_date_time]);

            if($update_param_query){
                $response = array('status'=>1, 'message'=>'Parameter updated successfully');
            } else {
                $response = array('status'=>1, 'message'=>'unable to update parameter');
            }
        }

        return response()->json($response);
    }

    public function add_parameter_option(Request $request){
        $response = array('status'=>0, 'message'=>'Missing Parameters');
        
        if(!empty($request->param_id) && !empty($request->option)){
            DB::table('input_param_options')->insert([
                'param_id' => $request->param_id,
                'option_value' => $request->option,
                'created_at' => $this->current_date_time,
                'is_active' => '1'
            ]);

            $response = array('status'=>1, 'message'=>'Option added successfully');
        }

        return response()->json($response);
    }

    public function add_tax_slabs(Request $request){
        $this->validate($request, [
            'min_amount' => 'required|number',
            'max_amount' => 'required|number|gt:min_amount',
            'tax_percent' => 'required|number',
        ]);

        DB::table('tax_slabs')->insert([
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'tax_percent' => $request->tax_percent,
            'created_at' => $this->current_date_time,
            'is_active' => '1'
        ]);

        return back();
    }

    public function update_tax_slabs(Request $request){
        $response = array('status'=>0, 'message'=>'Missing Parameters');

        if(isset($request->slab_min) && isset($request->slab_percent) && !empty($request->slab_max) && !empty($request->slab_id)){
            $update_slab_query = DB::table('tax_slabs')->where('id', $request->slab_id)->update(['min_amount' => $request->slab_min,'max_amount' => $request->slab_max,'tax_percent' => $request->slab_percent,'updated_at' => $this->current_date_time]);

            if($update_slab_query){
                $response = array('status'=>1, 'message'=>'Tax slab updated successfully');
            } else {
                $response = array('status'=>1, 'message'=>'unable to update tax slab');
            }
        }

        return response()->json($response);
    }
}
