<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAgeIdModel extends Model
{
   	protected $table = 'user_age_id';

   	public function user() {
		return $this->belongsTo(User::class, "user_id");
	}

	public function restaurant(){
        return $this->belongsTo(User::class, "restaurant_id");
	}

	public function getstatus(){
        return $this->belongsTo(AgeIdStatusModel::class, "status");
	}

	

	public function getLogo()
	{
		if(!empty($this->logo))
		{
			return url('upload/age/'.$this->logo);
		}
		else
		{
			return "";
		}
	}


	static public function sendPushNotificationCutsomer($title,$message,$user_id) {
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

				$notification = array('title' => $title, 'body' => $message);

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


}
