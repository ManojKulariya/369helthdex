<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;
use Session;
use validate;
use Sentinel;
use Response;
use Validator;
use Illuminate\Validation\Rule;
use DB;
use DataTables;
use App\Models\User;
use App\Models\Transport;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Subcategory;
use App\Models\Token;
use App\Models\Resetpassword;
use App\Models\Package;
use App\Models\Package_FRQ;
use Illuminate\Http\RedirectResponse;
use App\Models\Parameter;
use App\Models\FamilyMember;
use App\Models\Profiles;
use App\Models\TestDetails;
use App\Models\UserAddress;
use App\Models\Review;
use App\Models\Popular_package;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\Orders;
use App\Models\City;
use App\Models\OrdersData;
use App\Models\Offer;
use App\Models\PaymentGateway;
use App\Models\CartMember;
use App\Models\Feedback;
use App\Models\Homevisit;
use App\Models\Timeslote;
use App\Models\Userprescription;
use App\Models\Callback;
use Hash;
use Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Discount;
use App\Models\Discountid;
use Carbon\Carbon;

class ApiController extends Controller
{
    public $currentDate;
   
    public function __construct()
    {
         $this->currentDate = Carbon::now();

    }
    public function show_printorder(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['user_id' => 'required','id' => 'required'];

        $messages = array(
            'user_id.required' => "user_id is required",'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
        $data = Orders::with('useraddressdetails', 'partiallyreports')->where("user_id", $request->get("user_id"))->where("id", $request->get("id"))->first();
            if ($data) {
                $data->orderdata = OrdersData::with("memberdetails")->where("order_id", $request->get("id"))->get();
                $popular_package = Popular_package::whereNull('deleted_at')->get();
                $category = Category::where('is_deleted', '0')->get();
                $setting = Setting::find(1);
                $getcurrency = explode("-", $setting->currency);
                $dataset=[
                    'orderdata'=>$data,'popular_package'=>$popular_package,'category'=>$category,'setting'=>$setting,'getcurrency'=>$getcurrency
                    ];
                $response = array(
                    "status" => "1",
                    "msg" => "Invoice Data set",
                    "data"=>$dataset
                );
            }else{
                $response = array(
                    "status" => "0",
                    "msg" => "order not found!"
                );
            }
        }
        return json_encode($response);

    }
    
    public function UpdatePayment(Request $req)
	{
	    $UserFID=     $req->UserFID;
	    $TestRegnId=  $req->TestRegnId;
	    $amount=      $req->amount;
	   
	   
		$paymentUpdation = [
			"objBillRecieptClass" => [
				"TestRegnID" => (int)$TestRegnId,
				"AmountPaid" => $amount,
				"CurrentPayAmt" => $amount,
				"Task" => 3,
				"PaymentMethodType" => "7",
				"UserID" => $UserFID,
				"LabID" =>  env('REPORT_LAB_ID'), // TEST_LAB_ID
			]
		];
		
		$postdata = json_encode($paymentUpdation);
		$method = "POST";
		$url = "https://reliabletest.elabassist.com/Services/Test_RegnService.svc/UpdateTestRegnBalAmt";
		
		$mydata = $this->callAPI($method, $url, $postdata);
		$mydata = json_decode($mydata, true);
		$response = array(
                "status" => 1,
                "msg" => 'Payment update successfully..'

            );
		return json_encode($response, JSON_NUMERIC_CHECK);
	

	}
	public function callAPI($method, $url, $data = false)
    {
        $curl = curl_init();
		switch ($method) {
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "GET":
				// curl_setopt($curl, CURLOPT_POST,1);
				break;
		}
		curl_setopt($curl, CURLOPT_URL, $url);
		/* Define Content Type */
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('content-type:application/json'));
		/* Return JSON */
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// /* new connection instead of cached one */
		// curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
    } 
    public function current_date_time(){
        $res = ['date'=>date('Y-m-d'),
            'time'=>date('H:i')];
        return $res;
    }
    public function get_discount($test_id,$type,$mrp){
        $mrp = (float) $mrp;
        $fixed=0;
        $per=0;
        // dd($mrp);
        $dis = Discountid::join('discounts','discounts.id','discount_ids.dis_id')
                ->whereDate('discounts.start_date', '<=', $this->currentDate)
                ->whereDate('discounts.end_date', '>=', $this->currentDate)
                ->where('discount_ids.type',$type)->where("discount_ids.test_id", $test_id)->first();
        if($dis){
            if($dis->dis_type == 'per'){
                $per = (float) $dis->discount;
                $fixed = $mrp * ($per/100);
            }else{
                $fixed = (float) $dis->discount;
                $per =  ($mrp / $fixed) * 100 ;
            }
        }
        $dis_data=['per'=>$per,'fixed'=>$fixed];
        return $dis_data;
    }
    public function applycoupon(Request $request)
    {
        $discount = 0;
        
        $discount =$this->applycoupononcoustomer($request->user_id,$request->input('id'),$request->input('subtotal'));
     
        if ($discount == 0) { 
            $response = array(
                "status" => "0",
                "discount" => $discount

            );

        } else {
            $response = array(
                "status" => "1",
                "discount" => $discount

            );
        }

        return response()->json($response);

    }
    public function applycoupon_v2(Request $request)
    {
        $discount = 0;
        $cart = json_decode($request->test_json,true);
        //   log::info($cart);
        $cart_data = [];
        foreach ($cart['Testdata'] as $member) {
            foreach ($member['items'] as $item) {
                $cart_data[] = [
                    'type'             => $item['type'],
                    'type_id'          => $item['id'],   // item id = type_id
                    'parameter'        => $item['parameter'] ?? null,
                    'price'            => $item['price'] ?? 0,
                    'mrp'              => $item['mrp'] ?? 0,
                    'family_member_id' => $member['member_id'], // rename properly
                ];
            }
        }
     
        
        $discount =$this->ApplyCoupononUser($request->user_id,$request->id,$request->subtotal,$cart_data);
       
     
        if ($discount == 0) { 
            $response = array(
                "status" => "0",
                "discount" => $discount

            );

        } else {
            $response = array(
                "status" => "1",
                "discount" => $discount

            );
        }

        return response()->json($response);

    }
    public function add_all_reviews()
    {
        $user_arr = array(3, 4, 5, 6);
        $review = array(
            "The quality of your report and your results made it easy to identify potential problems.",
            "The extractable organics GC/MS work was well documented, the best I have seen from a commercial lab.",
            "Very good just what you need every important test covered",
            "I have had nothing but wonderful service from them. I would highly recommend them and I would hire them again.",
            "it was a good value for the money!"
        );
        $str = array(5, 4);

        $getallproduct = Profiles::all();

        foreach ($getallproduct as $g) {
            for ($i = 0; $i < 4; $i++) {
                $random_users = array_rand($user_arr, 1);
                //echo $random_users;exit;
                $random_str = array_rand($str, 1);
                $random_review = array_rand($review, 1);
                $data = new Review();
                $data->user_id = $user_arr[$random_users];
                $data->type = '2';
                $data->type_id = $g->id;
                $data->ratting = $str[$random_str];
                $data->description = $review[$random_review];
                $data->date = $this->getsitedate();
                $data->save();
            }
        }

        echo "done";

    }

    public function post_register(Request $request)
    {
         $setting = Setting::find(1);
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
    
        $rules = [
            'name' => 'required',
            'phone' => ['required', 'unique:users,phone', Rule::unique('users', 'phone')->whereNull('deleted_at')],
            'type' => 'required',
            'gender' => 'required',
            'age' => 'required',
        ];
    
        $messages = array(
            'name.required' => 'name is required',
            'phone.unique' => 'Mobile Number Already exists',
            'phone.required' => "phone is required",
            'type.required' => "type is required",
            'gender.required' => "gender is required",
            'age.required' => "age required",
        );
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $inset = new User();
            $inset->name = $request->get("name");
            $inset->password = Hash::make($request->get("password"));
            $inset->email = $request->get("email");
            $inset->phone = $request->get("phone");
            $inset->sex = $request->get("gender");
            $inset->d_o_b = $request->get("d_o_b");
            $inset->age = $request->get("age");
            $inset->wallet_amount  =$setting->wallet_point_on_register;
            $inset->save();
    
            $storeFamily = new FamilyMember();
            $storeFamily->name = $request->get("name");
            $storeFamily->mobile_no = $request->get("phone");
            $storeFamily->age = $request->get("age");
            $storeFamily->email = $request->get("email");
            $storeFamily->dob = $request->get("d_o_b");
            $storeFamily->relation = 'Self';
            $storeFamily->gender = $request->get("gender");
            $storeFamily->user_id = $inset->id;
            $storeFamily->save();
            
            
            $wallet_data = new Wallet();
            $wallet_data->user_id  =  $inset->id;
            $wallet_data->wallet_points  =  $setting->wallet_cashback_point;
            $wallet_data->order_id  =  0  ;
            $wallet_data->action  =  1;
            $wallet_data->expire_on  =  date('Y-m-d', strtotime('+1 year'));
            $wallet_data->save();
    
            $existingToken = Token::where("token", $request->get("token"))->first();
            if ($existingToken) {
                // Update the user_id of the existing token if it's already present
                $existingToken->user_id = $inset->id;
                $existingToken->save();
            } else {
                // Create a new token record if it does not exist
                $store = new Token();
                $store->token = $request->get("token");
                $store->type = $request->get("type");
                $store->user_id = $inset->id;
                $store->save();
            }
            
           
                
            
    
            $response['status'] = "1";
            $response['msg'] = "User Registered Successfully";
            $response['register'] = array(
                "user_id" => $inset->id,
                "name" => $request->get("name"),
                "email" => $inset->email,
                "phone" => $inset->phone,
                "sex" => $inset->sex,
                "d_o_b" => $inset->d_o_b,
                "age" => $inset->age
            );
        }
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function post_login(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['login_type' => 'required', 'token' => 'required', 'token_type' => 'required'];
        if ($request->input('login_type') == '1') {
            $rules['password'] = 'required';
            $rules['email'] = 'required';
        }
        if ($request->input('login_type') == '2' || $request->input('login_type') == '3') {
            $rules['name'] = 'required';
            $rules['soical_id'] = 'required';
        }

        $messages = array(
            'login_type.required' => "login_type is required",
            'token.required' => "token is required",
            'token_type.required' => "token_type is required",
            'email.required' => "email is required",
            'password.required' => "password is required",
            "name.required" => "name is required",
            "soical_id.required" => "soical_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->input('login_type') == '1') {
                $user = User::where("email", $request->get("email"))
                    ->where("user_type", '3')
                    ->first();
                if ($user) {
                    if (Hash::check($request->get("password"), $user->password)) {
                        $gettoken = Token::where("token", $request->get("token"))
                            ->first();
                        if (!$gettoken) {
                            $store = new Token();
                            $store->token = $request->get("token");
                            $store->type = $request->get("token_type");
                            $store->user_id = $user->id;
                            $store->save();
                        } else {
                            $gettoken->user_id = $user->id;
                            $gettoken->save();
                        }
                        $user->login_type = $request->get("login_type");
                        $user->save();
                        if ($user->profile_pic != "") {
                            $image = asset("storage/app/public/profile") . '/' . $user->profile_pic;
                        } else {
                            $image = asset("public/upload/profile/profile.png");
                        }
                        $response['status'] = "1";
                        $response['headers'] = array(
                            'Access-Control-Allow-Origin' => '*'
                        );
                        $response['msg'] = "Login Successfully";
                        $response['register'] = array(
                            "user_id" => $user->id,
                            "name" => $user->name,
                            "phone" => $user->phone,
                            "email" => $user->email,
                            "profile_pic" => $image
                        );
                    } else {
                        $response = array(
                            "status" => 0,
                            "msg" => "Login Credentials Are Wrong"
                        );
                    }

                } else {
                    $response = array(
                        "status" => 0,
                        "msg" => "Login Credentials Are Wrong"
                    );
                }
            }
            if ($request->input('login_type') == '2' || $request->input('login_type') == '3') {
                $checkuser = User::where("email", $request->get("email"))
                    ->first();
                if ($checkuser) {
                    $gettoken = Token::where("token", $request->get("token"))
                        ->first();
                    if (!$gettoken) {
                        $store = new Token();
                        $store->token = $request->get("token");
                        $store->type = $request->get("token_type");
                        $store->user_id = $checkuser->id;
                        $store->save();
                    } else {
                        $gettoken->user_id = $checkuser->id;
                        $gettoken->save();
                    }

                    $checkuser->login_type = $request->input('login_type');
                    $checkuser->soical_id = $request->get('soical_id');
                    $checkuser->save();
                    $imgdata = $checkuser->profile_pic;
                    $png_url = "";
                    if ($request->get("image") != "") {
                        $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                        $path = storage_path() . '/app/public/profile/' . $png_url;
                        $content = $this->file_get_contents_curl($request->get("image"));
                        $savefile = fopen($path, 'w');
                        fwrite($savefile, $content);
                        fclose($savefile);
                        $img = storage_path() . '/app/public/profile/' . $png_url;
                        $checkuser->login_type = $request->get("login_type");
                        $checkuser->profile_pic = $png_url;
                        $checkuser->save();
                    }
                    if ($imgdata != $png_url && $imgdata != "") {
                        $image_path = storage_path() . "/app/public/profile/" . $imgdata;
                        if (file_exists($image_path) && $imgdata != "") {
                            try {
                                unlink($image_path);
                            } catch (Exception $e) {
                            }
                        }
                    }

                    if ($checkuser->profile_pic != "") {
                        $image = asset("storage/app/public/profile") . '/' . $checkuser->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $response['status'] = "1";
                    $response['headers'] = array(
                        'Access-Control-Allow-Origin' => '*'
                    );
                    $response['msg'] = "Login Successfully";
                    $response['register'] = array(
                        "user_id" => $checkuser->id,
                        "name" => $checkuser->name,
                        "phone" => $checkuser->phone,
                        "email" => $checkuser->email,
                        "profile_pic" => $image
                    );
                } else {
                    $str = explode(" ", $request->get("name"));
                    $store = new User();
                    $store->name = $str[0];
                    $store->email = $request->get("email");
                    $store->login_type = $request->get("login_type");
                    $store->soical_id = $request->get('soical_id');
                    $store->phone = $request->get("phone");
                    if ($request->get("image") != "") {
                        $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                        $path = storage_path() . '/app/public/profile/' . $png_url;
                        $content = $this->file_get_contents_curl($request->get("image"));
                        $savefile = fopen($path, 'w');
                        fwrite($savefile, $content);
                        fclose($savefile);
                        $img = storage_path() . '/app/public/profile/' . $png_url;
                        $getuser->profile_pic = $png_url;
                    }
                    $store->save();
                    if ($store->profile_pic != "") {
                        $image = storage_path() . '/app/public/profile' . '/' . $store->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $gettoken = Token::where("token", $request->get("token"))
                        ->first();
                    if (!$gettoken) {
                        $store = new Token();
                        $store->token = $request->get("token");
                        $store->type = $request->get("token_type");
                        $store->user_id = $store->id;
                        $store->save();
                    } else {
                        $gettoken->user_id = $store->id;
                        $gettoken->save();
                    }
                    $response['status'] = "1";
                    $response['headers'] = array(
                        'Access-Control-Allow-Origin' => '*'
                    );
                    $response['msg'] = "Login Successfully";
                    $response['register'] = array(
                        "user_id" => $store->id,
                        "name" => $store->name,
                        "phone" => $store->phone,
                        "email" => $store->email,
                        "profile_pic" => $image
                    );
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function get_category(Request $request)
    {
        // Log::info($request->city);
        $getcategory = array();
        $categorydata = Subcategory::select('id', 'name', 'image', 'short_desc')->where("is_deleted", '0')
            ->get();
           
        $defaultcityID = $this->getdefaultcityid($request->city);
        foreach ($categorydata as $row) {

            $package_list = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                               ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                               ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
            $profile_list = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                                    ->whereIn('pb.branch_id', [$defaultcityID])
                                    ->whereNull('profiles.deleted_at')
                                    ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
            $parameter_list = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                    ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                    ->whereNull('parameters.deleted_at')
                                    ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();

            if ($package_list != 0 || $profile_list != 0 || $parameter_list != 0) {
            // if ($package_list != 0 and $profile_list != 0 and $parameter_list != 0) {
                $getcategory[] = $row;
            }

        }
        foreach ($getcategory as $g) {
            $g->image = asset('storage/app/public/Subcategory') . '/' . $g->image;
        }
        $response = array(
            "status" => 1,
            "msg" => "Get Category List",
            "data" => $getcategory
        );
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function serach_category(Request $request)
    {

        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['term' => 'required'];
        $messages = array(
            'term.required' => "term is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $getcategory = Subcategory::select('id', 'name', 'image', 'short_desc')->where("is_deleted", '0')->where('name', 'like', '%' . $request->get("term") . '%')
                ->get();
            foreach ($getcategory as $g) {
                $g->image = asset('storage/app/public/Subcategory') . '/' . $g->image;
            }
            $response = array(
                "status" => 1,
                "msg" => "Get Category List",
                "data" => $getcategory
            );
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function post_savetoken(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
    
        $rules = [
            'token' => 'required',
            'type' => 'required'
        ];
    
        $messages = [
            'token.required' => "token is required",
            'type.required' => "type is required"
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->get("token") != "" && $request->get("type") != "" && $request->get("token") != "null") {
                $existingToken = Token::where("token", $request->get("token"))->first();
    
                if ($existingToken) {
                    // Update the type if the token already exists
                    $existingToken->type = $request->get("type");
                    $existingToken->save();
    
                    $response = array(
                        "status" => 1,
                        "msg" => "Token Updated Successfully",
                        "data" => $existingToken
                    );
                } else {
                    // Create a new token record if it does not exist
                    $store = new Token();
                    $store->token = $request->get("token");
                    $store->type = $request->get("type");
                    $store->save();
    
                    $response = array(
                        "status" => 1,
                        "msg" => "Token Saved Successfully",
                        "data" => $store
                    );
                }
            } else {
                $response = array(
                    "status" => 0,
                    "msg" => "Fields are required"
                );
            }
        }
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function forgotpassword(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['email' => 'required'];

        $messages = array(
            'email.required' => "email is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $checkmobile = User::where("email", $request->get("email"))
                ->first();

            if ($checkmobile) {
                $code = mt_rand(100000, 999999);
                $store = array();
                $store['email'] = $checkmobile->email;
                $store['name'] = $checkmobile->name;
                $store['code'] = $code;
                $add = new Resetpassword();
                $add->user_id = $checkmobile->id;
                $add->code = $code;
                $add->save();
                try {
                    Mail::send('email.forgotpassword', ['user' => $store], function ($message) use ($store) {
                        $message->to($store['email'], $store['name'])->subject(__('message.site_name'));
                    });
                } catch (\Exception $e) {
                }
                $response['status'] = "1";
                $response['msg'] = "Mail Send Successfully";
            } else {
                $response['status'] = "0";
                $response['msg'] = "Email Not Found";

            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_category_detail(Request $request)
    {
        // Log::info($request->all());
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['cat_id' => 'required'];

        $messages = array(
            'cat_id.required' => "cat_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $getcategory = Subcategory::find($request->get("cat_id"));
            if ($getcategory) {
                $defaultcityID = $this->getdefaultcityid($request->city);
                $getcategory->image = asset('storage/app/public/Subcategory') . '/' . $getcategory->image;
                $data1 = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                                   ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                                   ->select('packages.*','package_branch.mrp','package_branch.price')
                                   ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$request->get("cat_id")])->whereNull('deleted_at')->get();
                $data2 = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                                    ->whereIn('pb.branch_id', [$defaultcityID])
                                    ->whereNull('profiles.deleted_at')
                                    ->select('profiles.*','pb.mrp','pb.price')
                                    ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$request->get("cat_id")])->whereNull('deleted_at')->get();
                $data3 = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                    ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                    ->whereNull('parameters.deleted_at')
                                    ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')
                                    ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$request->get("cat_id")])->whereNull('deleted_at')->get();
                $ls = array();
                foreach ($data1 as $d1) {
                    $find_pa = TestDetails::where("package_id", $d1->id)->get();
                    $parameter = 0;
                    $ls1 = array();
                    foreach ($find_pa as $d) {
                        if ($d->type == 1) {
                            $ls1[] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                            $parameter = $parameter + 1;
                        }
                        if ($d->type == 2) {
                            $a = Profiles::find($d->type_id);
                            if ($a) {
                                $arr = explode(",", $a->no_of_parameter);
                                foreach ($arr as $l) { 
                                    $ls1[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                                    
                                }
                                $parameter = $parameter + count($arr);
                            }
                        }
                    }
                    $a = array();
                    $a['id'] = (int) $d1->id;
                    $a['name'] = $d1->name;
                    $a['mrp'] = number_format($d1->mrp, 2, '.', '');
                    $a['price'] =$d1->price;
                    $total = 100 * ($d1->mrp - $d1->price) / $d1->mrp;
                    // $a['discount'] = number_format($total, '2', '.', '');
                    $dis_pa = $this->get_discount($d1->id,'Package',$d1->mrp);
                    $a['discount'] = $dis_pa;
                    $a['type'] = '1';
                    $a['no_of_parameter'] = $parameter;
                    $a['parameter_list'] = array_slice($ls1, 0, 4);
                    $ls[] = $a;
                }
                $total2 = 0;
                foreach ($data3 as $d1) {
                    $a = array();
                    $a['id'] = (int) $d1->id;
                    $a['name'] = $d1->name;
                   
                    if ($d1->mrp != 0.00 && $d1->price != 0.00) {
                        $total2 = 100 * ($d1->mrp - $d1->price) / $d1->mrp;
                    }
                    $a['mrp'] = round($d1->mrp);
                    $a['price'] = number_format($d1->price, 2, '.', '');
                    $dis_pa = $this->get_discount($d1->id,'Parameter',$d1->mrp);
                    $a['discount'] = $dis_pa;
                    $a['type'] = '2';
                    $a['no_of_parameter'] = 1;
                    $a['parameter_list'] = array($d1->name);
                    $ls[] = $a;
                }
                foreach ($data2 as $d1) {
                    
                    $arr = explode(",", $d1->no_of_parameter);
                    $i = 0;
                    $ls1 = array();
                    foreach ($arr as $a) {
                        if ($i <= 3) {
                            $ls1[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                        }
                        $i++;
                    }

                    $a = array();
                    $a['id'] = (int) $d1->id;
                    $a['name'] = $d1->profile_name;
                    $a['mrp'] = number_format($d1->mrp, 2, '.', '');
                    $a['price'] =$d1->price;
                    $total = 100 * ($d1->mrp - $d1->price) / $d1->mrp;
                    // $a['discount'] = number_format($total, '2', '.', '');
                    $dis_pa = $this->get_discount($d1->id,'Profiles',$d1->mrp);
                    $a['discount'] = $dis_pa;
                    $a['type'] = '3';
                    $a['no_of_parameter'] = count($arr);
                    $a['parameter_list'] = $ls1;
                    $ls[] = $a;

                }
                $getcategory->package_detail = $ls;
                $getcategory->currency = Setting::find(1) ? Setting::find(1)->currency : '';
                $response['status'] = "1";
                $response['msg'] = "Category Detail Get Successfully";
                $response['data'] = $getcategory;
            } else {
                $response['status'] = "0";
                $response['msg'] = "Category Not Found";

            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function package_detail(Request $request)
    {
        
        $response = array(
            "status" => 0,
            "msg" => "Validation error" 
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $defaultcityID = $this->getdefaultcityid($request->city);
            $package = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                   ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('deleted_at')
                   ->select('packages.*','package_branch.mrp','package_branch.price')->find($request->get("id"));
            if ($package) {
                $find_pa = TestDetails::where("package_id", $package->id)->get();
                $mrp = 0;
                $parameter = 0;
                $ls1 = array();
                foreach ($find_pa as $d) {
                    if ($d->type == 1) {
                        $a = array();
                        $a['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                        
                        $a['id'] = (int) $d->type_id;
                        $a['type'] = '2';
                        $a['parameter'] = array();
                        $parameter = $parameter + 1;
                        $ls1[] = $a;
                    }
                    if ($d->type == 2) {
                        $a = Profiles::find($d->type_id);
                        if ($a) {
                            $a1 = array();
                            $a1['name'] = $a->profile_name;
                            $a1['id'] = (int) $d->type_id;
                            $a1['type'] = '3';
                            $k = array();
                            $arr = explode(",", $a->no_of_parameter);
                            foreach ($arr as $l) {
                                $c = array();
                                $c['name'] = Parameter::find($l) ? Parameter::find($l)->name : '';
                                
                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                                $c['id'] = (int) $l;
                                $k[] = $c;
                            }
                            $a1['parameter'] = $k;
                            $ls1[] = $a1;
                            $parameter = $parameter + count($arr);
                        }
                    }
                }
                $package->no_of_parameter = $parameter;
                $package->parameter_list = $ls1;
                $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '1')->get();
                $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '1')->where("type_id", $package->id)->get();
                foreach ($package->review as $r) {
                    $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                    $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
                }
                $total = 100 * ($package->mrp - $package->price) / $package->mrp;
                $dis_pa = $this->get_discount($package->id,'Package',$package->mrp);
                $package->discount = $dis_pa;
                $package->totalreview = count(Review::with('userdata')->where("type", '1')->where("type_id", $package->id)->get());
                $package->avgreview = (string) Review::where("type", '1')->where("type_id", $package->id)->avg('ratting');
                $response['status'] = 1;
                $response['msg'] = "Package Detail Get Successfully";
                $response['data'] = $package;
            } else {
                $response['status'] = 0;
                $response['msg'] = "Package Not Found";

            }
        }
        return json_encode($response);
    }


    public function profile_detail(Request $request)
    {
        // Log::info($request->all());
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $defaultcityID = $this->getdefaultcityid($request->city);
            $package = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                            ->whereIn('pb.branch_id', [$defaultcityID])
                            ->whereNull('profiles.deleted_at')
                            ->select('profiles.*','pb.mrp','pb.price')
                            ->find($request->get("id"));
            if ($package) {
                $arr = explode(",", $package->no_of_parameter);
                $ls = array();
                $i = 0;
                $mrp = 0 ;
                foreach ($arr as $a) {
                    $k = array();
                    $k['name'] = Parameter::find($a) ? Parameter::find($a)->name : '';
                    $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                    $k['id'] = (int) $a;
                    $ls[] = $k;
                }
                $package->no_of_parameter = count($arr);
                $package->parameter_list = $ls;
                $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '3')->get();
                $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '3')->where("type_id", $package->id)->get();
                foreach ($package->review as $r) {
                    $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                    $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
                }
                $total = 100 * ($package->mrp - $package->price) / $package->mrp;
                $dis_pa = $this->get_discount($package->id,'Profiles',$package->mrp);
                $package->discount = $dis_pa;
                $package->totalreview = count(Review::with('userdata')->where("type", '3')->where("type_id", $package->id)->get());
                $package->avgreview = Review::where("type", '3')->where("type_id", $package->id)->avg('ratting');
                $response['status'] = "1";
                $response['msg'] = "Profile Detail Get Successfully";
                $response['data'] = $package;
            } else {
                $response['status'] = "0";
                $response['msg'] = "Profile Not Found";

            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function parameter_detail(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $defaultcityID = $this->getdefaultcityid($request->city);
            $package = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                            ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                            ->whereNull('parameters.deleted_at')
                            ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')
                            ->find($request->get("id"));
            if ($package) {
                $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '3')->get();
                $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '3')->where("type_id", $package->id)->get();
                foreach ($package->review as $r) {
                    $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                    $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
                }
                $total = 100 * ($package->mrp - $package->price) / $package->mrp;
                $dis_pa = $this->get_discount($package->id,'Parameter',$package->mrp);
                $package->discount = $dis_pa;
                $package->totalreview = count(Review::with('userdata')->where("type", '3')->where("type_id", $package->id)->get());
                $package->avgreview = Review::where("type", '3')->where("type_id", $package->id)->avg('ratting');
                $response['status'] = "1";
                $response['msg'] = "Parameter Detail Get Successfully";
                $response['data'] = $package;
            } else {
                $response['status'] = "0";
                $response['msg'] = "Parameter Not Found";

            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function save_member(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'mobile_no' => 'required',
            // 'age' => 'required',
            // 'email' => 'required',
            // 'dob' => 'required',
            'relation' => 'required',
            'gender' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required",
            'user_id.required' => "user_id is required",
            'name.required' => "name is required",
            'mobile_no.required' => "mobile_no is required",
            // 'age.required' => "age is required",
            // 'email.required' => "email is required",
            // 'dob.required' => "dob is required",
            'relation.required' => "relation is required",
            'gender.required' => "gender is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->get("id") == 0) {
                $store = new FamilyMember();
                $msg = "Member Add Successfully";
            } else {
                $store = FamilyMember::find($request->get("id"));
                if (empty($store)) {
                    $response['status'] = "0";
                    $response['msg'] = "Member Not Found";
                }
                $msg = "Member Update Successfully";
            }

            $store->name = $request->get("name");
            $store->mobile_no = $request->get("mobile_no");
            $store->age = $request->get("age");
            $store->email = $request->get("email");
            $store->dob = $request->get("dob");
            $store->relation = $request->get("relation");
            $store->gender = $request->get("gender");
            $store->user_id = $request->get("user_id");
            $store->save();
            $response['status'] = "1";
            $response['msg'] = $msg;
            $response['data'] = $store;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function delete_member(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = FamilyMember::find($request->get("id"));
           if ($data) {

            // 🔴 Prevent self delete
            if ($data->relation == 'Self') {
                $response['status'] = "0";
                $response['msg'] = "You cannot delete yourself";
            } else {
                $data->delete();
                $response['status'] = "1";
                $response['msg'] = "Member Delete Successfully";
            }

        } else {
            $response['status'] = "0";
            $response['msg'] = "Member Not Found";
        }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_member_list(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = FamilyMember::where("user_id", $request->get("id"))->wherenull('deleted_at')->get();
            if (count($data) > 0) {
                $response['status'] = "1";
                $response['msg'] = "Member Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = "Member Not Found";
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function save_address(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'house_no' => 'required',
            'pincode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required",
            'user_id.required' => "user_id is required",
            'name.required' => "name is required",
            'house_no.required' => "house_no is required",
            'pincode.required' => "pincode is required",
            'state.required' => "state is required",
            'address.required' => "address is required",
            'lat.required' => "lat is required",
            'long.required' => "long is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->get("id") == 0) {
                $store = new UserAddress();
                $msg = "Address Add Successfully";
            } else {
                $store = UserAddress::find($request->get("id"));
                if (empty($store)) {
                    $response['status'] = "0";
                    $response['msg'] = "Address Not Found";
                    return json_encode($response, JSON_NUMERIC_CHECK);
                }
                $msg = "Address Update Successfully";
            }

            $store->name = $request->get("name");
            $store->user_id = $request->get("user_id");
            $store->house_no = $request->get("house_no");
            $store->pincode = $request->get("pincode");
            $store->city = $request->get("city");
            $store->address = $request->get("address");
            $store->state = $request->get("state");
            $store->lat = $request->get("lat");
            $store->long = $request->get("long");
            $store->phone = $request->get("phone_no");      
            $store->apartment = $request->get("apartment");      
            $store->landmark = $request->get("landmark");
            $store->save();
            if ($request->get("is_default") == 1) {
                UserAddress::where("user_id", $request->get("user_id"))->update(['is_default' => 0]);
                $store->is_default = '1';
                $store->save();
            } else {
                $store->is_default = '0';
                $store->save();
            }

            $response['status'] = "1";
            $response['msg'] = $msg;
            $response['data'] = $store;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getaddress(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = UserAddress::where("user_id", $request->get("id"))->wherenull('deleted_at')->get();
            if (count($data) > 0) {
                $response['status'] = "1";
                $response['msg'] = "Addresses Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = "Address Not Found";
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function delete_address(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['id' => 'required'];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = UserAddress::find($request->get("id"));
            if ($data) {
                $data->delete();
                $response['status'] = "1";
                $response['msg'] = "Address Delete Successfully";
            } else {
                $response['status'] = "0";
                $response['msg'] = "Address Not Found";
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getlab_bycityname(Request $request){
        if($request->cityname == ''){
            $response['status'] = "0";
            $response['msg'] = "Please enter cityname";
        }else{

            $cityname = $request->cityname;
            
            $users = City::select('users.id','users.name')->join('users','users.city','city.id')
                ->where('users.user_type',2)
                ->where('city.city',$cityname)
                ->where('users.status',1)
                ->orderByRaw("CASE WHEN city.default = 'Yes' THEN 0 ELSE 1 END")
                ->distinct()
                ->get();
            if (count($users) == 0) {
                $response['status'] = "0";
                $response['msg'] = "no lab found at this address";
            } else {
                $response['data'] = $users;
                $response['status'] = "1";
                $response['msg'] = "lab get Successfully";
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function getUsersByCity(Request $request)
    {
        if($request->get("city_id") == ''){
            $response['status'] = "0";
            $response['msg'] = "Please enter ID";
        }else{

            $id = $request->get("city_id");
            $city = DB::table('user_addresses')->where('id', $id)->first();
            if ($city == null) {
                $response['status'] = "0";
                $response['msg'] = " city_id not found!";
            }
            $lat = $city->lat;
            $lng = $city->long;
            $latRange = 0.1; // 0.1 degree range
            $lngRange = 0.1; // 0.1 degree range
    
            $users = City::select('city.*','users.name as lab_name','users.name as name')->join('users','users.city','city.id')
                ->where('users.user_type',2)
                ->whereBetween('city.lat', [$lat - $latRange, $lat + $latRange])
                ->whereBetween('city.lng', [$lng - $lngRange, $lng + $lngRange])
                ->where('users.status',1)
                ->orderByRaw("CASE WHEN city.default = 'Yes' THEN 0 ELSE 1 END")
                ->distinct()
                ->get();
            if (count($users) == 0) {
                $response['status'] = "0";
                $response['msg'] = "no lab found at this address";
            } else {
                $response['data'] = $users;
                $response['status'] = "1";
                $response['msg'] = "lab get Successfully";
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function booknow(Request $request)
    {
        // Log::info($request->all());
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'sample_collection_address_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'payment_method' => 'required',
            'subtotal' => 'required',
            'tax' => 'required',
            'final_total' => 'required',
            // 'test_json' => 'required',
            'member_id' => 'required'
        ];
        if ($request->input('payment_method') == "braintree") {
            $rules['payment_method_nonce'] = 'required';
        }

        if ($request->input('payment_method') == "stripe") {
            $rules['stripeToken'] = 'required';
        }
        $setting = Setting::find(1);
        $messages = array(
            'user_id.required' => "user_id is required",
            'sample_collection_address_id.required' => "sample_collection_address_id is required",
            'date.required' => "date is required",
            'time.required' => "time is required",
            'payment_method.required' => "payment_method is required",
            'subtotal.required' => "subtotal is required",
            'tax.required' => "tax is required",
            'final_total.required' => "final_total is required",
            // 'test_json.required' => "test_json is required",
            'payment_method_nonce.required' => "payment_method_nonce is required",
            'stripeToken.required' => "stripeToken is required",
            'member_id.required' => "member_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $lab = User::where('user_type', 2)->where('city', $request->get("member_id"))->first();
            if ($lab == null) {
                $response = array(
                    "status" => "0",
                    "msg" => "Lab not found"

                );
                return json_encode($response, JSON_NUMERIC_CHECK);
            }
            $member = $lab->id;
            $getallkeys = PaymentGateway::all();
            $ls = array();
            foreach ($getallkeys as $g) {
                $ls[$g->payment_gateway_name . "_" . $g->key_name] = $g->meta_value;
            }

            $setting = Setting::find(1);
            $visit_type = 1;
            if (isset($request['visit_type']) && $request['visit_type'] !== '') {
                $visit_type = $request['visit_type'];
            }
            $subtotal = $request->get("subtotal");
            $final_total = $request->get("final_total");
            $wallet_cashback_point = 0;
            $store = new Orders();
            #------------------coupon----------------

            $cart_data = CartMember::where("user_id", $request->get("user_id"))->get();

            foreach ($cart_data as $g) {

                if ($g->type == 1) {
                    $item_data = Package::find($g->type_id);
                    $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                } else if ($g->type == 2) {
                    $item_data = Parameter::find($g->type_id);
                    $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                } else {
                    $item_data = Profiles::find($g->type_id);
                    $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                    if ($item_data) {
                        $item_data->name = $item_data->profile_name;
                    }
                }
                
                $prices = $item_data['mrp'];
                $g['price'] =   $prices;

            }
            $price = 0;
            $discount = 0;
            if (isset($request['coupon_id']) && $request['coupon_id'] !== '' && $request['coupon_id'] !== null) {
                $discount=$this->applycoupononcoustomer($request->get("user_id"),$request['coupon_id'],$request->get("subtotal"));
                $store->coupon_id = $request['coupon_id'];
                $store->coupon_discount = $discount;

            }
            //---------wallet-----------
            $dis = 0;
            if (isset($request['wallet_point']) && $request['wallet_point'] > 0) {
                $userupdate = User::find($request->get("user_id"));
                $userupdate->wallet_amount -= $request['wallet_point'] * $setting->wallet_cashback_point;
                $userupdate->save();
                $dis = $request['wallet_point'];
                $final_total = $final_total - $dis;
                
                
            }

            #-------------- wallet cash back---------------------------

            $wallet_cashback_per = $setting->wallet_cashback_per / 100;
            $wallet_cashback_point = ($subtotal * $wallet_cashback_per) * $setting->wallet_cashback_point;
            $wallet_cashback_point = number_format($wallet_cashback_point, 2);
            $userupdate = User::find($request->get("user_id"));
            $userupdate->wallet_amount += $wallet_cashback_point;
            $userupdate->save();
            #----------------------------------------------------------

            if ($request->get("payment_method") == "cod") {

                DB::beginTransaction();
                try {


                    $store->user_id = $request->get("user_id");
                    $store->sample_collection_address_id = $request->get("sample_collection_address_id");
                    $store->date = $request->get("date");
                    $store->time = $request->get("time");
                    $store->payment_method = $request->get("payment_method");
                    $store->visit_type = $visit_type;
                    $store->token = '';
                    $store->subtotal = $subtotal;
                    $store->cashback_point = $request['wallet_point'];
                    $store->wallet_discount = $dis;
                    $store->manager_id = $member;
                    $store->tax = $request->get("tax");
                    $store->final_total = $request->get("final_total");
                    $store->status = 1;
                    $store->from_device = 'APP';
                    $store->orderplace_date = $this->getsitedate();
                    $store->save();
                    
                    $order_id = $store->id;
                    
                     if (isset($request['wallet_point']) && $request['wallet_point'] > 0) {
                        $wallet_data = new Wallet();
                        $wallet_data->user_id  = Auth::id();
                        $wallet_data->wallet_points  =  $request['wallet_point'];
                        $wallet_data->order_id  =  $order_id   ;
                        $wallet_data->action  =  0;
                        $wallet_data->save();
                    }
                        
                        $wallet_data = new Wallet();
                        $wallet_data->user_id  = Auth::id();
                        $wallet_data->wallet_points  =  $setting->wallet_cashback_point;
                        $wallet_data->order_id  =  $order_id   ;
                        $wallet_data->action  =  1;
                        $wallet_data->expire_on  =  date('Y-m-d', strtotime('+1 year'));
                        $wallet_data->save();

                    $store1 = CartMember::where("user_id", $request->get("user_id"))->get();
                    if (count($store1) > 0) {
                        foreach ($store1 as $s) {
                            $mrp=0;
                            if ($s->type == 1) {
                                $item_data = Package::find($s->type_id);
                                $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                                foreach ($find_pa as $d) {
                                
                                    if ($d->type == 1) {
                                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                                    }
                                    if ($d->type == 2) {
                                        $a = Profiles::find($d->type_id);
                                        if ($a) {
                                            $alr = explode(",", $a->no_of_parameter);
                                            foreach ($alr as $l) {
                                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                                            }
                                        }
                                    }
                                }
                                $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                            } else if ($s->type == 2) {
                                $item_data = Parameter::find($s->type_id);
                                $mrpg = $item_data->mrp;
                                $price = $item_data->price;
                                $item_data->mrp = $price;
                                $item_data->price = $mrpg;
                                $mrp =  $item_data->price;
                                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                            } else {
                                $item_data = Profiles::find($s->type_id);
                                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                                if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                                // $item_data->name = $item_data->profile_name;
                                }
                                if ($item_data) {
                                    $item_data->name = $item_data->profile_name;
                                }
                            }
                            
                            $prices = $item_data['mrp'];
                            
                            $data = new OrdersData();
                            $data->order_id = $store->id;
                            $data->member_id = $member;
                            $data->item_id = $s->type_id;
                            $data->family_member_id = $s->family_member_id;
                            $data->type = $s->type;
                            $data->item_name = $item_data->name;
                            $data->parameter = $s->parameter;
                            $data->mrp = $mrp;
                            // $data->price = $item_data->price;
                            $data->price = $prices;
                            $data->save();

                        }
                    }
                    CartMember::where("user_id", $request->get("user_id"))->delete();
                    DB::commit();
                    $getuseraddress = UserAddress::find($store->sample_collection_address_id);
                    if ($getuseraddress) {
                        $getmanager = User::where("user_type", "2")->where("city", $getuseraddress->city)->get();
                        foreach ($getmanager as $gm) {
                            $gm->order_notification = $gm->order_notification + 1;
                            $gm->save();
                            $data1 = array();
                            $data1['email'] = $gm->email;
                            $data1['msg'] = "You Get New Booking For Test";
                            $data1['order_id'] = $store->id;
                            $data1['customer_name'] = User::find($data->user_id) ? User::find($data->user_id)->name : '';
                            $data1['manager_name'] = $gm->name;
                            try {
                                $result = Mail::send('email.order_status', ['user' => $data1], function ($message) use ($data1) {
                                    $message->to($data1['email'], $data1['manager_name'])->subject(__('message.site_name'));
                                });
                            } catch (\Exception $e) {
                            }
                        }
                    }
                    $msg = "Test Booked Successfully";
                        //------------ SMS data----
                        $userdata = User::find($store->user_id);
                        $userdatalab = User::find($store->manager_id);
                        $to = $userdatalab->phone;
                        $getorderdatat = OrdersData::where('order_id',$store->id)->first();
                            $test = 'Test';
                        if($getorderdatat){
                            $test = $getorderdatat->item_name;
                        }
                            $templateName='Order_Received';
                            // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                            $datatm=[
                            'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                            ];
                            
                            $this->sendSms($to ,$datatm, $templateName);
                        // For 8094416508 , 7976526802 
                        $templateName='Order_Received';
                        // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                        $datatm=[
                        'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                        ];
                        
                        $this->sendSms(8094416508 ,$datatm, $templateName);
                        // --
                        $templateName='Order_Received';
                        // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                        $datatm=[
                        'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                        ];
                        
                        $this->sendSms(7976526802 ,$datatm, $templateName);
                        // ------------------------
                    $android = $this->send_notification_order_android($setting->android_server_key, $store->user_id, $msg, $store->id);

                    $ios = $this->send_notification_order_ios($setting->ios_server_key, $store->user_id, $msg, $store->id);
                    $response['status'] = "1";
                    $response['msg'] = "Test Book Successfully";
                    $response['data'] = $store->id;
                } catch (\Exception $e) {
                    // DB::rollback();
                    $response['status'] = "0";
                    $response['msg'] = $e;
                }
            } else {
                DB::beginTransaction();
                // try {

                    // $store = new Orders();
                    $store->user_id = $request->get("user_id");
                    $store->sample_collection_address_id = $request->get("sample_collection_address_id");
                    $store->date = $request->get("date");
                    $store->time = $request->get("time");
                    $store->payment_method = $request->get("payment_method");
                    $store->token = $request->get("tr_id");

                    $store->visit_type = $visit_type;
                    $store->subtotal = $subtotal;
                    $store->tax = $request->get("tax");
                    $store->cashback_point = $request['wallet_point'];
                    $store->wallet_discount = $dis;

                    $store->manager_id = $member;
                    $store->final_total = $final_total;
                    $store->orderplace_date = $this->getsitedate();
                    $store->from_device = 'APP';
                    $store->status = 1;
                    $store->save();
                    // $jsondata = json_decode($request->get("test_json"));
                    
                    $store1 = CartMember::where("user_id", $request->get("user_id"))->get();
                    foreach ($store1 as $ji) {
                        $mrp=0;
                        // foreach ($jt->items as $ji) {
                            if ($ji->type == 1) {
                                $item_data = Package::find($ji->type_id);
                                $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                                foreach ($find_pa as $d) {
                                
                                    if ($d->type == 1) {
                                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                                    }
                                    if ($d->type == 2) {
                                        $a = Profiles::find($d->type_id);
                                        if ($a) {
                                            $alr = explode(",", $a->no_of_parameter);
                                            foreach ($alr as $l) {
                                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                                            }
                                        }
                                    }
                                }
                                $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                            } else if ($ji->type == 2) {
                                $item_data = Parameter::find($ji->type_id);
                                $mrpg = $item_data->mrp;
                                $price = $item_data->price;
                                $item_data->mrp = (int)$price;
                                $item_data->price = $mrpg;
                                $mrp =  $item_data->price;
                                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                            } else {
                                $item_data = Profiles::find($ji->type_id);
                                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                                if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                                // $item_data->name = $item_data->profile_name;
                                }
                                if ($item_data) {
                                    $item_data->name = $item_data->profile_name;
                                }
                            }
                             $prices = $item_data['mrp'];
                            $data = new OrdersData();
                            $data->order_id = $store->id;
                            //  $data->member_id = $jt->member_id;
                            $data->member_id = $member;

                            $data->family_member_id = $ji->family_member_id;
                            $data->item_id = $ji->type_id;
                            $data->type = $ji->type;
                            $data->item_name = isset($item_data->name) ? $item_data->name : '';
                            $data->parameter = $ji->parameter;
                            $data->mrp = $mrp;
                            $data->price = $prices;
                            // $data->price = isset($item_data->mrp) ? $item_data->mrp : '';
                            $data->save();
                        // }
                    }
                    CartMember::where("user_id", $request->get("user_id"))->delete();
                    DB::commit();
                    $getuseraddress = UserAddress::find($store->sample_collection_address_id);
                    if ($getuseraddress) {
                        $getmanager = User::where("user_type", "2")->where("city", $getuseraddress->city)->get();
                        foreach ($getmanager as $gm) {
                            $gm->order_notification = $gm->order_notification + 1;
                            $gm->save();
                            $data1 = array();
                            $data1['email'] = $gm->email;
                            $data1['msg'] = "You Get New Booking For Test";
                            $data1['order_id'] = $store->id;
                            $data1['customer_name'] = User::find($data->user_id) ? User::find($data->user_id)->name : '';
                            $data1['manager_name'] = $gm->name;
                            try {
                                $result = Mail::send('email.order_status', ['user' => $data1], function ($message) use ($data1) {
                                    $message->to($data1['email'], $data1['manager_name'])->subject(__('message.site_name'));
                                });
                            } catch (\Exception $e) {
                            }
                        }
                    }

                    $msg = "Test Booked Successfully";
                        //------------ SMS data----
                        $userdata = User::find($store->user_id);
                        $userdatalab = User::find($store->manager_id);
                        $to = $userdatalab->phone;
                        $getorderdatat = OrdersData::where('order_id',$store->id)->first();
                            $test = 'Test';
                        if($getorderdatat){
                            $test = $getorderdatat->item_name;
                        }
                            $templateName='Order_Received';
                            // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                            $datatm=[
                            'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                            ];
                            
                            $this->sendSms($to ,$datatm, $templateName);
                        // For 8094416508 , 7976526802 
                        $templateName='Order_Received';
                        // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                        $datatm=[
                        'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                        ];
                        
                        $this->sendSms(8094416508 ,$datatm, $templateName);
                        // --
                        $templateName='Order_Received';
                        // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                        $datatm=[
                        'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                        ];
                        
                        $this->sendSms(7976526802 ,$datatm, $templateName);
                        // ------------------------
                    
                    $android = $this->send_notification_order_android($setting->android_server_key, $store->user_id, $msg, $store->id);
                    $ios = $this->send_notification_order_ios($setting->ios_server_key, $store->user_id, $msg, $store->id);
                    
                    $response['status'] = "1";
                    $response['msg'] = "Test Book Successfully";
                    $response['data'] = $store->id;

            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function booknow_v2(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'sample_collection_address_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'payment_method' => 'required',
            'subtotal' => 'required',
            'tax' => 'required',
            'final_total' => 'required',
            'test_json' => 'required',
            'member_id' => 'required'
        ];
        
        $setting = Setting::find(1);
        $messages = array(
            'user_id.required' => "user_id is required",
            'sample_collection_address_id.required' => "sample_collection_address_id is required",
            'date.required' => "date is required",
            'time.required' => "time is required",
            'payment_method.required' => "payment_method is required",
            'subtotal.required' => "subtotal is required",
            'tax.required' => "tax is required",
            'final_total.required' => "final_total is required",
            'test_json.required' => "test_json is required",
            'payment_method_nonce.required' => "payment_method_nonce is required",
            'stripeToken.required' => "stripeToken is required",
            'member_id.required' => "member_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $lab = User::where('user_type', 2)->where('city', $request->member_id)->first();
            if ($lab == null) {
                $response = array(
                    "status" => "0",
                    "msg" => "Lab not found"

                );
                return json_encode($response, JSON_NUMERIC_CHECK);
            }
            $member = $lab->id;
            $ls = array();
            
            $setting = Setting::find(1);
            $visit_type = 1;
            $cart = json_decode($request->test_json,true);
        
            $cart_data = [];
            foreach ($cart['Testdata'] as $memberss) {
                foreach ($memberss['items'] as $item) {
                    $cart_data[] = [
                        'type'             => $item['type'],
                        'type_id'          => $item['id'],   // item id = type_id
                        'parameter'        => $item['parameter'] ?? null,
                        'price'            => $item['price'] ?? 0,
                        'mrp'              => $item['mrp'] ?? 0,
                        'family_member_id' => $memberss['member_id'], // rename properly
                    ];
                }
            }
            
            if (isset($request['visit_type']) && $request['visit_type'] !== '') {
                $visit_type = $request['visit_type'];
            }
            $subtotal = $request->get("subtotal");
            $final_total = $request->get("final_total");
            $wallet_cashback_point = 0;
            $store = new Orders();
            #------------------coupon----------------
            $price = 0;
            $discount = 0;
            
            $store->coupon_id = $request['coupon_id'];
            $store->coupon_discount = $request['coupon_dis'];
        
            //---------wallet-----------
            $dis = 0;
            if (isset($request['wallet_point']) && $request['wallet_point'] > 0) {
                $userupdate = User::find($request->get("user_id"));
                $userupdate->wallet_amount -= $request['wallet_point'] * $setting->wallet_cashback_point;
                $userupdate->save();
                $dis = $request['wallet_point'];
                $final_total = $final_total - $dis;
            }

            #-------------- wallet cash back---------------------------

            $wallet_cashback_per = $setting->wallet_cashback_per / 100;
            $wallet_cashback_point = ($subtotal * $wallet_cashback_per) * $setting->wallet_cashback_point;
            $wallet_cashback_point = number_format($wallet_cashback_point, 2);
            
            $wallet = str_replace(',', '', $wallet_cashback_point);
            $wallet = (float) $wallet;
            
            $userupdate = User::find($request->get("user_id"));
            $userupdate->wallet_amount += $wallet;
            $userupdate->save();
            #----------------------------------------------------------
            
            Try{
                DB::beginTransaction();
                // -- detail
                $store->user_id = $request->get("user_id");
                $store->sample_collection_address_id = $request->get("sample_collection_address_id");
                $store->date = $request->get("date");
                $store->time = $request->get("time");
                $store->payment_method = $request->get("payment_method");
                $store->visit_type = $visit_type;
                $store->subtotal = $subtotal;
                $store->cashback_point = $request['wallet_point'];
                $store->wallet_discount = $dis;
                $store->manager_id = $member;
                $store->tax = $request->get("tax");
                $store->final_total = $request->get("final_total");
                $store->orderplace_date = $this->getsitedate();
                $store->from_device = 'APP';
                $store->status = 1;
                
                // --
                if ($request->get("payment_method") == "cod") {
                   
                    $store->token = '';
                    $store->status = 1;
                    $store->save();
                     
                }else{
                   
                    $store->token = $request->get("tr_id");
                    $store->save();
                    
                }
             
                $store1 = $cart_data;
                foreach ($store1 as $s) {
            
                    if ($s['type'] == 1) {
                        $item_data = Package::find($s['type_id']);
                         
                    } else if ($s['type'] == 2) {
                        $item_data = Parameter::find($s['type_id']);
                      
                    } else {
                        $item_data = Profiles::find($s['type_id']);
                        if ($item_data) {
                            $item_data->name = $item_data->profile_name;
                        }
                    }
                    
                    $data = new OrdersData();
                    $data->order_id = $store->id;
                    $data->member_id = $member;
                    $data->item_id = $s['type_id'];
                    $data->family_member_id = $s['family_member_id'];
                    $data->type = $s['type'];
                    $data->item_name = $item_data->name;
                    $data->parameter = $s['parameter'];
                    $data->mrp = $s['price'];
                    $data->price = $s['mrp'];
                    $data->save();

                }
            
                CartMember::where("user_id", $request->get("user_id"))->delete();
                DB::commit();
                $getuseraddress = UserAddress::find($store->sample_collection_address_id);
                if ($getuseraddress) {
                    $getmanager = User::where("user_type", "2")->where("city", $getuseraddress->city)->get();
                    foreach ($getmanager as $gm) {
                        $gm->order_notification = $gm->order_notification + 1;
                        $gm->save();
                        $data1 = array();
                        $data1['email'] = $gm->email;
                        $data1['msg'] = "You Get New Booking For Test";
                        $data1['order_id'] = $store->id;
                        $data1['customer_name'] = User::find($data->user_id) ? User::find($data->user_id)->name : '';
                        $data1['manager_name'] = $gm->name;
                        try {
                            $result = Mail::send('email.order_status', ['user' => $data1], function ($message) use ($data1) {
                                $message->to($data1['email'], $data1['manager_name'])->subject(__('message.site_name'));
                            });
                        } catch (\Exception $e) {
                        }
                    }
                }
                $msg = "Test Booked Successfully";
                //------------ SMS data----
                $userdata = User::find($store->user_id);
                $userdatalab = User::find($store->manager_id);
                $to = $userdatalab->phone;
                $getorderdatat = OrdersData::where('order_id',$store->id)->first();
                $test = 'Test';
                if($getorderdatat){
                    $test = $getorderdatat->item_name;
                }
                    $templateName='Order_Received';
                    // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                    $datatm=[
                    'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                    ];
                    
                    $this->sendSms($to ,$datatm, $templateName);
                    // For 8094416508 , 7976526802 
                    $templateName='Order_Received';
                    // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                    $datatm=[
                    'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                    ];
                    
                    $this->sendSms(8094416508 ,$datatm, $templateName);
                    // --
                    $templateName='Order_Received';
                    // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                    $datatm=[
                    'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                    ];
                    
                    $this->sendSms(7976526802 ,$datatm, $templateName);
                    $this->sendSms(9799983646 ,$datatm, $templateName);
                    $this->sendSms(9610988988 ,$datatm, $templateName);
                    // ------------------------
                $android = $this->send_notification_order_android($setting->android_server_key, $store->user_id, $msg, $store->id);

                $ios = $this->send_notification_order_ios($setting->ios_server_key, $store->user_id, $msg, $store->id);
                $response['status'] = "1";
                $response['msg'] = "Test Book Successfully";
                $response['data'] = $store->id;
            } catch (\Exception $e) {
                // DB::rollback();
                $response['status'] = "0";
                $response['msg'] = $e;
            }
            

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function send_notification_order_android($key, $user_id, $msg, $id)
    {
      
        // Fetch user tokens from the database (type 1 represents Android tokens in this case)
        $getuser = Token::where("type", 1)->where('user_id', $user_id)->get();
        
        //   Log::info('Feni P Patel' . $getuser);
        
    
        if (count($getuser) != 0) {
            $reg_ids = array();
            foreach ($getuser as $gt) {
                $reg_ids[] = $gt->token;
            }
    
            // OneSignal requires player IDs instead of FCM registration IDs
            $playerIds = $reg_ids;
    
            // Notification content
            $content = [
                'en' => $msg, // Notification message
            ];
    
            // Notification heading
            $headings = [
                'en' => 'Booking Successful', // Notification title
            ];
    
            // Data to be sent with the notification
            $data = [
                'order_id' => $id, // Custom data (order ID)
                'key' => 'Booking', // Custom key
            ];
    
            // Prepare payload for OneSignal API
            $fields = [
                'app_id' => '079a2107-0b13-4687-b48e-7e4a9d9b50c4', // Replace with your OneSignal App ID
                'include_player_ids' => $playerIds,  // Player IDs (Android tokens in this case)
                'contents' => $content,
                'headings' => $headings,
                'data' => $data, // Additional data for the app
                'android_sound' => 'default', // Android-specific sound
                'priority' => 10,             // High priority notification
            ];
    
            // Send notification via OneSignal API
            $url = 'https://onesignal.com/api/v1/notifications';
            $headers = [
                'Authorization: Basic OTk4YzMwNGEtNDNkYi00NDE3LTg4NTItNWE4NTAwMzAyOTgz', // OneSignal REST API Key
                'Content-Type: application/json',
            ];
    
            $json = json_encode($fields);
    
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);
    
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
    
                curl_close($ch);
                $response = json_decode($result, true);
            } catch (\Exception $e) {
                return 0;
            }
    
            // Check if the notification was sent successfully
            if (isset($response) && isset($response['recipients']) && $response['recipients'] > 0) {
                return 1; // Success
            } else {
                return 0; // Failure
            }
        }
    
        return 0;
    }
    public function send_notification_order_ios($key, $user_id, $msg, $id)
    {
        // Fetch user tokens from the database (type 2 represents iOS tokens in this case)
        $getuser = Token::where("type", 2)->where('user_id', $user_id)->get();
    
        if (count($getuser) != 0) {
            $reg_ids = array();
            foreach ($getuser as $gt) {
                $reg_ids[] = $gt->token;
            }
    
            // OneSignal requires player IDs instead of FCM registration IDs
            $playerIds = $reg_ids;
    
            // Notification content
            $content = [
                'en' => $msg, // Notification message
            ];
    
            // Notification heading
            $headings = [
                'en' => 'Booking Successful', // Notification title
            ];
    
            // Data to be sent with the notification
            $data = [
                'order_id' => $id, // Custom data (order ID)
                'key' => 'Booking', // Custom key
            ];
    
            // Prepare payload for OneSignal API
            $fields = [
                'app_id' => '079a2107-0b13-4687-b48e-7e4a9d9b50c4', // Replace with your OneSignal App ID
                'include_player_ids' => $playerIds,  // Player IDs (iOS tokens in this case)
                'contents' => $content,
                'headings' => $headings,
                'data' => $data, // Additional data for the app
                'ios_sound' => 'default', // iOS-specific sound
                'priority' => 10,         // High priority notification
            ];
    
            // Send notification via OneSignal API
            $url = 'https://onesignal.com/api/v1/notifications';
            $headers = [
                'Authorization: Basic OTk4YzMwNGEtNDNkYi00NDE3LTg4NTItNWE4NTAwMzAyOTgz', // OneSignal REST API Key
                'Content-Type: application/json',
            ];
    
            $json = json_encode($fields);
    
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);
    
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
    
                curl_close($ch);
                $response = json_decode($result, true);
            } catch (\Exception $e) {
                return 0;
            }
    
            // Check if the notification was sent successfully
            if (isset($response) && isset($response['recipients']) && $response['recipients'] > 0) {
                return 1; // Success
            } else {
                return 0; // Failure
            }
        }
    
        return 0;
    }

    public function edit_profile(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required",
            'name.required' => "name is required",
            'email.required' => "email is required",
            'phone.required' => "phone is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $update = User::find($request->get("id"));
            if ($update) {
                $getemail = User::where("email", $request->get("email"))->where("id", "!=", $request->get("id"))->where("user_type", 2)->first();
                if (empty($getemail)) {
                    $update->email = $request->get("email");
                    $update->name = $request->get("name");
                    $update->phone = $request->get("phone");
                    if ($request->file("image")) {

                        $file = $request->file('image');
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension() ?: 'png';
                        $folderName = Storage_path("app/public/profile/");
                        $picture = rand() . time() . '.' . $extension;
                        //$picture = str_random(10).time().'.'.$extension;
                        //$destinationPath = public_path() . $folderName;
                        $request->file('image')->move($folderName, $picture);
                        $image_path = Storage_path() . "/app/public/profile/" . $update->profile_pic;
                        if (file_exists($image_path) && $update->image != "") {
                            try {
                                unlink($image_path);
                            } catch (Exception $e) {

                            }
                        }
                        $update->profile_pic = $picture;
                    }
                    $update->save();
                    $update->profile_pic = asset("storage/app/public/profile") . '/' . $update->profile_pic;
                    $response['status'] = "1";
                    $response['msg'] = "Profile Update Successfully";
                    $response['data'] = $update;
                } else {
                    $response['status'] = "0";
                    $response['msg'] = "Email Already Exist";
                }

            } else {
                $response['status'] = "0";
                $response['msg'] = "Profile Not Found";
            }


        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function add_review(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'type' => 'required',
            'type_id' => 'required',
            'ratting' => 'required',
            'description' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'type.required' => "type is required",
            'type_id.required' => "type_id is required",
            'ratting.required' => "ratting is required",
            'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = new Review();
            $data->user_id = $request->get("user_id");
            $data->type = $request->get("type");
            $data->type_id = $request->get("type_id");
            $data->ratting = $request->get("rating");
            $data->description = $request->get("description");
            $data->date = $this->getsitedate();
            $data->save();
            $response['status'] = "1";
            $response['msg'] = "Review Add Successfully";
            $response['data'] = $data;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function add_feedback(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'order_id' => 'required',
            'ratting' => 'required',
            'description' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'order_id.required' => "order_id is required",
            'ratting.required' => "ratting is required",
            'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = new Feedback();
            $data->user_id = $request->get("user_id");
            $data->order_id = $request->get("order_id");
            $data->ratting = $request->get("ratting");
            $data->description = $request->get("description");
            $data->date = $this->getsitedate();
            $data->save();
            $response['status'] = "1";
            $response['msg'] = "Feedback Save Successfully";
            $response['data'] = $data;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function update_cart(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'member_id' => 'required',
            'type_id' => 'required',
            'type' => 'required',
            'parameter' => 'required',
            'action' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'member_id.required' => "member_id is required",
            'type_id.required' => "type_id is required",
            'type.required' => "type is required",
            'parameter.required' => "parameter is required",
            'action.required' => "action is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->get("action") == 0) {
                $ls = explode(",", $request->get("member_id"));
                foreach ($ls as $l) {
                    $data = new CartMember();
                    $data->user_id = $request->get("user_id");
                    $data->family_member_id = $l;
                    $data->type_id = $request->get("type_id");
                    $data->type = $request->get("type");
                    $data->parameter = $request->get("parameter");
                    $data->save();
                }

                $response['status'] = "1";
                $response['msg'] = "CartMember Save Successfully";
            } else { // delete
                if($request->get("cart_id")){
                    CartMember::where('id',$request->get("cart_id"))->delete();
                }
               
                $response['status'] = "1";
                $response['msg'] = "Cart Delete Successfully";
            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_cart(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = DB::table('cart_member')
                ->select('cart_member.family_member_id')
                ->join('family_member', 'family_member.id', '=', 'cart_member.family_member_id')
                ->where("cart_member.user_id", $request->get("user_id"))
                ->groupBy('cart_member.family_member_id')
                ->get();
            $getdefaultaddress = array();

            $setting = Setting::find(1);
            $getdefaultaddress = UserAddress::where("is_default", '1')->where('user_id', $request->get("user_id"))->first();
            if (empty($getdefaultaddress)) {
                $getdefaultaddress = array();
            }
            if (count($data) > 0) {
                $ls = array();
                foreach ($data as $g) {
                    $arr = array();
                    $getfamilyinfo = FamilyMember::find($g->family_member_id);
                    
                    $arr['member_id'] = $g->family_member_id;
                    $arr['member_name'] = isset($getfamilyinfo->name) ? $getfamilyinfo->name : '';
                    $arr['relation'] = isset($getfamilyinfo->relation) ? $getfamilyinfo->relation : '';
                    $arr['gender'] = isset($getfamilyinfo->gender) ? $getfamilyinfo->gender : '';
                    $arr['age'] = isset($getfamilyinfo->age) ? $getfamilyinfo->age : '';
                    $getcartinfo = CartMember::where("user_id", $request->get("user_id"))->where("family_member_id", $g->family_member_id)->get();
                    foreach ($getcartinfo as $g) {
                        $mrp=0;
                        $b = array();
                        if ($g->type == 1) {
                            $item_data = Package::find($g->type_id);
                            $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                                foreach ($find_pa as $d) {
                                
                                    if ($d->type == 1) {
                                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                                    }
                                    if ($d->type == 2) {
                                        $a = Profiles::find($d->type_id);
                                        if ($a) {
                                            $alr = explode(",", $a->no_of_parameter);
                                            foreach ($alr as $l) {
                                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                                            }
                                        }
                                    }
                                }
                            $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                            
                        } else if ($g->type == 2) {
                            $item_data = Parameter::find($g->type_id);
                            $mrp +=$item_data->mrp;
                            $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                            $mrpg = $item_data->mrp;
                            $price = $item_data->price;
                            $item_data->mrp = (int)$price;
                            $item_data->price = $mrpg;
                        } else {
                            $item_data = Profiles::find($g->type_id);
                            
                            if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                                $item_data->name = $item_data->profile_name;
                            }
                            $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                        }
                        $b['discount'] = $dis_pa;
                        $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                        $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
                        $b['price'] = $mrp;
                        $b['parameter'] = $g->parameter;
                        $b['type'] = $g->type;
                        $b['type_id'] = $g->type_id;
                        $b['cart_id'] = $g->id;
                        $arr['testdata'][] = $b;
                        
                    }
                    $ls[] = $arr;
                }

                $getdefaultaddress = UserAddress::where("is_default", '1')->where('user_id', $request->get("user_id"))->first();

                $response['status'] = '1';
                $response['msg'] = "Cart Data";
                $response['data'] = array("cart" => $ls, "txt" => $setting->txt_charge, "default_address" => $getdefaultaddress);
            } else {
                $response['status'] = '0';
                $response['msg'] = "Cart is empty";
                $response['data'] = array("cart" => array(), "txt" => $setting->txt_charge, "default_address" => $getdefaultaddress);
            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_cart_v2(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'city' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $defaultcityID = $this->getdefaultcityid($request->get("city"));
            $data = DB::table('cart_member')
                ->select('cart_member.family_member_id')
                ->join('family_member', 'family_member.id', '=', 'cart_member.family_member_id')
                ->where("cart_member.user_id", $request->get("user_id"))
                ->groupBy('cart_member.family_member_id')
                ->get();
            $getdefaultaddress = array();

            $setting = Setting::find(1);
            $getdefaultaddress = UserAddress::where("is_default", '1')->where('user_id', $request->get("user_id"))->first();
            if (empty($getdefaultaddress)) {
                $getdefaultaddress = array();
            }
            if (count($data) > 0) {
                $ls = array();
                foreach ($data as $g) {
                    $arr = array();
                    $getfamilyinfo = FamilyMember::find($g->family_member_id);
                    
                    $arr['member_id'] = $g->family_member_id;
                    $arr['member_name'] = isset($getfamilyinfo->name) ? $getfamilyinfo->name : '';
                    $arr['relation'] = isset($getfamilyinfo->relation) ? $getfamilyinfo->relation : '';
                    $arr['gender'] = isset($getfamilyinfo->gender) ? $getfamilyinfo->gender : '';
                    $arr['age'] = isset($getfamilyinfo->age) ? $getfamilyinfo->age : '';
                    $arr['testdata']    = []; // always init
                    $getcartinfo = CartMember::where("user_id", $request->get("user_id"))->where("family_member_id", $g->family_member_id)->get();
                    foreach ($getcartinfo as $g) {
                        $mrp=0;
                        $b = array();
                        if ($g->type == 1) {
                            $item_data = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                                            ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                                            ->select('packages.*','package_branch.mrp','package_branch.price')->find($g->type_id);
                            if($item_data){
                                $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                                foreach ($find_pa as $d) {
                                
                                    if ($d->type == 1) {
                                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                                    }
                                    if ($d->type == 2) {
                                        $a = Profiles::find($d->type_id);
                                        if ($a) {
                                            $alr = explode(",", $a->no_of_parameter);
                                            foreach ($alr as $l) {
                                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                                            }
                                        }
                                    }
                                }
                                $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                            }
                            
                            
                        } else if ($g->type == 2) {
                            $item_data = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                            ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                            ->whereNull('parameters.deleted_at')
                                            ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')->find($g->type_id);
                            if($item_data){
                                $mrp +=$item_data->mrp;
                                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp); 
                            }
                            
                         
                        } else {
                            $item_data = Profiles::join('profile_branch', 'profiles.id', '=', 'profile_branch.profile_id')
                                        ->select('profiles.*','profile_branch.mrp','profile_branch.price')
                                        ->whereIn('profile_branch.branch_id', [$defaultcityID])->find($g->type_id);
                            
                            if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                                $item_data->name = $item_data->profile_name;
                                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                            }
                            
                        }
                        if($item_data){
                            $b['discount'] = $dis_pa;
                            $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                            $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
                            $b['price'] = isset($item_data->price) ? $item_data->price : '';
                            $b['parameter'] = $g->parameter;
                            $b['type'] = $g->type;
                            $b['type_id'] = $g->type_id;
                            $b['cart_id'] = $g->id;
                            $arr['testdata'][] = $b;
                        }
                        
                    }
                    if (count($arr['testdata']) > 0) {
                        $ls[] = $arr;
                    }
                }

                $getdefaultaddress = UserAddress::where("is_default", '1')->where('user_id', $request->get("user_id"))->first();

                $response['status'] = '1';
                $response['msg'] = "Cart Data";
                $response['data'] = array("cart" => $ls, "txt" => $setting->txt_charge, "default_address" => $getdefaultaddress);
            } else {
                $response['status'] = '0';
                $response['msg'] = "Cart is empty";
                $response['data'] = array("cart" => array(), "txt" => $setting->txt_charge, "default_address" => $getdefaultaddress);
            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function book_detail(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'order_id' => 'required'
        ];

        $messages = array(
            'order_id.required' => "order_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $get_order = Orders::with("useraddressdetails", "partiallyreports", "sampleboyDetails")->find($request->get("order_id"));
            if ($get_order) {
                $get_order->phone = User::find($get_order->user_id) ? User::find($get_order->user_id)->phone : '';
                $data = DB::table('orders_data')
                    ->select('orders_data.family_member_id')
                    ->join('family_member', 'family_member.id', '=', 'orders_data.family_member_id')
                    ->where("orders_data.order_id", $request->get("order_id"))
                    ->groupBy('orders_data.family_member_id')
                    ->get();
                $ls = array();
                foreach ($data as $g) {
                    $arr = array();
                    $getfamilyinfo = FamilyMember::find($g->family_member_id);
                    $arr['member_id'] = $g->family_member_id;
                    $arr['member_name'] = isset($getfamilyinfo->name) ? $getfamilyinfo->name : "";
                    $arr['relation'] = isset($getfamilyinfo->relation) ? $getfamilyinfo->relation : '';
                    $arr['gender'] = isset($getfamilyinfo->gender) ? $getfamilyinfo->gender : '';
                    $arr['age'] = isset($getfamilyinfo->age) ? $getfamilyinfo->age : '';
                    $getcartinfo = OrdersData::where("order_id", $request->get("order_id"))->where("family_member_id", $g->family_member_id)->get();
                   
                    foreach ($getcartinfo as $g) {
                        $mrp=0;
                        $b = array();
                        if ($g->type == 1) {
                            $item_data = Package::find($g->item_id);
                            $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                            foreach ($find_pa as $d) {
                            
                                if ($d->type == 1) {
                                    $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                                }
                                if ($d->type == 2) {
                                    $a = Profiles::find($d->type_id);
                                    if ($a) {
                                        $alr = explode(",", $a->no_of_parameter);
                                        
                                    }
                                }
                            }
                            $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                        } else if ($g->type == 2) {
                            $item_data = Parameter::find($g->item_id);
                            $mrp +=$item_data->mrp;
                            $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                         
                        } else {
                            $item_data = Profiles::find($g->item_id);
                            if ($item_data) {
                                $item_data->name = $item_data->profile_name;
                            }
                            if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    
                            }
                            $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                        }     
                        $get_order['discount'] = $dis_pa;
                        $b['discount'] = $dis_pa;
                        $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                        $b['mrp'] = $g->price;
                        $b['price'] = $g->mrp;
                        $b['parameter'] = $g->parameter;
                        $b['type'] = $g->type;
                        $b['type_id'] = $g->item_id;
                        $arr['testdata'][] = $b;
                    }
                    $ls[] = $arr;
                }
                    
                $get_order->orderdata = $ls;
                $response['status'] = '1';
                $response['msg'] = "Order Detail Get Successfully";
                $response['data'] = $get_order;
            } else {
                $response['status'] = '0';
                $response['msg'] = "Order Not Found";
            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    public function get_city(Request $request)
    {
        $userLat = $request->lat;
        $userLng = $request->lng;
    
        if (!empty($userLat) && !empty($userLng)) {
            $query = DB::table('city')
                ->select(
                    'city.*', // Select all city columns
                    DB::raw("(6371 * acos(cos(radians($userLat)) * cos(radians(city.lat)) * cos(radians(city.lng) - radians($userLng)) + sin(radians($userLat)) * sin(radians(city.lat)))) AS distance")
                )
                ->where('default', '=', 'Yes');
                $query->orderByRaw("(CASE WHEN city.status = 1 THEN 0 ELSE 1 END), distance ASC");
                $city_data = $query->get();
        } else {
            $city_data = DB::table('city')
                ->select('city.*') // Select all city columns
                ->where('default', '=', 'Yes')
                ->orderBy('status', 'desc')
                ->get();
        }
        if ($city_data->count() > 0) {
            foreach ($city_data as &$city) {
                if ($city->status == 0 && strpos($city->name, '(upcoming)') === false) {
                    $city->city .= ' (Coming soon)';
                }
            
                $phone = User::where('user_type', 2)
                    ->where('city', $city->id)
                    ->value('phone');
            
                $city->phone = $phone ? (int)$phone : '';
            }
            $response = array(
                "status" => 1,
                "msg" => "Get City List",
                "data" => $city_data
            );
        } else {
            $response = array(
                "status" => 0,
                "msg" => "No Data Found",
            );
        }
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_city_test(Request $request)
    {
        $city_data = DB::table('city')->orderBy("city.id", 'DESC')->get();


        if (count($city_data) > 0) {
            $response = array(
                "status" => 1,
                "msg" => "Get City List",
                "data" => $city_data
            );
        } else {
            $response = array(
                "status" => 0,
                "msg" => "No Data Found",
            );
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    
    public function get_lab(Request $request)
    {
        $userLat = $request->lat ?? 26.9124;
        $userLng = $request->lng ?? 75.7873;
        $userCityId = $request->slug ?? 1;

        $perPage = $request->input('per_page', 10);

        $city_data = User::with('location')
            ->join('city', 'users.city', '=', 'city.id')
            ->select('users.*', 'city.lat', 'city.lng', DB::raw("(6371 * acos(cos(radians($userLat)) * cos(radians(city.lat)) * cos(radians(city.lng) - radians($userLng)) + sin(radians($userLat)) * sin(radians(city.lat)))) AS distance"))
            ->where('users.user_type', 2)
            // ->where('city.id',$userCityId)
            ->when($request->slug, function ($query, $userCityId) {
            return $query->where('city.city', $userCityId);
                })
            ->orderBy('distance')
            ->paginate($perPage);


        if (count($city_data) > 0) {
            $response = array(
                "status" => 1,
                "msg" => "Get Lab List",
                "data" => $city_data
            );
        } else {
            $response = array(
                "status" => 0,
                "msg" => "No Labs Found",
                "data" => []
            );
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    
    public function get_test(Request $request)
    {
        //  Log::info('get test:-');
        // Log::info($request->all());
        $defaultcityID = $this->getdefaultcityid($request->city);
        $uniquePackages = Profiles::query()
                ->join('profile_branch as pb', 'pb.profile_id', '=', 'profiles.id')
                ->whereIn('pb.branch_id', [$defaultcityID])   
                ->whereNull('profiles.deleted_at')
                ->select('profiles.*','pb.mrp','pb.price')                        
                ->distinct('profiles.id')  
                ->get();

        $datatest = array();

        if ($uniquePackages) {
            $ls = array();
            foreach ($uniquePackages as $row) {
                $mrp=0;
                $arr = explode(",", $row->no_of_parameter);
                $i = 0;
                foreach ($arr as $a) {
                    if ($i <= 3) {
                        $ls[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                    }
                    $i++;
                    
                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                }
                $row->paramater_data = $ls;
                $ls = [];
                $dis_pa = $this->get_discount($row->id,'Profiles',$row->mrp);
                $row->discount = $dis_pa;
                
                $datatest[] = $row;
            }

        }

        $response = array(
            "status" => 1,
            "msg" => "Get Lab List",
            "data" => $datatest
        );
     

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_pera(Request $request)
    {
        $inputLatitude = $request->lat ?? 26.9124;
        $inputLongitude = $request->lng ?? 75.7873;
        $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
            ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
            ->get();
        $usersIds = $city->pluck('users.*.id')->flatten();

        $uniquePackages = collect();

        foreach ($usersIds as $branchId) {
            $data = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

            foreach ($data as $package) {
                $dis_pa = $this->get_discount($package->id,'Parameter',$package->mrp);
                $package->discount = $dis_pa;
                $uniquePackages->add($package);
            }
        }

        $datatest = $uniquePackages->unique('id');

        $datatest = array();

        if (count($datatest) > 0) {
            $response = array(
                "status" => 1,
                "msg" => "Get Parameters List",
                "data" => $datatest
            );
        } else {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
            $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
                ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
                ->get();
            $usersIds = $city->pluck('users.*.id')->flatten();
            $uniquePackages = collect();

            foreach ($usersIds as $branchId) {
                $data = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

                foreach ($data as $package) {
                    $dis_pa = $this->get_discount($package->id,'Parameter',$package->mrp);
                    $package->discount = $dis_pa;
                    $uniquePackages->add($package);
                }
            }

            $datatest = $uniquePackages->unique('id');

            $response = array(
                "status" => 1,
                "msg" => "Get Parameters List",
                "data" => $datatest
            );
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_package(Request $request)
    {
        $inputLatitude = $request->lat ?? 26.9124;
        $inputLongitude = $request->lng ?? 75.7873;
        
        $defaultcityID = $this->getdefaultcityid($request->city);

        $branchId = $defaultcityID;

        // check karo selected city me data hai ya nahi
        $branchExists = DB::table('package_branch')
            ->where('branch_id', $branchId)
            ->exists();
        
        // agar nahi hai → fallback branch use karo
        if (!$branchExists) {
            $branchId = DB::table('package_branch')->value('branch_id');
        }
        
        // final query
        $uniquePackages = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
            ->where('package_branch.branch_id', $branchId)
            ->whereNull('packages.deleted_at')
            ->select('packages.*','package_branch.mrp','package_branch.price')
            ->distinct()
            ->get();

        $datatest = array();
        foreach ($uniquePackages as $package) {
            $find_pa = TestDetails::where("package_id", $package->id)->get();
            $parameter = 0;
            $mrp=0;
            $ls1 = array();
            foreach ($find_pa as $d) {
                if ($d->type == 1) {
                    $a = array();
                    $a['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                    $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                    $a['id'] = (int) $d->type_id;
                    $a['type'] = '2';
                    $a['parameter'] = array();
                    $parameter = $parameter + 1;
                    $ls1[] = $a;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->type_id);
                    if ($a) {
                        $a1 = array();
                        $a1['name'] = $a->profile_name;
                        $a1['id'] = $d->type_id;
                        $a1['type'] = '3';
                        $k = array();
                        $arr = explode(",", $a->no_of_parameter);
                        foreach ($arr as $l) {
                            $c = array();
                            $c['name'] = Parameter::find($l) ? Parameter::find($l)->name : '';
                            $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                            $c['id'] = (int) $l;
                            $k[] = $c;
                        }
                        $a1['parameter'] = $k;
                        $ls1[] = $a1;
                        $parameter = $parameter + count($arr);
                    }
                }
            }
            $package->no_of_parameter = $parameter;
            $package->parameter_list = $ls1;
            $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '1')->get();
            $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '1')->where("type_id", $package->id)->get();

            foreach ($package->review as $r) {
                $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
            }

            $total = 100 * ($package->mrp - $package->price) / $package->mrp;
            
            
            $dis_pa = $this->get_discount($package->id,'Package',$package->mrp);
            $package->discount = $dis_pa;

            $package->totalreview = count(Review::with('userdata')->where("type", '1')->where("type_id", $package->id)->get());
            $package->avgreview = (string) Review::where("type", '1')->where("type_id", $package->id)->avg('ratting');

            $datatest[] = $package; // Add the modified package to the data array
        }

        $response = array(
            "status" => 1,
            "msg" => "Get Package List",
            "data" => $datatest
        );

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function book_filter(Request $request)
    {

        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'type' => 'required',
            'status' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'type.required' => "type is required",
            'status.required' => "status is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            //echo $this->getsitedateonly();exit;
            if ($request->get("type") == 1) { //past
                if ($request->get("status") == 2) { //pending
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", "<", date('Y-m-d'))->wherein("status", [1, 2, 5, 6])->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 3) { //complete
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", "<", date('Y-m-d'))->where("status", 7)->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 4) { //reject
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", "<", date('Y-m-d'))->wherein("status", [3, 4])->orderBy('id', 'DESC')->paginate(10);
                } else { //all
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", "<", date('Y-m-d'))->orderBy('id', 'DESC')->paginate(10);
                }

            } else if ($request->get("type") == 2) { //upcoming
                if ($request->get("status") == 2) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", ">", date('Y-m-d'))->wherein("status", [1, 2, 5, 6])->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 3) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", ">", date('Y-m-d'))->where("status", 7)->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 4) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", ">", date('Y-m-d'))->wherein("status", [3, 4])->orderBy('id', 'DESC')->paginate(10);
                } else {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", ">", date('Y-m-d'))->orderBy('id', 'DESC')->paginate(10);
                }

            } else if ($request->get("type") == 3) { //today
                if ($request->get("status") == 2) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", date('Y-m-d'))->wherein("status", [1, 2, 5, 6])->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 3) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", date('Y-m-d'))->where("status", 7)->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 4) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", date('Y-m-d'))->wherein("status", [3, 4])->orderBy('id', 'DESC')->paginate(10);
                } else {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->whereDate("date", date('Y-m-d'))->orderBy('id', 'DESC')->paginate(10);
                }

            }else { //all
                if ($request->get("status") == 2) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->wherein("status", [1, 2, 5, 6])->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 3) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->where("status", 7)->orderBy('id', 'DESC')->paginate(10);
                } else if ($request->get("status") == 4) {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->wherein("status", [3, 4])->orderBy('id', 'DESC')->paginate(10);
                } else {
                    $data = Orders::with("sampleboyDetails")->select('id', 'payment_method', 'date', 'time', 'final_total', 'status', 'sample_collection_boy_id')->where("user_id", $request->get("user_id"))->orderBy('id', 'DESC')->paginate(10);
                }
            }
            

            if ($data) {
                $response['status'] = '1';
                $response['msg'] = "Order List Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = '0';
                $response['msg'] = "Data Not Found";
            }



        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_lab_test_package(Request $request)
    {
        $branchId = $request->lab_id; // Branch ID to filter by

        //--------------test package ------------------------------
        $profiles = Profiles::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->get();
        $parameters = [];
        foreach ($profiles as $profile) {
            $noOfParameters = explode(',', $profile->no_of_parameter);
            $parameters[$profile->id] = Parameter::whereIn('id', $noOfParameters)->get();
        }

        // Append the parameter data to each profile
        $profiles->each(function ($profile) use ($parameters) {
            $profile->parameters = $parameters[$profile->id];
        });

        //-----------------package---------------------------------------
        $packages = Package::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->get();
        // $parameters = [];



        foreach ($packages as $package) {
            $find_pa = TestDetails::where("package_id", $package->id)->get();
            $parameter = 0;
            $ls1 = array();
            foreach ($find_pa as $d) {
                if ($d->type == 1) {
                    $a = array();
                    $a['name'] = Parameter::find($d->package_id) ? Parameter::find($d->package_id)->name : '';
                    $a['id'] = $d->package_id;
                    $a['type'] = '2';
                    $a['parameter'] = array();
                    $parameter = $parameter + 1;
                    $ls1[] = $a;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->package_id);
                    if ($a) {
                        $a1 = array();
                        $a1['name'] = $a->profile_name;
                        $a1['id'] = (int) $d->package_id;
                        $a1['type'] = '3';
                        $k = array();
                        $arr = explode(",", $a->no_of_parameter);
                        foreach ($arr as $l) {
                            $c = array();
                            $c['name'] = Parameter::find($l) ? Parameter::find($l)->name : '';
                            $c['id'] = (int) $l;
                            $k[] = $c;
                        }
                        $a1['parameter'] = $k;
                        $ls1[] = $a1;
                        $parameter = $parameter + count($arr);
                    }
                }
            }
            $package->no_of_parameter = $parameter;
            $package->parameter_list = $ls1;
            $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '1')->get();
            $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '1')->where("type_id", $package->id)->get();
            foreach ($package->review as $r) {
                $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
            }

            $total = 100 * ($package->mrp - $package->price) / $package->mrp;
            $package->discount = number_format($total, '2', '.', '');

            $package->totalreview = count(Review::with('userdata')->where("type", '1')->where("type_id", $package->id)->get());
            $package->avgreview = (string) Review::where("type", '1')->where("type_id", $package->id)->avg('ratting');

        }

        $data['package'] = $packages;
        $data['test'] = $profiles;

        $response = array(
            "status" => 1,
            "msg" => "Get Lab test & package List",
            "data" => $data
        );
        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function get_test_package_lab_data(Request $request)
    {
        $product_type = $request->product_type;
        $product_id = $request->product_id;

        if ($product_type == 1) {
            $profiles = Profiles::find($product_id);
            $branchID = explode(',', $profile->branch_id);
            $users = User::with('location')->whereIn('id', $branchID)->get();

        } else {
            $Packages = Package::find($product_id);
            $branchID = explode(',', $Packages->branch_id);
            $users = User::with('location')->whereIn('id', $branchID)->get();


        }


        $response = array(
            "status" => 1,
            "msg" => "Get Lab & lat long list",
            "data" => $users
        );
        return json_encode($response, JSON_NUMERIC_CHECK);


    }
    
    public function sendOTP(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = ['phone' => 'required'];
    
        $messages = array(
            'phone.required' => "mobile number is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
    
            $checkmobile = User::withTrashed()->where("phone", $request->get("phone"))->first();
    
            if ($checkmobile) {
                if ($request->get("phone") == 8523697412 ) {
                    $otp = 1234;
                } else {
                    $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                }
                $otp = 1234;
                $checkmobile->otp = $otp;
                 if($checkmobile->deleted_at != null){
                     $checkmobile->deleted_at = null;
                }
                $checkmobile->save();
    
                $url = 'https://msg.smsguruonline.com/fe/api/v1/send';
                $username = '369healthdex.trans';
                $password = 'DBLD2';
                $from = 'HLTHDX';
                $to = $request->get("phone");
                $dltPrincipalEntityId = '1701176959781053032';
                $dltContentId = '1707176967358120748';
                $text = 'Your OTP for 369 HealthDex login is ' . $otp . ' Do not share this code with anyone. Team 369 HealthDex.';
    
                $params = [
                    'username' => $username,
                    'password' => $password,
                    'unicode' => false,
                    'from' => $from,
                    'to' => $to,
                    'dltPrincipalEntityId' => $dltPrincipalEntityId,
                    'dltContentId' => $dltContentId,
                    'text' => $text,
                ];
    
                $responseApi = Http::get($url, $params);
                log::info($responseApi);
    
                if ($responseApi->successful()) {
                    $response['status'] = "1";
                    $response['msg'] = "OTP Send Successfully";
                } else {
                    $response['status'] = "0";
                    $response['msg'] = "OTP not Send!";
                }
    
            } else {
                $response['status'] = "0";
                $response['msg'] = "mobile number Not Found";
    
            }
    
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    public function OTP_login(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
    
        $rules['phone'] = 'required';
        $messages = array(
            'phone.required' => "mobile number is required",
        );
    
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $user = User::where("phone", $request->get("phone"))
                ->whereIn("user_type", ['3','4'])
                ->first();
    
            if ($user) {
                $existingToken = Token::where("token", $request->get("token"))
                    ->where("user_id", $user->id)
                    ->first();
    
                if (!$existingToken) {
                    $store = new Token();
                    $store->token = $request->get("token");
                    $store->type = $request->get("token_type");
                    $store->user_id = $user->id;
                    $store->save();
                }
    
                $user->login_type = $request->get("login_type");
                $user->save();
    
                if ($user->profile_pic != "") {
                    $image = asset("storage/app/public/profile") . '/' . $user->profile_pic;
                } else {
                    $image = asset("public/upload/profile/profile.png");
                }
    
                $response['status'] = "1";
                $response['headers'] = array(
                    'Access-Control-Allow-Origin' => '*'
                );
                $response['msg'] = "Login Successfully";
                $response['register'] = array(
                    "user_id" => $user->id,
                    "name" => $user->name,
                    "phone" => $user->phone,
                    "email" => $user->email,
                    "profile_pic" => $image
                );
    
            } else {
                $response = array(
                    "status" => 0,
                    "msg" => "user not found"
                );
            }
        }
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    public function OTP_verify(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
    
        $rules['otp'] = 'required';
        $rules['phone'] = 'required';
        $rules['login_type'] = 'required';
    
        $messages = array(
            'phone.required' => "mobile number is required",
            'otp.required' => "OTP is required",
            'login_type.required' => "login_type is required",
        );
    
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $user = User::where("phone", $request->get("phone"))
                ->where("otp", $request->get("otp"))
                ->whereIn("user_type", ['3','4'])
                ->first();
    
            if ($user) {
                $existingToken = Token::where("token", $request->get("token"))
                    ->where("user_id", $user->id)
                    ->first();
    
                if (!$existingToken) {
                    $store = new Token();
                    $store->token = $request->get("token");
                    $store->type = $request->get("token_type");
                    $store->user_id = $user->id;
                    $store->save();
                }
    
                $user->login_type = $request->get("login_type");
                $user->save();
    
                if ($user->profile_pic != "") {
                    $image = asset("storage/app/public/profile") . '/' . $user->profile_pic;
                } else {
                    $image = asset("public/upload/profile/profile.png");
                }
    
                $response['status'] = "1";
                $response['headers'] = array(
                    'Access-Control-Allow-Origin' => '*'
                );
                $response['msg'] = "Login Successfully";
                $response['register'] = array(
                    "user_id" => $user->id,
                    "name" => $user->name,
                    "phone" => $user->phone,
                    "email" => $user->email,
                    "profile_pic" => $image
                );
    
            } else {
                $response = array(
                    "status" => 0,
                    "msg" => "invalid OTP!"
                );
            }
        }
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    public function coupon()
    {

        $Coupon = Coupon::where('available_for','user')->where('coupon_start_date', '<=', date('Y-m-d'))->where('coupon_end_date', '>=', date('Y-m-d'))->get();


        if (count($Coupon) > 0) {
            $response = array(
                "status" => 1,
                "msg" => "Available Coupon.",
                "data" => $Coupon
            );
        } else {

            $response = array(
                "status" => 0,
                "msg" => "No Data Found",
            );
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_offer()
    {

        $Coupon = Offer::all();


        if (count($Coupon) > 0) {
            $response = array(
                "status" => 1,
                'image_path' => "/storage/app/public/category/",
                "msg" => "Available Offer.",
                "data" => $Coupon
            );
        } else {

            $response = array(
                "status" => 0,
                "msg" => "No Data Found",
            );
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_user_wallet(Request $request)
    {
    $response = [
        "status" => 0,
        "msg" => "Validation error",
        "data" => null
    ];

    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
    ], [
        'user_id.required' => "User ID is required",
        'user_id.exists' => "User ID is invalid",
    ]);

    if ($validator->fails()) {
        $message = $validator->errors()->first();
        $response['msg'] = $message;
    } else {
        $user = User::find($request->input('user_id'));

        if ($user) {
            // Fetch the total wallet points used in booking payments for the user
            // $used_wallet_points = DB::table('orders')
            //     ->where('user_id', $user->id)
            //     ->sum('wallet_discount');
            // // Subtract the used wallet points from the user's current wallet amount
            // $available_wallet_amount = $user->wallet_amount - $used_wallet_points;
            
             $credit_walletpoints = Wallet::where('user_id', Auth::id())->where('expire_on', '>=', Carbon::now())->where('action', 1)->get();
        $credit_wallet_points = 0;
        
        foreach($credit_walletpoints as $k=>$v){
             $credit_wallet_points += $v->wallet_points;

       }
        $debit_walletpoints = Wallet::where('user_id', Auth::id())->where('action', 0)->get();
        $debit_wallet_points = 0;
        
        foreach($debit_walletpoints as $k=>$v){
             $debit_wallet_points += $v->wallet_points;

       }
       
        $wallet_points =  $credit_wallet_points - $debit_wallet_points;

            $response = [
                "status" => 1,
                "msg" => "Success",
                "data" => [
                     'wallet_amount' => $wallet_points
                ]
            ];
        } else {
            $response['msg'] = "User not found";
        }
    }

    return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
}
    public function getWalletSetting()
    {
        $walet = Setting::select('wallet_cashback_per', 'wallet_cashback_point')->first();
        $response = [
            "status" => 1,
            "msg" => "Success",
            "data" => $walet,
        ];
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
    public function banner()
    {
        $setting = Setting::select('main_banner', 'app_banner')->first();
        $imagePaths = unserialize($setting->main_banner);
        $imagePaths2 = unserialize($setting->app_banner);

        $response = [
            "status" => 1,
            "file_path" => "public",
            "msg" => "Success",
            "app_banner" => $imagePaths2,
            "main_banner" => $imagePaths,
        ];

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
    public function slots()
    {
        $timeslot = Timeslote::select('timeslot')->get();


        $response = [
            "status" => 1,
            "msg" => "Success",
            "data" => $timeslot,
        ];

        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
    public function homevisit(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );

        $rules['user_id'] = 'required';
        $rules['user_name'] = 'required';
        $rules['user_number'] = 'required';
        $rules['user_email'] = 'required';
        $rules['city_id'] = 'required';
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['state'] = 'required';
        $rules['pincode'] = 'required';
        $rules['lab_id'] = 'required';


        $messages = array(
            'user_id.required' => "user ID is required",
            'user_number.required' => "mobile number is required",
            'user_name.required' => "name is required",
            'user_email.required' => "email is required",
            'city_id.required' => "city_id is required",
            'lat.required' => "lat is required",
            'lng.required' => "lng is required",
            'state.required' => "state is required",
            'pincode.required' => "pincode is required",
            'lab_id.required' => "lab_id is required",

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = new Homevisit();
            // if(isset($request->lab_id) && $request->lab_id != ''){
            //     $data->lab_id = $request->lab_id;
            // }
            $data->user_id = $request->get("user_id");
            $data->user_name = $request->get("user_name");
            $data->user_number = $request->get("user_number");
            $data->user_email = $request->get("user_email");
            $data->city_id = $request->get("city_id");
            $data->lat = $request->get("lat");
            $data->lng = $request->get("lng");
            $data->state = $request->get("state");
            $data->pincode = $request->get("pincode");
            $data->lab_id = $request->get("lab_id");
            $data->save();
            if ($data) {
                $response['status'] = "1";
                $response['msg'] = "Home visit Request send Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = "Something went wrong! try again.";
            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function homeget(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );

        $rules['user_id'] = 'required';

        $messages = array(
            'user_id.required' => "user ID is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $Coupon = Homevisit::with('citydata', 'lab')->where('user_id', $request->get("user_id"))->get();

            if (count($Coupon) > 0) {
                $response = array(
                    "status" => 1,
                    "msg" => "Get Home visit successfully.",
                    "data" => $Coupon
                );
            } else {

                $response = array(
                    "status" => 0,
                    "msg" => "No Data Found",
                );
            }

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function upload_prescription(Request $request)
    {

        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            //  'prescription' => 'required|mimes:pdf,png,jpg,jpeg',
            'd_o_b' => 'required',
            'number' => 'required',

        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'name.required' => "name is required",
            'email.required' => "email is required",
            'gender.required' => "gender is required",
            'd_o_b.required' => "date of birth is required",
            'prescription.required' => "prescription is required",
            'prescription.mimes' => "invalid prescription format",
            'location_id.required' => "location is required",
            'number.required' => "number is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = new Userprescription();

            if ($request->file("prescription")) {

                $file = $request->file('prescription');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = Storage_path("app/public/profile/");
                $picture = rand() . time() . '.' . $extension;
                $request->file('prescription')->move($folderName, $picture);

                $data->prescription = $picture;
            }
            if(isset($request->lab_id) && $request->lab_id != ''){
                $data->lab_id = $request->lab_id;
            }
            $data->user_id = $request->user_id;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->gender = $request->gender;
            $data->d_o_b = $request->d_o_b;
            $data->number = $request->number;
            $data->is_agree = $request->is_agree;
            $data->location_id = $request->location_id;
            $data->save();
            $response['status'] = "1";
            $response['msg'] = "Prescription Upload Successfully";
            $response['data'] = $data;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function request_callback(Request $request)
    {

        $response = array(
            "status" => "0",
            // "msg" => "Validation error"
        );
        $rules = [
            'number' => 'required',
            'name' => 'required',
            // 'message' => 'required',


        ];

        $messages = array(
            'name.required' => "name is required",
            // 'message.required' => "message is required",
            'number.required' => "number is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = new Callback();

            $data->name = $request->name;
            $data->number = $request->number;
            $data->message = $request->message;
            $data->save();
            $response['status'] = "1";
            $response['msg'] = "Request Call back send Successfully";
            $response['data'] = $data;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_prescription(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',

        ];

        $messages = array(
            'user_id.required' => "user_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $Coupon = Userprescription::with('location')->where('user_id', $request->user_id)->get();

            if (count($Coupon) > 0) {
                $response = array(
                    "status" => 1,
                    'image_path' => "/storage/app/public/profile/",
                    "msg" => "Get Prescription Successfully",
                    "data" => $Coupon
                );
            } else {

                $response = array(
                    "status" => 0,
                    "msg" => "No Data Found",
                );
            }
        }

        return json_encode($response, JSON_NUMERIC_CHECK);

    }
    public function search_suggestion()
    {
        $names1 = Package::whereNull('deleted_at')->pluck('name')->toArray();
        $names2 = Profiles::whereNull('deleted_at')->pluck('profile_name')->toArray();
        $names3 = Parameter::whereNull('deleted_at')->pluck('name')->toArray();

        $allNames = array_merge($names1, $names2, $names3);

        if (empty($allNames)) {
            $response['status'] = "0";
            $response['msg'] = "oops! no data found";
        } else {
            $response['status'] = "1";
            $response['msg'] = "Data found";
            $response['data'] = $allNames;
        }

        return $response;
    }
    public function search_suggestion_v2(Request $request)
    {
        $defaultcityID = $this->getdefaultcityid($request->city);
        $names1 = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                            ->whereIn('package_branch.branch_id', [$defaultcityID])
                            ->whereNull('deleted_at')->pluck('name')->toArray();
        $names2 = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                            ->whereIn('pb.branch_id', [$defaultcityID])->whereNull('profiles.deleted_at')
                            ->whereNull('deleted_at')->pluck('profile_name')->toArray();
        $names3 = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                            ->whereIn('parameter_branch.branch_id', [$defaultcityID])->whereNull('deleted_at')->pluck('name')->toArray();

        $allNames = array_merge($names1, $names2, $names3);

        if (empty($allNames)) {
            $response['status'] = "0";
            $response['msg'] = "oops! no data found";
        } else {
            $response['status'] = "1";
            $response['msg'] = "Data found";
            $response['data'] = $allNames;
        }

        return $response;
    }
    public function search(Request $request)
    {
       
        // log::info($request->all());
        $defaultcityID = $this->getdefaultcityid($request->city);
        // log::info("defaultcityID :- $defaultcityID");
        $tags = $request->get("tags");
        $data1 = Package::select('packages.id')->join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                        ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')->Where('packages.name', $tags)->first();
        if ($data1) {
            $result = $this->package_detail_search($data1->id,$defaultcityID);
            return $result;
        }
        $data2 = Profiles::select('profiles.id')->join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                            ->whereIn('pb.branch_id', [$defaultcityID])->whereNull('profiles.deleted_at')->Where('profiles.profile_name', $tags)->first();
        if ($data2) {
            $result = $this->profile_detail_search($data2->id,$defaultcityID);
            return $result;
        }
        $data21 = Profiles::select('profiles.id')->join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                            ->whereIn('pb.branch_id', [$defaultcityID])->whereNull('deleted_at')->Where('profiles.test_short_code', $tags)->first();
        if ($data21) {

            $result = $this->profile_detail_search($data21->id,$defaultcityID);
            return $result;
        }
        $data3 = Parameter::select('parameters.id')->join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                ->whereIn('parameter_branch.branch_id', [$defaultcityID])->whereNull('parameters.deleted_at')->Where('parameters.name', $tags)->first();
        if ($data3) {
            $result = $this->parameter_detail_search($data3->id,$defaultcityID);
            return $result;
        }
        $data31 = Parameter::select('parameters.id')->join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                ->whereIn('parameter_branch.branch_id', [$defaultcityID])->whereNull('parameters.deleted_at')->Where('parameters.test_short_code', $tags)->first();
        if ($data31) {
            $result = $this->parameter_detail_search($data31->id,$defaultcityID);
            return $result;
        }
        $response['status'] = "0";
        $response['msg'] = "oops! no data found";
        return $response;
    }
    public function parameter_detail_search($id,$defaultcityID)
    {

        $package = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                    ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                    ->whereNull('parameters.deleted_at')
                                    ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')->find($id);
        if ($package) {
            $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '3')->get();
            $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '3')->where("type_id", $package->id)->get();
            foreach ($package->review as $r) {
                $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
            }
            $total = 100 * ($package->mrp - $package->price) / $package->mrp;
            $dis_pa = $this->get_discount($package->id,'Parameter',$package->mrp);
            $package->discount =$dis_pa;
            $package->totalreview = count(Review::with('userdata')->where("type", '3')->where("type_id", $package->id)->get());
            $package->avgreview = Review::where("type", '3')->where("type_id", $package->id)->avg('ratting');
            $response['status'] = "1";
            $response['page'] = "parameter";
            $response['msg'] = "Parameter Detail Get Successfully";
            $response['data'] = $package;
        } else {
            $response['status'] = "0";
            $response['msg'] = "Parameter Not Found";

        }

        return $response;
    }

    public function package_detail_search($id,$defaultcityID)
    {

        $package = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                           ->whereIn('package_branch.branch_id', [$defaultcityID])
                           ->select('packages.*','package_branch.mrp','package_branch.price')->find($id);

        if ($package) {
            $find_pa = TestDetails::where("package_id", $package->id)->get();
            $parameter = 0;
            $ls1 = array();
            foreach ($find_pa as $d) {
                if ($d->type == 1) {
                    $a = array();
                    $a['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                    $a['id'] = (int) $d->type_id;
                    $a['type'] = '2';
                    $a['parameter'] = array();
                    $parameter = $parameter + 1;
                    $ls1[] = $a;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->type_id);
                    if ($a) {
                        $a1 = array();
                        $a1['name'] = $a->profile_name;
                        $a1['id'] = (int) $d->type_id;
                        $a1['type'] = '3';
                        $k = array();
                        $arr = explode(",", $a->no_of_parameter);
                        foreach ($arr as $l) {
                            $c = array();
                            $c['name'] = Parameter::find($l) ? Parameter::find($l)->name : '';
                            $c['id'] = (int) $l;
                            $k[] = $c;
                        }
                        $a1['parameter'] = $k;
                        $ls1[] = $a1;
                        $parameter = $parameter + count($arr);
                    }
                }
            }
            $package->no_of_parameter = $parameter;
            $package->parameter_list = $ls1;
            $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '1')->get();
            $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '1')->where("type_id", $package->id)->get();
            foreach ($package->review as $r) {
                $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
            }
            $total = 100 * ($package->mrp - $package->price) / $package->mrp;
            $dis_pa = $this->get_discount($package->id,'Package',$package->mrp);
            $package->discount =$dis_pa;
            $package->totalreview = count(Review::with('userdata')->where("type", '1')->where("type_id", $package->id)->get());
            $package->avgreview = (string) Review::where("type", '1')->where("type_id", $package->id)->avg('ratting');
            $response['status'] = "1";
            $response['page'] = 'package';
            $response['msg'] = "Package Detail Get Successfully";
            $response['data'] = $package;
        } else {
            $response['status'] = "0";
            $response['msg'] = "Package Not Found";

        }

        return $response;
    }
    public function profile_detail_search($id,$defaultcityID)
    {
        $package = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                                    ->whereIn('pb.branch_id', [$defaultcityID])
                                    ->select('profiles.*','pb.mrp','pb.price')->find($id);
     
        if ($package) {
            $arr = explode(",", $package->no_of_parameter);
            $ls = array();
            $i = 0;
            $mrp = 0;
            foreach ($arr as $a) {
                $k = array();
                $k['name'] = Parameter::find($a) ? Parameter::find($a)->name : '';
                $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                $k['id'] = (int) $a;
                $ls[] = $k;
            }
            $package->no_of_parameter = count($arr);
            $package->parameter_list = $ls;
            $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '3')->get();
            $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '3')->where("type_id", $package->id)->get();
            foreach ($package->review as $r) {
                $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
            }
            $total = 100 * ($package->mrp - $package->price) / $package->mrp;
            // $package->discount = number_format($total, '2', '.', '');
            $dis_pa = $this->get_discount($package->id,'Profile',$package->mrp);
            $package->discount =$dis_pa;
            $package->totalreview = count(Review::with('userdata')->where("type", '3')->where("type_id", $package->id)->get());
            $package->avgreview = Review::where("type", '3')->where("type_id", $package->id)->avg('ratting');
            $ls = array();
            $i = 0;
           
            $package->paramater_data = $ls;
            $response['status'] = "1";
            $response['page'] = 'profile';
            $response['msg'] = "Profile Detail Get Successfully";
            $response['data'] = $package;

        } else {
            $response['status'] = "0";
            $response['msg'] = "Profile Not Found";
        }
        return $response;

    }
    public function delete_account(Request $request)
    {

        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',

        ];

        $messages = array(
            'user_id.required' => "user_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $user = User::find($request->user_id);
            $user->delete();

            $response['status'] = 1;
            $response['msg'] = "Account delete successfully.";

        }
        return $response;

    }
    // ----------------Transport App API -------------------------
    public function t_login(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

        $rules['password'] = 'required';
        $rules['email'] = 'required';


        $messages = array(
            'email.required' => "email is required",
            'password.required' => "password is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['message'] = $message;
        } else {

            $user = User::with('mylab')->where("email", $request->get("email"))->whereIn('user_type', ['5', '6', '8'])->first();
            if ($user) {
                if ($request->get("password") == $user->password) {

                    if ($user->profile_pic != "") {
                        $image = asset("storage/app/public/profile") . '/' . $user->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $response['status'] = true;
                    $response['headers'] = array(
                        'Access-Control-Allow-Origin' => '*'
                    );
                    $response['message'] = "Login Successfully";
                    $response['data'] = array(
                        "user_id" => $user->id,
                        "name" => $user->name,
                        "phone" => $user->phone,
                        "email" => $user->email,
                        "user_type" => $user->user_type,
                        "sample_branch" => $user->sample_branch,
                        "profile_pic" => $image,
                        "mylab" => array("name" => $user->mylab->name,
                            "phone" => $user->mylab->phone,
                            "email" => $user->mylab->email,
                            "is_head" => $user->mylab->is_head
                        )
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "message" => "Login Credentials Are Wrong"
                    );
                }

            } else {
                $response = array(
                    "status" => false,
                    "message" => "Login Credentials Are Wrong"
                );
            }
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function t_user(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

        $rules['user_id'] = 'required';


        $messages = array(
            'user_id.required' => "user_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['message'] = $message;
        } else {

            $user = User::with('mylab')->whereIn('user_type', ['5', '6'])->find($request->get("user_id"));
            if ($user) {

                if ($user->profile_pic != "") {
                    $image = asset("storage/app/public/profile") . '/' . $user->profile_pic;
                } else {
                    $image = asset("public/upload/profile/profile.png");
                }
                $response['status'] = true;
                $response['headers'] = array(
                    'Access-Control-Allow-Origin' => '*'
                );
                $response['message'] = "Login Successfully";
                $response['data'] = array(
                    "user_id" => $user->id,
                    "name" => $user->name,
                    "phone" => $user->phone,
                    "email" => $user->email,
                    "user_type" => $user->user_type,
                    "sample_branch" => $user->sample_branch,
                    "profile_pic" => $image,
                    "mylab" => array("name" => $user->mylab->name,
                        "phone" => $user->mylab->phone,
                        "email" => $user->mylab->email,
                        "is_head" => $user->mylab->is_head
                    )
                );


            } else {
                $response = array(
                    "status" => false,
                    "message" => "User not Found!"
                );
            }
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_t_lab(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

        $rules['sample_branch'] = 'required';


        $messages = array(
            'sample_branch.required' => "sample_branch is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['message'] = $message;
        } else {
            // Log::info($request->sample_branch);
            $lab_data = User::find($request->sample_branch);

            $Ids = explode(",", $lab_data->reciever_lab);
            $city_data = User::with('location')
                ->join('city', 'users.city', '=', 'city.id')
                ->select('users.*', 'city.lat', 'city.lng')
                ->where('users.user_type', 2)
                ->whereIn('users.id', $Ids)
                ->where('users.is_head', "Yes")
                ->get();


            if (count($city_data) > 0) {
                $response = array(
                    "status" => true,
                    "message" => "Get Lab List",
                    "data" => $city_data
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "No Labs Found",

                );
            }
        }

        return json_encode($response);
    }
    public function send_parcel(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'lab_id' => 'required',
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'lab_id.required' => 'lab is required',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $inset = new Transport();
            $inset->user_id = $request->user_id;
            $inset->send_by_lab = isset($user->sample_branch) ? $user->sample_branch : '';
            $inset->lab_id = $request->lab_id;
            $inset->qty = $request->qty;
            $inset->weight = $request->weight;
            $inset->courier_type = $request->courier_type;
            $inset->vehicle_no = $request->vehicle_no;
            $inset->date = $request->date;
            $inset->parcel_type = $request->parcel_type;
            $inset->time = $request->time;
            $inset->driver_name = $request->driver_name;
            $inset->driver_phon = $request->driver_phon;
            $inset->pickup_point = $request->pickup_point;
            if ($request->file("par_img")) {

                $file = $request->file('par_img');

                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = Storage_path("app/public/parcel/");
                $picture = rand() . time() . '.' . $extension;
                //$picture = str_random(10).time().'.'.$extension;
                //$destinationPath = public_path() . $folderName;
                $request->file('par_img')->move($folderName, $picture);

                $inset->par_img = $picture;

            }
             if ($request->file("cargo_slip")) {

                $file = $request->file('cargo_slip');

                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = Storage_path("app/public/parcel/");
                $picture = rand() . time() . '.' . $extension;
                //$picture = str_random(10).time().'.'.$extension;
                //$destinationPath = public_path() . $folderName;
                $request->file('cargo_slip')->move($folderName, $picture);

                $inset->cargo_slip = $picture;

            }
            $inset->save();



            $response['status'] = true;
            $response['message'] = "send parcel Successfully";
            $response['data'] = $inset;

        }
        return json_encode($response);
    }
    public function get_parcel(Request $request)
    {
        // log::info($request->sample_branch);

        $lab = User::find($request->sample_branch);
        if ($lab) {
            $perPage = $request->input('per_page', 10);
            $currentDateTime = now();
            $transport = Transport::with('users', 'users.location')->where('lab_id', $lab->id)->where('status', 0)
                ->orderByRaw("CASE WHEN date > '{$currentDateTime->toDateString()}' OR (date = '{$currentDateTime->toDateString()}' AND time > '{$currentDateTime->format('H:i:s')}') THEN 0 ELSE 1 END, date ASC, time ASC")
                ->paginate($perPage);

            if (count($transport) > 0) {
                foreach ($transport as $row) {
                    $tra_data = User::Find($row->user_id);
                    $row['send_by'] = User::with('location')->find($tra_data->sample_branch);
                }
                $transport->appends(['sample_branch' => $request->sample_branch]);
                foreach ($transport as $g) {
                    $g->par_img = asset('storage/app/public/parcel') . '/' . $g->par_img;
                }
                $response = array(
                    "status" => true,
                    "message" => "Get List",
                    "data" => $transport
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "No Found",

                );
            }

        } else {
            $response['status'] = false;
            $response['message'] = "User not found";
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function recive_parcel(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'transport_id' => 'required',
            'recive_img' => 'required',
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'transport_id.required' => 'transport_id is required',
            'recive_img.required' => 'recive_img is required',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['message'] = $message;
        } else {

            $inset = Transport::find($request->transport_id);
            $inset->recived_by = $request->user_id;
            $inset->status = 1;
            if ($request->file("recive_img")) {
                $file = $request->file('recive_img');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = Storage_path("app/public/parcel/");
                $picture = rand() . time() . '.' . $extension;
                //$picture = str_random(10).time().'.'.$extension;
                //$destinationPath = public_path() . $folderName;
                $request->file('recive_img')->move($folderName, $picture);
                $inset->recive_img = $picture;

            }
            $inset->save();



            $response['status'] = true;
            $response['message'] = "Parcel recived Successfully";
            $response['data'] = $inset;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_received_parcel(Request $request)
    {
        
        $currentDateTime = now();
        $lab = User::find($request->sample_branch);
        if ($lab) {
            $perPage = $request->input('per_page', 10);
            $transport = Transport::with('users', 'users.location')->where('lab_id', $lab->id)->where('status', 1)
                ->orderByRaw("CASE WHEN date > '{$currentDateTime->toDateString()}' OR (date = '{$currentDateTime->toDateString()}' AND time > '{$currentDateTime->format('H:i:s')}') THEN 0 ELSE 1 END, date ASC, time ASC")
                ->paginate($perPage);

            if (count($transport) > 0) {
                foreach ($transport as $row) {
                    $tra_data = User::Find($row->user_id);
                    $row['send_by'] = User::with('location')->find($tra_data->sample_branch);
                }
                $transport->appends(['sample_branch' => $request->sample_branch]);

                foreach ($transport as $g) {
                    $g->par_img = asset('storage/app/public/parcel') . '/' . $g->par_img;
                    $g->recive_img = asset('storage/app/public/parcel') . '/' . $g->recive_img;
                }
                $response = array(
                    "status" => true,
                    "message" => "Get List",
                    "data" => $transport
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "No Found",

                );
            }

        } else {
            $response['status'] = false;
            $response['message'] = "User not found";
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_send_parcel(Request $request)
    {

        $lab = User::find($request->user_id);
        if ($lab) {
            $perPage = $request->input('per_page', 10);
            $transport = Transport::with('users', 'users.location')->where('user_id', $lab->id)->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate($perPage);

            if (count($transport) > 0) {
                $transport->appends(['user_id' => $request->user_id]);
                foreach ($transport as $g) {
                    $g->par_img = asset('storage/app/public/parcel') . '/' . $g->par_img;
                }
                $response = array(
                    "status" => true,
                    "message" => "Get List",
                    "data" => $transport
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "No Found",

                );
            }

        } else {
            $response['status'] = false;
            $response['message'] = "User not found";
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function receive_parcel_byrecevier(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'transport_id' => 'required',
            //  'recive_img' => 'required', 
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'transport_id.required' => 'transport_id is required',
            // 'recive_img.required' => 'recive_img is required',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['message'] = $message;
        } else {

            $inset = Transport::find($request->transport_id);
            if ($inset->status == 0) {
                $response['status'] = false;
                $response['message'] = "Parcel not recived yet!";

            } elseif ($inset->status == 1) {
                $inset->recived_by_receiver = $request->user_id;
                $inset->status = 2;
                $inset->save();
                $response['status'] = true;
                $response['message'] = "Parcel recived Successfully at Lab";
                $response['data'] = $inset;
            } else {

                $response['status'] = false;
                $response['message'] = "Parcel already recived at Lab!";
            }




        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function get_parcel_by_recive(Request $request)
    {

        $lab = User::find($request->sample_branch);
        if ($lab) {
            $perPage = $request->input('per_page', 10);
            $currentDateTime = now();
            $transport = Transport::with('users', 'users.location')->where('lab_id', $lab->id)
                ->orderByRaw("CASE WHEN date > '{$currentDateTime->toDateString()}' OR (date = '{$currentDateTime->toDateString()}' AND time > '{$currentDateTime->format('H:i:s')}') THEN 0 ELSE 1 END, date ASC, time ASC")
                ->paginate($perPage);

            if (count($transport) > 0) {
                foreach ($transport as $row) {
                    $tra_data = User::Find($row->user_id);
                    $row['send_by'] = User::with('location')->find($tra_data->sample_branch);
                }
                $transport->appends(['sample_branch' => $request->sample_branch]);
                foreach ($transport as $g) {
                    $g->par_img = asset('storage/app/public/parcel') . '/' . $g->par_img;
                }
                $response = array(
                    "status" => true,
                    "message" => "Get List",
                    "data" => $transport
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "No Found",
                );
            }

        } else {
            $response['status'] = false;
            $response['message'] = "User not found";
        }


        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    public function get_setting(){
        
        $setting_data = Setting::select('phone','email')->first();
        
        $response = array(
        "status" => 1,
        "msg" => "Get Setting List",
        "data" => $setting_data
        );
         return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
        
    }
}