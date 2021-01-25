<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class CategoryModel extends Model {
	protected $table = 'category';

	
	public function user() {
		return $this->belongsTo(User::class, "user_id");
	}


	static public function getCategory() {
		return self::where('status', '=', '0')->where('is_delete','=','0')->get();
	}

	static public function getCategoryUserWise() {
		return self::where('status', '=', '0')->where('is_delete','=','0')->where('user_id', '=', Auth::user()->id)->orderBy('name','asc')->get();
	}


	
}
