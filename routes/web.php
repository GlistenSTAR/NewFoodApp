<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

 */

 // Authentication Routes...
Route::post('login', 'ApiController@Login');
Route::get('logout', 'ApiController@Logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'ApiController@Register');
Route::get('register2', 'Auth\RegisterController@showRegistrationForm')->name('register2');
Route::post('register2', 'ApiController@EditProfile');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Auth::routes();

// Route::post('/customer/login', 'AuthController@clientlogin');
// Route::post('/customer/register', 'AuthController@clientregister');

Route::get('/customer/{id}/{cat?}', 'MainController@firstPage');

Route::get('/confirm-payment','MainController@confirmPage');
Route::get('/stripe-payment', [StripeController::class, 'handleGet']);
Route::post('/stripe-payment', [StripeController::class, 'handlePost'])->name('stripe.payment');


Route::get('admin', 'AuthController@adminlogin');
Route::post('admin/login', 'AuthController@adminPostlogin');
Route::get('admin/logout', 'AuthController@adminlogout');

Route::group(['middleware' => 'admin'], function () {

	//Restaurant Start
	Route::get('admin/restaurant', 'RestaurantController@restaurant');
	Route::get('admin/restaurant/add', 'RestaurantController@AddRestaurant');
	Route::post('admin/restaurant/add', 'RestaurantController@InsertRestaurant');
	Route::get('admin/restaurant/edit/{id}', 'RestaurantController@editrestaurant');
	Route::get('admin/restaurant/show/{id}', 'RestaurantController@showrestaurant');
	Route::post('admin/restaurant/edit/{id}', 'RestaurantController@UpdateRestaurant');
	Route::get('admin/restaurant/delete/{id}', 'RestaurantController@deleterestaurant');

	Route::get('admin/restaurant/partner/{id}', 'RestaurantController@partner_list');
	Route::get('admin/restaurant/partner/add/{id}', 'RestaurantController@partner_add');
	Route::post('admin/restaurant/partner/add/{id}', 'RestaurantController@partner_insert');
	Route::get('admin/restaurant/partner/edit/{id}', 'RestaurantController@partner_edit');
	Route::post('admin/restaurant/partner/edit/{id}', 'RestaurantController@partner_update');
	Route::get('admin/restaurant/partner/delete/{id}', 'RestaurantController@delete_partner');
	//Restaurant End


	Route::get('admin/restaurant/postcodes/{id}', 'RestaurantController@postcodes');
	Route::post('admin/restaurant/postcodes/{id}', 'RestaurantController@submit_postcode');
	Route::get('admin/restaurant/postcodes/delete/{id}', 'RestaurantController@delete_postcode');

	Route::get('admin/restaurant/postcodes/edit/{id}', 'RestaurantController@edit_postcode');
	Route::post('admin/restaurant/postcodes/edit/{id}', 'RestaurantController@update_postcode');


	Route::get('admin/package', 'PackageController@package');
	Route::get('admin/package/edit/{id}', 'PackageController@editpackage');
	Route::post('admin/package/edit/{id}', 'PackageController@UpdatePackage');
	//Package End

	//About start
	Route::get('admin/page', 'PageController@page');
	Route::get('admin/page/edit/{id}', 'PageController@editapage');
	Route::post('admin/page/edit/{id}', 'PageController@UpdatePage');
	//About End

	// setting Start
	Route::get('admin/setting', 'AdminController@setting');
	Route::post('admin/setting', 'AdminController@update_setting');
	// setting End


	Route::get('admin/category_option', 'CategoryController@category_option');
	Route::post('admin/category_option', 'CategoryController@category_option_item');
	Route::post('admin/get_category_ajax', 'CategoryController@get_category_ajax');

	// Support Start
	Route::get('admin/support', 'SupportController@support');
	Route::get('admin/support/delete/{id}', 'SupportController@delete_support');
	Route::get('admin/support/reply/{id}', 'SupportController@reply');
	Route::post('admin/support/reply/{id}', 'SupportController@reply_insert');
	Route::get('admin/change_support_status', 'SupportController@change_support_status');
	// Support End



});


Route::group(['middleware' => 'restaurant'], function () {
	Route::get('admin/dashboard', 'AdminController@dashboard');

	Route::get('admin/myaccount', 'UserController@myaccount');
	Route::post('admin/myaccount', 'UserController@update');

	//category Start
	Route::get('admin/category', 'CategoryController@category');
	Route::get('admin/category/add', 'CategoryController@AddCategory');
	Route::post('admin/category/add', 'CategoryController@InsertCategory');
	Route::get('admin/category/edit/{id}', 'CategoryController@editCategory');
	Route::post('admin/category/edit/{id}', 'CategoryController@UpdateCategory');
	Route::get('admin/category/delete/{id}', 'CategoryController@deleteCategory');
	//category end

	//Item Start
	Route::get('admin/item', 'ItemController@item');
	Route::get('admin/item/add', 'ItemController@AddItem');
	Route::post('admin/item/add', 'ItemController@InsertItem');
	Route::get('admin/item/edit/{id}', 'ItemController@editItem');
	Route::post('admin/item/edit/{id}', 'ItemController@UpdateItem');
	Route::get('admin/item/delete/{id}', 'ItemController@deleteItem');
	Route::get('admin/item/show/{id}', 'ItemController@showitem');

	Route::get('admin/item/delete_option_multi', 'ItemController@delete_option_multi');
	Route::get('admin/item/delete_item_multi', 'ItemController@delete_item_multi');


	Route::get('admin/item/option/delete/{id}', 'ItemController@deleteoptionitem');
	//Item End

	//Schedule Start

	Route::get('admin/schedule', 'UserTimeController@schedule');
	Route::post('admin/schedule', 'UserTimeController@updateschedule');

	// end Schedule
	// Notification Start
	Route::get('admin/notification', 'NotificationController@notification');
	Route::post('admin/notification', 'NotificationController@updateNotification');
	// Notification End


	//Orders Start

	Route::get('admin/orders', 'OrdersController@orders');
	Route::get('admin/orders/delete/{id}', 'OrdersController@deleteOrders');
	Route::get('admin/orders/show/{id}', 'OrdersController@showorders');
	// Route::get('admin/orders/downloadPDF/{id}','OrdersController@downloadPDF');
	Route::get('admin/review', 'OrdersController@review');
	Route::get('admin/review/delete/{id}', 'OrdersController@deletereview');
	Route::get('admin/change_review_status', 'OrdersController@change_review_status');
	Route::get('admin/item/delete_order_multi', 'OrdersController@delete_order_multi');

	//Orders End

	Route::get('admin/changeStatus', 'OrdersController@changeStatus');
	Route::get('admin/payment', 'PaymentController@payment');
	// customer
	Route::get('admin/customer', 'CustomerController@customer');
	Route::get('admin/customer/delete/{id}', 'CustomerController@delete');

	// Discount code start
	Route::get('admin/discountcode', 'DiscountcodeController@index');
	Route::get('admin/discountcode/add', 'DiscountcodeController@create');
	Route::post('admin/discountcode/insert', 'DiscountcodeController@store');
	Route::get('admin/discountcode/edit/{id}', 'DiscountcodeController@edit');
    Route::post('admin/discountcode/update/{id}', 'DiscountcodeController@update');
    Route::get('admin/discountcode/delete/{id}', 'DiscountcodeController@destroy');
	// Route::get('admin/discountcode/show/{id}', 'DiscountcodeController@show');
	// Discount code end




	Route::get('admin/ageid', 'AgeIdController@index');
	Route::get('admin/ageid/updatestatus/{id}', 'AgeIdController@updatestatus');
	Route::get('admin/ageid/delete/{id}', 'AgeIdController@destroy');
	Route::post('admin/ageid/add_reason', 'AgeIdController@add_reason');

});

