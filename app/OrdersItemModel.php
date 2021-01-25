<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersItemModel extends Model
{
   protected $table = 'orders_item';

   public function item(){
        return $this->belongsTo(ItemModel::class, "item_id");
   }
    public function option(){
        return $this->belongsTo(ItemoptionModel::class, "option_id");
   }
}
