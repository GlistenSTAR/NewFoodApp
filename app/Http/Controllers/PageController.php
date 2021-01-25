<?php

namespace App\Http\Controllers;

use App\PageModel;
use Illuminate\Http\Request;
use Auth;

class PageController extends Controller
{
   
    public function page(Request $request)
    {
        $getrecord = PageModel::orderBy('id', 'desc');

        if ($request->id) {
            $getrecord = $getrecord->where('id', '=', $request->id);
        }
        if ($request->name) {
            $getrecord = $getrecord->where('name', 'like', '%' . $request->name . '%');
        }

        $getrecord = $getrecord->paginate(40);
        
        $data['getrecord'] = $getrecord;

        return view('admin.page.list', $data);
    }

   
   
    public function editapage ($id)
    {
        $getrecord = PageModel::find($id);
        $data['getrecord'] = $getrecord;
        return view('admin.page.edit', $data);
    }

 
    public function UpdatePage($id, Request $request) {
        $getrecord = PageModel::find($id);
    
        $getrecord->name = $request->name;
        $getrecord->description = $request->description;
        $getrecord->save();

        return redirect('admin/page')->with('success', 'Record updated Successfully!');
    }

   
}
