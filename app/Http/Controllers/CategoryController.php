<?php

namespace App\Http\Controllers;

use App\CategoryModel;
use Illuminate\Http\Request;
use Auth;
use File;
use App\User;
use App\ItemModel;
use App\ItemoptionModel;

class CategoryController extends Controller {

	public function category(Request $request) {
		$getrecord = CategoryModel::orderBy('id', 'desc')->where('is_delete','=',0);
		if ($request->id) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}
		if ($request->name) {
			$getrecord = $getrecord->where('name', 'like', '%' . $request->name . '%');
		}
		if(Auth::user()->is_admin == 2)
		{
			$getrecord = $getrecord->where('user_id', '=', Auth::user()->id);	
		}
		$getrecord = $getrecord->paginate(40);
		$data['getrecord'] = $getrecord;
		return view('admin.category.list', $data);
	}

	public function AddCategory() {
		return view('admin.category.add');
	}

	public function InsertCategory(Request $request) {

		$record = new CategoryModel;
		$record->name = trim($request->name);
		$record->user_id = Auth::user()->id;

		if (!empty($request->file('logo'))){
			$ext = 'jpg';
			$file = $request->file('logo');
			$randomStr = str_random(30);
			$filename = strtolower($randomStr) . '.' . $ext;
			$file->move('upload/category/', $filename);
			$record->logo = $filename;
		}

		$record->status = trim($request->status);
		if(!empty(Auth::user()->is_age))
		{
			$record->is_age = !empty($request->is_age) ? 1 : 0;	
		}
		$record->category_order_by = !empty($request->category_order_by) ? $request->category_order_by : '0';
		$record->save();
		return redirect('admin/category')->with('success', 'Category created Successfully!');
	}

	public function editCategory($id) {
		$getrecord = CategoryModel::where('id','=',$id);
		if(Auth::user()->is_admin == 2)
		{
			$getrecord = $getrecord->where('user_id', '=', Auth::user()->id);	
		}
		$getrecord = $getrecord->first();	
		$data['getrecord'] = $getrecord;
		return view('admin.category.edit', $data);
	}

	public function UpdateCategory($id, Request $request) {
		$record = CategoryModel::find($id);
		$record->name = trim($request->name);
		if (!empty($request->file('logo'))){

			if(!empty($record->logo) && file_exists('upload/category/'. $record->logo))
	        {
	          	unlink('upload/category/'. $record->logo);
	        }

			$ext = 'jpg';
			$file = $request->file('logo');
			$randomStr = str_random(30);
			$filename = strtolower($randomStr) . '.' . $ext;
			$file->move('upload/category/', $filename);
			$record->logo = $filename;
		}
		$record->status = trim($request->status);
		if(!empty(Auth::user()->is_age))
		{
			$record->is_age = !empty($request->is_age) ? 1 : 0;	
		}
		
		$record->category_order_by = !empty($request->category_order_by) ? $request->category_order_by : '0';

		$record->save();
		return redirect('admin/category')->with('success', 'Category updated Successfully!');
	}

	public function deleteCategory($id) {
		$getrecord = CategoryModel::find($id);
		$getrecord->is_delete = '1';
		$getrecord->save();
		return redirect('admin/category')->with('success', 'Record successfully deleted!');
	}



	public function category_option(Request $request) {
	  	$data['getUser'] = User::where('is_admin','=',2)->get();
		return view('admin.category_option', $data);
	}

	public function get_category_ajax(Request $request)
	{
		$html =  '';
		$getCategory = CategoryModel::where('user_id', '=', $request->id)->get();

		$html .= '<option value="">Select Category</option>';

		foreach ($getCategory as $key => $value) {
			$html .= '<option value="'.$value->id.'">'.$value->name.'</option>';			
		}

		$json['success'] = $html;
		echo json_encode($json);
	}

	public function category_option_item(Request $request)
	{
		$item = ItemModel::where('category_id','=',$request->category_id)->get();

		foreach ($item as $value_item) {

		    if(!empty($request->option))
	        {   
	            foreach ($request->option as $value) {
	                $item = new ItemoptionModel;
	                $item->item_id = $value_item->id;
	                $item->group_name = !empty($value['group_name'])?$value['group_name']:0;
	                $item->option_name = !empty($value['option_name'])?$value['option_name']:null;
	                $item->option_price = !empty($value['option_price'])?$value['option_price']:0;
	                $item->save();
	            }
	        }

		}

		return redirect('admin/category_option')->with('success', 'Category option added done!');

	}


}
