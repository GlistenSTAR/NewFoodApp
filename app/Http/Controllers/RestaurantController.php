<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\User;
use App\UserTimeModel;
use App\SettingModel;
use App\UserPostcodeModel;

use App\PageModel;
use File;
use Auth;
use Hash;
use App\PackageModel;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function restaurant(Request $request) {

		$user = User::orderBy('id', 'desc')->whereIn('is_admin',  array('1','2'))->where('is_delete','=',0);
		if ($request->id) {
			$user = $user->where('id', '=', $request->id);
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
		$user = $user->paginate(40);
		$data['user'] = $user;
		return view('admin.restaurant.list', $data);
	}
	
	public function AddRestaurant() {
		$data['package_row'] = PackageModel::get();
		return view('admin.restaurant.add', $data);
	}
	
	public function InsertRestaurant(UserRequest $request) {
		
		$user = new User;

		if (!empty($request->file('logo')))
	    {
	       		$ext = 'jpg';
	  			$file = $request->file('logo');
	  			$randomStr = str_random(30);
	  			$filename = strtolower($randomStr) . '.' . $ext;
	  			$file->move('upload/logo/', $filename);
	  			$user->logo = $filename;
	    }

		
		$user->password = Hash::make($request->password);
		$user->email = $request->email;
		$user->package_id = $request->package_id;
		$user->name = $request->name;
		$user->phone = $request->phone;
		$user->radius_miles = $request->radius_miles;
		$user->delivery_charge = $request->delivery_charge;
		$user->address_one = $request->address_one;
		$user->address_two = $request->address_two;
		$user->city = $request->city;
		$user->postcode = $request->postcode;
		$user->mobile_code = $request->mobile_code;
		$user->status = $request->status;
		$user->is_admin = $request->is_admin;
		$user->version_android = $request->version_android;
		$user->version_ios = $request->version_ios;

		$user->is_version_ios = !empty($request->is_version_ios)?1:0;
		$user->is_age = !empty($request->is_age)?1:0;
		$user->is_collection = !empty($request->is_collection)?1:0;
		$user->is_partner = !empty($request->is_partner)?1:0;
		$user->before_delivery_charge = $request->before_delivery_charge;

		$user->username = strtolower($request->username);
		$user->save();

		$update_user = User::find($user->id);
		$update_user->restaurant_id = $user->id;
		$update_user->save();

		$setting = new SettingModel;
		$setting->restaurant_id = $user->id;
		$setting->save();



		// $array = array('about','terms','privacy');

		// foreach ($array as $value) {
		// 	$page = new PageModel;
		// 	$page->restaurant_id = $user->id;
		// 	$page->slug = $value;
		// 	$page->name = $value;
		// 	$page->save();
		// }


		return redirect('admin/restaurant')->with('success', 'Restaurant created Successfully!');
	}

	public function editrestaurant($id) {
		$data['package_row'] = PackageModel::get();
		$data['user'] = User::find($id);
		return view('admin.restaurant.edit', $data);
	}

	public function UpdateRestaurant($id, Request $request) {
		$user = User::find($id);
		if (!empty($request->password)) {
			$user->password = Hash::make($request->password);
		}

	if (!empty($request->file('logo')))
      {
        if(!empty($user->logo) && file_exists('upload/logo/' . '/' . $user->logo))
        {
          unlink('upload/logo/' . '/' . $user->logo);
        }
        $ext = 'jpg';
  			$file = $request->file('logo');
  			$randomStr = str_random(30);
  			$filename = strtolower($randomStr) . '.' . $ext;
  			$file->move('upload/logo/', $filename);
  			$user->logo = $filename;
      }

  		$user->name 		= $request->name;
		$user->phone 		= $request->phone;
		$user->mobile_code 	= $request->mobile_code;
		$user->address_one  = $request->address_one;
		$user->address_two  = $request->address_two;
		$user->city 		= $request->city;
		$user->postcode 	= $request->postcode;


		$user->name = $request->name;
		$user->email = $request->email;
		$user->radius_miles = $request->radius_miles;
		$user->delivery_charge = $request->delivery_charge;
		$user->package_id = $request->package_id;
		$user->is_admin = $request->is_admin;
		$user->status = $request->status;
		$user->version_android = $request->version_android;
		$user->version_ios = $request->version_ios;
		$user->is_version_ios = !empty($request->is_version_ios)?1:0;
		$user->is_partner = !empty($request->is_partner)?1:0;
		$user->is_age = !empty($request->is_age)?1:0;
		$user->is_collection = !empty($request->is_collection)?1:0;
		$user->before_delivery_charge = $request->before_delivery_charge;

		
		if(!empty($request->stripe_publishable_key))
		{
			$user->stripe_publishable_key = trim($request->stripe_publishable_key);	
		}
		if(!empty($request->stripe_secret_key))
		{
			$user->stripe_secret_key = trim($request->stripe_secret_key);	
		}
		$user->save();
		return redirect('admin/restaurant')->with('success', 'Record updated Successfully!');

	}

	public function deleterestaurant($id) {
		$user = User::find($id);
		$user->is_delete = 1;
		$user->save();
		return redirect('admin/restaurant')->with('success', 'Record successfully deleted!');
	}

	
	public function showrestaurant($id) {
		$data['user'] = User::find($id);
		return view('admin.restaurant.view', $data);
	}


	public function postcodes($id, Request $request)
	{
		$data['user'] = User::find($id);
		$data['getPostcode'] = UserPostcodeModel::get_record($id);
		return view('admin.restaurant.postcodes', $data);	
	}

	public function edit_postcode($id)
	{
		$data['getPostcode'] = UserPostcodeModel::get_single($id);
		return view('admin.restaurant.edit_postcodes', $data);	
	}


	public function submit_postcode(Request $request)
	{
		$postcode = new UserPostcodeModel;
		$postcode->user_id = $request->user_id;
		$postcode->name    = $request->name;
		$postcode->save();
		return redirect()->back()->with('success', 'Postcode successfully created.');
	}

	public function update_postcode($id, Request $request)
	{
		$postcode = UserPostcodeModel::get_single($id);;
		$postcode->name    = $request->name;
		$postcode->save();

		return redirect('admin/restaurant/postcodes/'.$postcode->user_id)->with('success', 'Postcode successfully updated.');
	}

	public function delete_postcode($id)
	{
		$postcode = UserPostcodeModel::get_single($id);
		$postcode->is_delete = 1;
		$postcode->save();
		return redirect()->back()->with('success', 'Postcode successfully deleted.');
	}


	public function partner_list($restaurant_id)
	{
		$data['restaurant_id'] = $restaurant_id;
		$getrecord = User::orderBy('id', 'desc')->where('restaurant_id','=',$restaurant_id)->where('is_delete','=',0)->where('is_admin','=',3);
    	$getrecord = $getrecord->paginate(40);
		$data['user'] = $getrecord;
		return view('admin.restaurant.partner_list', $data);

	}

	public function partner_add()
	{
		return view('admin.restaurant.partner_add');
	}

	public function partner_insert($restaurant_id, Request $request)
	{
		$user = request()->validate([
			'name'		    => 'required',
			'email'			=> 'required',
			'password'		=> 'required',
			'phone'			=> 'required|unique:users',
			'username'		=> 'required|unique:users',
		]);

		$user = new User;
        
        $user->restaurant_id      = $restaurant_id;
        $user->name = $request->name;
		

		if (!empty($request->file('logo')))
	    {
       		$ext = 'jpg';
  			$file = $request->file('logo');
  			$randomStr = str_random(30);
  			$filename = strtolower($randomStr) . '.' . $ext;
  			$file->move('upload/logo/', $filename);
  			$user->logo = $filename;
	    }

		$user->phone = $request->phone;
		$user->username = strtolower($request->username);
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->status = $request->status;
		$user->is_admin = 3;
		
		$user->save();

		return redirect('admin/restaurant/partner/'.$restaurant_id)->with('success',"Partner successfully save."); 
	}

	public function partner_edit($id)
	{
		$getrecord = User::find($id);
		$data['user'] = $getrecord;
		return view('admin.restaurant.partner_edit', $data);
	}


	public function partner_update($id, Request $request)
	{
		//dd(request()->all());

		$user = User::find($id);
		if (!empty($request->password)) {
			$user->password = Hash::make($request->password);
		}

	    if (!empty($request->file('logo')))
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

  		$user->name 		= $request->name;
		$user->phone 		= $request->phone;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->status = $request->status;
	
		$user->save();
		return redirect('admin/restaurant/partner/'.$user->restaurant_id)->with('success', 'Record updated Successfully!');

	}

	public function delete_partner($id)
    {
    	$user = User::find($id);
		$user->is_delete = 1;
		$user->save();
		return redirect()->back()->with('success',"Record successfully deleted!");
    }


}


