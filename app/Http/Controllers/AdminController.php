<?php

namespace App\Http\Controllers;

use App\SettingModel;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller {

	public function dashboard() {
		return view('admin.dashboard');
	}

	// Setting Start
	public function setting() {
	   	$data['setting'] = SettingModel::find(1);
		return view('admin.setting.list', $data);
	}

	public function update_setting(Request $request) {

		$setting = SettingModel::find(1);
		$setting->notification_key = $request->notification_key;
		$setting->admin_email = $request->admin_email;
		
		$setting->save();
    	return redirect()->back()->with('success', 'Setting successfully updated.');
	}

	// Setting End
}