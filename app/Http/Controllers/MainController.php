<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\CategoryModel;
use App\User;
use App\UserTimeModel;
use App\ItemModel;
use Auth;
use DB;
use Session;

class MainController extends Controller
{
    public function firstPage($id, $cat = 1){

        $restaurant = User::where('restaurant_id','=',$id)->where('package_id','=','1')->first();
        $time = UserTimeModel::where('user_id','=',$id)->orderBy('week_id','asc')->get();
        $category = CategoryModel::where('user_id','=',$id)->where('status', '=', '0')->where('is_delete','=','0')->orderBy('category_order_by','asc')->get();
        $items = ItemModel::where('user_id','=',$id)->where('category_id','=',$cat)->orderBy('order_by','asc')->get();

        foreach ($items as $item){

            $options =  DB::table('item_option')->where('item_id','=',$item->id)->select('id','option_name','option_price')->get();
            // echo(json_encode($options));die;
            $item['options'] = $options;
        }

        // echo(json_encode($items));die;
        
        return view("client.main",['restaurant'=>$restaurant,'time'=>$time,'category'=>$category,'items'=>$items,'user'=>'guest','message'=>'']);
    }

    public function confirmPage(){

        $user_id = Session::get('userid');
        $user = User::where('id','=',$user_id);


        return view("client.confirm",['user'=>$user]);

    }

    
}
