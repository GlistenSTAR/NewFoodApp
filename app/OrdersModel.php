<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
   protected $table = 'orders';

   public function user() {
		return $this->belongsTo(User::class, "user_id");
   }
   
   public function restaurant() {
		return $this->belongsTo(User::class, "restaurant_id");
   }

   public function status() {
      return $this->belongsTo(OrderStatusModel::class, "status_id");
   }

   public function getorderitem() {
     // return OrdersItemModel::select('orders_item.*')
     //        ->join('item','item.id','=','orders_item.item_id')
     //        ->orderBy('item.category_id', 'asc')
     //        ->where('orders_item.order_id','=', $this->id)->get();

      return $this->hasMany(OrdersItemModel::class, "order_id")->join('item','item.id','=','orders_item.item_id')->orderBy('item.category_id', 'asc');
   }

   public function getorderstatus() {
      return $this->belongsTo(OrderStatusModel::class, "status_id");
   }

   static function getSum($first_month, $last_month, $user_id) {
       $total = self::where('added_date', '>=', $first_month)
                     ->where('added_date', '<=', $last_month)
                     ->where('restaurant_id', '=', $user_id)                                          
                     ->sum('commission_amount');

       return !empty($total)?$total:0;
    }


    static public function getRecordOrder($request)
    {

      $return =  self::select('orders.*')
                    ->orderBy('id','desc')
                    ->where('is_delete', '=', 0)
                    ->where('is_payment', '=', 1);
                    
                    // Search box start
                    if (!empty($request->id)) {
                        $return = $return->where('id', '=', $request->id);
                    }
                    if (!empty($request->transaction_id)) {
                        $return = $return->where('transaction_id', 'like', '%' . $request->transaction_id . '%');
                    }

                    if (!empty($request->name)) {
                        $return = $return->where('name', 'like', '%' . $request->name . '%');
                    }
                    if (!empty($request->payment_type)) {
                        $return = $return->where('payment_type', '=', $request->payment_type);
                    }
                    if (!empty($request->restaurant_id)) {
                        $return = $return->where('restaurant_id', '=', $request->restaurant_id);
                    }
                    if (!empty($request->status_id)) {
                        $status_id = $request->status_id;
                        if($request->status_id == 100)
                        {
                            $status_id = 0;
                        }

                        $return = $return->where('status_id','=',$status_id);
                    }

                    if(!empty($request->start_date))
                    {
                        $return = $return->where('orders.added_date', '>=', $request->start_date);
                    }
                    if(!empty($request->end_date))
                    {
                        $return = $return->where('orders.added_date', '<=', $request->end_date);
                    }
                    
                    //date('Y-m-d')

                    if(Auth::user()->is_admin == 2)
                    {
                         $return = $return->where('restaurant_id', '=', Auth::user()->id);   
                    }
                    // Search box end
       
       $return = $return->paginate(20);
       return $return;
    }


    static public function getStatusTotal($request, $status_type = ''){
      $return = self::select('orders.*')
                    ->where('is_delete', '=', 0)
                    ->where('is_payment', '=', '1');

                    if($status_type == 'Card' || $status_type == 'Cash')
                    {
                        $return = $return->where('payment_type','=',$status_type);    
                    }
                    else
                    {
                        if(!empty($status_type))
                        {
                            $return = $return->where('status_id','=',$status_type);    
                        }    
                    }

                    if (!empty($request->id)) {
                        $return = $return->where('id', '=', $request->id);
                    }
                    if (!empty($request->transaction_id)) {
                        $return = $return->where('transaction_id', 'like', '%' . $request->transaction_id . '%');
                    }

                    if (!empty($request->name)) {
                        $return = $return->where('name', 'like', '%' . $request->name . '%');
                    }
                    if (!empty($request->payment_type)) {
                        $return = $return->where('payment_type', '=', $request->payment_type);
                    }
                    if (!empty($request->restaurant_id))
                    {
                        $return = $return->where('restaurant_id', '=', $request->restaurant_id);
                    }
                    if (!empty($request->status_id)) {
                        $status_id = $request->status_id;
                        if($request->status_id == 100)
                        {
                            $status_id = 0;
                        }

                        $return = $return->where('status_id','=',$status_id);
                    }
                  

                    if(!empty($request->start_date))
                    {
                        $return = $return->where('orders.added_date', '>=', $request->start_date);
                    }
                    if(!empty($request->end_date))
                    {
                        $return = $return->where('orders.added_date', '<=', $request->end_date);
                    }

                    if(Auth::user()->is_admin == 2)
                    {
                         $return = $return->where('orders.restaurant_id', '=', Auth::user()->id);   
                    }

          $return = $return->sum('total_price');
          return $return;
    }
   

   


    static public function getcountStatus($request, $status_type = '')
    {
        $return = self::select('orders.*')
                    ->where('is_delete', '=', 0)
                    ->where('is_payment', '=', 1);
                    if(!empty($status_type))
                    {
                        $return = $return->where('status_id','=',$status_type);           
                    }
                    
                    if (!empty($request->id)) {
                        $return = $return->where('id', '=', $request->id);
                    }
                    if (!empty($request->transaction_id)) {
                        $return = $return->where('transaction_id', 'like', '%' . $request->transaction_id . '%');
                    }

                    if (!empty($request->name)) {
                        $return = $return->where('name', 'like', '%' . $request->name . '%');
                    }
                    if (!empty($request->payment_type)) {
                        $return = $return->where('payment_type', 'like', '%' . $request->payment_type . '%');
                    }
                    if (!empty($request->restaurant_id))
                    {
                        $return = $return->where('restaurant_id', 'like', '%' . $request->restaurant_id . '%');
                    }
                    if (!empty($request->status_id)) {
                        $status_id = $request->status_id;
                        if($request->status_id == 100)
                        {
                            $status_id = 0;
                        }
                        $return = $return->where('status_id','=',$status_id);
                    }
                    
                    if(!empty($request->start_date))
                    {
                        $return = $return->where('orders.added_date', '>=', $request->start_date);
                    }
                    if(!empty($request->end_date))
                    {
                        $return = $return->where('orders.added_date', '<=', $request->end_date);
                    }
                    if(Auth::user()->is_admin == 2)
                    {
                         $return = $return->where('orders.restaurant_id', '=', Auth::user()->id);   
                    }

      $return = $return->count();
      return $return;
    }





}
