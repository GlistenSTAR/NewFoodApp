<?php

namespace App\Http\Controllers;

use App\PackageModel;
use Illuminate\Http\Request;
use Auth;

class PackageController extends Controller
{
    public function package (Request $request)
    {
        $getrecord = PackageModel::orderBy('id', 'desc');

        if ($request->id) {
            $getrecord = $getrecord->where('id', '=', $request->id);
        }
        if ($request->name) {
            $getrecord = $getrecord->where('name', 'like', '%' . $request->name . '%');
        }
        if(Auth::user()->is_admin == 2) {
            $getrecord = $getrecord->where('restaurant_id', '=', Auth::user()->id);   
        }

       $getrecord = $getrecord->paginate(40);
       $data['getrecord'] = $getrecord;
       return view('admin.package.list', $data);
    }

    public function editpackage ($id)
    {
        $getrecord = PackageModel::find($id);
        $data['getrecord'] = $getrecord;
        return view('admin.package.edit', $data);
    }

    public function UpdatePackage($id, Request $request) {
		$getrecord = PackageModel::find($id);

	    $getrecord->name = $request->name;
        $getrecord->price = !empty($request->price) ? $request->price : '0';
		$getrecord->save();
		return redirect('admin/package')->with('success', 'Record updated Successfully!');
	}

}
