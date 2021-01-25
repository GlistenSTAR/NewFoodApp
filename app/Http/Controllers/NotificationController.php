<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryModel;
use App\User;
use App\SettingModel;
use Auth;
class NotificationController extends Controller
{
	public function notification(Request $request) {

		if(Auth::user()->is_admin == 2)
        {
            $data['categorys'] = CategoryModel::where('user_id','=',Auth::user()->id)->where('status','=','0')->where('is_delete','=','0')->get();
        }
        else
        {
            $data['categorys'] = CategoryModel::getCategory();
        }


    	return view('admin.notification.list', $data);
	}

	public function updateNotification(Request $request){
		if(Auth::user()->is_admin == 2) {
			$getUser = User::where('is_admin','=','0')->where('status','=','0')->where('restaurant_id', '=', Auth::user()->id)->get();
		}
		else
		{ 
			$getUser = User::where('is_admin','=','0')->where('status','=','0')->get();
		}

    	$result = SettingModel::find(1);
	    

	    $serverKey = $result->notification_key;

		if(!empty($getUser))
		{
			foreach ($getUser as $value) {
				
				if (!empty($value->token)) {

					$token = $value->token;

					$body['title'] = $request->title;
					$body['message'] = $request->message;


					$url = "https://fcm.googleapis.com/fcm/send";

					$notification = array('title' => $request->title, 'body' => $request->message);

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
		}

		return redirect()->back()->with('success', 'Notification successfully sent.');
	}


}
