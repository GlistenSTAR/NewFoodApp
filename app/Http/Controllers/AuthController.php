<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
	public function adminlogin() {
		// dd(\Hash::make('123456'));
		if (Auth::check()) {
			return redirect('admin/dashboard');
		}
		return view('admin.auth.login');
	}

	public function adminPostlogin(Request $request) {
		if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'is_delete' => '0'], true)) {
			if(empty(Auth::user()->status))
			{	
				if(Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
				{
					return redirect()->intended('admin/dashboard');		
				}
				else
				{
					Auth::logout();
					return redirect()->back()->with('error', 'Please enter the correct credentials');	
				}
			}
			else
			{
				Auth::logout();
				return redirect()->back()->with('error', 'Please enter the correct credentials');	
			}
		} else {
			return redirect()->back()->with('error', 'Please enter the correct credentials');
		}
	}

	// Auth logout
	public function adminlogout() {
		Auth::logout();
		return redirect(url(''));
	}

		

	// public function clientlogin(Request $req) {
	// 	// return view('client.login');
	// 	$user = $req->userN;
	// 	$pass = $req->userP;
	// 	// print_r($user);die;
	// 	// $temp = Hash::make('Sharky1989!');//JxvfsOYlPQO4AdF8ErFVJY14aXoaJi9fmTHHtEQ80wOk7tFNl5Br3W8804mr
	// 	if(Auth::attempt(['username' => $user, 'password' => $pass, 'is_delete' => '0'])){
	// 		if(empty(Auth::user()->status)){	
	// 			if(Auth::user()->is_admin == 0)
	// 			{
	// 				$req->session()->put('userid', Auth::user()->id);
	// 				return redirect()->back();		
	// 			}
	// 			else
	// 			{
	// 				Auth::logout();
	// 				return redirect()->back()->with('error', 'You are not our user');	
	// 			}
	// 		}
	// 		else
	// 		{
	// 			Auth::logout();
	// 			return redirect()->back()->with('error', 'You are not our user');	
	// 		}
	// 	} 
	// 	else
	// 	{
	// 		Auth::logout();
	// 		return redirect()->back()->with('error', 'Username or password incorrect.');	
	// 	}
	// } 
		
}
