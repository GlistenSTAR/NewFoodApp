<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPartnerStatusModel extends Model
{
    protected $table = 'order_partner_status';

  	static public function getStatus() {
		return self::get();
	}
}
