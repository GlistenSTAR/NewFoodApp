<?php

namespace App\Http\Controllers;
use App\UserTimeModel;
use App\WeekTimeModel;
use App\WeekModel;
use Auth;
use Illuminate\Http\Request;

class UserTimeController extends Controller
{
   	public function schedule(Request $request){
    	$data['week'] 			= WeekModel::get();
	    $data['week_time_row']  = WeekTimeModel::get();
	    $getrecord 				= UserTimeModel::get();
	    $data['getrecord'] 		= $getrecord;
	    
	    return view('admin.schedule.list', $data);
   	}

   	public function updateschedule(Request $request) {
   		UserTimeModel::where('user_id', '=', Auth::user()->id)->delete();
		if(!empty($request->week))
		{
			foreach($request->week as $value)
			{
				if(!empty($value['status']))
				{
					$record 			= new UserTimeModel;
					$record->week_id 	= trim($value['week_id']);
					$record->user_id 	= Auth::user()->id;
					$record->start_time = trim($value['start_time']);
					$record->end_time 	= trim($value['end_time']);
					$record->status 	= '1';
					$record->save();
				}	
			}
		}

		return redirect('admin/schedule')->with('success', 'Schedule updated successfully.');

	}

}
