<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use File;
use Hash;
class UserController extends Controller
{
    public function myaccount() {
    	$data['user'] = User::find(Auth::user()->id);
		return view('admin.myaccount.list', $data);
    }

    public function update(Request $request) {
    	$user = User::find(Auth::user()->id);
		
		if(!empty($request->file('logo')))
		{
			if(!empty($user->logo) && file_exists('upload/logo/'. $user->logo))
	        {
	          	unlink('upload/logo/'. $user->logo);
	        }
	        
			$ext = 'jpg';
			$file = $request->file('logo');
			$randomStr = str_random(30);
			$filename = strtolower($randomStr) . '.' . $ext;
			$file->move('upload/logo/', $filename);
			$user->logo = $filename;
		}
		
		if(!empty($request->password))
		{
			$user->password = Hash::make($request->password);	
		}
		
		$user->email 		= trim($request->email);
		$user->name 		= $request->name;
		$user->phone 		= $request->phone;
		$user->address_one 	= $request->address_one;
		$user->address_two 	= $request->address_two;
		$user->city 		= $request->city;
		$user->postcode 	= $request->postcode;

		if(!empty($request->stripe_publishable_key))
		{
			$user->stripe_publishable_key = trim($request->stripe_publishable_key);	
		}
		if(!empty($request->stripe_secret_key))
		{
			$user->stripe_secret_key = trim($request->stripe_secret_key);	
		}
		
		$user->save();

		return redirect('admin/myaccount')->with('success', 'Account successfully updated!');
    }

    
}
