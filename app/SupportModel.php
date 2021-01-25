<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportModel extends Model
{
   protected $table = 'support';

   // public $timestamps = false;

   public function user(){
        return $this->belongsTo(User::class, "user_id");
	}

	public function getsupportreply() {
		return $this->hasMany(SupportReplyModel::class, "support_id");
	}

	static public function getSupportList($request)
	{
		// $return = self::select('support.*')
		// 				->orderBy('id', 'desc')
		// 				->paginate(20);
  		//  return $return;
		$return = self::select('support.*')
    				->orderBy('id', 'desc')
    				->join('users', 'users.id','=', 'support.user_id'); 

    				if(!empty($request->id))
    				{
    					$return = $return->where('support.id', '=', $request->id);
    				}

    				if (!empty($request->user_id)) {
			            $return = $return->where('support.user_id', '=',  $request->user_id );
			        }

    				if(!empty($request->title))
    				{
    					$return = $return->where('title', 'like', '%' . $request->title . '%');
    				}

    				if (!empty($request->status)) {
			            $status = $request->status;
			              if ($request->status == '1000') {
			                $status = '0';
			              }
			            $return = $return->where('support.status', '=', $status);
			        }

            $return = $return->paginate(20);

        return $return;
	}
}
