<?php

namespace App\Http\Controllers;

use App\DiscountcodeModel;
use App\CategoryModel;
use App\DiscountCategoryModel;
use Illuminate\Http\Request;
use Auth;
class DiscountcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = DiscountcodeModel::orderBy('id', 'desc')->where('is_delete','=',0);
       
        if ($request->id) {
            $getrecord = $getrecord->where('id', '=', $request->id);
        }
        if ($request->discount_code) {
            $getrecord = $getrecord->where('discount_code', 'like', '%' . $request->discount_code . '%');
        }
        if ($request->discount_price) {
            $getrecord = $getrecord->where('discount_price', 'like', '%' . $request->discount_price . '%');
        }
         if ($request->type) {
            $type = $request->type;
            if($request->type == 100)
            {
                $type = 0;
            }

            $getrecord = $getrecord->where('type','=',$type);
        }

        if(Auth::user()->is_admin == 2)
        {
             $getrecord = $getrecord->where('user_id', '=', Auth::user()->id);   
        }
        
        $getrecord = $getrecord->paginate(40);
        $data['getrecord'] = $getrecord;

       

        return view('admin.discount_code.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $data['getCategory'] = CategoryModel::getCategoryUserWise();
       return view('admin.discount_code.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new DiscountcodeModel;
        $record->user_id = Auth::user()->id;
        $record->discount_code = trim(strtoupper($request->discount_code));
        $record->expiry_date = trim($request->expiry_date);
        $record->discount_price = !empty($request->discount_price) ? $request->discount_price : '0';
        $record->type  = trim($request->type);
        $record->usage  = trim($request->usage);
        $record->save();


        
        if(!empty($request->category_id))
        {
            foreach ($request->category_id as  $category_id) {
                $category = new DiscountCategoryModel;
                $category->discount_id = $record->id;
                $category->category_id = $category_id;
                $category->save();
            }    
        }
        
        return redirect('admin/discountcode')->with('success', 'Discount code created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscountcodeModel  $discountcodeModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['getrecord'] = DiscountcodeModel::find($id);
        
        return view('admin.discount_code.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscountcodeModel  $discountcodeModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 2)
        {
            $getrecord = DiscountcodeModel::where('user_id', '=', Auth::user()->id)->where('id','=',$id)->first();
        }
        else
        {
            $getrecord = DiscountcodeModel::find($id); 
        }

        $data['getrecord'] = $getrecord;

        $data['getCategory'] = CategoryModel::getCategoryUserWise();

        $data['getCategoryOption'] = DiscountCategoryModel::where('discount_id','=',$id)->get();


        return view('admin.discount_code.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountcodeModel  $discountcodeModel
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        if(Auth::user()->is_admin == 2)
        {
            $record = DiscountcodeModel::where('user_id', '=', Auth::user()->id)->where('id','=',$id)->first();
        }
        else
        {
            $record = DiscountcodeModel::find($id); 
        }
        $record->discount_code = trim(strtoupper($request->discount_code));
        $record->expiry_date = trim($request->expiry_date);
        $record->discount_price = !empty($request->discount_price) ? $request->discount_price : '0';
        $record->type  = trim($request->type);
        $record->usage  = trim($request->usage);
        $record->save();

        DiscountCategoryModel::where('discount_id','=',$record->id)->delete();

        if(!empty($request->category_id))
        {
            foreach ($request->category_id as  $category_id) {
                $category = new DiscountCategoryModel;
                $category->discount_id = $record->id;
                $category->category_id = $category_id;
                $category->save();
            }    
        }
        
       return redirect('admin/discountcode')->with('success', 'Discount code updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountcodeModel  $discountcodeModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->is_admin == 2)
        {
            $getrecord = DiscountcodeModel::where('user_id', '=', Auth::user()->id)->where('id','=',$id)->first();
        }
        else
        {
            $getrecord = DiscountcodeModel::find($id); 
        }
        $getrecord->delete();
        return redirect('admin/discountcode')->with('success', 'Record successfully deleted!');
    }
}
