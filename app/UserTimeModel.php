<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserTimeModel extends Model
{
  	protected $table = 'user_time';

	public function week(){
        return $this->belongsTo(WeekModel::class, "week_id");
	}

	static public function getDetail($weekid) {
		return self::where("week_id", '=', $weekid)->where("user_id", '=', Auth::user()->id)->first();
	}

	static public function getDetailAPI($weekid,$user_id) {
		return self::where("week_id", '=', $weekid)->where("user_id", '=',$user_id)->first();
	}

}
