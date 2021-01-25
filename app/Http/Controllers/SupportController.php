<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportModel;
use App\SupportReplyModel;
use App\User;
use Auth;
use DB; 

class SupportController extends Controller
{
  
    public function support(Request $request)
    {
        $getrecord = SupportModel::getSupportList($request);
        $data['user'] = $getrecord;
        $data['getUser'] = User::getUser();
        return view('admin.support.list', $data);
    }

    public function reply($id)
    {
        $getrecord = SupportModel::where('id','=',$id);
        $getrecord = $getrecord->first();   
        $data['edit'] = $getrecord;
        return view('admin.support.reply', $data);
    }
    
    public function reply_insert($id, Request $request)
    {
        //dd(request()->all());
        $getrecord = new SupportReplyModel;
        $getrecord->user_id     = Auth::user()->id;
        $getrecord->support_id  = $request->id;
        $getrecord->description = $request->description;
        $getrecord->save();
        return redirect('admin/support/reply/'.$id)->with('success', 'Record updated Successfully!');
    }

    public function delete_support($id)
    {
        $support = SupportModel::where('id','=',$id)->where('user_id','=',Auth::user()->id)->delete();
        $getSupportReply = SupportReplyModel::where('support_id', '=', $id)->where('user_id','=',Auth::user()->id)->get();
        if (!empty(count($getSupportReply))) {
            foreach($getSupportReply as $list)
            {
                SupportReplyModel::find($list->id)->delete();
            }
        }
        return redirect('admin/support')->with('success', 'Record successfully deleted!');
    }

    public function change_support_status(Request $request)
    {
        $record = SupportModel::find($request->id);
        $record->status = $request->status;
        $record->save();

        $json['success'] = true;
        echo json_encode($json);
    }


}
