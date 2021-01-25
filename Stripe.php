<?php
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

print_r('"');


header('Content-Type: application/json');
$YOUR_DOMAIN = env('APP_URL');
$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'usd',
      'unit_amount' => 2000,
      'product_data' => [
        'name' => 'Stubborn Attachments',
        'images' => ["https://i.imgur.com/EHyR2nP.png"],
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN ,
  'cancel_url' => $YOUR_DOMAIN ,
]);

// echo json_encode(3456);
// echo json_encode(['id' => $checkout_session->id]);

return "3";

?>