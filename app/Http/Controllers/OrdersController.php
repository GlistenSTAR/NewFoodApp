<?php

namespace App\Http\Controllers;

use App\OrdersModel;
use App\OrderStatusModel;
use App\SettingModel;

// use PDF;
use App\User;
use Illuminate\Http\Request;
use Auth;

class OrdersController extends Controller
{
    
     public function orders(Request $request)
    {

        $getrecord = OrdersModel::getRecordOrder($request);
       
        $data['getrecord'] = $getrecord;

        $data['getUser']   = User::getUser();

        $data['getStatus'] = OrderStatusModel::getStatus();


        $data['countTotal']                = OrdersModel::getcountStatus($request, '');

        $data['countStatusPending']        = OrdersModel::getcountStatus($request, 1);
        $data['countStatusAccepted']       = OrdersModel::getcountStatus($request, 2);
        $data['countStatusProcessing']     = OrdersModel::getcountStatus($request, 3);
        $data['countStatusDelivered']      = OrdersModel::getcountStatus($request, 4);
        $data['countStatusOrderCancelled'] = OrdersModel::getcountStatus($request, 5);


        $data['TotalAmount']                = OrdersModel::getStatusTotal($request, '');    
        $data['CardAmountTotal']            = OrdersModel::getStatusTotal($request, 'Card');
        $data['CashAmountTotal']            = OrdersModel::getStatusTotal($request, 'Cash');


        $data['countPendingTotal']         = OrdersModel::getStatusTotal($request,1);
        $data['countAcceptedTotal']        = OrdersModel::getStatusTotal($request,2);
        $data['countProcessingTotal']      = OrdersModel::getStatusTotal($request,3);
        $data['countDeliveredTotal']       = OrdersModel::getStatusTotal($request,4);
        $data['countOrderCancelledTotal']  = OrdersModel::getStatusTotal($request,5);
    


        return view('admin.orders.list', $data);  
    }

    
    public function deleteOrders($id) {
        $getrecord = OrdersModel::find($id);
        $getrecord->is_delete = 1;
        $getrecord->save();
        return redirect('admin/orders')->with('success', 'Record successfully deleted!');
    }

    public function delete_order_multi(Request $request) {

       if(!empty($request->id))
        {
            $option = explode(',', $request->id);
            foreach($option as $id)
            {
                if(!empty($id))
                {
                    $getrecord = OrdersModel::find($id);
                    $getrecord->is_delete = 1;
                    $getrecord->save();       
                }
            }
        }
      
        return redirect('admin/orders')->with('success', 'Record successfully deleted!');
    }




    public function showorders($id) {
        if(Auth::user()->is_admin == 2)
        {
            $getrecord = OrdersModel::where('id','=',$id)->where('restaurant_id', '=', Auth::user()->id)->first();               
        }
        else
        {
            $getrecord = OrdersModel::find($id);
        }

        if(!empty($getrecord))
        {

            
            $data['getrecord'] = $getrecord;
            $data['getStatus'] = OrderStatusModel::getStatus();
            return view('admin.orders.view', $data);
        }
        else
        {
            return redirect(url('admin/orders'));
        }
        
    }

    public function changeStatus(Request $request) {


        $order = OrdersModel::find($request->order_id);
        $order->status_id = $request->status_id;
        $order->save();

        $this->sendPushNotification($order->status_id, $order->user_id);

        $json['success'] = true;
        echo json_encode($json);



    }

    public function sendPushNotification($status_id,$user_id) {
        $status = OrderStatusModel::find($status_id);
        $user   = User::find($user_id);

        $result = SettingModel::find(1);       
        $serverKey = $result->notification_key;

        try {
            if(!empty($user->token))
            {
                $token           = $user->token;

                $body['message'] = $status->message;
                $body['body'] = $status->message;
                $body['title']   = $status->title;

                $url = "https://fcm.googleapis.com/fcm/send";

                $notification = array('title' => $status->title, 'body' => $status->message);

                $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $body, 'priority' => 'high');

                $json1 = json_encode($arrayToSend);
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: key=' . $serverKey;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                //Send the request
                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        catch (\Exception  $e) {
        
        }
    }

    // public function downloadPDF($id) {
    //     $getrecord = OrdersModel::find($id);
    //     // dd($getrecord);
    //     $pdf = PDF::loadView('admin.orders.pdf', compact('getrecord'));
        
    //     return $pdf->download('invoice.pdf');
    // }

    public function review(Request $request){
        $getrecord = OrdersModel::orderBy('id', 'desc')->where('review', '!=', '');

        // Search box start
        if ($request->id) {
            $getrecord = $getrecord->where('id', '=', $request->id);
        }
        if ($request->name) {
            $getrecord = $getrecord->where('name', 'like', '%' . $request->name . '%');
        }
  
        if ($request->review) {
            $getrecord = $getrecord->where('review', 'like', '%' . $request->review . '%');
        }
        // Search box End
        if(Auth::user()->is_admin == 2)
        {
             $getrecord = $getrecord->where('restaurant_id', '=', Auth::user()->id);   
        }

        $getrecord = $getrecord->paginate(40);
        $data['getrecord'] = $getrecord;

        return view('admin.orders.review', $data);
    }

    public function change_review_status(Request $request)
    {
        $order = OrdersModel::find($request->id);
        $order->is_review = $request->status;
        $order->save();

        $json['success'] = true;
        echo json_encode($json);

    }

    public function deletereview($id) {
        if(Auth::user()->is_admin == 2)
        {
            $user = OrdersModel::where('id','=',$id)->where('restaurant_id','=',Auth::user()->id)->first();
        }
        else
        {
            $user = OrdersModel::find($id);
        }
        
        $user->review = null;
        $user->rating = 0;
        $user->is_review = 0;
        $user->save();
        return redirect('admin/review')->with('success', 'Record successfully deleted!');
    }
    
   
    
}


