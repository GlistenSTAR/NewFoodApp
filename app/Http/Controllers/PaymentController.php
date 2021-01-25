<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\OrdersModel;
use Auth;

class PaymentController extends Controller
{

    public function payment(Request $request){

    	if(!empty($request->user_id))
    	{
    		$user_id = $request->user_id;	
    	}
    	else
    	{
    		$user_id = Auth::user()->id;		
    	}

		$first_day_this_month = date('Y-m-01'); 
		$last_day_this_month  = date('Y-m-t');

		$data['this_month'] = OrdersModel::getSum($first_day_this_month, $last_day_this_month,$user_id);

		$first_day_this_month = date('Y-m-d', strtotime('first day of last month')); 
		$last_day_this_month  = date('Y-m-d', strtotime('last day of last month'));
		$data['last_month'] = OrdersModel::getSum($first_day_this_month, $last_day_this_month,$user_id);
    	
    	$data['user'] = User::find($user_id);

    	return view('admin.payment.list',$data);
    }

}
