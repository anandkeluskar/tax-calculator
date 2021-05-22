<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $payer_requests = DB::table('payer_requests')->where([['user_id','=',auth()->user()->id],['is_active','=','1']])->get();

        return view('dashboard', ['payer_requests'=>$payer_requests]);
    }

    public function view_tax_request($ref_no, Request $request){
        $tax_details = DB::table('payer_requests')
        ->join('payer_income_tax_details', 'payer_income_tax_details.request_id', '=', 'payer_requests.id')
        ->where([['payer_requests.reference_no', '=', $ref_no],['payer_requests.user_id', '=', auth()->user()->id],['payer_requests.is_active', '=', '1']])
        ->select('payer_requests.created_at', 'payer_income_tax_details.parameter', 'payer_income_tax_details.value')
        ->get();

        return view('view-tax', ['ref_no'=>$ref_no, 'tax_details'=>$tax_details]);
    }
}
