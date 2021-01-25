<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportReplyModel extends Model
{
   protected $table = 'support_reply';

    public function user(){
        return $this->belongsTo(User::class, "user_id");
	}


}
