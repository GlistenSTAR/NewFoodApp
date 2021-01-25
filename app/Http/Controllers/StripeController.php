<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Session;




class StripeController extends Controller
{
    public function handleGet()
    {
        return view('client.stripe');
    }
  
    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        Charge::create ([
                "amount" => 100 * $request->chargeAmount,
                "currency" => "GBP",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);

        Stripe::setPublishableKey(env('STRIPE_KEY'));
        

        $pur_arr = json_decode($request->purchase_list);
        $user_id = $request->userID;
        $restaurant_id = $request->restaurantID;

        echo $user_id;
        echo $restaurant_id;

        foreach ($pur_arr as $pur){
            echo $pur->itemID;
        } 
        // die;
  
        Session::flash('success', 'Payment has been successfully processed.');
          
        return back();
    }
}
