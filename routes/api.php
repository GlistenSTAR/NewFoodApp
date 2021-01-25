<?php

// Route::post('login', 'ApiController@Login');
// Route::post('register', 'ApiController@Register');
// Route::post('forgotpassword', 'ApiController@forgotpassword');

// Route::post('mobile_check', 'ApiController@mobile_check');
// Route::post('check_forgot_password', 'ApiController@check_forgot_password');



Route::post('getrestaurant', 'ApiController@getRestaurant');


Route::post('getprofile', 'ApiController@getProfile');
Route::post('updateprofile', 'ApiController@UpdateProfile');
Route::post('updatepassword', 'ApiController@updatepassword');
Route::post('updateimage', 'ApiController@UpdateImage');



Route::post('getcategory', 'ApiController@getCategory');
Route::post('getitem', 'ApiController@getItem');
Route::post('getitemdetail', 'ApiController@getItemDetail');


Route::get('getpage', 'ApiController@getpage');
Route::post('tokensave', 'ApiController@tokensave');


// cart

Route::post('add_cart_update', 'ApiController@add_cart_update');
Route::post('get_cart', 'ApiController@getCartDetail');
Route::post('delete_cart', 'ApiController@DeleteCart');


// place order


Route::post('get_my_order_restaurant', 'ApiController@get_my_order_restaurant');
Route::post('get_my_order_detail_restaurant', 'ApiController@get_my_order_detail_restaurant');
Route::post('change_order_status_restaurant', 'ApiController@change_order_status_restaurant');
Route::post('notify_customer_restaurant', 'ApiController@notify_customer_restaurant');
Route::post('send_notification_restaurant', 'ApiController@send_notification_restaurant');


Route::post('get_my_order_partner', 'ApiController@get_my_order_partner');
Route::post('get_my_order_detail_partner', 'ApiController@get_my_order_detail_partner');
Route::post('change_order_status_partner', 'ApiController@change_order_status_partner');





Route::post('place_order', 'ApiController@place_order');
Route::post('get_my_order', 'ApiController@get_my_order');
Route::post('get_my_order_detail', 'ApiController@get_my_order_detail');


Route::post('stripe_payment', 'ApiController@stripe_payment');
Route::post('place_order_status', 'ApiController@place_order_status');


Route::post('write_order_review', 'ApiController@write_order_review');

Route::post('get_order_review', 'ApiController@get_order_review');

Route::post('apply_discount', 'ApiController@ApplyDiscount');


Route::post('update_bank_detail', 'ApiController@update_bank_detail');

Route::post('get_today_restaurant_detail', 'ApiController@get_today_restaurant_detail');



Route::post('app_get_age_id', 'ApiController@app_get_age_id');


Route::post('app_age_id_upload', 'ApiController@app_age_id_upload');
Route::post('app_get_age_id_restaurant_list', 'ApiController@app_get_age_id_restaurant_list');
Route::post('app_update_status_age_id', 'ApiController@app_update_status_age_id');
// 26-11-2020

Route::post('app_submit_support', 'ApiController@app_submit_support');
Route::post('app_get_support', 'ApiController@app_get_support');
Route::post('app_support_reply', 'ApiController@app_support_reply');
Route::post('app_get_schedule', 'ApiController@app_get_schedule');
Route::post('app_submit_schedule', 'ApiController@app_submit_schedule');

Route::post('app_assign_partner', 'ApiController@app_assign_partner');















