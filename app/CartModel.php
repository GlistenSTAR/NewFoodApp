<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $table = 'cart';

    public function item() {

		return $this->belongsTo(ItemModel::class, "item_id");
		
    }
}
