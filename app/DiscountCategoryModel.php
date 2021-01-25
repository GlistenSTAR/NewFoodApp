<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountCategoryModel extends Model
{
    protected $table = 'discount_category';


    public function getcategory() {
		return $this->belongsTo(CategoryModel::class, "category_id");
	}
	
}
