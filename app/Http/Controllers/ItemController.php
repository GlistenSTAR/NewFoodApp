<?php
namespace App\Http\Controllers;

use App\ItemModel;
use Illuminate\Http\Request;
use Auth;
use File;
use App\User;
use App\CategoryModel;
use App\ItemoptionModel;

class ItemController extends Controller {

    public function item(Request $request)
    {


//           $getrecord = ItemModel::where('is_delete', '=', '1')->get();  
//           foreach($getrecord as $item)
//           {

//                 ItemoptionModel::where('item_id','=',$item->id)->delete();

//                 $save = ItemModel::find($item->id);
//                 $save->delete();
//           }


        // $category  = CategoryModel::get();  
        
        // foreach ($category as  $value) {
        //       $i = 1;

        //       $getrecord = ItemModel::where('category_id', '=', $value->id)->orderBy('id', 'asc')->get();  

        //       foreach($getrecord as $item)
        //       {
        //             $save = ItemModel::find($item->id);
        //             $save->order_by = $i;
        //             $save->save();
        //             $i++;
        //       }

        // }


        $getrecord = ItemModel::orderBy('id', 'desc')->where('is_delete','=',0);
       
        if ($request->id) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}
		if ($request->item_name) {
			$getrecord = $getrecord->where('item_name', 'like', '%' . $request->item_name . '%');
        }
         if ($request->user_id) {
            $getrecord = $getrecord->where('user_id', '=',  $request->user_id );
        }
        if ($request->category_id) {
            $getrecord = $getrecord->where('category_id', '=', $request->category_id);
        }
       

        if(Auth::user()->is_admin == 2)
		{
			$getrecord = $getrecord->where('user_id', '=', Auth::user()->id);	
		}
		$getrecord = $getrecord->paginate(40);

        $data['getrecord'] = $getrecord;



        if(Auth::user()->is_admin == 2)
        {
            $data['getCategory'] = CategoryModel::where('user_id','=',Auth::user()->id)->where('status','=','0')->where('is_delete','=','0')->get();
        }
        else
        {
            $data['getCategory'] = CategoryModel::where('status','=','0')->where('is_delete','=','0')->get();
        }

       
        $data['getUser'] = User::getUser();

        return view('admin.item.list', $data);
    }
    
    public function AddItem ()
    {
       if(Auth::user()->is_admin == 2)
        {
            $data['category_row'] = CategoryModel::where('user_id','=',Auth::user()->id)->where('status','=','0')->where('is_delete','=','0')->get();
        }
        else
        {
            $data['category_row'] = CategoryModel::where('status','=','0')->where('is_delete','=','0')->get();
        }
        


        return view('admin.item.add', $data);
    } 

    public function InsertItem(Request $request) {
       
       
        $record = new ItemModel;
		$record->category_id = trim($request->category_id);
		$record->user_id = Auth::user()->id;

        if(!empty($request->file('item_image'))){
            $ext = 'jpg';
            $file = $request->file('item_image');
            $randomStr = str_random(30);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/item/', $filename);
            $record->item_image = $filename;

        }

        $record->item_name          = trim($request->item_name);
        $record->item_description   = trim($request->item_description);
        $record->price              = !empty($request->price) ? $request->price : '0';
		$record->status             = trim($request->status);
        $record->order_by           = trim($request->order_by);

        $record->option_type = trim($request->option_type);
        $record->option_size = !empty($request->option_size) ? $request->option_size : 0;

        $record->save();

        if(!empty($request->option))
        {   
            foreach ($request->option as $value) {
                $item = new ItemoptionModel;
                $item->item_id = $record->id;
                $item->group_name = !empty($value['group_name'])?$value['group_name']:'0';
                $item->option_name = !empty($value['option_name'])?$value['option_name']:null;
                $item->option_price = !empty($value['option_price'])?$value['option_price']:0;
                $item->save();
            }
        }
        
      

		return redirect('admin/item')->with('success', 'Item created successfully!');
	}

    
    public function editItem($id) {
        $getrecord = ItemModel::where('id','=',$id);
		if(Auth::user()->is_admin == 2)
		{
			$getrecord = $getrecord->where('user_id', '=', Auth::user()->id);	
		}
        $getrecord = $getrecord->first();	
        

        $data['getrecord'] = $getrecord;

         if(Auth::user()->is_admin == 2)
        {
            $data['category_row'] = CategoryModel::where('user_id','=',Auth::user()->id)->where('status','=','0')->where('is_delete','=','0')->get();
        }
        else
        {
            $data['category_row'] = CategoryModel::where('status','=','0')->where('is_delete','=','0')->get();
        }

        
		return view('admin.item.edit', $data);
    }
    
    public function UpdateItem($id, Request $request) {
		$record = ItemModel::find($id);
        $record->category_id = trim($request->category_id);
        $record->item_name = trim($request->item_name);
        $record->item_description = trim($request->item_description);
        if (!empty($request->file('item_image')))
        {
            if (!empty($record->item_image) && file_exists('upload/item/'.$record->item_image))
            {
                unlink('upload/item/'.$record->item_image);
            }
            $ext = 'jpg';
            $file = $request->file('item_image');
            $randomStr = str_random(30);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/item/', $filename);
            $record->item_image = $filename;
        }
        $record->price = !empty($request->price) ? $request->price : '0';
        $record->order_by = trim($request->order_by);
        $record->status = trim($request->status);

        $record->option_type = trim($request->option_type);
        $record->option_size = !empty($request->option_size) ? $request->option_size : 0;

		$record->save();

       if(!empty($request->option))
        {   
            foreach ($request->option as $value) {

                if(!empty($value['id']))
                {
                    $item = ItemoptionModel::find($value['id']);
                }
                else
                {
                    $item = new ItemoptionModel;    
                }
                
                $item->item_id = $record->id;
                $item->group_name = !empty($value['group_name'])?$value['group_name']:'0';
                $item->option_name = !empty($value['option_name'])?$value['option_name']:null;
                $item->option_price = !empty($value['option_price'])?$value['option_price']:0;
                $item->save();
            }
        }
        


		return redirect('admin/item')->with('success', 'Item updated successfully!');
	}
    
    public function deleteItem($id) {
		$getrecord = ItemModel::find($id);
		$getrecord->is_delete = '1';
		$getrecord->save();
		return redirect('admin/item')->with('success', 'Record successfully deleted!');
	}


    public function delete_item_multi(Request $request){
        if(!empty($request->id))
        {
            $option = explode(',', $request->id);
            foreach($option as $id)
            {
                if(!empty($id))
                {
                    $getrecord = ItemModel::find($id);
                    $getrecord->is_delete = '1';
                    $getrecord->save();
                }
            }
        }
        return redirect()->back()->with('success', 'Option successfully deleted!');
    }


    

    public function deleteoptionitem($id){
        $getrecord = ItemoptionModel::find($id);
        $getrecord->is_delete = '1';
        $getrecord->save();
        return redirect()->back()->with('success', 'Option successfully deleted!');
    }

    public function delete_option_multi(Request $request){
        if(!empty($request->id))
        {
            $option = explode(',', $request->id);
            foreach($option as $id)
            {
                if(!empty($id))
                {
                    $getrecord = ItemoptionModel::find($id);
                    $getrecord->is_delete = '1';
                    $getrecord->save();            
                }
            }
        }
        return redirect()->back()->with('success', 'Option successfully deleted!');
    }

    

    public function showitem($id) {
        $data['getrecord'] = ItemModel::find($id);
        $data['categorys'] = CategoryModel::where('user_id','=',Auth::user()->id)->where('status','=','0')->where('is_delete','=','0')->get();
		return view('admin.item.view', $data);
	}

    
}
