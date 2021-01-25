<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class CustomerController extends Controller
{
    public function customer (Request $request)
    {
        $user = User::orderBy('id', 'desc');

        if(Auth::user()->is_admin == 2) {
            $user = $user->where('restaurant_id', '=', Auth::user()->id);   
        }
        if ($request->id) {
			$user = $user->where('id', 'like', '%' . $request->id . '%');
		}
        if ($request->name) {
			$user = $user->where('name', 'like', '%' . $request->name . '%');
		}
		if ($request->username) {
			$user = $user->where('username', 'like', '%' . $request->username . '%');
		}
		if ($request->email) {
			$user = $user->where('email', 'like', '%' . $request->email . '%');
		}

        if (!empty($request->restaurant_id)) {
            $user = $user->where('restaurant_id', '=', $request->restaurant_id);
        }

        $user = $user->where('is_admin', '=', 0);   
        $user = $user->where('is_delete', '=', 0);   
        $user = $user->paginate(40);
        $data['user'] = $user;

        $data['getrestaurant'] = User::getUser();

        return view('admin.customer.list', $data);
    }

    public function delete($id){
    	if(Auth::user()->is_admin == 2) {
    		$user = User::where('id','=', $id)->where('restaurant_id', '=', Auth::user()->id)->first();
    	}
    	else {
    		$user = User::find($id);	
    	}
		$user->is_delete = 1;
		$user->save();
		return redirect('admin/customer')->with('success', 'Record successfully deleted!');
    }
}
