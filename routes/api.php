<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\SampleController;
 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any("cc_cancle",[ApiController::class,"cc_cancle"])->name("cc_cancle");

Route::any("cc_request_res",[ApiController::class, "cc_request_res"])->name("cc_request_res");

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any("current_date_time",[ApiController::class,"current_date_time"])->name("current_date_time");
Route::any("pay_online",[ApiController::class,"pay_online"])->name("pay_online");
Route::any("pay_online_server",[ApiController::class,"pay_online_server"])->name("pay_online_server");

Route::any("teststore",[ApiController::class,"teststore"])->name("teststore");

Route::get("add_all_reviews",[ApiController::class,"add_all_reviews"]);
Route::post("login",[ApiController::class,"post_login"]);
Route::post("OTP_login",[ApiController::class,"OTP_login"]);
Route::post("register",[ApiController::class,"post_register"]);
Route::any("savetoken",[ApiController::class,"post_savetoken"]);
Route::any("getcategory",[ApiController::class,"get_category"]);
Route::any("serach_category",[ApiController::class,"serach_category"]);
Route::any("category_detail",[ApiController::class,"get_category_detail"]);
Route::any("forgotpassword",[ApiController::class,"forgotpassword"]);
Route::any("package_detail",[ApiController::class,"package_detail"]);
Route::any("profile_detail",[ApiController::class,"profile_detail"]);
Route::any("parameter_detail",[ApiController::class,"parameter_detail"]);
Route::any("get_popular_package_list",[ApiController::class,"get_popular_package_list"]);
Route::any("save_member",[ApiController::class,"save_member"]);
Route::get("delete_member",[ApiController::class,"delete_member"]);
Route::get("get_member_list",[ApiController::class,"get_member_list"]);

Route::any("saveaddress",[ApiController::class,"save_address"]);
Route::get("getaddress",[ApiController::class,"getaddress"]);
Route::get("delete_address",[ApiController::class,"delete_address"]);
Route::any("booknow",[ApiController::class,"booknow"]);
Route::any("booknow_v2",[ApiController::class,"booknow_v2"]);
Route::any("edit_profile",[ApiController::class,"edit_profile"]);
Route::any("add_review",[ApiController::class,"add_review"]);
Route::any("book_filter",[ApiController::class,"book_filter"]);
Route::any("add_feedback",[ApiController::class,"add_feedback"]);
Route::get("update_cart",[ApiController::class,"update_cart"]);
Route::get("get_cart",[ApiController::class,"get_cart"]);
Route::get("get_cart_v2",[ApiController::class,"get_cart_v2"]);
Route::get("book_detail",[ApiController::class,"book_detail"]);
Route::get("get_city",[ApiController::class,"get_city"]);
Route::get("get_city_test",[ApiController::class,"get_city_test"]);
Route::any("get_lab",[ApiController::class,"get_lab"]);
Route::any("get_parameters",[ApiController::class,"get_pera"]);

Route::get("get_lab_test_package",[ApiController::class,"get_lab_test_package"]);

Route::post("get_test",[ApiController::class,"get_test"]);
Route::get("get_test",[ApiController::class,"get_test"]);
Route::get("get_package",[ApiController::class,"get_package"]);

Route::post("get_test_package_lab_data",[ApiController::class,"get_test_package_lab_data"]);

Route::any("sendOTP",[ApiController::class,"sendOTP"]);

Route::get("coupon",[ApiController::class,"coupon"]);

Route::get("get_offer",[ApiController::class,"get_offer"]);

Route::get("get_user_wallet",[ApiController::class,"get_user_wallet"]);

Route::get("getUsersByCity",[ApiController::class,"getUsersByCity"]);

Route::get("getWalletSetting",[ApiController::class,"getWalletSetting"]);

Route::get("banner",[ApiController::class,"banner"]);

Route::any("homevisit_request",[ApiController::class,"homevisit"]);

Route::any("homevisit_get",[ApiController::class,"homeget"]);

Route::any("slots",[ApiController::class,"slots"]);

Route::any("upload_prescription",[ApiController::class,"upload_prescription"]); 

Route::any("get_prescription",[ApiController::class,"get_prescription"]); 

Route::any("request_callback",[ApiController::class,"request_callback"]); 

Route::any("search",[ApiController::class,"search"]); 

Route::any("search_suggestion",[ApiController::class,"search_suggestion"]);
Route::any("search_suggestion_v2",[ApiController::class,"search_suggestion_v2"]);

Route::any("OTP_verify",[ApiController::class,"OTP_verify"]);

Route::any("delete_account",[ApiController::class,"delete_account"]);
Route::any("applycoupon",[ApiController::class,"applycoupon"]);
Route::any("applycoupon_v2",[ApiController::class,"applycoupon_v2"]);

Route::post("server_book_payment",[ApiController::class,"server_book_payment"]);


// ------------Transport App #API-------------------=---

Route::any("transport_user_login",[ApiController::class,"t_login"]);

Route::any("transport_user_data",[ApiController::class,"t_user"]);

Route::any("get_labs",[ApiController::class,"get_t_lab"]);

Route::any("send_parcel",[ApiController::class,"send_parcel"]);

Route::any("get_parcel",[ApiController::class,"get_parcel"]);

Route::any("get_parcel_by_recive",[ApiController::class,"get_parcel_by_recive"]);

Route::any("recive_parcel",[ApiController::class,"recive_parcel"]);

Route::any("get_received_parcel",[ApiController::class,"get_received_parcel"]);

Route::any("get_send_parcel",[ApiController::class,"get_send_parcel"]);

Route::any("receive_parcel_byrecevier",[ApiController::class,"receive_parcel_byrecevier"]);

Route::any("UpdatePayment",[ApiController::class,"UpdatePayment"]);

Route::any("show_printorder",[ApiController::class,"show_printorder"]);

Route::any("getlab_bycityname",[ApiController::class,"getlab_bycityname"]);


Route::any("get_all_Setting",[ApiController::class,"get_Setting"]);
 

//address add.edit.delete.list
//book detail
//check out
//edit profile
//add review

// ---------------------Sample boy Api-------------------------------------//

Route::any("sample_login",[SampleController::class,"post_login"]);

Route::any("sample_edit_profile",[SampleController::class,"edit_profile"]);

Route::any("assined_order",[SampleController::class,"book_filter"]);


Route::any("upcomming_assined_order",[SampleController::class,"upcomming_book_filter"]); 

Route::get("assined_order_book_detail",[SampleController::class,"book_detail"]);

Route::get("assined_total_deliveries",[SampleController::class,"assined_total_deliveries"]); 


Route::any("search_test",[SampleController::class,"search_test"]);
Route::any("show_other_test_list",[SampleController::class,"show_other_test_list"]);
Route::any("show_other_test_list_v2",[SampleController::class,"show_other_test_list_v2"]);

Route::any("show_other_package_list",[SampleController::class,"show_other_package_list"]);
Route::any("show_other_package_list_v2",[SampleController::class,"show_other_package_list_v2"]);

Route::any("notification_list",[SampleController::class,"notification_list"]);
Route::any("get_payment_list",[SampleController::class,"get_payment_list"]);
Route::any("save_payment",[SampleController::class,"save_payment"]);
Route::any("reschedule_order",[SampleController::class,"reschedule_order"]);


Route::any("show_other_parameter_list",[SampleController::class,"show_other_parameter_list"]);
Route::any("show_other_parameter_list_v2",[SampleController::class,"show_other_parameter_list_v2"]);


Route::any("sampalboy_check_out",[SampleController::class,"sampalboy_check_out"]);
Route::any("sampalboy_check_out_v2",[SampleController::class,"sampalboy_check_out_v2"]);

Route::any("admin_check_out",[SampleController::class,"admin_check_out"]);

Route::any("sampalboy_semple_collect",[SampleController::class,"sampalboy_semple_collect"]);
Route::any("searchData",[SampleController::class,"searchData"]); 

Route::any("get_Setting",[SampleController::class,"get_Setting"]);


Route::any("applycoupon_sample",[SampleController::class,"applycoupon_sample"]);
Route::any("applycoupon_sample_v2",[SampleController::class,"applycoupon_sample_v2"]);

Route::any("reschedule_order_sample", [SampleController::class, "show_reschedule_order_sample"]);


Route::any("sample_count", [SampleController::class, "sample_count"]);


Route::any("cancle_order_sample", [SampleController::class, "cancle_order_sample"]);
Route::any("boy_sendOTP",[SampleController::class,"sendOTP"]);
Route::any("boy_OTP_verify",[SampleController::class,"OTP_verify"]);
Route::post("boy_sign_up",[SampleController::class,"sign_up"]);
Route::any("get_all_lab",[SampleController::class,"get_all_lab"]);








