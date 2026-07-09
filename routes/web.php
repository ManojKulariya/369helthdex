<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreateorderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagePriceController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\AdminTransportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReportControllers;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderControllers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MakePaymentController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ControllerCoupon;
use App\Http\Controllers\SampleController;

use App\Http\Controllers\ParcelControllers;


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('cache-clear', function () {
    Artisan::call("optimize:clear");
    echo "done";
});
Route::get("test_sms", [FrontController::class, "test_sms"]);

Route::post('/verify-payment', [ReportControllers::class, 'verifyPayment']);
Route::get("make_payment/{id}", [MakePaymentController::class, "show_make_payment"])->name('make_payment');
Route::post("save_braintree", [MakePaymentController::class, "save_braintree"])->name("save-braintree");
Route::any("razor_payment", [MakePaymentController::class, "razor_payment"])->name("razor-payment");
Route::post("paystack-payment", [MakePaymentController::class, "show_paystack_payment"])->name("paystack-payment");
Route::any("paystackcallback", [MakePaymentController::class, "paystackcallback"])->name('paystackcallback');
Route::any("rave-payment", [MakePaymentController::class, "show_rave_payment"])->name("rave-payment");
Route::any('/rave/callback', [MakePaymentController::class, "rave_callback"])->name('rave-callback');
Route::any("paytm-payment", [MakePaymentController::class, "store_paytm_data"])->name("paytm-payment");
Route::any("paytmstatus", [MakePaymentController::class, "paymentpaytmCallback"])->name('paytmstatus');
Route::get("payment_success", [MakePaymentController::class, "payment_success"])->name("payment-success");
Route::get("payment_failed", [MakePaymentController::class, "payment_failed"])->name("payment-failed");


Route::any("/", [FrontController::class, "show_home"])->name('home');
#-----------------------home visit-----------------------------------------------------
Route::get("home_visit", [FrontController::class, "show_home_visit"])->name('home_visit');
Route::post("save_home", [FrontController::class, "save_home"])->name('save-home-visit');
Route::get("my-home", [FrontController::class, "my_home"])->name('my-home');
#-----------------------upload Prescription-----------------------------------------------------

#--------------------------- call back --------------------------------------------------------
Route::post("save_callback", [FrontController::class, "save_callback"])->name('save_callback');

Route::get("Upload_Prescription", [FrontController::class, "prescription"])->name('Upload_Prescription');

Route::get("feedback", [FrontController::class, "feedback"])->name('feedback');

Route::get("nearest_center", [FrontController::class, "nearest_center"])->name('nearest_center');

Route::get("career", [FrontController::class, "career"])->name('career');

Route::get("promotion_discount", [FrontController::class, "promotion_discount"])->name('promotion_discount');
Route::get('/get-center', [FrontController::class, "getcenter"]);
Route::get('/get-aj-pera', [FrontController::class, "get_aj_pera"]);
Route::get('apply-job', [FrontController::class, "applyjob"])->name('apply-job');
Route::post('apply-job-otp', [FrontController::class, "applyjob_otp"])->name('apply-job-otp');
Route::get('/get-job', [FrontController::class, "getjob"]);
//Route::get('/get-job',[FrontController::class,"getjob"]);

Route::post("save_prescription", [FrontController::class, "save_prescription"])->name('save_prescription');


Route::post("save_feedback", [FrontController::class, "save_feedback"])->name('save_feedback');

Route::get("my_prescription", [FrontController::class, "my_prescription"])->name('my_prescription');



Route::get("update-location", [FrontController::class, "updateBrowserLocation"])->name('update-location');
Route::get("update-location-city", [FrontController::class, "updateLocationcity"])->name('update-location-city');

Route::get("get-map-url", [FrontController::class, "get_map_url"])->name('get-map-url');

Route::get("get-map-url-ex", [FrontController::class, "get_map_url_ex"])->name('get-map-url-ex');

Route::get("lifestyle-disorder/{city}", [FrontController::class, "show_categorylist"])->name('lifestyle-disorder');
// Route::get("lifestyle-disorder/{city}/{slug}",[FrontController::class,"show_subcategory_detail"])->name("lifestyle-disorder");

Route::get("lifestyle-disorder/{city}/{slug}", [FrontController::class, "show_subcategory_detail"])->name("lifestyledisorder");

Route::get("package/{city}/{id}", [FrontController::class, "show_package_detail"])->name("package");
Route::get("parameter/{city}/{id}", [FrontController::class, "show_parameter_detail"])->name("parameter");
Route::get("profile/{city}/{id}", [FrontController::class, "show_profile_detail"])->name("profile");

Route::get("get-users-by-city/{id}", [FrontController::class, "getUsersByCity"]);

Route::get("get-users-by-city-home/{id}", [FrontController::class, "getUsersByCityHome"]);
Route::get("applycoupon", [FrontController::class, "applycoupon"]);
Route::get("login", [FrontController::class, "show_login"])->name("user-login");
Route::get("otpsend", [FrontController::class, "otpsend"]);
Route::get("otpverify", [FrontController::class, "otp_verify"]);
Route::get("resend-login-otp", [FrontController::class, "resend_login_otp"])->name('resend-login-otp');
Route::get("save_user_details", [FrontController::class, "save_user_details"]);
Route::get("otp-job-verify", [FrontController::class, "job_otp_verify"]);
Route::get("appId/{id}", [FrontController::class, "appId"])->name('appId');
Route::get("register", [FrontController::class, "show_register"])->name("user-register");
Route::any("post_login", [FrontController::class, "post_user_login"])->name('post-user-login');
Route::post("post_user_register", [FrontController::class, "post_user_register"])->name("post-user-register");

Route::post("submit-application", [FrontController::class, "submit_application"])->name("submit-application");
Route::get("aboutus", [FrontController::class, "show_aboutus"])->name("aboutus");
Route::get("certification", [FrontController::class, "certification"])->name("certification");

/* Front Blog */
Route::post('/like/{post}', [BlogController::class, 'toggleLike'])->name('like.toggle');

Route::post('/comments/{post}', [BlogController::class, 'storecomment'])->name('comments.store');
Route::post('/share/{post}/{platform}', [BlogController::class, 'storeShare']);


Route::get("blog", [FrontController::class, "show_bloglist"])->name('blog');
Route::get("blog/{slug}", [FrontController::class, "show_blog_detail"])->name("blog_detail");


Route::get("Terms_of_Service", [FrontController::class, "Terms_of_Service"])->name("Terms_of_Service");
Route::get("delete-account", [FrontController::class, "deleteAccount"])->name("deleteAccount");


Route::get("refund_policy", [FrontController::class, "refund_policy"])->name("refund_policy");
Route::get("Privacy_Policy", [FrontController::class, "Privacy_Policy"])->name("Privacy_Policy");
Route::get("franchise", [FrontController::class, "franchise"])->name("franchise");

Route::get("service", [FrontController::class, "show_service"])->name("service");
Route::get("contact-us", [FrontController::class, "show_contactus"])->name("contact-us");

Route::get("addcart", [CartController::class, "show_addcart"])->name('addcart');
Route::get("deletecart", [CartController::class, "show_deletecart"])->name("deletecart");

Route::get("viewcartdata", [CartController::class, "viewcartdata"]);
Route::post("save-contact", [FrontController::class, "save_contact_detail"])->name("save-contact");
Route::get("addnewsletter/{email}", [FrontController::class, "addnewsletter"]);
Route::get("getallpack", [FrontController::class, "getallpack"])->name("getallpack");
Route::any("search-item", [FrontController::class, "show_search_item"])->name("search-item");
Route::get("popular-packages/{city}", [FrontController::class, "show_package_list"])->name("popular-packages");
Route::get("popular-blood-tests/{city}", [FrontController::class, "show_test_list"])->name("popular-blood-tests");
Route::get("forgotpassword", [FrontController::class, "show_forgotpassword"])->name("forgotpassword");
Route::post("post-forgotpassword", [FrontController::class, "post_forgotpassword"])->name("post-forgotpassword");

Route::get("resetpassword/{code}", [FrontController::class, "resetpassword"]);
Route::any("resetnewpwd", [FrontController::class, "resetnewpwd"]);
Route::post("postreview", [FrontController::class, "show_postreview"])->name("postreview");

Route::post("add_cart_member", [CartController::class, "add_cart_member"])->name("add-cart-member");

Route::get("add_cart_member_ajax", [CartController::class, "add_cart_member_ajax"])->name("add-cart-member-ajax");

Route::group(['middleware' => ['usercheckexiste']], function () {
    Route::get("deletemembercart", [CartController::class, "deletemembercart"]);
    Route::get("addcustomizepackage", [CartController::class, "addcustomizepackage"])->name("addcustomizepackage");
    Route::get("removecustomizepackage", [CartController::class, "removecustomizepackage"])->name("removecustomizepackage");
    Route::get("user_dashboard", [FrontController::class, "show_dashboard"])->name('dashboard');
    Route::get("user_logout", [FrontController::class, "show_user_logout"])->name('user-logout');
    Route::post("update_user_address", [FrontController::class, "show_update_user_address"])->name('update-user-address');
    Route::post("post_user_address", [FrontController::class, "show_post_user_address"])->name("post-user-address");
    Route::post("book_order", [FrontController::class, "post_Book_order"])->name("book-order");

    Route::get("book_payment", [FrontController::class, "book_payment"])->name("book_payment");

    Route::get("appointmentbook/{id}", [FrontController::class, "show_appointmentbook"])->name("appointmentbook");
    Route::get("changepassword", [FrontController::class, "show_changepassword"])->name("user-change-password");
    Route::post("update_change_password", [FrontController::class, "update_change_password"])->name("update-change-password");
    Route::get("user_profile", [FrontController::class, "show_user_profile"])->name("user-profile");
    Route::post("update_profile_info", [FrontController::class, "show_update_profile_info"])->name("update-profile-info");
    Route::get("my_addresses", [FrontController::class, "show_my_addresses"])->name("my-addresses");
    Route::get("my_family_member", [FrontController::class, "show_my_family_member"])->name("my-family-member");
    Route::post("update_user_family", [FrontController::class, "show_update_user_family"])->name("update-user-family");
    Route::get("getmember", [FrontController::class, "show_getmember"])->name("getmember");
    Route::get("deletememer/{id}", [FrontController::class, "deletememer"])->name("deletememer");
    Route::get("getaddress", [FrontController::class, "getaddress"])->name("getaddress");
    Route::get("deleteaddress/{id}", [FrontController::class, "deleteaddress"])->name("deleteaddress");
    Route::get("deletevisit/{id}", [FrontController::class, "deletevisit"])->name("deletevisit");
    Route::get("printorder", [FrontController::class, "show_printorder"])->name("printorder");
    Route::get("track-order/{id}", [FrontController::class, "show_track_order"])->name("track-order");
    Route::get("report-user-view/{id}", [FrontController::class, "show_report_view"])->name("report-user-view");
    Route::post("post_user_feedback", [FrontController::class, "show_post_user_feedback"])->name("post-user-feedback");

    Route::post("save_member_detail", [FrontController::class, "show_update_user_member"])->name('save-member-detail');
    Route::get("checkout", [FrontController::class, "show_checkout"])->name("checkout");
    // ------------- checkout ajax------------------
    
    Route::get("update_user_family_ajax", [OrderControllers::class, "show_update_user_family_ajax"])->name("update-user-family-ajax");
    Route::get("update_user_address_ajax", [OrderControllers::class, "update_user_address_ajax"])->name("update-user-address-ajax");
    Route::get("getcart_id_ajax", [CartController::class, "getcart_id_ajax"])->name("getcart_id_ajax");
    
   Route::get("checkout_online/{id}", [FrontController::class, "checkout_online"])->name("checkout_online"); 
    
    // ---------------------------------------------
});
   
   Route::get("checkouts/{id}/{type}/{parameter}", [FrontController::class, "show_checkout"])->name("checkouts"); 
   Route::get("search", [FrontController::class, "search"])->name("search"); 
   Route::get("searchtag", [FrontController::class, "searchtag"])->name("searchtag"); 



Route::get("checkadminpassword/{val}", [AdminController::class, "update_check_admin_password"]);

//admin side

Route::get("rowdata", [AdminController::class, "rowdata"]);
Route::get("admin", [AdminController::class, "show_login"])->name("admin-login");
Route::post("admin_postlogin", [AdminController::class, "post_login"])->name("admin-postlogin");

Route::get("manager-login", [ManagerController::class, "show_manager_login"])->name("manager-login");
Route::post("manager_postlogin", [ManagerController::class, "post_login"])->name("manager-postlogin");

Route::group(['middleware' => ['admincheckexiste']], function () {
    // ------------------------export import prices-------------------------------------
    Route::get("export_center_prices/{profileId}/{type}", [ManagePriceController::class, "export_center_prices"]);
    Route::post("import_center_prices", [ManagePriceController::class, "importCenterPrices"])->name("import_center_prices");
    Route::post("/export_multiple_center_prices", [ManagePriceController::class, "export_multiple_center_prices"])->name('export_multiple_center_prices');
    Route::post("/import_multiple_center_prices", [ManagePriceController::class, "import_multiple_center_prices"])->name('import_multiple_center_prices');
    Route::get("/export_master_data/{type}", [ManagePriceController::class, "export_master_data"])->name('export_master_data');
    // ----------- create booking at backend---------------------//
    Route::get('make_booking',[CreateorderController::class,'index'])->name('make_booking');
    Route::post('save_booking',[CreateorderController::class,'index'])->name('save_booking');
    
    // ----------------------------------------------------------//
    Route::get('admin-dashboard', [AdminController::class, 'show_dashboard'])->name('admin-dashboard');

    Route::get("logout", [AdminController::class, "logout"])->name("admin-logout");

    Route::get("admin_profile", [AdminController::class, "show_admin_profile"])->name("admin-profile");
    Route::post("update_admin_profile", [AdminController::class, "show_update_admin_profile"])->name('update-admin-profile');


    Route::get('admin-changepassword', [AdminController::class, 'change_password'])->name('admin-changepassword');
    Route::post("update_admin_change_password", [AdminController::class, "show_update_admin_change_password"])->name('update_admin_change_password');

    Route::get("categorydatatable", [CategoryController::class, "categorydatatable"])->name("admin-categorydatatable");
    
    Route::get("sampletypedatatable", [SampleController::class, "categorydatatable"])->name("admin-sampletypedatatable");
    
    
    Route::get("category", [CategoryController::class, "show_category"])->name("admin-category");
    Route::get("savecategory/{url}", [CategoryController::class, "show_savecategory"]);
    
    
    Route::get("savesample/{url}", [SampleController::class, "show_savesample"]);
    
    Route::post("update_category", [CategoryController::class, "show_update_category"])->name('update-category');
    Route::post("update_sample", [SampleController::class, "update_sample"])->name('update-sample');
    
    Route::get("deletecategory/{id}", [CategoryController::class, "deletecategory"])->name('delete-category');
    
    Route::get("deletesample/{id}", [SampleController::class, "deletecategory"])->name('delete-sample'); 
    #------------------------ offers --------------------------------------------------------
    Route::get("offer", [CategoryController::class, "show_offer"])->name("admin-offer");
    Route::get("vacancies", [CategoryController::class, "show_vacancies"])->name("vacancies");
    Route::get("offerdatatable", [CategoryController::class, "offerdatatable"])->name("admin-offerdatatable");

    Route::get("jobsdatatable", [CategoryController::class, "jobdatatable"])->name("jobsdatatable");

    Route::get("saveoffer/{url}", [CategoryController::class, "show_saveoffer"]);

    Route::get("savevacancies/{url}", [CategoryController::class, "savevacancies"]);
    Route::post("update_offer", [CategoryController::class, "show_update_offer"])->name('update-offer');

    Route::post("update_job", [CategoryController::class, "show_update_job"])->name('update-job');
    Route::get("deleteoffer/{id}", [CategoryController::class, "deleteoffer"])->name('delete-offer');

    Route::get("deletejob/{id}", [CategoryController::class, "deletejob"])->name('delete-job');

    #------------------------ coupon --------------------------------------------------------
    Route::get("coupon", [ControllerCoupon::class, "show_coupon"])->name("admin-coupon");
    Route::get("savecoupon/{url}", [ControllerCoupon::class, "show_savecoupon"]);
    Route::post("update_coupon", [ControllerCoupon::class, "show_update_coupon"])->name('update-coupon');
    Route::get("coupondatatable", [ControllerCoupon::class, "coupondatatable"])->name("admin-coupondatatable");
    Route::get("deletecoupon/{id}", [ControllerCoupon::class, "deletecoupon"])->name('delete-coupon');

    Route::get("callback", [ControllerCoupon::class, "callback"])->name("callback");
    Route::get("application", [ControllerCoupon::class, "application"])->name("application");
    Route::get("application-datatable", [ControllerCoupon::class, "application_datatable"])->name("application-datatable");

    Route::get("calbackdatatable", [ControllerCoupon::class, "calbackdatatable"]);

    Route::get("complaintsdatatable", [ControllerCoupon::class, "complaintsdatatable"]);

    Route::get("complaints", [ControllerCoupon::class, "complaints"])->name("complaints");

    Route::get("admin-city", [CityController::class, "show_city"])->name("admin-city");
    Route::get("citydatatable", [CityController::class, "citydatatable"])->name("citydatatable");
    Route::get("savecity/{id}", [CityController::class, "save_city"])->name("savecity");
    Route::post("update_city", [CityController::class, "post_city"])->name("update-city");
    Route::get("deletecity/{id}", [CityController::class, "delete_city"])->name("deletecity");
    

    Route::get("subcategorydatatable", [SubcategoryController::class, "subcategorydatatable"])->name("admin-subcategorydatatable");
    Route::get("admin-subcategory", [SubcategoryController::class, "show_subcategory"])->name("admin-subcategory");
    Route::get("savesubcategory/{url}", [SubcategoryController::class, "show_savesubcategory"]);
    Route::post("update_subcategory", [SubcategoryController::class, "show_update_subcategory"])->name('update_subcategory');
    Route::get("deletesubcategory/{id}", [SubcategoryController::class, "deletesubcategory"])->name('delete-subcategory');
    
    /* Admin Discount */
    Route::get("admin-discount", [DiscountController::class, "show_discount"])->name("admin-discount");
    Route::get("discountdatatable", [DiscountController::class, "discountdatatable"])->name("discountdatatable");
    Route::get("savediscount/{id}", [DiscountController::class, "save_discount"])->name("savediscount");
    Route::post("update_discount", [DiscountController::class, "post_discount"])->name("update-discount");
    Route::get("deletediscount/{id}", [DiscountController::class, "delete_discount"])->name("deletediscount");

    /* Admin Blog */
    Route::get("blogdatatable", [BlogController::class, "blogdatatable"])->name("admin-blogdatatable");
    Route::get("admin-blog", [BlogController::class, "show_blog"])->name("admin-blog");
    Route::get("saveblog/{url}", [BlogController::class, "show_saveblog"]);
    Route::post("update_blog", [BlogController::class, "show_update_saveblog"])->name('update_blog');
    Route::get("deleteblog/{id}", [BlogController::class, "deleteblog"])->name('delete-blog');

    /* Admin Blog */
    Route::get("contentdatatable", [ContentController::class, "contentdatatable"])->name("admin-contentdatatable");
    Route::get("admin-content", [ContentController::class, "show_content"])->name("admin-content");
    Route::get("savecontent/{url}", [ContentController::class, "show_savecontent"]);
    Route::post("update_content", [ContentController::class, "show_update_savecontent"])->name('update_content');
    Route::get("deletecontent/{id}", [ContentController::class, "deletecontent"])->name('delete-content');
    
    /* Admin Tag */
    Route::get("tagdatatable", [TagController::class, "tagdatatable"])->name("admin-tagdatatable");
    Route::get("admin-tag", [TagController::class, "show_tag"])->name("admin-tag");
    Route::get("savetag/{url}", [TagController::class, "show_savetag"]);
    Route::post("update_tag", [TagController::class, "show_update_savetag"])->name('update_tag');
    Route::get("deletetag/{id}", [TagController::class, "deletetag"])->name('delete-tag');

    Route::get("/update_status/{id}/{status}", [PackageController::class, "update_status"])->name('update_status');
    Route::get("/copy_package/{id}", [PackageController::class, "copy_package"])->name('copy_package');
    Route::get("/copy_parameter/{id}", [PackageController::class, "copy_parameter"])->name('copy_parameter');
    
    Route::get("/copy_profile/{id}", [PackageController::class, "copy_profile"])->name('copy_profile');
    

    Route::post('/ckeditor_upload', [PackageController::class, 'upload'])->name('ckeditor_upload');


    Route::get("show-package", [PackageController::class, "show_package"])->name('show-package');
    Route::get("show-sample", [SampleController::class, "show_sample"])->name('show-sample');
    Route::get("package_datatable", [PackageController::class, "package_datatable"])->name("package_datatable");
    Route::get("save_package/{id}/{tab}", [PackageController::class, "show_save_package"])->name('save-package');
    Route::post("/package_basic_info", [PackageController::class, "show_package_basic_info"])->name("save-package-basic-info");
    Route::post("/package_lab_info", [PackageController::class, "show_package_lab_info"])->name("save-package-lab-info");

    Route::get("/save_parameter/{id}/{tab}", [PackageController::class, "show_save_parameter"])->name('save-parameter');
    Route::post("save_parameter_basic_info", [PackageController::class, "show_save_parameter_basic_info"])->name('save-parameter-basic-info');
    Route::post("save_parameter_lab_info", [PackageController::class, "show_save_parameter_lab_info"])->name('save-parameter-lab-info');
    Route::get("parameter_get", [PackageController::class, "show_parameter"])->name('parameter_get');
    Route::get("get_parameter_slug", [PackageController::class, "get_parameter_slug"])->name('get_parameter_slug');
    Route::get("parameter_datatable", [PackageController::class, "parameter_datatable"])->name("parameter_datatable");
    Route::get("delete_parameter/{id}", [PackageController::class, "show_delete_parameter"])->name("delete_parameter");

    Route::get("deletepackage/{id}", [PackageController::class, "delete_package"])->name("deletepackage");

    Route::get("delete_profile/{id}", [PackageController::class, "delete_profile"])->name("delete_profile");
    Route::get("getsubcategorybycategory/{id}", [PackageController::class, "show_getsubcategorybycategory"])->name("getsubcategorybycategory");
    Route::get("getlistofparameter", [PackageController::class, "getlistofparameter"])->name("getlistofparameter");
    Route::post("save_package_test_info", [PackageController::class, "show_save_package_test_info"])->name("save-package-test-info");
    Route::post("save_package_branch_info", [PackageController::class, "show_save_package_branch_info"])->name("save-package-branch-info");
    Route::post("save_parameter_branch_info", [PackageController::class, "show_save_parameter_branch_info"])->name("save-parameter-branch-info");
    Route::get("frq/{id}/{type}", [PackageController::class, "viewfrq"])->name("frq");
    Route::get("frq_datatable/{id}/{type}", [PackageController::class, "frq_datatable"])->name("frq_datatable");
    Route::post("update_frq", [PackageController::class, "update_frq"])->name("update-frq");
    Route::get("delete_frq/{id}", [PackageController::class, "show_delete_frq"])->name("delete_frq");
    Route::get("getfrq/{id}", [PackageController::class, "show_getfrq"])->name("getfrq");

    Route::get("profiles", [PackageController::class, "show_profiles"])->name("profiles");
    Route::post("update_profile", [PackageController::class, "show_update_profile"])->name("update-profile");
    Route::get("save_profile/{id}", [PackageController::class, "show_save_profile"])->name('save-profile');
    Route::get("profiledatatable", [PackageController::class, "profiledatatable"])->name("profiledatatable");
    Route::get("gettestids/{type}", [PackageController::class, "show_get_test_ids"])->name("gettestids");


    Route::get("manager", [UserController::class, "show_manager"])->name("manager");
    Route::get("sampleuser", [UserController::class, "show_sample"])->name("sampleuser");
    
    Route::get("user_prescription", [UserController::class, "user_prescription"])->name("user_prescription");
    
    Route::get("predataTable", [UserController::class, "predataTable"])->name("predataTable");


    Route::get("ManagerTable", [UserController::class, "show_ManagerTable"])->name("ManagerTable");
    
    Route::get("update_user_status/{id}/{status}", [UserController::class, "update_user_status"])->name("update_user_status");
    
    Route::get("SampleTable", [UserController::class, "show_sampleTable"])->name("SampleTable");
    
    
    Route::get("save_cc_boy/{id}", [UserController::class, "save_cc_boy"])->name("save_cc_boy");
    Route::get("savemanager/{id}", [UserController::class, "show_savemanager"])->name("savemanager");
    Route::post("update_manager_profile_admin", [UserController::class, "show_update_manager_profile"])->name("update-manager-profile-admin");
    
    Route::post("update_manager_profile_admin_sample", [UserController::class, "update_manager_profile_admin_sample"])->name("update-manager-profile-admin-sample");
    Route::get("deleteuser/{id}", [UserController::class, "deleteuser"])->name("deleteuser");
    //////--------------------------------------------------//////////
    Route::get("testuser/{id}", [UserController::class, "testuser"])->name("testuser");
    Route::post("add-item", [UserController::class, "addtest"])->name("add-item");
    Route::post("remove-item", [UserController::class, "removetest"])->name("remove-item");

    Route::post("update-items", [UserController::class, "updatetests"])->name("update-items");

    route::get("popular-package", [PackageController::class, "show_popular_package"])->name("popular-package");
    Route::get("popularPackageTable", [PackageController::class, "show_popularPackageTable"])->name("popularPackageTable");
    Route::get("save_popular_package/{id}", [PackageController::class, "show_save_popular_package"])->name('save-popular-package');
    Route::get("searchpopulartype/{id}", [PackageController::class, "show_searchpopulartype"])->name("searchpopulartype");
    Route::post("update_popular_package", [PackageController::class, "show_update_popular_package"])->name('update-popular-package');

    Route::get("deleteuser_detail/{id}", [UserController::class, "deleteuser_detail"])->name("deleteuser_detail");

    Route::get("user", [UserController::class, "show_user"])->name("user");
    Route::get("UserTable", [UserController::class, "show_UserTable"])->name("UserTable");
    Route::get("getmembersinfo/{id}", [UserController::class, "getmembersinfo"])->name("getmembersinfo");
    Route::get("getaddress/{id}", [UserController::class, "getaddress"])->name("getaddress");

    Route::get("setting/{id}", [AdminController::class, "showsetting"])->name("setting");

    Route::get("remove_slider/{id}/{col}", [AdminController::class, "remove_slider"])->name("remove_slider");

    Route::post("savebasicsetting", [AdminController::class, "savebasicsetting"])->name("savebasicsetting");
    Route::post("server_key", [AdminController::class, "server_key"])->name("server_key");

    Route::get("orders", [OrderControllers::class, "show_order"])->name("admin-orders");

    Route::get("OrdersTable", [OrderControllers::class, "show_OrdersTable"])->name("OrdersTable");

    Route::get("getorderdetails/{id}", [OrderControllers::class, "getorderdetails"])->name("getorderdetails");
    Route::get("adminprintorders/{id}", [FrontController::class, "show_admin_printorder"]);

    Route::get("show-contact", [AdminController::class, "show_contactus"])->name("show-contact");
    Route::get("contact_datatable", [AdminController::class, "contact_datatable"])->name("contact_datatable");

    Route::get("deletecontact/{id}", [AdminController::class, "deletecontact"])->name("deletecontact");

    Route::get("sendnews", [AdminController::class, "show_news"])->name("send-news");
    Route::post("post_news", [AdminController::class, "sendnews"])->name("post-news");
    Route::get("notification", [NotificationController::class, "notification"])->name("notification");

    Route::post("change-payment-detail", [AdminController::class, "change_payment_detail"])->name("change-payment-detail");
    Route::post("update-website-details", [AdminController::class, "show_update_website_details"])->name("update-website-details");
    Route::post("update-wallet-details", [AdminController::class, "show_update_wallet_details"])->name("update-wallet-details");
    Route::get("payment-setting", [PaymentSettingController::class, "show_payment_setting"])->name('payment-setting');
    Route::post("updategateway", [PaymentSettingController::class, "show_update_gateway"])->name('updategateway');
    // ------------- Admin order processing--------------------
    
    Route::get("change_order_status_admin/{id}/{status}", [OrderControllers::class, "show_change_order_status"])->name("change_order_status_admin");
    
    Route::get("sample_boy_list", [OrderControllers::class, "sample_boy_list"])->name("sample_boy_list");
    
    
    Route::post("report-order-sample-admin", [OrderControllers::class, "show_report_order_sample"])->name("report-order-sample-admin");
    
    Route::post("report-order-lab-admin", [OrderControllers::class, "show_report_order_lab"])->name("report-order-lab-admin");
    
    
    Route::post("complete-order-admin", [OrderControllers::class, "show_complete_order"])->name("complete-order-admin");
    
    Route::get("change_order_sample_status_admin/{id}/{status}", [OrderControllers::class, "change_order_sample_status"])->name("change_order_sample_status_admin");
    

    Route::get("report-view-admin/{id}", [OrderControllers::class, "show_report_view_admin"])->name("report-view-admin");
});


    Route::get("get_report_details", [OrderControllers::class, "get_report_details"])->name("get_report_details");
    
    Route::get("save_report", [OrderControllers::class, "save_report"])->name("save_report");

    Route::group(['middleware' => ['managercheckexiste']], function () {
    
    Route::get("get_pre", [UserController::class, "get_pre"])->name("get_pre");
    // Route::get("predataTable", [UserController::class, "predataTable"])->name("predataTable");
    

    Route::get("sampleboy", [UserController::class, "show_sampleboy"])->name("sampleboy");

    Route::get("sampleboyTable", [UserController::class, "show_sampleboyTable"])->name("sampleboyTable");

    Route::get("savesampleboy/{id}", [UserController::class, "savesampleboy"])->name("savesampleboy");

    Route::post("update_sample_profile_admin", [UserController::class, "show_update_sample_profile"])->name("update-sample-profile-admin");

    Route::get('manager-dashboard', [ManagerController::class, 'show_manager_dashboard'])->name('manager-dashboard');

    Route::get("manager-logout", [ManagerController::class, "logout"])->name("manager-logout");

    Route::get("manager_profile", [ManagerController::class, "show_manager_profile"])->name("manager-profile");
    Route::post("update_manager_profile", [ManagerController::class, "show_update_manager_profile"])->name('update-manager-profile');

    Route::get("checkmanagerpassword/{val}", [ManagerController::class, "update_check_manager_password"]);
    Route::get('manager-changepassword', [ManagerController::class, 'change_password'])->name('manager-changepassword');
    Route::post("update_manager_change_password", [ManagerController::class, "show_update_manager_change_password"])->name('update_manager_change_password');


    Route::get("managers_orders", [OrderControllers::class, "show_manager_order"])->name("manager-orders");
    Route::get("manager_home_visit", [OrderControllers::class, "manager_home_visit"])->name("manager-home-visit");
    Route::post("homevisits_status/{id}/{status}", [OrderControllers::class, "homevisits_status"])->name("homevisits_status");

    Route::get("ManagerOrdersTable", [OrderControllers::class, "show_manager_OrdersTable"])->name("ManagerOrdersTable");
    Route::get("ManagerOrderschangeTable", [OrderControllers::class, "show_manager_OrdersTable_edit"])->name("ManagerOrderschangeTable");

    Route::get("getmanagerorderdetails/{id}", [OrderControllers::class, "getorderdetails"])->name("getorderdetails");
    Route::get("managerprintorders/{id}", [FrontController::class, "show_admin_printorder"]);


    Route::get("change_order_sample_status/{id}/{status}", [OrderControllers::class, "change_order_sample_status"])->name("change_order_sample_status");
    Route::get("change_order/{id}", [OrderControllers::class, "show_change_order"])->name("change_order");
    Route::post("complete-order", [OrderControllers::class, "show_complete_order"])->name("complete-order");

   
    Route::post("report-order-sample", [OrderControllers::class, "show_report_order_sample"])->name("report-order-sample");

    Route::post("reschedule-order-sample", [OrderControllers::class, "show_reschedule_order_sample"])->name("reschedule-order-sample");

    Route::get("report-view/{id}", [OrderControllers::class, "show_report_view"])->name("report-view");
    Route::post("sampleboy_check_out", [OrderControllers::class, "sampleboy_check_out"])->name("sampleboy_check_out");
    Route::get("sampleboy_by_check_out", [OrderControllers::class, "post_Book_order"])->name("sampleboy_by_check_out");
    Route::get("edit-Order/{id}", [OrderControllers::class, "edit_order"])->name("edit-Order");
    Route::get("TodayManagerOrdersTable", [OrderControllers::class, "TodayManagerOrdersTable"])->name("TodayManagerOrdersTable");
    Route::get("applycoupons", [FrontController::class, "applycouponbyBoy"]);

    Route::post("update_user_family_boy", [OrderControllers::class, "show_update_user_family"])->name("update-user-family-boy");

});

Route::get("change_order_status/{id}/{status}", [OrderControllers::class, "show_change_order_status"])->name("change_order_status");

Route::post("report-order", [OrderControllers::class, "show_report_order"])->name("report-order");
Route::get("api_payment_status/{status}", [FrontController::class, "api_payment_status"])->name("api_payment_status");

Route::post("api_payment_cancle", [FrontController::class, "api_payment_cancle"])->name("api_payment_cancle");

// Transport Admin side

Route::get("transport", [AdminTransportController::class, "show_login"])->name("transport-login");
Route::post("transport_admin_postlogin", [AdminTransportController::class, "post_login"])->name("transport-admin-postlogin");
Route::group(['middleware' => ['transportadmincheckexiste']], function () {
    Route::get('transport-admin-dashboard', [AdminTransportController::class, 'show_dashboard'])->name('transport-admin-dashboard');
    Route::get("transport-logout", [AdminTransportController::class, "logout"])->name("transport-admin-logout");

    Route::get("transport-manager", [UserController::class, "transport_show_manager"])->name("transport-manager");
    Route::get("transport-lab-user", [UserController::class, "transport_show_user"])->name("transport-lab-user");
    Route::get("TransportManagerTable", [UserController::class, "transport_show_ManagerTable"])->name("TransportManagerTable");
    Route::get("transportsavemanager/{id}", [UserController::class, "transport_show_savemanager"])->name("transportsavemanager");
    

    Route::get("TransportUserTable", [UserController::class, "Transportshow_UserTable"])->name("TransportUserTable");
    Route::post("update_transport_manager_profile_admin", [UserController::class, "show_update_transport_manager_profile"])->name("update-transport-manager-profile-admin");

    Route::get("savelabuser/{id}", [UserController::class, "savelabuser"])->name("savelabuser");

    Route::post("update_transport_profile_admin", [UserController::class, "show_update_transport_profile"])->name("update-transport-profile-admin");

    Route::get("deleteuser_detail/{id}", [UserController::class, "deleteuser_detail"])->name("deleteuser_detail");

    Route::get("upcomming-parcel", [ParcelControllers::class, "show_upcomming_order"])->name("upcomming-parcel");
    Route::get("all-parcel", [ParcelControllers::class, "show_order"])->name("all-parcel");

    Route::get("parcelTable", [ParcelControllers::class, "show_OrdersTable"])->name("parcelTable");

    Route::get("parcelTableupcomming", [ParcelControllers::class, "show_Orders_upcommingTable"])->name("parcelTableupcomming");

    Route::get("getparceldetails/{id}", [ParcelControllers::class, "getorderdetails"])->name("getparceldetails");

});
// Receiver Panel Login
Route::get("receiver", [ReceiverController::class, "show_login"])->name("receiver-login");
Route::post("receiver_admin_postlogin", [ReceiverController::class, "post_login"])->name("receiver-admin-postlogin");

Route::group(['middleware' => ['receivercheckexists']], function () {
    Route::get('receiver-dashboard', [ReceiverController::class, "show_dashboard"])->name('receiver-dashboard');
    Route::get("receiver-logout", [ReceiverController::class, "logout"])->name("receiver-logout");
    Route::get("parcelTableupcomming-rec", [ParcelControllers::class, "show_Orders_upcommingTable_rec"])->name("parcelTableupcomming-rec");
    Route::get("parcelTable-rec", [ParcelControllers::class, "show_OrdersTable_rec"])->name("parcelTable-rec");
    Route::post('receiver/parcel/mark-received', [ReceiverController::class, 'markAsReceived']);

        Route::get("getparceldetails-rec/{id}", [ParcelControllers::class, "getorderdetails_rec"])->name("getparceldetails-rec");

    Route::get("upcomming-parcel-rec", [ParcelControllers::class, "show_upcomming_order_rec"])->name("upcomming-parcel-rec");
    Route::get("all-parcel-rec", [ParcelControllers::class, "show_order_rec"])->name("all-parcel-rec");
    // // Receiver Parcel Management
    // Route::get("receiver-upcoming-parcels", [ReceiverParcelController::class, "show_upcoming_parcels"])->name("receiver-upcoming-parcels");
    // Route::get("receiver-all-parcels", [ReceiverParcelController::class, "show_all_parcels"])->name("receiver-all-parcels");

    // Route::get("receiver-parcel-table", [ReceiverParcelController::class, "show_parcel_table"])->name("receiver-parcel-table");
    // Route::get("receiver-parcel-upcoming-table", [ReceiverParcelController::class, "show_upcoming_parcel_table"])->name("receiver-parcel-upcoming-table");

    // Route::get("receiver-parcel-details/{id}", [ReceiverParcelController::class, "get_parcel_details"])->name("receiver-parcel-details");

    // Receiver Profile & User Handling (Optional)
    Route::get("receiver-profile", [ReceiverController::class, "show_profile"])->name("receiver-profile");
    Route::post("receiver-profile-update", [ReceiverController::class, "update_profile"])->name("receiver-profile-update");
});


    Route::get("download-report", [ReportControllers::class, "show_login"])->name("download-report");
    Route::get("check_login", [ReportControllers::class, "check_login"]);
    Route::get("otpsend_report", [ReportControllers::class, "otpsend"]); 
    Route::get("otpverify_report", [ReportControllers::class, "otp_verify"]);
    
    Route::any("helthdex-report", [ReportControllers::class, "show_reports"])->name("helthdex-report");
    Route::get("report-details/{id}", [ReportControllers::class, "show_report_details"])->name("report-details");
    
    
    
    Route::get("check_login_api", [ReportControllers::class, "check_login_api"]);
    Route::get("helthdex-report-api", [ReportControllers::class, "show_reports_api"])->name("helthdex-report-api");
    
    Route::get("helthdex-report-download-api", [ReportControllers::class, "getPatientReport"])->name("helthdex-report-api-download");
    
    Route::get("cc_request", [ReportControllers::class, "cc_request"])->name("cc_request");
    
    // -----------------------------------------------------------------------------------------
    Route::get('get_user_list',[CreateorderController::class,'getUser'])->name('get_user_list');
    
    Route::post('save_user_',[CreateorderController::class,'save_user_'])->name('save_user_');
    
    Route::get("ManagerOrderschangeTable", [OrderControllers::class, "show_manager_OrdersTable_edit"])->name("ManagerOrderschangeTable");
    Route::get('/get_user_details', function (Request $request) {
        $user = \App\Models\User::find($request->user_id);
        return response()->json($user);
    });
    
    Route::get('/custom-captcha', function () {
        $code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);
        session(['captcha' => $code]);
    
        $image = imagecreate(130, 40);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $lineColor = imagecolorallocate($image, 100, 100, 100);
    
        // Add lines for noise
        for ($i = 0; $i < 5; $i++) {
            imageline($image, rand(0,130), rand(0,40), rand(0,130), rand(0,40), $lineColor);
        }
    
        imagestring($image, 5, 15, 10, $code, $textColor);
    
        ob_start();
        imagepng($image);
        $data = ob_get_clean();
    
        return response($data)->header('Content-Type', 'image/png');
    });

    



