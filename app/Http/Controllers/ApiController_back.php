<?php

namespace App\Http\Controllers;

use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\CategoryModel;
use App\ItemModel;
use App\PageModel;
use App\CartModel;
use App\OrdersModel;
use App\OrdersItemModel;
use App\WeekModel;
use App\ItemoptionModel;
use App\DiscountcodeModel;
use App\UserTimeModel;
use App\OrderStatusModel;
use App\DiscountCategoryModel;
use App\UserAgeIdModel;
use App\UserPostcodeModel;



use App\SettingModel;
use App\Mail\ForgotPasswordMail;
use Stripe\Stripe;


class ApiController extends Controller {
	
	public $restaurant_id;
	public $token;

	public function __construct(Request $request) {
		$this->restaurant_id = !empty($request->header('restaurantid'))?$request->header('restaurantid'):'';
		$this->token = !empty($request->header('token'))?$request->header('token'):'';
	}

	public function Login(Request $request) {
		
		if (!empty($this->restaurant_id) && !empty($request->phone) && !empty($request->password)) {
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{

				$user = User::where('phone', '=', $request->phone)
					->where('status', '=', '0')
					->where('is_delete', '=', '0')
					->where('restaurant_id', '=', $this->restaurant_id)
					->first();


				if (!empty($user)) {
					$check = Hash::check($request->password, $user->password);
					if (!empty($check)) {

						if(!empty($request->device_token))
						{
							$datauser = User::find($user->id);	
							$datauser->token = $request->device_token;
							$datauser->save();
						}

						$this->updateToken($user->id);

						$json['status'] = true;
						$json['message'] = 'Record found.';
						$json['result'] = $this->getProfileUser($user->id);
					} else {
						$json['status'] = false;
						$json['message'] = 'Your username or password is incorrect please try again.';
					}
				} else {
					$json['status'] = false;
					$json['message'] = 'Your username or password is incorrect please try again.';
				}
			}
			else {
				
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}

		} else {

			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}

	public function Register(Request $request) {
		if (!empty($this->restaurant_id) && !empty($request->phone) && !empty($request->phone) && !empty($request->password)) {
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$checkemail = User::where('phone', '=', trim($request->phone))->where('restaurant_id', '=', $this->restaurant_id)->count();
				if ($checkemail == '0') {
					$record = new User;
					$record->restaurant_id = trim($this->restaurant_id);
					$record->username = trim(strtolower($request->username));
					$record->phone = trim($request->phone);
					$record->email = trim($request->email);
					$record->password = Hash::make($request->password);
					$record->token = !empty($request->device_token)?$request->device_token:null;
					$record->save();

					$this->updateToken($record->id);

					$json['status'] = true;
					$json['message'] = 'Account Successfully created.';
					$json['result'] = $this->getProfileUser($record->id);
				} else {
					$json['status'] = false;
					$json['message'] = 'Your mobile number already exist please login or try again.';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	public function mobile_check(Request $request) {	
		if(!empty($request->phone)) {
			$checkmobile = User::where('phone', '=', $request->phone)->where('restaurant_id', '=', $this->restaurant_id)->count();
			if($checkmobile == '0') {
				$json['status'] = true;
				$json['message'] = 'Success';
			}
			else {
				$json['status'] = false;
				$json['message'] = 'Your mobile number already exist please login or try again.';
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Parameter missing!';
		}
		echo json_encode($json);
	}

	public function check_forgot_password(Request $request) {
		if(!empty($request->phone)) {
			$checkmobile = User::where('phone', '=', $request->phone)->where('restaurant_id', '=', $this->restaurant_id)->count();
			if($checkmobile > 0) {
				$json['status'] = true;
				$json['message'] = 'Success';
			}
			else {
				$json['status'] = false;
				$json['message'] = 'Mobile number not found.';
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Parameter missing!';
		}
		echo json_encode($json);
	}


	public function forgotpassword(Request $request) {
		if (!empty($request->phone) && !empty($this->restaurant_id) && !empty($request->password)) {
			$user = User::where('phone', '=', trim($request->phone))->where('restaurant_id','=',$this->restaurant_id)->first();
			if (!empty($user)) {

				$user->password = Hash::make($request->password);
				$user->is_delete = 0;
				$user->save();

				$json['status'] = true;
				$json['message'] = 'Password successfully change.';

			} else {
				$json['status'] = false;
				$json['message'] = 'Mobile number not found!';
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}



	public function checkRestaurant($restaurant_id)
	{
		$json = array();
		$checkRestaurant = User::where('id', '=', trim($restaurant_id))->count();
		if(!empty($checkRestaurant))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function checkToken()
	{
		$checkToken = User::where('restaurant_id', '=', trim($this->restaurant_id))->where('user_token', '=', trim($this->token))->first();
		if(!empty($checkToken))
		{
			return $checkToken->id;
		}
		else
		{
			return 0;
		}
	}

	public function updateToken($user_id)
	{
		$randomStr = str_random(40).$user_id;
		$save_token = User::find($user_id);
		$save_token->user_token = $randomStr;
		$save_token->save();
	}
	
	
	public function getProfileUser($id) {

		$user = User::find($id);
		$json['id'] 	= $user->id;
		$json['restaurant_id'] = !empty($user->restaurant_id) ? $user->restaurant_id : '';
		$json['name'] = !empty($user->name) ? $user->name : '';
		$json['email'] = !empty($user->email) ? $user->email : '';
		$json['username'] = !empty($user->username) ? $user->username : '';
		$json['address_one'] = !empty($user->address_one) ? $user->address_one : '';
		$json['address_two'] = !empty($user->address_two) ? $user->address_two : '';
		$json['city'] = !empty($user->city) ? $user->city : '';

		$json['postcode'] = !empty($user->postcode) ? $user->postcode : '';
		$json['half_postcode'] = !empty($user->half_postcode) ? $user->half_postcode : '';
		$json['postcode_id'] = !empty($user->postcode_id) ? intval($user->postcode_id) : 0;

		$json['phone'] = !empty($user->phone) ? $user->phone : '';
		$json['mobile_code'] = !empty($user->mobile_code) ? $user->mobile_code : '';
		$json['user_type'] = $user->is_admin;
		$json['token'] = !empty($user->user_token) ? $user->user_token : '';
		$json['stripe_publishable_key'] = !empty($user->stripe_publishable_key) ? $user->stripe_publishable_key : '';
		$json['version_android'] 	  = !empty($user->version_android) ? $user->version_android : '';
		$json['version_ios'] 		  = !empty($user->version_ios) ? $user->version_ios : '';
		$json['version_ios_active']   = $user->is_version_ios;		
		$json['is_collection']        = !empty($user->is_collection) ? $user->is_collection : 0;
		$json['is_age']   		 	  = !empty($user->is_age) ? $user->is_age : 0;		
		$json['is_age']   		 	  = !empty($user->is_age) ? $user->is_age : 0;		


		// $json['stripe_secret_key'] = !empty($user->stripe_secret_key) ? $user->stripe_secret_key : '';

		if (!empty($user->logo)) 
		{
			$json['logo'] = url('upload/logo/' . $user->logo);
		} else 
		{
			$json['logo'] = '';
		}

		return $json;
	}

	public function getRestaurant(Request $request) {
		if (!empty($this->restaurant_id)) {
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$json['status'] = true;
				$json['message'] = 'Record found.';


				$about = $this->getProfileUser($this->restaurant_id);
				$json['version_android'] = $about['version_android'];				
				$json['version_ios']     = $about['version_ios'];		
				$json['version_ios_active']   = !empty($about['version_ios_active']) ? true : false;		
						

				$subjson['about'] = $about;


				$getWeek = WeekModel::get();


				$week = array();

				foreach ($getWeek as $value) {
					$getuserweek =  UserTimeModel::getDetailAPI($value->id,$this->restaurant_id);
	                $open_close = !empty($getuserweek->status)?$getuserweek->status:'0';
	                $start_time = !empty($getuserweek->start_time)?$getuserweek->start_time:'';
	                $end_time = !empty($getuserweek->end_time)?$getuserweek->end_time:'';

					$data['weekname'] = $value->name;
					$data['start_time'] = $start_time;
					$data['end_time'] = $end_time;
					$data['open_close'] = !empty($open_close)?'Open':'Closed';
					$week[] = $data;
				}

				$subjson['week'] = $week;



				$week_object = array();

				foreach ($getWeek as $value) {

					$getuserweek 	=  UserTimeModel::getDetailAPI($value->id,$this->restaurant_id);
	                $open_close 	= !empty($getuserweek->status)?$getuserweek->status:'0';
	                $start_time 	= !empty($getuserweek->start_time)?$getuserweek->start_time:'';
	                $end_time 		= !empty($getuserweek->end_time)?$getuserweek->end_time:'';

					$data_week['weekname'] 		= $value->name;
					$data_week['start_time'] 	= $start_time;
					$data_week['end_time'] 		= $end_time;
					$data_week['open_close']	= !empty($open_close)?'Open':'Closed';

					$week_object[$value->name] 	= $data_week;					

				}

				$subjson['week_object'] = $week_object;


				$getreview = OrdersModel::where('review', '!=', '')->where('is_review', '=', 1)->where('restaurant_id', '=', $this->restaurant_id)->orderBy('id','desc')->limit(5)->get();

				$result_review = array();
					
				foreach ($getreview as $valuer) {
					$datar['name'] 		= $valuer->name;
					$datar['id'] 		= $valuer->id;
					$datar['rating'] 	= $valuer->rating;
					$datar['review'] 	= $valuer->review;
					$datar['timestamp']  = strtotime($valuer->updated_at);
					$result_review[] = $datar;
				}

				$subjson['review'] = $result_review;


				$postcode_array = array();
				$getPostcode = UserPostcodeModel::get_record_app($this->restaurant_id);
				foreach ($getPostcode as $value_post) {
					$data_post = array();
					$data_post['id'] = $value_post->id;
					$data_post['name'] = $value_post->name;
					$postcode_array[] = $data_post;
				}

				$subjson['postcode'] = $postcode_array;

				$json['status'] = true;
				$json['message'] = 'Record found';
				$json['result'] = $subjson;

			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}


		$user_id = $this->checkToken();

		if(!empty($user_id)) {
			$json['total_qty'] = $this->getCountCart($user_id);
		}
		else {
			$json['total_qty'] = 0;
		}
		echo json_encode($json);
	}


	public function getProfile(Request $request) {
		if (!empty($this->token) && !empty($this->restaurant_id)) {
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$user = User::where('id','=',$user_id)->where('restaurant_id','=',$this->restaurant_id)->count();

				if (!empty($user)) {
					$json['status'] = true;
					$json['message'] = 'Record found.';
					$json['result'] = $this->getProfileUser($user_id);

				} else {
					$json['status'] = false;
					$json['message'] = 'Record not found.';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}

	public function app_age_id_upload(Request $request)
	{
		if (!empty($request->file('logo')) && !empty($this->restaurant_id)) {
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$user = User::where('id','=',$user_id)->where('restaurant_id','=',$this->restaurant_id)->first();
				if (!empty($user))
				{

					$delete = UserAgeIdModel::where('user_id','=',$user_id)->get();
					foreach ($delete as $key => $value) {

						if(!empty($value->logo))
						{
							unlink('upload/age/'.$value->logo);	
						}

						$value->delete();
					}


					$New_ID = new UserAgeIdModel;

						$ext = 'jpg';
						$file = $request->file('logo');
						$randomStr = str_random(30);
						$filename = $randomStr . '.' . $ext;
						$file->move('upload/age/', $filename);


					$New_ID->user_id 		= $user_id;	
					$New_ID->restaurant_id 	= $this->restaurant_id;
					$New_ID->logo = $filename;
					$New_ID->save();

					$title = 'Age 18 + ID';
					$message = 'New Customer uploaded 18 + ID';
					$this->sendPushNotificationCutsomer($title,$message,$this->restaurant_id);

					$json['status'] = true;
					$json['message'] = 'ID successfully uploaded.';
					$json['result'] = $this->get_age_id($New_ID->id);
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Token expire.';
					$json['code'] = 400;
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Due to some error please try again!';
			}
		}
		else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);

	}

	public function app_get_age_id_restaurant_list(Request $require)
	{
		
		if(!empty($this->restaurant_id) && !empty($this->token))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{	
				$result = array();
				$getdata = UserAgeIdModel::orderBy('id','desc')->where('restaurant_id','=',$this->restaurant_id)->paginate(20);
				foreach ($getdata as  $value) {
					$data = array();
					$data = $this->get_age_id($value->id);
					$result[] = $data;
				}

				$page = 0;
				if(!empty($getdata->nextPageUrl()))
	            {
		              $parse_url =parse_url($getdata->nextPageUrl()); 
		              if(!empty($parse_url['query']))
		              {
		                   parse_str($parse_url['query'], $get_array);     
		                   $page = !empty($get_array['page']) ? $get_array['page'] : 0;
		              }
	     	    }

	     	    $json['page'] = intval($page);


				$json['status'] = true;
				$json['message'] = 'Success';
				$json['result'] = $result;
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}

	public function app_update_status_age_id(Request $request)
	{
		if(!empty($request->status) && !empty($request->id))
		{	
			$user_id 		 = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$message = 'Your ID has been approved.';
				$value = UserAgeIdModel::find($request->id);
				$value->status = $request->status;
				if($value->status == 3)
				{
					$value->reason = !empty($request->reason) ? $request->reason : '';
					$message = 'Your ID has been rejected please upload again.';
				}
				$value->save();


				$title = 'Age 18 + ID';
				
				$this->sendPushNotificationCutsomer($title,$message,$value->user_id);

				$json['status'] = true;
				$json['message'] = 'Success';
				$json['result'] = $this->get_age_id($value->id);
			}
			else
			{
				$json['status']  = false;
				$json['message'] = 'Token expire.';
				$json['code'] 	 = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';	
		}

		echo json_encode($json);
	}

	public function get_age_id($id)
	{
		$value = UserAgeIdModel::find($id);
		$json['id'] = $value->id;
		$json['name'] = $value->user->name;
		$json['reason'] = !empty($value->reason) ? $value->reason : '';
		$json['logo'] = $value->getLogo();
		$json['status'] = $value->status;
		$json['status_name'] = $value->getstatus->name;
		$json['timestamp'] = strtotime($value->created_at);
		return $json;
	}

	public function app_get_age_id()
	{
	
		$user_id 		 = $this->checkToken();
		$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
		if(!empty($checkRestaurant) && !empty($user_id))
		{
			$UserAgeId = UserAgeIdModel::where('restaurant_id','=',$this->restaurant_id)
									->where('user_id','=',$user_id)
									->first();
			if(!empty($UserAgeId))
			{
				$json['status'] = true;
				$json['message'] = 'Success';
				$json['result'] = $this->get_age_id($UserAgeId->id);	
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'ID not found';
			}
		}
		else
		{
			$json['status']  = false;
			$json['message'] = 'Token expire.';
			$json['code'] 	 = 400;
		}
	

		echo json_encode($json);
	}

	public function UpdateImage(Request $request) {

		if (!empty($request->file('logo')) && !empty($this->restaurant_id)) {
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$user = User::where('id','=',$user_id)->where('restaurant_id','=',$this->restaurant_id)->first();
				if (!empty($user))
				{
				  	if(!empty($user->logo) && file_exists('upload/logo/' .  $user->logo))
				    {
			            unlink('upload/logo/' . $user->logo);
			        }

					$ext = 'jpg';
					$file = $request->file('logo');
					$randomStr = str_random(30);
					$filename = strtolower($randomStr) . '.' . $ext;
					$file->move('upload/logo/', $filename);
					$user->logo = $filename;
					$user->save();

					$json['status'] = true;
					$json['message'] = 'Profile successfully updated.';
					$json['result'] = $this->getProfileUser($user_id);
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Token expire.';
					$json['code'] = 400;
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Due to some error please try again!';
			}
		}
		else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}

	public function UpdateProfile(Request $request) {

		if (!empty($request->name) && !empty($this->restaurant_id)) {
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$user = User::where('id','=',$user_id)->where('restaurant_id','=',$this->restaurant_id)->first();
				if (!empty($user))
				{

					if (!empty($request->file('logo')))
					{
					    if(!empty($user->logo) && file_exists('upload/logo/' .  $user->logo))
				        {
				          unlink('upload/logo/' . $user->logo);
				        }

						$ext = 'jpg';
						$file = $request->file('logo');
						$randomStr = str_random(30);
						$filename = strtolower($randomStr) . '.' . $ext;
						$file->move('upload/logo/', $filename);
						$user->logo = $filename;
					}

					$user->email = $request->email;
					$user->name = $request->name;
					$user->phone = $request->phone;
					$user->address_one = $request->address_one;
					$user->address_two = $request->address_two;
					$user->city = $request->city;
					$user->postcode = $request->postcode;
					$user->half_postcode = !empty($request->half_postcode) ? $request->half_postcode : '';
					$user->postcode_id = !empty($request->postcode_id) ? $request->postcode_id : '';
					$user->save();

					$json['status'] = true;
					$json['message'] = 'Profile successfully updated.';
					$json['result'] = $this->getProfileUser($user_id);
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Due to some error please try again!';
				}
			}
			else {

				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}


	public function updatepassword(Request $request) {
		if (!empty($this->restaurant_id) && !empty($request->new_password) && !empty($request->old_password)) {

			$user_id = $this->checkToken();

			$user = User::where('id','=',$user_id)->where('restaurant_id','=',$this->restaurant_id)->first();

			

			if (!empty($user) && !empty($user_id)) {
				$check = Hash::check($request->old_password, $user->password);
				if (!empty($check)) {

					$user->password = Hash::make($request->new_password);
					$user->save();

					$json['status'] = true;
					$json['message'] = 'Password successfully updated.';

				} else {
					$json['status'] = false;
					$json['message'] = 'Old password wrong.';
				}
			} else {
				$json['status'] = false;
				$json['message'] = 'Due to some error please try again!';
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}


	// update cart

	public function add_cart_update(Request $request){
		if (!empty($this->restaurant_id) && !empty($request->item_id) && !empty($this->token) && !empty($request->qty)) 
		{

			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			$user_id = $this->checkToken();

			if (!empty($checkRestaurant) && !empty($user_id)) 
			{
				$status = 0;

				$item = ItemModel::find($request->item_id);
				if(!empty($item->getcategory->is_age))
				{
					$UserAgeId = UserAgeIdModel::where('restaurant_id','=',$this->restaurant_id)
									->where('user_id','=',$user_id)
									->where('status','=',2)
									->count();

					if(empty($UserAgeId))
					{
						$status = 1;
					}
				}

				if(empty($status))
				{
					// $chcek_cart = CartModel::where('user_id','=',$user_id)->where('item_id','=',$request->item_id)->first();
					if(!empty($request->cart_id))
					{
						$cart = CartModel::find($request->cart_id);
						if(empty($cart))
						{
							$cart = new CartModel;			
						}
					}
					else
					{
						$cart = new CartModel;	
					}
					
					$cart->user_id  = $user_id;
					$cart->option_id  = !empty($request->option_id)?$request->option_id:null;
					$cart->item_id  = $request->item_id;
					$cart->qty  = $request->qty;
					$cart->save();
					$json = $this->getCart($user_id);
					$json['id'] = $cart->id;
				}
				else
				{
					$json['status']  = false;
					$json['message'] = 'Please upload your age verification document';
					$json['type'] 	 = '1';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Please login to place your order';
		}
		echo json_encode($json);
	}

	
	public function getCartDetail(Request $request) {

		if (!empty($this->restaurant_id)  && !empty($this->token)) 
		{
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			$user_id = $this->checkToken();

			if (!empty($checkRestaurant) && !empty($user_id)) 
			{
				$json = $this->getCart($user_id);
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}

		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		if(!empty($user_id)) {
			$json['total_qty'] = $this->getCountCart($user_id);	
		}
		else {
			$json['total_qty'] = 0;
		}
	
		echo json_encode($json);

	}

	public function DeleteCart(Request $request) {
		if (!empty($this->restaurant_id) && !empty($this->token) && !empty($request->cart_id)) 
		{
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			$user_id = $this->checkToken();

			if (!empty($checkRestaurant) && !empty($user_id)) 
			{
				$chcek_cart = CartModel::where('user_id','=',$user_id)->where('id','=',$request->cart_id)->delete();
				if(!empty($request->is_order))
				{
					$json['status'] = true;
					$json['message'] = 'Cart Order successfully removed';
				}
				else
				{
					$json = $this->getCart($user_id);	
				}

				
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		 {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);

	}

	
	public function deleteAllCart($user_id) {
		CartModel::where('user_id','=',$user_id)->delete();
	}

	public function getCart($user_id) {
		$cart = CartModel::where('user_id','=',$user_id)->get();
		if(!empty(count($cart)))
		{
			$result = array();
			$total = 0; 
			$total_qty = 0; 

			foreach($cart as $value)
			{

				$final_total = 0;

				$price = !empty($value->item['price'])?$value->item['price']:0;
				
				$total_qty = $total_qty + $value->qty;

				$subtotal = $price * $value->qty;

				$final_total = $final_total + $subtotal;

				
				$data['id'] = $value->id;
				$data['item_id'] = $value->item_id;
				$data['option_id'] = $value->option_id;
				$data['category_id'] = !empty($value->item['category_id'])?$value->item['category_id']:'';
				$data['item_name'] = !empty($value->item['item_name'])?$value->item['item_name']:'';
				$data['price'] = $this->getformatnumber($price);
				$data['qty'] = $value->qty;

				$categorydata = CategoryModel::find($value->item['category_id']);
				
				if (!empty($categorydata->logo)) {
					$data['logo'] = url('upload/category/' . $categorydata->logo);
				} else {
					$data['logo'] = null;
				}
			
				$data['subtotal'] = $this->getformatnumber($subtotal);
				
				$sub_array = array();

				if(!empty($value->option_id))
				{
					$option_array = explode(",", $value->option_id);

					foreach($option_array as $option_id)
					{
						$optiondata = ItemoptionModel::find($option_id);
						if(!empty($optiondata))
						{
							$option_price = !empty($optiondata->option_price)?$optiondata->option_price:0;

							$option_sub_total = $option_price * $value->qty;

							$sub['option_id'] = $option_id;	
							$sub['option_name'] = $optiondata->option_name;	
							$sub['option_price'] = 	$this->getformatnumber($option_price);
							$sub['option_sub_total'] = $this->getformatnumber($option_sub_total);	
							$final_total = $final_total + $option_sub_total;
							$sub_array[] = $sub;
						}
					}

				}

				$data['final_total'] = $this->getformatnumber($final_total);
				$data['option'] = $sub_array;

				$total = $total + $final_total;

				$result[] = $data;
			}

			$json['status'] = true;
			$json['message'] = 'Record found.';
			$json['total'] = $this->getformatnumber($total);
			$json['total_qty'] = $total_qty;
			
			$json['result'] = $result;
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Record not found.';
		}
		return $json;
	}

	public function getformatnumber($price)
	{
		$finaltotal =  number_format($price,2);
		return str_replace(",","",$finaltotal);
	}
	

	// start order

	public function stripe_payment(Request $request)
	{
		if (!empty($this->restaurant_id) && !empty($this->token) 
			&& !empty($request->email) 
			&& !empty($request->phone) 
			&& !empty($request->address_one) 
			&& !empty($request->city) 
			&& !empty($request->postcode) 
			&& !empty($request->payment_type) 
		) 
		{
			try {

				$user_id = $this->checkToken();
				if(!empty($user_id))
				{
					$cart = $this->getCart($user_id);

					if(!empty($cart['result']))
					{
						if($request->payment_type == 'Cash')
						{
							$order_id = $this->place_order($user_id,$request);
							
							$this->deleteAllCart($user_id);

							$data['order_id'] = $order_id;
							$data['clientSecret'] = '';
							$json['status'] = true;
				    		$json['message'] = "Order successfully placed.";	
				    		$json['result'] = $data;	
						}
						else
						{
							if(!empty($request->paymentMethodId))
							{	
								$restaurant = User::find($this->restaurant_id);

								$paymentMethodId = $request->paymentMethodId;
								if(!empty($request->discount_code))
								{
									$getdiscount = $this->orderdiscount($request->discount_code);
									if(!empty($getdiscount))
									{

									    $getCategoryOption = DiscountCategoryModel::where('discount_id','=',$getdiscount['discount_id'])->get();

									    $check_category = '';

										foreach($cart['result'] as $checking_discount)
										{
											foreach ($getCategoryOption as $value_checking_category) {
												if($value_checking_category->category_id == $checking_discount['category_id'])
												{
													$check_category = '1';
												}
											}							
										}

										if(empty($check_category))
										{
											$total = !empty($getdiscount['payable_amount'])?$getdiscount['payable_amount']:0;
											$total = $total + $request->delivery;
										}
										else
										{
											$total = !empty($cart['total'])?$cart['total']:0;	
											$total = $total + $request->delivery;
										}
									}
									else
									{
										$total = !empty($cart['total'])?$cart['total']:0;	
										$total = $total + $request->delivery;
									}

								}
								else
								{
									$total = !empty($cart['total'])?$cart['total']:0;	
									$total = $total + $request->delivery;
								}

								$finaltotal = $total * 100;

								Stripe::setApiKey($restaurant->stripe_secret_key);

								$intent = \Stripe\PaymentIntent::create([
									"amount" => $finaltotal,
									"currency" => 'GBP',
									"payment_method" => $paymentMethodId,
									"confirmation_method" => "manual",
									"confirm" => true
								]);

								
								if(!empty($intent->status) && $intent->status == 'succeeded')
								{

									$order_id = $this->place_order($user_id,$request);

									$save_order=  OrdersModel::find($order_id);
									$save_order->PaymentIntentID = $intent->id;
									$save_order->save();

									$data['clientSecret'] = $intent->client_secret;
									$data['order_id'] = $order_id;
									$json['status'] = true;
						    		$json['message'] = "Record found.";	
						    		$json['result'] = $data;	
								}
								else
								{
									$json['status'] = false;
						    		$json['message'] = "Your card was declined";	
								}
							}
							else
							{
								$json['status'] = false;
    							$json['message'] = "Your card was declined";
							}
						}
					}
					else
					{
						$json['status'] = false;
						$json['message'] = 'Cart empty';					
					}
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Token expire.';
					$json['code'] = 400;
				}
			}
			catch (\Exception  $e) {
		    	$json['status'] = false;
		    	$json['message'] = "Due to some error please try again.";
		    }
	    }
	    else
	    {
	    	$json['status'] = false;
	    	$json['message'] = "Due to some error please try again.";
	    }

		echo json_encode($json);
	}




	public function place_order($user_id,$request) {

			$cart = $this->getCart($user_id);

			if(!empty($request->discount_code))
			{
				$getdiscount = $this->orderdiscount($request->discount_code);
				if(!empty($getdiscount))
				{
					$getCategoryOption = DiscountCategoryModel::where('discount_id','=',$getdiscount['discount_id'])->get();
				    $check_category = '';

					foreach($cart['result'] as $checking_discount)
					{
						foreach ($getCategoryOption as $value_checking_category) {
							if($value_checking_category->category_id == $checking_discount['category_id'])
							{
								$check_category = '1';
							}
						}							
					}

					if(!empty($check_category))
					{
						$getdiscount = 0;	
					}
				}
				else
				{
					$getdiscount = 0;	
				}
			}
			else
			{
				$getdiscount = 0;	
			}


			$total = !empty($cart['total'])?$cart['total']:0;

			$total = $total + $request->delivery;


			$total_qty = !empty($cart['total_qty'])?$cart['total_qty']:0;

			$order = new OrdersModel;

			$restaurant = User::find($this->restaurant_id);
			if(!empty($restaurant->package->type))
			{
				$percent = !empty($restaurant->package->price)?$restaurant->package->price:0;
				$commission = ($total * $percent) / 100;
				$order->commission_amount = $commission;
				$order->commission_type   = !empty($restaurant->package->type)?$restaurant->package->type:0;
			}

			$order->restaurant_id 	= $this->restaurant_id;
			$order->user_id 		= $user_id;
			$order->name 			= $request->name;
			$order->email 			= $request->email;
			$order->address_one 	= $request->address_one;
			$order->address_two 	= $request->address_two;
			$order->city  			= $request->city;
			$order->postcode  		= $request->postcode;
			$order->phone   		= $request->phone;
			$order->payment_type   	= $request->payment_type;
			$order->delivery   		= $request->delivery;
			$order->postcode_id   	= !empty($request->postcode_id) ? $request->postcode_id : '';
			$order->is_collection 	= !empty($request->is_collection) ? 1 : 0;		
			$order->miles   		= $request->miles;

			if(!empty($request->paymentMethodId))
			{
				$order->paymentMethodId = $request->paymentMethodId;	
			}

			if($request->payment_type == 'Cash')
			{
				$order->is_payment  = 1;				
			}
			
			$order->added_date   	= date('Y-m-d');
			if(!empty($request->note))
			{
				$order->note   = $request->note;
			}

			$order->total_qty   = $total_qty;
			if(!empty($getdiscount))
			{
				$order->final_total = $getdiscount['total'];
				$order->discount_type = $getdiscount['type'];
				$order->discount_price = $getdiscount['discount_price'];
				$order->discount_amount = $getdiscount['discount'];
				$order->total_price = $getdiscount['payable_amount'] + $request->delivery;
				$order->discount_code = $request->discount_code;
			}
			else
			{
				$order->final_total = $total;
				$order->total_price = $total;	
			}
			

			$order->save();

			foreach($cart['result'] as $value)
			{	
				$item 				= new OrdersItemModel;
				$item->order_id 	= $order->id;
				$item->item_id 		= $value['item_id'];
				$item->qty 			= $value['qty'];
				$item->price 		= $value['price'];
				$item->sub_total 	= $value['subtotal'];
				$item->final_total 	= $value['final_total'];

				if(!empty($value['option_id']))
				{
					$item->option_id 	= $value['option_id'];
					$option 			= json_encode($value['option']);
					$item->option_data 	= $option;	
				}

				$item->save();
			}

			$this->sendPushNotification(1,$this->restaurant_id);

			return $order->id;

	}


	public function orderdiscount($discount_code)
	{
		$discount_code = strtoupper($discount_code);
		$getdiscount = DiscountcodeModel::where('user_id','=',$this->restaurant_id)->where('expiry_date','>=', date('Y-m-d'))->where('discount_code','=', $discount_code)->first();

		if(!empty($getdiscount))
		{

			$ordercheckdisocunt = 0;
			
			if(trim($getdiscount->usage) == 1)
			{
				$ordercheckdisocunt = OrdersModel::where('discount_code','=',$discount_code)->where('is_payment','=',1)->where('restaurant_id','=',$this->restaurant_id)->count();
			}



			if(empty($ordercheckdisocunt))
			{	
				$user_id = $this->checkToken();

				$cart = $this->getCart($user_id);	

				$discount_price = $getdiscount->discount_price;

				$total = !empty($cart['total'])?$cart['total']:0;

				if($getdiscount->type == '1')
				{
					$discount_amount = $total - $discount_price;
					$discount = $discount_price;

				}
				else
				{
					$discount_cal = ($total * $discount_price) / 100;
					$discount = $discount_cal;
					$discount_amount = $total - $discount_cal;
				}

				if($total > $discount)
				{
					$data['discount_id'] = $getdiscount->id;
					$data['type'] = $getdiscount->type;
					$data['discount_price'] = $getdiscount->discount_price;
					$data['discount'] = $this->getformatnumber($discount);
					$data['total'] = $this->getformatnumber($total);
					$data['payable_amount'] = $this->getformatnumber($discount_amount);
					return $data;	
				}
				else
				{
					return 0;
				}
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}		
	}


	public function place_order_status(Request $request)
	{
		if(!empty($this->restaurant_id) && !empty($this->token) && !empty($request->order_id) && !empty($request->transaction_id))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$gerOrder = OrdersModel::where('user_id','=',$user_id)->where('id','=',$request->order_id)->first();
				if(!empty($gerOrder))
				{
					$restaurant = User::find($this->restaurant_id);

					try {

						\Stripe\Stripe::setApiKey($restaurant->stripe_secret_key);
						

						$payment_intent = \Stripe\PaymentIntent::retrieve(
						  $gerOrder->PaymentIntentID
						);

						if($payment_intent->status == 'succeeded')
						{
							$gerOrder->transaction_id = $gerOrder->PaymentIntentID;
							$gerOrder->payment_data   = json_encode($payment_intent);
							
							$gerOrder->is_payment     = 1;
							$gerOrder->save();	

							$this->deleteAllCart($user_id);

							$json['status'] = true;
							$json['message'] = 'Order successfully placed.';
							
						}
						else
						{
							$json['status'] = false;
				    		$json['message'] = "Due to some error please try again.";	
						}

					}
					catch (\Exception  $e) {
				    	$json['status'] = false;
				    	$json['message'] = "Due to some error please try again.";
				    }
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Order not found.';
				}
			}	
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}

	public function update_bank_detail(Request $request) {

		if(!empty($this->restaurant_id) && !empty($this->token) && !empty($request->order_id) && !empty($request->sort_code) && !empty($request->account_number)) {

			$user_id		 = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);

			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$gerOrder = OrdersModel::where('user_id','=',$user_id)->where('id','=',$request->order_id)->first();
				if(!empty($gerOrder))
				{
					$gerOrder->account_number = trim($request->account_number);
					$gerOrder->sort_code   	  = trim($request->sort_code);
					$gerOrder->save();	

					$created_at = date('Y-m-d H:i:s',strtotime('+'.$gerOrder->custom_time.' minutes',strtotime($gerOrder->created_at)));

					$json['order_id']   = $gerOrder->id;
					$json['custom_time']  = strtotime($created_at);
					$json['status'] 	= true;
					$json['message']    = 'Refund information successfully sent.';
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Order not found.';
				}
			}	
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);

	}


	public function write_order_review(Request $request)
	{
		if(!empty($this->restaurant_id) && !empty($this->token) && !empty($request->order_id))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$gerOrder = OrdersModel::where('user_id','=',$user_id)->where('id','=',$request->order_id)->first();
				if(!empty($gerOrder))
				{
					$gerOrder->review = $request->review;
					$gerOrder->rating = !empty($request->rating) ? $request->rating : 1;
					$gerOrder->save();	

					$json['status'] = true;
					$json['message'] = 'Review successfully added';
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Order not found.';
				}
			}	
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);

	}

	public function get_order_review() {
		if(!empty($this->restaurant_id))
		{
			$user = User::find($this->restaurant_id);
			if(!empty($user))
			{
				$getreview = OrdersModel::where('is_review', '=', 1)->where('restaurant_id', '=', $this->restaurant_id)->orderBy('id','desc')->paginate(2);

				if(!empty(count($getreview)))
				{
					$result = array();
					
					foreach ($getreview as $value) {
						$data['name'] 		= $value->name;
						$data['id'] 		= $value->id;
						$data['rating'] 	= $value->rating;
						$data['review'] 	= $value->review;
						$data['timestamp']  = strtotime($value->updated_at);
						$result[] = $data;
					}

					$json['status'] = true;
					$json['message'] = 'Record found.';
					$json['result'] = $result;
					$json['next_page_url'] = $getreview->nextPageUrl();
					$json['prev_page_url'] = $getreview->previousPageUrl();

					$page = 0;
					if(!empty($getreview->nextPageUrl()))
		            {
			              $parse_url =parse_url($getreview->nextPageUrl()); 
			              if(!empty($parse_url['query']))
			              {
			                   parse_str($parse_url['query'], $get_array);     
			                   $page = !empty($get_array['page']) ? $get_array['page'] : 0;
			              }
		     	    }

		     	    $json['page'] = intval($page);
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'Review not found.';				
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Restaurant not found.';		
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}



	public function get_my_order(Request $request){
		if(!empty($this->restaurant_id) && !empty($this->token))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$restaurant = User::find($this->restaurant_id);
				$orders = OrdersModel::where('user_id', '=' ,$user_id)->where('is_payment', '=', 1)->where('is_delete', '=', 0)->where('restaurant_id', '=' ,$this->restaurant_id)->orderBy('id','desc')->paginate(10);	
				

				if(!empty(count($orders))) {
					$result = array();
					foreach ($orders as $value) {
						$data['id'] 				= $value->id;
						$data['transaction_id'] 	= $value->transaction_id;
						$data['total_qty'] 			= $value->total_qty;
						$data['total_price'] 		= $this->getformatnumber($value->total_price);
						$data['payment_type'] 		= $value->payment_type;
						$data['timestamp'] 		    = strtotime($value->created_at);
						$data['order_status'] 		= !empty($value->status->name)?$value->status->name:'';
						$data['is_collection'] 		= !empty($user->is_collection) ? $user->is_collection : 0;

						$result[] = $data;
					}

					$json['status'] = true;
					$json['message'] = 'Record found.';
					$json['result'] = $result;
					$json['next_page_url'] = $orders->nextPageUrl();
					$json['prev_page_url'] = $orders->previousPageUrl();

					$page = 0;
					if(!empty($orders->nextPageUrl()))
		            {
			              $parse_url =parse_url($orders->nextPageUrl()); 
			              if(!empty($parse_url['query']))
			              {
			                   parse_str($parse_url['query'], $get_array);     
			                   $page = !empty($get_array['page']) ? $get_array['page'] : 0;
			              }
		     	    }
		     	    $json['page'] = intval($page);


				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	public function get_my_order_detail(Request $request) {
		if(!empty($request->order_id) && !empty($this->restaurant_id) && !empty($this->token))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$value = OrdersModel::where('user_id', '=' ,$user_id)->where('restaurant_id', '=' ,$this->restaurant_id)->where('id', '=' ,$request->order_id)->first();

				if(!empty($value))
				{
					$finaldata['id'] = $value->id;
					$finaldata['transaction_id'] = $value->transaction_id;
					$finaldata['name'] = $value->name;
					$finaldata['address_one'] = $value->address_one;
					$finaldata['address_two'] = $value->address_two;
					$finaldata['city'] = $value->city;
					$finaldata['postcode'] = $value->postcode;
					$finaldata['phone'] = $value->phone;
					$finaldata['total_qty'] = $value->total_qty;
					$finaldata['total_price'] = $this->getformatnumber($value->total_price);
					$finaldata['delivery'] = $this->getformatnumber($value->delivery);
					$finaldata['payment_type'] = $value->payment_type;
					$finaldata['order_status'] = !empty($value->status->name)?$value->status->name:'';
					$finaldata['status_id'] = intval($value->status_id);

					$finaldata['rating'] = $value->rating;
					$finaldata['review'] = !empty($value->review)?$value->review:'';
					$finaldata['is_review'] = !empty($value->review)?true:false;

					$finaldata['is_collection'] = $value->is_collection;

					$created_at = date('Y-m-d H:i:s',strtotime('+'.$value->custom_time.' minutes',strtotime($value->created_at)));
							
					$finaldata['custom_time']  = strtotime($created_at);

					$itemdata = array();

				 	foreach ($value->getorderitem as $item)
				 	{

				 		$categorydata = CategoryModel::find($item->item->category_id);

						if (!empty($value->item_image) && file_exists('upload/item/' . $value->item_image)) {
							$sub['logo'] = url('upload/item/' . $value->item_image);
						} else {
							$sub['logo'] = url('upload/category/' . $categorydata->logo);
						}

				 		$sub['item_id'] = $item->item_id;
				 		$sub['item_name'] = !empty($item->item->item_name)?$item->item->item_name:'';
				 		$sub['qty'] = $item->qty;
				 		$sub['price'] = $item->price;
				 		$sub['sub_total'] = $item->sub_total;
				 		$sub['final_total'] = $item->final_total;
				 		if(!empty($item->option_data))
				 		{
				 			$sub['option'] = json_decode($item->option_data);	
				 		}
				 		else
				 		{
				 			$sub['option'] = array();	
				 		}
				 		
				 		$itemdata[] = $sub;
				 	}

				 	$finaldata['items'] = $itemdata;

				 	$json['status'] = true;
					$json['message'] = 'Record found.';
				 	$json['result'] = $finaldata;
					
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	// start order restaurant

	public function get_my_order_restaurant(Request $request){
		if(!empty($this->restaurant_id) && !empty($this->token))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$restaurant = User::find($this->restaurant_id);


				$orders = OrdersModel::where('is_delete', '=', 0)->where('is_payment', '=', 1)->where('restaurant_id', '=' ,$this->restaurant_id);

				if(!empty($request->status_id)) {
					$orders = $orders->where('status_id','=',$request->status_id);
				}

				$orders = $orders->orderBy('id','desc')->paginate(10);	
				

				if(!empty(count($orders))) {
					$result = array();
					foreach ($orders as $value) {
						$data['id'] 				= $value->id;
						$data['transaction_id'] 	= !empty($value->transaction_id)?$value->transaction_id:'';
						$data['total_qty'] 			= $value->total_qty;
						$data['total_price'] 		=  $this->getformatnumber($value->total_price);
						$data['payment_type'] 		= $value->payment_type;
						$data['miles'] 				= !empty($value->miles) ? $value->miles : 0;
						$data['timestamp'] 		    = strtotime($value->created_at);
						$data['order_status'] 		= !empty($value->status->name)?$value->status->name:'';
						$data['is_collection'] 		= !empty($value->is_collection) ? $value->is_collection : 0;
						$result[] = $data;
					}

					$json['status'] = true;
					$json['message'] = 'Record found.';
					$json['result'] = $result;
					$json['next_page_url'] = $orders->nextPageUrl();
					$json['prev_page_url'] = $orders->previousPageUrl();

					$page = 0;
					if(!empty($orders->nextPageUrl()))
		            {
			              $parse_url =parse_url($orders->nextPageUrl()); 
			              if(!empty($parse_url['query']))
			              {
			                   parse_str($parse_url['query'], $get_array);     
			                   $page = !empty($get_array['page']) ? $get_array['page'] : 0;
			              }
		     	    }
		     	    $json['page'] = intval($page);


				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	public function get_my_order_detail_restaurant(Request $request) {
		if(!empty($request->order_id) && !empty($this->restaurant_id) && !empty($this->token))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$value = OrdersModel::where('restaurant_id', '=' ,$this->restaurant_id)->where('id', '=' ,$request->order_id)->first();

				if(!empty($value))
				{
					$finaldata['id'] = $value->id;
					$finaldata['transaction_id'] = $value->transaction_id;
					$finaldata['name'] = $value->name;
					$finaldata['address_one'] = $value->address_one;
					$finaldata['address_two'] = $value->address_two;
					$finaldata['city'] = $value->city;
					$finaldata['email'] = $value->email;
					$finaldata['postcode'] = $value->postcode;
					$finaldata['phone'] = $value->phone;
					$finaldata['total_qty'] = $value->total_qty;
					$finaldata['total_price'] =  $this->getformatnumber($value->total_price);
					$finaldata['delivery'] = $this->getformatnumber($value->delivery);
					$finaldata['payment_type'] = $value->payment_type;
					$finaldata['order_status'] = !empty($value->status->name)?$value->status->name:'';
					$finaldata['status_id'] = intval($value->status_id);
					$finaldata['note'] = !empty($value->note) ? $value->note : '';
					$finaldata['miles']  = !empty($value->miles) ? $value->miles : 0;

					$created_at = date('Y-m-d H:i:s',strtotime('+'.$value->custom_time.' minutes',strtotime($value->created_at)));
					$finaldata['custom_time'] = strtotime($created_at);
					

					$finaldata['is_collection'] = $value->is_collection;

					
					$finaldata['rating'] = $value->rating;
					$finaldata['review'] = !empty($value->review)?$value->review:'';
					$finaldata['is_review'] = !empty($value->review)?true:false;

					$itemdata = array();

				 	foreach ($value->getorderitem as $item)
				 	{

				 		$categorydata = CategoryModel::find($item->item->category_id);
						if (!empty($value->item_image) && file_exists('upload/item/' . $value->item_image)) {
							$sub['logo'] = url('upload/item/' . $value->item_image);
						} else {
							$sub['logo'] = url('upload/category/' . $categorydata->logo);
						}

				 		$sub['item_id'] = $item->item_id;
				 		$sub['item_name'] = !empty($item->item->item_name)?$item->item->item_name:'';
				 		$sub['qty'] = $item->qty;
				 		$sub['price'] = $item->price;
				 		$sub['sub_total'] = $item->sub_total;
				 		$sub['final_total'] = $item->final_total;
				 		if(!empty($item->option_data))
				 		{
				 			$sub['option'] = json_decode($item->option_data);	
				 		}
				 		else
				 		{
				 			$sub['option'] = array();	
				 		}
				 		
				 		$itemdata[] = $sub;
				 	}

				 	$finaldata['items'] = $itemdata;

				 	$status = array();

				 	$getstatus = OrderStatusModel::all();	

				 	foreach ($getstatus as $statusvalue) {
				 		$sdata['id'] = $statusvalue->id;
				 		$sdata['name'] = $statusvalue->name;
				 		$status[] = $sdata;
				 	}


				 	$finaldata['status'] = $status;
				 	$json['status'] = true;
					$json['message'] = 'Record found.';
				 	$json['result'] = $finaldata;
					
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	public function change_order_status_restaurant(Request $request) {
		if(!empty($request->order_id) && !empty($this->restaurant_id) && !empty($this->token) && !empty($request->status_id))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$order = OrdersModel::where('restaurant_id', '=' ,$this->restaurant_id)->where('id', '=' ,$request->order_id)->first();

				if(!empty($order))
				{
					$order->status_id = $request->status_id;
					if(!empty($request->custom_time))
					{
						$order->custom_time = $request->custom_time;
					}
					else
					{
						$order->custom_time = 45;	
					}
					$order->save();

					$this->sendPushNotification($request->status_id,$order->user_id);

					$gerOrder = OrdersModel::find($request->order_id);

					$created_at = date('Y-m-d H:i:s',strtotime('+'.$gerOrder->custom_time.' minutes',strtotime($gerOrder->created_at)));

					$json['status'] 	 = true;
					$json['custom_time'] = strtotime($created_at);
					$json['is_collection'] = !empty($gerOrder->is_collection) ? $gerOrder->is_collection : 0;
					$json['message']     = 'Order status successfully changed.';	
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	public function notify_customer_restaurant(Request $request) {
		if(!empty($request->order_id) && !empty($this->restaurant_id) && !empty($this->token) && !empty($request->title) && !empty($request->message))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$order = OrdersModel::where('restaurant_id', '=' ,$this->restaurant_id)->where('id', '=' ,$request->order_id)->first();

				if(!empty($order)) {

					$this->sendPushNotificationCutsomer($request->title,$request->message,$order->user_id);

					$json['status'] = true;
					$json['message'] = 'Notification successfully sent.';	
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}



	public function send_notification_restaurant(Request $request) {

		if(!empty($this->restaurant_id) && !empty($this->token) && !empty($request->title) && !empty($request->message))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$users = User::where('restaurant_id', '=' ,$this->restaurant_id)->get();

				if(!empty($users)) {

					foreach ($users as $value) {
						$this->sendPushNotificationCutsomer($request->title,$request->message,$value->id);	
					}
					
					$json['status'] = true;
					$json['message'] = 'Notification successfully sent.';	
				}
				else
				{
					$json['status'] = false;
					$json['message'] = 'There is no order yet!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);

	}
	


	public function sendPushNotificationCutsomer($title,$message,$user_id) {
		$user 	= User::find($user_id);

		$result = SettingModel::find(1);	   
	    $serverKey = $result->notification_key;

		try {
			if(!empty($user->token)) {

				$token = $user->token;

				$body['message'] = $message;
				$body['body'] = $message;
				$body['title']   = $title;

				$url = "https://fcm.googleapis.com/fcm/send";

				$notification = array('title' => $title, 'text' => $message, 'body' => $message);

				$arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $body, 'priority' => 'high');

				$json1 = json_encode($arrayToSend);
				$headers = array();
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: key=' . $serverKey;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				//Send the request
				$response = curl_exec($ch);
				curl_close($ch);
			}
		}
		catch (\Exception  $e) {
	    
	    }
	}


	public function sendPushNotification($status_id,$user_id) {
		$status = OrderStatusModel::find($status_id);
		$user 	= User::find($user_id);

		$result = SettingModel::find(1);	   
	    $serverKey = $result->notification_key;

		try {
			if(!empty($user->token))
			{
				$token = $user->token;

				$body['message'] = $status->message;
				$body['body'] = $status->message;
				$body['title']   = $status->title;

				$url = "https://fcm.googleapis.com/fcm/send";

				$notification = array('title' => $status->title, 'text' => $status->message, 'body' => $status->message);

				$arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $body, 'priority' => 'high');

				$json1 = json_encode($arrayToSend);
				$headers = array();
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: key=' . $serverKey;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				//Send the request
				$response = curl_exec($ch);
				curl_close($ch);
			}
		}
		catch (\Exception  $e) {
	    
	    }
	}


	public function get_today_restaurant_detail(Request $request)
	{

		if(!empty($this->restaurant_id) && !empty($this->token))
		{
			$user_id = $this->checkToken();
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant) && !empty($user_id))
			{
				$total_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->count();

				$total_cash_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('payment_type', '=', 'Cash')->count();
				
				$total_card_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('payment_type', '=', 'Card')->count();
				

				$total_cash_payment = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('payment_type', '=', 'Cash')->sum('final_total');
				

				$total_card_payment = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('payment_type', '=', 'Card')->sum('final_total');
				

				$total_amount = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->sum('final_total');

				$total_pending_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('status_id', '=', 1)->count();

				$total_accepted_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('status_id', '=', 2)->count();

				$total_processing_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('status_id', '=', 3)->count();

				$total_delivered_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('status_id', '=', 4)->count();

				$total_cancelled_order = OrdersModel::where('added_date', '=', date('Y-m-d'))->where('is_payment', '=', '1')->where('is_delete', '=', '0')->where('status_id', '=', 5)->count();
				
				$data = array();

				$data['total_order']		    = $total_order;
				$data['total_cash_order'] 		= $total_cash_order;
				$data['total_card_order'] 		= $total_card_order;
				$data['total_cash_payment'] 	= $this->getformatnumber($total_cash_payment);
				$data['total_card_payment'] 	= $this->getformatnumber($total_card_payment);
				$data['total_amount'] 			= $this->getformatnumber($total_amount);

				$data['total_pending_order'] 	= $total_pending_order;
				$data['total_accepted_order'] 	= $total_accepted_order;
				$data['total_processing_order'] = $total_processing_order;
				$data['total_delivered_order'] 	= $total_delivered_order;
				$data['total_cancelled_order'] 	= $total_cancelled_order;


				$json['status']  = true;
				$json['message'] = 'Today Report';	
				$json['result']  = $data;	
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}


	

	// end order restaurant

	public function ApplyDiscount(Request $request) {

		if (!empty($this->token) && !empty($this->restaurant_id)) {
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			$user_id = $this->checkToken();

			if(!empty($checkRestaurant) && !empty($user_id))
			{

				if($request->is_type == 'discount')
				{
					$getdiscount = $this->orderdiscount($request->discount_code);
					if(!empty($getdiscount))
					{
						$user_id = $this->checkToken();
						$cart = $this->getCart($user_id);	

					    $getCategoryOption = DiscountCategoryModel::where('discount_id','=',$getdiscount['discount_id'])->get();

					    $check_category = '';

						foreach($cart['result'] as $checking_discount)
						{
							foreach ($getCategoryOption as $value_checking_category) {
								if($value_checking_category->category_id == $checking_discount['category_id'])
								{
									$check_category = '1';
								}
							}							
						}

						if(empty($check_category))
						{
							$getDelivery = $this->common_apply_delivery($this->restaurant_id, $request->postcode, $request);

							$data['delivery'] = $getDelivery['delivery'];
							$data['miles']	  = $getDelivery['miles'];

							$data['type'] = $getdiscount['type'];
							$data['discount_price'] = $getdiscount['discount_price'];
							$data['discount'] = $this->getformatnumber($getdiscount['discount']);
							$data['total'] = $this->getformatnumber($getdiscount['total']);

							$payable_amount = $getdiscount['payable_amount'] + $getDelivery['delivery'];

							$data['payable_amount'] = $this->getformatnumber($payable_amount);
							
							$json['status'] = true;
							$json['message'] = 'Discount code successfully applied';
							$json['result'] = $data;	
						}
						else
						{
							$getDelivery = $this->common_apply_delivery($this->restaurant_id, $request->postcode, $request);
							$data['delivery'] = $getDelivery['delivery'];
							$data['miles']	  = $getDelivery['miles'];

							$data['type'] = '';
							$data['discount_price'] = '';
							$data['discount'] = '0';

							$cart = $this->getCart($user_id);
							$total = !empty($cart['total'])?$cart['total']:0;


							$data['total'] = $this->getformatnumber($total);

							$payable_amount = $total + $getDelivery['delivery'];

							$data['payable_amount'] = $this->getformatnumber($payable_amount);

							$json['status'] = false;
							$json['message'] = 'One of the items in your order is not eligable for this discount code.';
							$json['result'] = $data;
						}
					}
					else
					{

						$getDelivery = $this->common_apply_delivery($this->restaurant_id, $request->postcode, $request);
						$data['delivery'] = $getDelivery['delivery'];
						$data['miles']	  = $getDelivery['miles'];

						$data['type'] = '';
						$data['discount_price'] = '';
						$data['discount'] = '0';

						$cart = $this->getCart($user_id);
						$total = !empty($cart['total'])?$cart['total']:0;


						$data['total'] = $this->getformatnumber($total);

						$payable_amount = $total + $getDelivery['delivery'];

						$data['payable_amount'] = $this->getformatnumber($payable_amount);

						$json['status'] = false;
						$json['message'] = 'Discount code not found.';
						$json['result'] = $data;
					}
				}
				else
				{	
					$getDelivery = $this->common_apply_delivery($this->restaurant_id, $request->postcode, $request);
					$data['delivery'] = $getDelivery['delivery'];
					$data['miles']	  = $getDelivery['miles'];

					$data['type'] = '';
					$data['discount_price'] = '';
					$data['discount'] = '0';

					$cart = $this->getCart($user_id);
					$total = !empty($cart['total'])?$cart['total']:0;


					$data['total'] = $this->getformatnumber($total);

					$payable_amount = $total + $getDelivery['delivery'];

					$data['payable_amount'] = $this->getformatnumber($payable_amount);

				
					$json['status'] = true;
					$json['message'] = 'Success';
					$json['result'] = $data;
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
		}
		else
		{
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}

	
	// end order



	public function getCategory(Request $request) {
		if (!empty($this->restaurant_id)) {
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$category = CategoryModel::where('user_id','=',$this->restaurant_id)->where('status','=','0')->where('is_delete','=','0')->orderBy('category_order_by','asc')->get();
				if (!empty(count($category))) {
					$result = array();
					foreach ($category as $value) {
						
						$data['id'] 	= $value->id;
						$data['name'] 	= $value->name;
						$data['is_age'] = !empty($value->is_age) ? $value->is_age : 0;

						if (!empty($value->logo)) {
							$data['logo'] = url('upload/category/' . $value->logo);
						} else {
							$data['logo'] = null;
						}

						$result[] = $data;
					}

					$json['status'] = true;
					$json['message'] = 'Record found.';
					$json['result'] = $result;
				} else {
					$json['status'] = false;
					$json['message'] = 'Record not found.';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}


		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}




	public function getItem(Request $request) {
		if (!empty($this->restaurant_id)) {

			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$item = ItemModel::where('user_id','=',$this->restaurant_id);

				if (!empty($request->item_name)) {
					$item = $item->where('item_name', 'like', '%' . $request->item_name . '%');
		        }

				if(!empty($request->category_id)) {
					$item = $item->where('category_id','=', $request->category_id);	
				}

				$item = $item->where('is_delete','=','0')->where('status','=','0')->orderBy('order_by','asc')->paginate(20);

				if (!empty(count($item))) {
					$result = array();
					foreach ($item as $value) {
						$data['id'] = $value->id;
						$data['item_name'] = $value->item_name;
						$data['item_description'] = $value->item_description;
						$data['category_name'] = !empty($value->getcategory->name)?$value->getcategory->name:'';
						$data['price'] = $value->price;
						$result[] = $data;
					}

					$json['status'] = true;
					$json['message'] = 'Record found.';
					$json['result'] = $result;

					$category = array();

					if(!empty($request->category_id))
					{
						$categorydata = CategoryModel::find($request->category_id);
						if(!empty($categorydata))
						{
							$category['id'] = $categorydata->id;
							$category['name'] = $categorydata->name;
							if (!empty($categorydata->logo)) {
								$category['logo'] = url('upload/category/' . $categorydata->logo);
							} else {
								$category['logo'] = null;
							}
						}
					}

					$json['category'] = $category;
					$json['next_page_url'] = $item->nextPageUrl();
					$json['prev_page_url'] = $item->previousPageUrl();

					$page = 0;
					if(!empty($item->nextPageUrl()))
		            {
			              $parse_url =parse_url($item->nextPageUrl()); 
			              if(!empty($parse_url['query']))
			              {
			                   parse_str($parse_url['query'], $get_array);     
			                   $page = !empty($get_array['page']) ? $get_array['page'] : 0;
			              }
		     	    }


					$json['page'] = intval($page);


				} else {
					$json['status'] = false;
					$json['message'] = 'Record not found.';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}


		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}




	public function getItemDetail(Request $request) {
		if (!empty($this->restaurant_id) && !empty($request->item_id)) {

			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$value = ItemModel::where('user_id','=',$this->restaurant_id)->where('id','=',$request->item_id)->first();

				if (!empty($value)) {
					$result = array();



					$user_id = $this->checkToken();
					$cart = CartModel::where('user_id','=',$user_id)->where('item_id','=',$value->id)->first();

					$cart_staus = false;
					$cart_id = 0;
					$cart_qty = 1;
					$option_id = '';

					
					// 	if(!empty($cart))
					// 	{	
					// 		$cart_staus = true;
					// 		$cart_id = $cart->id;
					// 		$cart_qty = $cart->qty;
					// 		$option_id = explode(",", $cart->option_id);
					// 	}

					$main_json['status'] = true;
					$main_json['message'] = 'Record found.';
				
					$item_data['id'] 			= $value->id;
					$item_data['cart_staus'] 	= $cart_staus;
					$item_data['cart_id'] 	 	= intval($cart_id);
					$item_data['cart_qty'] 	 	= $cart_qty;

					$item_data['option_size'] 	= !empty($value->option_size) ? $value->option_size : 0;

					$item_data['item_name'] 	= !empty($value->item_name) ? $value->item_name : '';
					$item_data['item_description'] = !empty($value->item_description) ? $value->item_description : '';
					$item_data['price'] = $value->price;
					$item_data['created_at'] = $value->created_at;
					$item_data['timestamp'] = strtotime($value->created_at);
				
					$categorydata = CategoryModel::find($value->category_id);
					$item_data['category_id'] = $categorydata->id;
					$item_data['category_name'] = !empty($categorydata->name)?$categorydata->name:'';
					

					if (!empty($value->item_image) && file_exists('upload/item/' . $value->item_image)) {
						$item_data['category_logo'] = url('upload/item/' . $value->item_image);
					} else {
						if (!empty($categorydata->logo)) {
							$item_data['category_logo'] = url('upload/category/' . $categorydata->logo);
						} else {
							$item_data['category_logo'] = '';
						}
					}

				
					$json['item'] = $item_data;




					$option = array();
					$option_group = array();

					$option_group_name = ItemoptionModel::where('item_id','=',$value->id)->groupBy('group_name')->where('is_delete','=',0)->get();

					$optiondata = ItemoptionModel::where('item_id','=',$value->id)->where('is_delete','=',0)->get();

					if(!empty(count($optiondata)))
					{
						foreach ($optiondata as  $value_option) {
							$is_select_option = false;
							if(!empty($option_id))
							{
								if (in_array($value_option->id, $option_id))
  								{
  									$is_select_option = true;
  								}
							}

							$option_data['id'] = $value_option->id;
							$option_data['group_name'] = $value_option->group_name;
							$option_data['option_name'] = $value_option->option_name;
							$option_data['option_price'] = $value_option->option_price;	
							$option_data['cart_select'] = $is_select_option;	
							$option[] = $option_data;
						}	

						foreach($option_group_name as $value_group)
						{
							$option_group[] = $value_group->group_name;
						}

					}

					$json['option'] = $option;
					$json['option_group'] = $option_group;
					
					$main_json['result'] = $json;


				} else {
					$main_json['status'] = false;
					$main_json['message'] = 'Record not found.';
				}
			}
			else
			{
				$main_json['status'] = false;
				$main_json['message'] = 'Token expire.';
				$main_json['code'] = 400;
			}


		} else {
			$main_json['status'] = false;
			$main_json['message'] = 'Due to some error please try again.';
		}

		if(!empty($user_id))
		{
			$main_json['total_qty']  = $this->getCountCart($user_id);
		}
		else
		{
			$main_json['total_qty']  = 0;	
		}
		

		echo json_encode($main_json);
	}

	public function getCountCart($user_id) {

		$cart = CartModel::where('user_id','=',$user_id)->sum('qty');
		return !empty($cart) ? $cart : 0;

	}

	public function common_apply_delivery($restaurant_id, $postcode, $request) {

		try
		{
				$getRestaurant = User::find($restaurant_id);

				$string_rest = $getRestaurant->postcode;

				$string_rest = str_replace(" ", "+", urlencode($string_rest));
				$details_url_rest = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $string_rest . "&key=AIzaSyAkabKUynM5GzV7Fno2ndFUUwVc31OzVJA";
				$ch_res = curl_init();
				curl_setopt($ch_res, CURLOPT_URL, $details_url_rest);
				curl_setopt($ch_res, CURLOPT_RETURNTRANSFER, 1);
				$response_rest = json_decode(curl_exec($ch_res), true);

				$geometry_rest = $response_rest['results'][0]['geometry'];

				$resto_lat = $geometry_rest['location']['lat'];
				$resto_lng  = $geometry_rest['location']['lng'];

				

				$string_custo = $postcode;

				$string_custo = str_replace(" ", "+", urlencode($string_custo));
				$details_url_custo = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $string_custo . "&key=AIzaSyAkabKUynM5GzV7Fno2ndFUUwVc31OzVJA";
				$ch_cust = curl_init();
				curl_setopt($ch_cust, CURLOPT_URL, $details_url_custo);
				curl_setopt($ch_cust, CURLOPT_RETURNTRANSFER, 1);
				$response_custo = json_decode(curl_exec($ch_cust), true);

				$response_custo = $response_custo['results'][0]['geometry'];

				$custo_lat = $response_custo['location']['lat'];
				$custo_lng  = $response_custo['location']['lng'];

				$theta = $resto_lng - $custo_lng;
			    $dist = sin(deg2rad($resto_lat)) * sin(deg2rad($custo_lat)) +  cos(deg2rad($resto_lat)) * cos(deg2rad($custo_lat)) * cos(deg2rad($theta));
			    $dist = acos($dist);
			    $dist = rad2deg($dist);
			    $miles = $dist * 60 * 1.1515;


		    	if(!empty($request->is_collection))
		    	{
	    			$json['status'] = true;
					$json['delivery'] = 0;
					$json['miles'] = $this->getformatnumber($miles);
					$json['message'] = 'Success';
		    	}
		    	else
		    	{
					if($miles >= $getRestaurant->radius_miles) {
						$json['status'] = true;
						$json['delivery'] = !empty($getRestaurant->delivery_charge)?$getRestaurant->delivery_charge:0;
						$json['miles'] = $this->getformatnumber($miles);
						$json['message'] = 'Success';
					}
					else if(!empty($getRestaurant->before_delivery_charge))
					{
						$json['status'] = true;
						$json['delivery'] = !empty($getRestaurant->before_delivery_charge)?$getRestaurant->before_delivery_charge:0;
						$json['miles'] = $this->getformatnumber($miles);
						$json['message'] = 'Success';	
					}
					else
					{
						$json['status'] = true;
						$json['delivery'] = 0;
						$json['miles'] = $this->getformatnumber($miles);
						$json['message'] = 'Success';
					}
		    	}
		}
		catch (\Exception  $e) {
	    	$json['status'] = true;
	    	$json['delivery'] = 0;
	    	$json['miles'] = 0;
	    	$json['message'] = 'Success';
	    }
		return $json;
	}
	
	

	public function tokensave(Request $request) {
		if (!empty($this->restaurant_id) && !empty($request->user_id) && !empty($request->token)) {
			$checkRestaurant = $this->checkRestaurant($this->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$user = User::find($request->user_id);
				if (!empty($user)) {
					$user->token = $request->token;
					$user->save();
					$json['status'] = true;
					$json['message'] = 'Successfully save';
				} else {
					$json['status'] = false;
					$json['message'] = 'Due to some error please try again!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
			
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}
		echo json_encode($json);
	}


	

	public function getpage(Request $request) {
		if (!empty($request->restaurant_id) && !empty($request->page_name)) {

			$checkRestaurant = $this->checkRestaurant($request->restaurant_id);
			if(!empty($checkRestaurant))
			{
				$page = PageModel::where('slug','=',$request->page_name)->first();
				if (!empty($page)) {

					echo '<!DOCTYPE html><html><head><title>'.$page->name.'</title></head><body>'.$page->description.'</body></html>';
					die;
					
				} else {
					$json['status'] = false;
					$json['message'] = 'Due to some error please try again!';
				}
			}
			else
			{
				$json['status'] = false;
				$json['message'] = 'Token expire.';
				$json['code'] = 400;
			}
			
		} else {
			$json['status'] = false;
			$json['message'] = 'Due to some error please try again.';
		}

		echo json_encode($json);
	}

}
