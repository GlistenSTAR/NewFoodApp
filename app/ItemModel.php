<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model {


    protected $table = 'item';

	
	public function getcategory(){
        return $this->belongsTo(CategoryModel::class, "category_id");
	}
	
	public function user() {
		return $this->belongsTo(User::class, "user_id");
	}

	public function getoption() {
		return $this->hasMany(ItemoptionModel::class, "item_id")->where('is_delete','=',0);
	}

	public function users() {
		return $this->belongsTo(User::class, "restaurant_id");
	}


}
