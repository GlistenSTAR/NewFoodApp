<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusModel extends Model
{
    protected $table = 'orders_status';

  	static public function getStatus() {
		return self::get();
	}

}
