<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;

class UserPostcodeModel extends Model
{
   protected $table = 'user_postcode';

   static public function get_single($id)
   {
   		return self::find($id);
   }

   static public function get_record($id) {
        $return = self::where('user_id','=',$id);
        		if(Request::get('id'))
        		{
					$return = $return->where('id','=',Request::get('id'));
        		}
        		if(Request::get('name'))
        		{
					$return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        		}
    			$return = $return->orderBy('id','desc');
    			$return = $return->where('is_delete','=',0)->paginate(100);
        return $return;
   }

    static public function get_record_app($id) {
        $return = self::where('user_id','=',$id);
        		$return = $return->orderBy('id','desc');
    			$return = $return->where('is_delete','=',0)->get();
        return $return;
   }

}
