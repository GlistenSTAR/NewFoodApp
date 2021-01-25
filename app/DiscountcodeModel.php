<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountcodeModel extends Model
{
     protected $table = 'discount_code';

    public function getcategorydiscount() {
      return $this->hasMany(DiscountCategoryModel::class, "discount_id");
    }
}
