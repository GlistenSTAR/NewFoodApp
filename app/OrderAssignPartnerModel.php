<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAssignPartnerModel extends Model
{
    protected $table = 'order_assign_partner';

    static public function get_assign_order($order_id)
    {
    	return self::select('order_assign_partner.*')
    		->join('users','users.id','=','order_assign_partner.partner_id')
    		->where('order_assign_partner.order_id','=',$order_id)
    		->get();
    }

    public function user() {
      return $this->belongsTo(User::class, "partner_id");
    }

    public function getorderstatus() {
      return $this->belongsTo(OrderPartnerStatusModel::class, "status_id");
    }

    public function get_order() {
      	return $this->belongsTo(OrdersModel::class, "order_id");
    }

}
