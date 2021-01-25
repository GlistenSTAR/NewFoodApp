<?php

namespace App\Http\Controllers;

use App\User;
use App\UserAgeIdModel;
use App\AgeIdStatusModel;
use Illuminate\Http\Request;
use Auth;
class AgeIdController extends Controller
{
    public function index(Request $request)
    {
    	
    	$getrecord = UserAgeIdModel::orderBy('user_age_id.id', 'desc')->select('user_age_id.*');
		$getrecord = $getrecord->join('users', 'users.id','=', 'user_age_id.user_id');
	

		if ($request->id) {
			$getrecord = $getrecord->where('user_age_id.id', '=', $request->id);
		}
		
		if ($request->user_id) {
			$getrecord = $getrecord->where('user_age_id.restaurant_id', '=',  $request->user_id );
		}

		if ($request->name) {
			$getrecord = $getrecord->where('users.name', 'like', '%' . $request->name . '%');
		}

		if ($request->status) {
            $getrecord = $getrecord->where('user_age_id.status','=',$request->status);
        }

        if(Auth::user()->is_admin == 2)
        {
        	$getrecord = $getrecord->where('user_age_id.restaurant_id','=',Auth::user()->id);	
        }
        
		
		$getrecord = $getrecord->paginate(40);
		$data['getrecord'] = $getrecord;


	    $data['getUser'] = User::getUser();

		$data['getStatus'] = AgeIdStatusModel::get();
		
    	return view('admin.ageid.list', $data);
    }


    public function destroy($id) {
		$getrecord = UserAgeIdModel::find($id);

		if(!empty($getrecord->logo))
		{
			unlink('upload/age/'.$getrecord->logo);	
		}

		$getrecord->delete();




		return redirect('admin/ageid')->with('success', 'Record successfully deleted!');
	}

	public function updatestatus($id)
	{
    	$record = UserAgeIdModel::find($id);
     	$record->status = 2;
     	$record->reason = null;
		$record->save();

		$title = 'Age 18 + ID';

		$message = 'Your ID has been approved.';

		UserAgeIdModel::sendPushNotificationCutsomer($title,$message,$record->user_id);


		return redirect('admin/ageid')->with('success', 'Status successfully updated.');			
	}
	


    public function add_reason(Request $request)
    {
    	$record = UserAgeIdModel::where('id', '=', trim($request->reason_no))->first();
     	$record->reason = $request->reason;
     	$record->status = 3;
		$record->save();

		$title = 'Age 18 + ID';
		$message = 'Your ID has been rejected please upload again.';
		UserAgeIdModel::sendPushNotificationCutsomer($title,$message,$record->user_id);

		return redirect('admin/ageid')->with('success', 'Status successfully updated.');	
	}


}
