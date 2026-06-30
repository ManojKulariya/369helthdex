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

use App\Models\Notification;
use App\Models\Payment;

use Hash;
use Mail;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;
use App\Models\Discountid;
use App\Models\Discount;
use Carbon\Carbon;

class SampleController extends Controller
{
    public $currentDate;
    public function __construct()
    {
         $this->currentDate = Carbon::now();
    }
    public function get_Setting()
    {
        $walet = Setting::select('txt_charge')->first();
        $response = [
            "status" => 1,
            "msg" => "Success",
            "data" => $walet,
        ];
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
    public function sign_up(Request $request)
    {
        $response = array(
            "status" => "0",
            "msg" => "Validation error"
        );
    
        $rules = [
            'name' => 'required',
            'sample_branch'=> 'required',
            'phone' => ['required', 'unique:users,phone', Rule::unique('users', 'phone')->whereNull('deleted_at')],
            ];
    
        $messages = array(
            'name.required' => 'name is required',
            'sample_branch.required' => 'lab is required',
            'phone.unique' => 'Mobile Number Already exists'
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
            $inset->sample_branch = $request->get("sample_branch");
            $inset->password = "XRDCHDYSR";
            $inset->user_type = 4;
            $inset->status = 0;
            $inset->phone = $request->get("phone");
            $inset->save();
    
            // $existingToken = Token::where("token", $request->get("token"))->first();
            // if ($existingToken) {
            //     // Update the user_id of the existing token if it's already present
            //     $existingToken->user_id = $inset->id;
            //     $existingToken->save();
            // } else {
            //     // Create a new token record if it does not exist
            //     $store = new Token();
            //     $store->token = $request->get("token");
            //     $store->type = $request->get("type");
            //     $store->user_id = $inset->id;
            //     $store->save();
            // }
    
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

    public function sendOTP(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
    
            $checkmobile = User::where("phone", $request->get("phone"))
                ->first();
            if ($checkmobile) {
                if ($request->get("phone") == 9587949553 || $request->get("phone") == 7229833335) {
                    $otp = 1234;
                } else {
                    // $otp = 1234;
                    $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                }
                $otp = 1234;
                $checkmobile->otp = $otp;
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
    
                // $responseApi = Http::get($url, $params);
    
                // if ($responseApi->successful()) {
                    $response['status'] = true;
                    $response['message'] = "OTP Send Successfully";
                // } else {
                //     $response['status'] = false;
                //     $response['message'] = "OTP not Send!";
                // }
    
            } else {
                $response['status'] = false;
                $response['message'] = "mobile number Not Found";
    
            }
    
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    
    public function OTP_verify(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

        $rules['otp'] = 'required';
        $rules['phone'] = 'required';

        $messages = array(

            'phone.required' => "mobile number is required",
            'otp.required' => "OTP is required",
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

            $checkuser = User::where("phone", $request->phone)->where("otp", $request->get("otp"))->where('user_type', 4)->first();
            if ($checkuser) {
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
                $response['status'] = true;
                $response['headers'] = array(
                    'Access-Control-Allow-Origin' => '*'
                );
                $gettoken = Token::where("token", $request->get("token"))->first();
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
                $response['message'] = "Login Successfully";
                $response['data'] = array(
                    "user_id" => $checkuser->id,
                    "name" => $checkuser->name,
                    "phone" => $checkuser->phone,
                    "email" => $checkuser->email,
                    "sample_branch" => $checkuser->sample_branch,
                    "address" => $checkuser->address,
                    "profile_pic" => $image
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "Invalid iogin details"
                );
            }


        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_all_lab(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

            $city_data = User::where('users.user_type', 2)->get();

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
        

        return json_encode($response);
    }
    public function post_login(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

        $rules = ['email' => 'required', 'password' => 'required', 'token' => 'required', 'token_type' => 'required'];
        $messages = array(
            'email.required' => "email is required",
            'password.required' => "password is required",
            'token.required' => "token are required",
            'token_type.required' => "token_type are required",
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

            $checkuser = User::where("email", $request->email)->where("password", $request->password)->where('user_type', 4)->first();
            if ($checkuser) {
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
                $response['status'] = true;
                $response['headers'] = array(
                    'Access-Control-Allow-Origin' => '*'
                );
                $gettoken = Token::where("token", $request->get("token"))->first();
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
                $response['message'] = "Login Successfully";
                $response['data'] = array(
                    "user_id" => $checkuser->id,
                    "name" => $checkuser->name,
                    "phone" => $checkuser->phone,
                    "email" => $checkuser->email,
                    "sample_branch" => $checkuser->sample_branch,
                    "address" => $checkuser->address,
                    "profile_pic" => $image
                );
            } else {
                $response = array(
                    "status" => false,
                    "message" => "Invalid iogin details"
                );
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

    public function post_savetoken(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = ['token' => 'required', 'type' => 'required'];
        $messages = array(
            'token.required' => "token is required",
            'type.required' => "type is required"
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
            if ($request->get("token") != "" && $request->get("type") != "" && $request->get("token") != "null") {
                $store = new Token();
                $store->token = $request->get("token");
                $store->type = $request->get("type");
                $store->save();
                $response = array(
                    "status" => 1,
                    "message" => "Token Save Successfully",
                    "data" => $store
                );
            } else {
                $response = array(
                    "status" => 0,
                    "message" => "Fields is Required"
                );
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function forgotpassword(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
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
                $response['status'] = true;
                $response['message'] = "Mail Send Successfully";
            } else {
                $response['status'] = false;
                $response['message'] = "Email Not Found";

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
    public function edit_profile(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required",
            'name.required' => "name is required",
            'address.required' => "address is required",
            'phone.required' => "phone is required"
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
            $update = User::find($request->get("id"));
            if ($update) {
                $update->name = $request->get("name");
                $update->phone = $request->get("phone");
                $update->address = $request->get("address");
                if ($request->file("image")) {

                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension() ?: 'png';
                    $folderName = Storage_path("app/public/profile/");
                    $picture = rand() . time() . '.' . $extension;
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
                $update->user_id = $update->id;
                $update->profile_pic = asset("storage/app/public/profile") . '/' . $update->profile_pic;
                $response['status'] = true;
                $response['message'] = "Profile Update Successfully";
                $response['data'] = $update;


            } else {
                $response['status'] = false;
                $response['message'] = "Profile Not Found";
            }


        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function get_discount($test_id,$type,$mrp)
    {
        $mrp = (float) $mrp;
        $fixed=0;
        $per=0;
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

    // public function book_detail(Request $request)
    // {
    //     $response = array(
    //         "status" => false,
    //         "message" => "Validation error"
    //     );
    //     $rules = [
    //         'order_id' => 'required'
    //     ];

    //     $messages = array(
    //         'order_id.required' => "order_id is required"
    //     );
    //     $validator = Validator::make($request->all(), $rules, $messages);
    //     if ($validator->fails()) {
    //         $message = '';
    //         $messages_l = json_decode(json_encode($validator->messages()), true);
    //         foreach ($messages_l as $msg) {
    //             $message .= $msg[0] . ", ";
    //         }
    //         $response['message'] = $message;
    //     } else {
    //         $get_order = Orders::with("useraddressdetails", "partiallyreports")->find($request->get("order_id"));
    //         if ($get_order) {
    //             $get_order->phone = User::find($get_order->user_id) ? User::find($get_order->user_id)->phone : '';

    //             $arr = array();
    //             $getcartinfo = OrdersData::with("memberdetails")->where("order_id", $request->get("order_id"))->get();
        
    //             foreach ($getcartinfo as &$g) {
    //                 $b = array();
    //                 $mrp =0;
    //                 if ($g->type == 1) {
    //                     $item_data = Package::find($g->item_id);
    //                     $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
    //                     $find_pa = TestDetails::where("package_id", $item_data->id)->get();
    //                             foreach ($find_pa as $d) {
                                
    //                                 if ($d->type == 1) {
    //                                     $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
    //                                 }
    //                                 if ($d->type == 2) {
    //                                     $a = Profiles::find($d->type_id);
    //                                     if ($a) {
    //                                         $alr = explode(",", $a->no_of_parameter);
    //                                         foreach ($alr as $l) {
    //                                             $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
    //                                         }
    //                                     }
    //                                 }
    //                             }
    //                   $b['type_name']  = 'Package';
    //                     $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
    //                 } else if ($g->type == 2) {
    //                     $item_data = Parameter::find($g->item_id);
    //                     $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
    //                     $p=$item_data->price;
    //                     $item_data->price = $item_data->mrp;
    //                     $item_data->mrp = $p;
    //                     $mrp +=$item_data->price;
                        
    //                     $b['type_name']  = 'Parameter';
                      
    //                 } else {
    //                     $item_data = Profiles::find($g->item_id);
                        
    //                     if($item_data){
    //                                 // dd($item_data->no_of_parameter);
    //                                 $al = explode(",", $item_data->no_of_parameter);
    //                                 foreach ($al as $a) {
    //                                     $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
    //                                 }
                                    
    //                                 $item_data->name = $item_data->profile_name;
                                    
    //                             }
    //                     $b['type_name'] = 'Profiles';
    //                     $dis_pa = $this->get_discount($item_data->id,'Profile',$item_data->mrp);
    //                      $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
    //                 }
    //                 $b['memberdetails'] = isset($g->memberdetails) ? $g->memberdetails : null;
    //                 $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                   
    //                 $price = $item_data['mrp'];
    //                 $b['mrp']= $mrp;
    //                 $b['price'] =$price;
    //                 $b['parameter'] = $g->parameter;
    //                 $b['type'] = $g->type;
    //                 $b['type_id'] = $g->item_id;
    //                 $arr[] = $b;
    //             }

    //             $get_order->orderdata = $arr;
    //             $response['status'] = true;
    //             $response['message'] = "Order Detail Get Successfully";
    //             $response['data'] = $get_order;
    //         } else {
    //             $response['status'] = false;
    //             $response['message'] = "Order Not Found";
    //         }

    //     }
    //     return json_encode($response);
    // }
    public function book_detail(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $get_order = Orders::with("useraddressdetails", "partiallyreports")->find($request->get("order_id"));
            if ($get_order) {
                $get_order->phone = User::find($get_order->user_id) ? User::find($get_order->user_id)->phone : '';

                $arr = array();
                $getcartinfo = OrdersData::with("memberdetails")->where("order_id", $request->get("order_id"))->get();
        
                foreach ($getcartinfo as &$g) {
                    $b = array();
                    $ls = array();
                    $parameter = 0;
                    if ($g->type == 1) {
                        $item_data = Package::find($g->item_id);
                        $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                        $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                                foreach ($find_pa as $d) {
                                
                                    if ($d->type == 1) {
                                         $ls[] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                                   
                                        $parameter = $parameter + 1;
                                    }
                                    if ($d->type == 2) {
                                        $a = Profiles::find($d->type_id);
                                        if ($a) {
                                            $alr = explode(",", $a->no_of_parameter);
                                            foreach ($alr as $l) {
                                                $ls[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                                                
                                            }
                                            $parameter = $parameter + count($alr);
                                        }
                                    }
                                }
                       $b['type_name']  = 'Package';
                    } else if ($g->type == 2) {
                        $item_data = Parameter::find($g->item_id);
                        $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                        
                        $b['type_name']  = 'Parameter';
                      
                    } else {
                        $item_data = Profiles::find($g->item_id);
                        if($item_data){
                            $al = explode(",", $item_data->no_of_parameter);
                            foreach ($al as $a) {
                                $parameter = Parameter::find($a);
                                $ls[] = $parameter ? $parameter->name : '';
                            }
                            
                            $item_data->name = $item_data->profile_name;
                                
                            }
                        $b['type_name'] = 'Profiles';
                        $dis_pa = $this->get_discount($item_data->id,'Profile',$item_data->mrp);
                         
                    }
                    $b['paramater_data'] = implode("#", $ls);
                    $b['memberdetails'] = isset($g->memberdetails) ? $g->memberdetails : null;
                    $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                    $b['mrp']=  $g->mrp;
                    $b['price'] = $g->price;
                    $b['parameter'] = $g->parameter;
                    $b['type'] = $g->type;
                    $b['type_id'] = $g->item_id;
                    $b['description'] = isset($item_data->description) ? $item_data->description : '';
                    $b['short_desc'] = isset($item_data->short_desc) ? $item_data->short_desc : '';
                    $b['fasting_time'] = isset($item_data->fasting_time) ? $item_data->fasting_time : '';
                    $b['paramter_included'] = $item_data->paramter_included;
                    $b['no_of_test'] = isset($item_data->no_of_test) ? $item_data->no_of_test : null;
                    $b['sample_collection'] = isset($item_data->sample_collection) ? $item_data->sample_collection : '';
                    $b['sample_collection_fee'] = isset($item_data->sample_collection_fee) ? $item_data->sample_collection_fee : '';
                    $b['no_of_parameter'] = isset($item_data->no_of_parameter) ? $item_data->no_of_parameter : '';
                    $b['report_time'] = isset($item_data->report_time) ? $item_data->report_time : '';
                    $b['test_recommended_for'] = isset($item_data->test_recommended_for) ? $item_data->test_recommended_for : '';
                    $b['test_recommended_for_age'] = isset($item_data->test_recommended_for_age) ? $item_data->test_recommended_for_age : '';
                    $arr[] = $b;
                    
                }

                $get_order->orderdata = $arr;
                $response['status'] = true;
                $response['message'] = "Order Detail Get Successfully";
                $response['data'] = $get_order;
            } else {
                $response['status'] = false;
                $response['message'] = "Order Not Found";
            }

        }
        return json_encode($response);
    }

    public function notification_list(Request $request)
    {

        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $perPage = $request->input('per_page', 10);
            $data = Notification::with("user")->where("user_id", $request->get("user_id"))->orderBy('id', 'DESC')->paginate($perPage);

            if (count($data) > 0) {
                $data->appends(['user_id' => $request->user_id]);
                $response['status'] = true;
                $response['message'] = "Notification List Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
        }
        return json_encode($response);
    }

    public function get_payment_list(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $perPage = $request->input('per_page', 10);
            $data = Payment::with("user")->where("sample_boy_id", $request->get("user_id"))->orderBy('id', 'DESC')->paginate($perPage);

            if (count($data) > 0) {
                $data->appends(['user_id' => $request->user_id]);
                $response['status'] = true;
                $response['message'] = "Payment List Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
        }
        return json_encode($response);
    }


    public function reschedule_order(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );

        $rules = [
            'order_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'remark' => 'required|string|max:100',
        ];
        $messages = array(
            'order_id.required' => 'order_id is required',
            'date.required' => 'date is required',
            'time.required' => 'time is required',
            'remark.required' => 'remark is required'
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
            $insert = Orders::find($request->order_id);

            if ($insert) {
                $insert->date = $request->date;
                $insert->time = $request->time;
                $insert->remark = $request->remark;
                $insert->save();

                $response['status'] = true;
                $response['message'] = "Order rescheduled Successfully";
                $response['data'] = $insert;
            } else {
                $response['status'] = false;
                $response['message'] = "Something went wrong!";
            }
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function save_payment(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'order_id' => 'required',
            'lab_id' => 'required',
            'sample_boy_id' => 'required',
            'price' => 'required',
            'paymant_mode' => 'required',
            'status' => 'required'
        ];
        $messages = array(
            'order_id.required' => 'order_id is required',
            'lab_id.required' => 'lab_id is required',
            'sample_boy_id.required' => 'sample_boy_id is required',
            'price.required' => 'price is required',
            'paymant_mode.required' => 'paymant_mode is required',
            'status.required' => 'status is required'
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
            $insert = new Payment();
            $insert->order_id = $request->order_id;
            $insert->lab_id = $request->lab_id;
            $insert->sample_boy_id = $request->sample_boy_id;
            $insert->price = $request->price;
            $insert->paymant_mode = $request->paymant_mode;
            $insert->status = $request->status;
            $insert->save();
            $response['status'] = true;
            $response['message'] = "Payment recived Successfully";
            $response['data'] = $insert;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
    public function search_test(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'text' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'text.required' => "text is required"
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
            $searchTerm = $request->text;
            $Packageids = Package::where('name', 'LIKE', '%' . $searchTerm . '%')->whereNull('deleted_at')->pluck('id')->toArray();
            $Profilesids = Profiles::where('profile_name', 'LIKE', '%' . $searchTerm . '%')->whereNull('deleted_at')->pluck('id')->toArray();
            $Parameterids = Parameter::where('name', 'LIKE', '%' . $searchTerm . '%')->whereNull('deleted_at')->pluck('id')->toArray();
            
            $user = User::find($request->user_id);
            $perPage = $request->input('per_page', 10);
            $branchId = $user->sample_branch;
            #
            $Parameter = Parameter::whereIn('id',$Parameterids)->where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();
            foreach ($Parameter as $row) {
                $dis_pa = $this->get_discount($row->id,'Parameter',$row->mrp);
                if ($dis_pa['fixed'] > 0.00 ) {
                $per = $dis_pa['per'];
                $price = $row['mrp'] - $dis_pa['fixed'];
                }else{
                 $price = $row['mrp'];
                }
                $row->price = $price;
                $row->no_of_parameter = 1;
                $row->parameter_data = "";
                $row->type = 'Parameter';
                $row->ty_id = 2;
            }
            #
            $data_test = Profiles::whereIn('id',$Profilesids)->where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

            foreach ($data_test as $row) {
                $dis_pa = $this->get_discount($row->id,'Profile',$row->mrp);
                if ($dis_pa['fixed'] > 0.00 ) {
                $per = $dis_pa['per'];
                $price = $row['mrp'] - $dis_pa['fixed'];
                }else{
                 $price = $row['mrp'];
                }
                $row->price = $price;

                $arr = explode(",", $row->no_of_parameter);
                $row->no_of_parameter = count($arr);

                $ls = [];
                foreach ($arr as $a) {
                    $parameter = Parameter::find($a);
                    $ls[] = $parameter ? $parameter->name : '';
                }
                $row->parameter_data = implode(",", $ls);
                $row->type = 'Profiles';
                $row->ty_id = 3;
            }
            #
            $data_test_pkg = Package::whereIn('id',$Packageids)->where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

            foreach ($data_test_pkg as $p) {
                $dis_pa = $this->get_discount($p->id,'Package',$p->mrp);
                if ($dis_pa['fixed'] > 0.00 ) {
                $per = $dis_pa['per'];
                $price = $p->mrp - $dis_pa['fixed'];
                }else{
                 $price = $p->mrp;
                }
                $p->price = $price;
                $find_pa = TestDetails::where("package_id", $p->id)->get();
                $parameter = 0;
                $p->type = 'Package';
                $p->ty_id = 1;
                foreach ($find_pa as $d) {
                    if ($d->type == 1) {
                        $ls[] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                        $parameter = $parameter + 1;
                    }
                    if ($d->type == 2) {
                        $a = Profiles::find($d->type_id);
                        //  $ls[] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                        if ($a) {
                            $arr = explode(",", $a->no_of_parameter);
                            foreach ($arr as $l) {
                                $ls[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                            }
                            $parameter = $parameter + count($arr);
                        }
                    }
                }
                $p->no_of_parameter = $parameter;
                $p->paramater_data = implode("#", $ls);


            }
        // $allNames = array_merge($Parameter, $data_test, $data_test_pkg);
        $allNames = array_merge(
    $Parameter->toArray(), 
    $data_test->toArray(), 
    $data_test_pkg->toArray()
);

        if (count($allNames) > 0) {

                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $allNames;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
            
        }
         return json_encode($response);
       
    }
    public function get_default_price_city($sample_branch){
        $lab = User::find($sample_branch);
        if($lab){
            $cityid = $lab->city;
            if($cityid != null || $cityid != ''){
                $ct = City::find($cityid);
                if($ct){
                    $cityname = $ct->city;
                }else{
                    $cityname = 'Jaipur'; 
                }
                
                
            }else{
                $cityname = 'Jaipur';
            }
        }else{
            $cityname = 'Jaipur';
        }
        
        $branchIds = $this->getdefaultcityid($cityname);
        return $branchIds;
    }
    public function show_other_parameter_list(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $perPage = $request->input('per_page', 10);
            $branchId = $user->sample_branch;
            $searchTerm = $request->text;
            $Parameter = Parameter::when(!empty($searchTerm), function ($query) use ($searchTerm) {
                        return $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })->where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')
                    ->whereNull('deleted_at')->paginate($perPage);
            foreach ($Parameter as $row) {
               
                $price = $row['mrp'];
                $mrp = $row['price'];
                $row->price = $mrp;
                $row->mrp = $price;
                $row->no_of_parameter = 1;
                $row->parameter_data = "";
                $row->type = 'Parameter';
                $row->ty_id = 2;
            }
            if (count($Parameter) > 0) {

                $Parameter->appends(['user_id' => $request->user_id,'text' => $request->text]);
                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $Parameter;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
        }
        //  return $response;
        return json_encode($response);

    }

    public function show_other_parameter_list_v2(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $perPage = $request->input('per_page', 10);
            $branchId = $user->sample_branch;
            $defaultcityID = $this->get_default_price_city($branchId);
            // return $defaultcityID;
            $searchTerm = $request->text;
            $Parameter = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                    ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                    ->whereNull('parameters.deleted_at')
                                    ->select('parameters.*','parameter_branch.mrp as price','parameter_branch.price as mrp')
                                    ->when(!empty($searchTerm), function ($query) use ($searchTerm) {
                                            return $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                                        })->paginate($perPage);
            foreach ($Parameter as $row) {
               
                $row->no_of_parameter = 1;
                $row->parameter_data = "";
                $row->type = 'Parameter';
                $row->ty_id = 2;
            }
            if (count($Parameter) > 0) {

                $Parameter->appends(['user_id' => $request->user_id,'text' => $request->text]);
                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $Parameter;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
        }
        //  return $response;
        return json_encode($response);

    }

    public function show_other_test_list_v2(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $branchId = $user->sample_branch;
            $defaultcityID = $this->get_default_price_city($branchId);
            $data = [];
            $searchTerm = $request->text;
            $perPage = $request->input('per_page', 10);
            $data_test = Profiles::join('profile_branch', 'profiles.id', '=', 'profile_branch.profile_id')
                                        ->select('profiles.*','profile_branch.mrp as price','profile_branch.price as mrp')
                                        ->whereIn('profile_branch.branch_id', [$defaultcityID])
                                        ->when(!empty($searchTerm), function ($query) use ($searchTerm) {
                                            return $query->where('profile_name', 'LIKE', '%' . $searchTerm . '%');
                                        })->paginate($perPage);

            foreach ($data_test as $row) {
                $arr = explode(",", $row->no_of_parameter);
                $row->no_of_parameter = count($arr);
                $ls = [];
                foreach ($arr as $a) {
                    $parameter = Parameter::find($a);
                    $ls[] = $parameter ? $parameter->name : '';
                }
                $row->parameter_data = implode(",", $ls);
                $row->type = 'Profiles';
                $row->ty_id = 3;
            }

            if (count($data_test) > 0) {
                $data_test->appends(['user_id' => $request->user_id,'text' => $request->text]);
                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $data_test;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }


        }

        return json_encode($response);

    }
    public function show_other_test_list(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $branchId = $user->sample_branch;
            $data = [];
            $searchTerm = $request->text;
            $perPage = $request->input('per_page', 10);
            $data_test = Profiles::when(!empty($searchTerm), function ($query) use ($searchTerm) {
                        return $query->where('profile_name', 'LIKE', '%' . $searchTerm . '%');
                    })->where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->paginate($perPage);

            foreach ($data_test as $row) {
                $mrp=0;
                $price = $row['mrp'];
                $row->price = $price;

                $arr = explode(",", $row->no_of_parameter);
                $row->no_of_parameter = count($arr);

                $ls = [];
                foreach ($arr as $a) {
                    $parameter = Parameter::find($a);
                    $ls[] = $parameter ? $parameter->name : '';
                    $mrp += $parameter ? $parameter->mrp : 0;
                }
                $row->mrp = $mrp;
                $row->parameter_data = implode(",", $ls);
                $row->type = 'Profiles';
                $row->ty_id = 3;
            }

            if (count($data_test) > 0) {
                $data_test->appends(['user_id' => $request->user_id,'text' => $request->text]);
                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $data_test;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }


        }

        return json_encode($response);

    }
    public function show_other_package_list_v2(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $branchId = $user->sample_branch;
            $defaultcityID = $this->get_default_price_city($branchId);
            $data = [];
            $searchTerm = $request->text;
            $perPage = $request->input('per_page', 10);
            $data_test = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                                            ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                                            ->select('packages.*','package_branch.mrp as price','package_branch.price as mrp')
                                            ->when(!empty($searchTerm), function ($query) use ($searchTerm) {
                                                return $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                                            })->paginate($perPage);

            foreach ($data_test as $p) {
                $mrp=0;
                $dis_pa = $this->get_discount($p->id,'Package',$p->mrp);
               
                $find_pa = TestDetails::where("package_id", $p->id)->get();
                $parameter = 0;
                $p->type = 'Package';
                $p->ty_id = 1;
                foreach ($find_pa as $d) {
                    if ($d->type == 1) {
                        $ls[] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                                   
                        $parameter = $parameter + 1;
                    }
                    if ($d->type == 2) {
                        $a = Profiles::find($d->type_id);
                        if ($a) {
                            $arr = explode(",", $a->no_of_parameter);
                            foreach ($arr as $l) {
                                $ls[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                                
                            }
                            $parameter = $parameter + count($arr);
                        }
                    }
                }
                $p->no_of_parameter = $parameter;
                $p->paramater_data = implode("#", $ls);

            }


            if (count($data_test) > 0) {
                $data_test->appends(['user_id' => $request->user_id,'text' => $request->text]);
                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $data_test;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }

        }

        return json_encode($response);

    }
    public function show_other_package_list(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $user = User::find($request->user_id);
            $branchId = $user->sample_branch;
            $data = [];
            $searchTerm = $request->text;
            $perPage = $request->input('per_page', 10);
            $data_test = Package::when(!empty($searchTerm), function ($query) use ($searchTerm) {
                        return $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })->where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->paginate($perPage);

            foreach ($data_test as $p) {
                $mrp=0;
                $dis_pa = $this->get_discount($p->id,'Package',$p->mrp);
                // if ($dis_pa['fixed'] > 0.00 ) {
                // $per = $dis_pa['per'];
                // $price = $p->mrp - $dis_pa['fixed'];
                // }else{
                 $price = $p->mrp;
                // }
                $p->price = $price;
                $find_pa = TestDetails::where("package_id", $p->id)->get();
                $parameter = 0;
                $p->type = 'Package';
                $p->ty_id = 1;
                foreach ($find_pa as $d) {
                    if ($d->type == 1) {
                        $ls[] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                                   
                        $parameter = $parameter + 1;
                    }
                    if ($d->type == 2) {
                        $a = Profiles::find($d->type_id);
                        //  $ls[] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                        if ($a) {
                            $arr = explode(",", $a->no_of_parameter);
                            foreach ($arr as $l) {
                                $ls[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                            }
                            $parameter = $parameter + count($arr);
                        }
                    }
                }
                $p->mrp = $mrp;
                $p->no_of_parameter = $parameter;
                $p->paramater_data = implode("#", $ls);


            }


            if (count($data_test) > 0) {
                $data_test->appends(['user_id' => $request->user_id,'text' => $request->text]);
                $response['status'] = true;
                $response['message'] = "get data successfuly";
                $response['data'] = $data_test;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }

        }

        return json_encode($response);

    }
    public function assined_total_deliveries(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $data = Orders::with("useraddressdetails", "customer")
                ->where("sample_collection_boy_id", $request->get("user_id"))
                //->whereNotIn('status', ['1','3', '4','5','7'])
                ->whereIn('sample_status', ['2', '3'])
                ->orderBy('id', 'DESC')->paginate(10);

            if (count($data) > 0) {


                $data->appends(['user_id' => $request->user_id]);
                $response['status'] = true;
                $response['message'] = "Order List Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }



        }
        return json_encode($response);
    }
    
    public function sample_count(Request $request){
         $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            
            $order_status = "Active";
            $data = Orders::with("useraddressdetails", "customer")
                ->where("sample_collection_boy_id", $request->get("user_id"))
                ->whereNotIn('status', ['1'])
                ->get();
                $Pending = 0;
                $Completed = 0;
                $Cancelled = 0;
                foreach($data as &$row){
                    if($row->sample_status == 3 || $row->sample_status == 2){
                        ++$Completed;
                    }elseif($row->sample_status == 5 ){
                        ++$Cancelled;
                    }elseif($row->sample_status == 1 || $row->sample_status == 4){
                        ++$Pending; 
                    }
                }
                $payment = Payment::where("sample_boy_id", $request->get("user_id"))->sum('price');

                $data=(['Pending' => $Pending,'Completed'=>$Completed,'Cancelled'=>$Cancelled,'payment'=>$payment]);
                $response['status'] = true;
                $response['message'] = "Order List Get Successfully";
                $response['data'] = $data;
            
        }
        return json_encode($response);
    }
    public function book_filter(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            // Active =>Order with Pending and completed status will show in Active
            // 
            $order_status = "Active";
            $data = Orders::with("useraddressdetails", "customer")
                ->where("sample_collection_boy_id", $request->get("user_id"))
                ->whereNotIn('status', ['1'])
                // ->where('sample_status', '!=', 2)
                ->when($request->get("order_status") == 'Completed', function ($query) {
                    $query->whereIn("sample_status",['3','2']);
                })
                ->when($request->get("order_status") == 'Cancelled', function ($query) {
                    $query->whereIn("sample_status", ['5']);
                })
                ->when($request->get("order_status") == 'Pending', function ($query) {
                    $query->whereIn("sample_status",[1,4]);
                })
                ->orderBy('id', 'DESC')->paginate(10);
                foreach($data as &$row){
                    $dataorder = OrdersData::where('order_id',$row->id)->pluck('item_name');
                    $row->item_name = $dataorder;
                    $st='';
                    if($row->sample_status == 1 || $row->sample_status == 4 ){ 
                      $st='Pending';  
                    }
                    if($row->sample_status == 3 || $row->sample_status == 2){
                        $st='Completed';
                    }
                    if($row->sample_status == 5 ){
                        $st='Cancelled';
                    }
                    $row->sample_order_status = $st;
                }
            if (count($data) > 0) {
                $data->appends(['user_id' => $request->user_id]);
                $response['status'] = true;
                $response['message'] = "Order List Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
        }
        return json_encode($response);
    }
   

    public function upcomming_book_filter(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
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
            $response['message'] = $message;
        } else {
            $data = Orders::with("useraddressdetails", "customer")->whereNotIn('status', ['1', '3', '4', '5', '7'])->where('sample_status', '!=', 2)
                ->where("sample_collection_boy_id", $request->get("user_id"))
                ->where('date', '>=', now()->toDateString()) // Only get records with a date greater than or equal to today
                ->orderBy('date')
                ->orderBy('time')
                ->paginate(10);


            if (count($data) > 0) {

                $data->appends(['user_id' => $request->user_id]);
                $response['status'] = true;
                $response['message'] = "Order List Get Successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = "Data Not Found";
            }
        }
        return json_encode($response);
    }
    public function sampalboy_check_out(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'test_json' => 'required',
            'order_id' => 'required',
            'subtotal' => "required",
            'tax' => "required",
            'final_total' => "required",
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'test_json.required' => "test_json is required",
            'order_id.required' => "order_id is required",
            'subtotal.required' => "subtotal is required",
            'tax.required' => "tax is required",
            'final_total.required' => "final_total is required",
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
            $cart_data = $request->test_json;
            $user = User::find($request->user_id);
            if ($user->user_type == 2) {
                $member = $user->id;
            } else {
                $member = $user->sample_branch;
            }
            try {
                $subtotal = $request->subtotal;
                $final_total = $request->final_total;
                $store = Orders::find($request->order_id);
                
                #------------------coupon----------------
                $price = 0;
                $discount = 0;
                if (isset($request['coupon_id']) && $request['coupon_id'] !== '' && $request['coupon_id'] !== null) {
                    $coupon_data =  Coupon::where('coupon_code',$request->coupon_id)->first(); 
                    $today = date('l');
                    $days = explode(',', $coupon_data->day);
                    foreach ($days as $dy) {
                        if ($dy == $today) {

                            if ($coupon_data->type == 4) {
                                $price = $request->get("subtotal");
                                if ($coupon_data->coupon_type == 'percent') {
                                    $discount = $price * ($coupon_data->coupon_value / 100);
                                } else {
                                    $discount = $coupon_data->coupon_value;
                                }
                            }
                            if ($coupon_data->type == 1) {
                                $product_ids = explode(',', $coupon_data->product_ids);
                                foreach ($product_ids as $product_id) {
                                    foreach ($cart_data as $g) {
                                        if ($product_id == $g->type_id) {
                                            $price = $g->price;
                                            if ($coupon_data->coupon_type == 'percent') {
                                                $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                            } else {
                                                $discount_cp = $coupon_data->coupon_value;
                                            }
                                            $discount = $discount + $discount_cp;
                                        }
                                    }
                                }
                            }
                            if ($coupon_data->type == 2) {
                                $product_ids = explode(',', $coupon_data->product_ids);
                                foreach ($product_ids as $product_id) {
                                    foreach ($cart_data as $g) {
                                        if ($product_id == $g->type_id) {
                                            $price = $g->price;
                                            if ($coupon_data->coupon_type == 'percent') {
                                                $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                            } else {
                                                $discount_cp = $coupon_data->coupon_value;
                                            }
                                            $discount = $discount + $discount_cp;
                                        }
                                    }
                                }
                            }
                            if ($coupon_data->type == 3) {
                                $product_ids = explode(',', $coupon_data->product_ids);
                                foreach ($product_ids as $product_id) {
                                    foreach ($cart_data as $g) {
                                        if ($product_id == $g->type_id) {
                                            $price = $g->price;
                                            if ($coupon_data->coupon_type == 'percent') {
                                                $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                            } else {
                                                $discount_cp = $coupon_data->coupon_value;
                                            }
                                            $discount = $discount + $discount_cp;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    $store->coupon_id = $coupon_data->id;
                    $store->coupon_discount = $discount;
                    $final_total = $subtotal - $discount;

                }else{
                    $store->coupon_id = null;
                    $store->coupon_discount = null;
                }
                
                // #payment ---------------
                if($store->payment_method == "cod"){
                  $sm_price =  $final_total;
                }else{
                  $sm_price =  $final_total - $store->final_total ; 
                }
                if(isset($request['payable_amount']) && $request['payable_amount'] > 0){
                    // Payment::where('order_id',$store->id)->delete();
                    $payment = new Payment();
                    $payment->lab_id  = $store->manager_id;
                    $payment->sample_boy_id = $store->sample_collection_boy_id;
                    $payment->order_id = $store->id;
                    $payment->price = $request['payable_amount'];
                    $payment->paymant_mode = 'cod';
                    $payment->status = '1';
                    $payment->save();
                }
                OrdersData::where("order_id", $request->order_id)->delete();
                $store->subtotal = $subtotal;
                $store->final_total = $final_total;
                $store->tax = $request->tax;
                $store->save();
                $store1 = $cart_data;
                foreach ($store1 as $s) {
                    $mrp=0;
                    if ($s['type'] == 1) {
                        $item_data = Package::find($s['type_id']);
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
                    } else if ($s['type'] == 2) {
                        $item_data = Parameter::find($s['type_id']);
                        $mrp +=$item_data->mrp;
                        $mrpg = $item_data->mrp;
                        $price = $item_data->price;
                        $item_data->mrp = $price;
                        $item_data->price = $mrpg;
                        $mrp =  $item_data->price;
                        $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                    } else {
                        $item_data = Profiles::find($s['type_id']);
                        if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                            }
                        $item_data->name = $item_data->profile_name;
                        $dis_pa = $this->get_discount($item_data->id,'Profile',$item_data->mrp);
                    }
                    $data = new OrdersData();
                    $data->order_id = $request->order_id;
                    $data->member_id = $member;
                    $data->family_member_id = $s['family_member_id'];
                    $data->item_id = $s['type_id'];
                    $data->type = $s['type'];
                    $data->item_name = $item_data->name;
                    $data->parameter = $s['parameter'];
                    $data->mrp = $mrp;
                    $price = $item_data->mrp;
                    $data->price = $price;
                    $data->save();
                }
                $response = array(
                    "status" => true,
                    "message" => "booking has been updated."
                );

            } catch (\Exception $e) {
                DB::rollback();
                $response['status'] = false;
                $response['message'] = "Something Getting Worng";
            }
        }
        return json_encode($response);
    }
    public function sampalboy_check_out_v2(Request $request)
    {
        Log::info($request->all());
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'test_json' => 'required',
            'order_id' => 'required',
            'subtotal' => "required",
            'tax' => "required",
            'final_total' => "required",
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'test_json.required' => "test_json is required",
            'order_id.required' => "order_id is required",
            'subtotal.required' => "subtotal is required",
            'tax.required' => "tax is required",
            'final_total.required' => "final_total is required",
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
            $cart_data = $request->test_json;
            $user = User::find($request->user_id);
            if ($user->user_type == 2) {
                $member = $user->id;
            } else {
                $member = $user->sample_branch;
            }
            try {
                $subtotal = $request->subtotal;
                $final_total = $request->final_total;
                $store = Orders::find($request->order_id);
                
                #------------------coupon----------------
                $price = 0;
                $discount = $request->coupon_dis;
                // if (isset($request['coupon_id']) && $request['coupon_id'] !== '' && $request['coupon_id'] !== null) {
                    $coupon_data =  Coupon::where('coupon_code',$request->coupon_id)->first(); 
                    if($coupon_data){
                        $store->coupon_id = $coupon_data->id;
                    }
                    $store->coupon_discount = $discount;
                    $final_total = $subtotal - $discount;

                // }else{
                //     $store->coupon_id = null;
                //     $store->coupon_discount = null;
                // }
                
                // #payment ---------------
                if($store->payment_method == "cod"){
                  $sm_price =  $final_total;
                }else{
                  $sm_price =  $final_total - $store->final_total ; 
                }
                if(isset($request['payable_amount']) && $request['payable_amount'] > 0){
                    
                    $payment = new Payment();
                    $payment->lab_id  = $store->manager_id;
                    $payment->sample_boy_id = $store->sample_collection_boy_id;
                    $payment->order_id = $store->id;
                    $payment->price = $request['payable_amount'];
                    $payment->paymant_mode = 'cod';
                    $payment->status = '1';
                    $payment->save();
                }
                OrdersData::where("order_id", $request->order_id)->delete();
                $store->subtotal = $subtotal;
                $store->final_total = $final_total;
                $store->tax = $request->tax;
                $store->save();
                $store1 = $cart_data;
                Log::info($store1);
                foreach ($store1 as $s) {
                
                    if ($s['type'] == 1) {
                        $item_data = Package::find($s['type_id']);
                       
                    } else if ($s['type'] == 2) {
                        $item_data = Parameter::find($s['type_id']);
                    } else {
                        $item_data = Profiles::find($s['type_id']);
                        
                        $item_data->name = $item_data->profile_name;
                    }
                    $data = new OrdersData();
                    $data->order_id = $request->order_id;
                    $data->member_id = $member;
                    $data->family_member_id = $s['family_member_id'];
                    $data->item_id = $s['type_id'];
                    $data->type = $s['type'];
                    $data->item_name = $item_data->name;
                    $data->parameter = $s['parameter'];
                    $data->mrp = $s['mrp'];
                    $data->price = $s['price'];
                    $data->save();
                }
                $response = array(
                    "status" => true,
                    "message" => "booking has been updated."
                );

            } catch (\Exception $e) {
                DB::rollback();
                $response['status'] = false;
                $response['message'] = "Something Getting Worng";
            }
        }
        return json_encode($response);
    }
    public function admin_check_out(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'userid' => 'required',
            'test_json' => 'required',
            'subtotal' => "required",
            'final_total' => "required",
            'date'=>"required",
            'time'=>"required"
        ];
        $messages = array(
            'userid.required' => "userid is required",
            'test_json.required' => "test_json is required",
            'subtotal.required' => "subtotal is required",
            'final_total.required' => "final_total is required",
            'date.required' => "date is required",
            'time.required' => "time is required",
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
            $cart_data = json_decode($request->test_json,true);
            $user = User::find($request->user_id);
            $member = $request->labid;
            
            // try {
                $subtotal = $request->subtotal;
                $final_total = $request->final_total;
                $store = new Orders();
                #------------------coupon----------------
                $price = 0;
                $discount = 0;
                if (isset($request['coupon_id']) && $request['coupon_id'] !== '' && $request['coupon_id'] !== null) {
                    $coupon_data =  Coupon::where('coupon_code',$request->coupon_id)->first(); 
                    if($coupon_data){
                    $today = date('l');
                    $days = explode(',', $coupon_data->day);
                    foreach ($days as $dy) {
                        if ($dy == $today) {

                            if ($coupon_data->type == 4) {
                                $price = $request->get("subtotal");
                                if ($coupon_data->coupon_type == 'percent') {
                                    $discount = $price * ($coupon_data->coupon_value / 100);
                                } else {
                                    $discount = $coupon_data->coupon_value;
                                }
                            }
                            if ($coupon_data->type == 1) {
                                $product_ids = explode(',', $coupon_data->product_ids);
                                foreach ($product_ids as $product_id) {
                                    foreach ($cart_data as $g) {
                                        if ($product_id == $g->type_id) {
                                            $price = $g->price;
                                            if ($coupon_data->coupon_type == 'percent') {
                                                $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                            } else {
                                                $discount_cp = $coupon_data->coupon_value;
                                            }
                                            $discount = $discount + $discount_cp;
                                        }
                                    }
                                }
                            }
                            if ($coupon_data->type == 2) {
                                $product_ids = explode(',', $coupon_data->product_ids);
                                foreach ($product_ids as $product_id) {
                                    foreach ($cart_data as $g) {
                                        if ($product_id == $g->type_id) {
                                            $price = $g->price;
                                            if ($coupon_data->coupon_type == 'percent') {
                                                $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                            } else {
                                                $discount_cp = $coupon_data->coupon_value;
                                            }
                                            $discount = $discount + $discount_cp;
                                        }
                                    }
                                }
                            }
                            if ($coupon_data->type == 3) {
                                $product_ids = explode(',', $coupon_data->product_ids);
                                foreach ($product_ids as $product_id) {
                                    foreach ($cart_data as $g) {
                                        if ($product_id == $g->type_id) {
                                            $price = $g->price;
                                            if ($coupon_data->coupon_type == 'percent') {
                                                $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                            } else {
                                                $discount_cp = $coupon_data->coupon_value;
                                            }
                                            $discount = $discount + $discount_cp;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $store->coupon_id = $coupon_data->id;
                    $store->coupon_discount = $discount;
                    $final_total = $subtotal - $discount;
                    }

                }
                
                // #payment ---------------
                $store->payment_method = "cod";
                $store->sample_collection_address_id = $request->get("sample_collection_address_id");
                $store->date = $request->get("date");
                $store->time = $request->get("time");
                $store->subtotal = $subtotal;
                $store->visit_type = 0;
                $store->from_device = 'Admin';
                $store->manager_id = $member;
                $store->user_id = $request->get('userid');
                $store->orderplace_date = $this->getsitedate();
                $store->final_total = $final_total;
                $store->save();
                // dd($cart_data);
                $store1 = $cart_data;
                foreach ($store1 as $s) {
                    $mrp=0;
                    if ($s['type'] == 1) {
                        $item_data = Package::find($s['type_id']);
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
                    } else if ($s['type'] == 2) {
                        $item_data = Parameter::find($s['type_id']);
                        $mrp +=$item_data->mrp;
                        $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                    } else {
                        $item_data = Profiles::find($s['type_id']);
                        if ($item_data) {
                                 $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                                // $item_data->name = $item_data->profile_name;
                            }
                        $item_data->name = $item_data->profile_name;
                        $dis_pa = $this->get_discount($item_data->id,'Profile',$item_data->mrp);
                    }
                    $data = new OrdersData();
                    $data->order_id = $store->id;
                    $data->member_id = $member;
                    $data->family_member_id = $s['family_member_id'];
                    $data->item_id = $s['type_id'];
                    $data->type = $s['type'];
                    $data->item_name = $item_data->name;
                    $data->parameter = $s['parameter'];
                    $data->mrp = $mrp;
                    $price = $item_data->mrp;
                    $data->price = $price;
                    $data->save();

                }

                $response = array(
                    "status" => true,
                    "message" => "booking has been updated."
                );
        }
        return json_encode($response);
    }
    public function sampalboy_semple_collect(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'user_id' => 'required',
            'order_id' => 'required',
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'order_id.required' => 'order_id is required',
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
            try {
                $data = Orders::find($request->order_id);
                $data->sample_status = 2;
                $data->save();
                if ($data) {
                    $response = array(
                        "status" => true,
                        "message" => "The sample has been collected successfully"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "message" => "Somthing went wrong!"
                    );
                }
            } catch (\Exception $e) {
                $response = array(
                    "status" => false,
                    "message" => "Somthing went wrong!"
                );
            }

        }

        return json_encode($response);

    }
    public function applycoupon_sample(Request $request)
    {
        #------------------coupon----------------
        $cart_data =$request->book_test;
        
        $price = 0;
        $discount = 0;
        $coupon_data = Coupon::where('coupon_code',$request->coupon_code)->first();
        if(!$coupon_data){
          $response = array(
                "status" => false,
                "message" => "coupon not found!"
            );  
            return response()->json($response);
        }
        $discount =$this->applycoupononsample($cart_data,$coupon_data->id,$request->subTotal);
        if ($discount == 0) {
            $response = array(
                "status" => false,
                "discount" => $discount
            );
        } else {
            $response = array(
                "status" => true,
                "discount" => $discount

            );
        }

        return response()->json($response);

    }
    public function applycoupon_sample_v2(Request $request)
    {
        #------------------coupon----------------
        $cart_data =$request->book_test;
        Log::info($cart_data);
        $price = 0;
        $discount = 0;
        $coupon_data = Coupon::where('coupon_code',$request->coupon_code)->first();
        if(!$coupon_data){
          $response = array(
                "status" => false,
                "message" => "coupon not found!"
            );  
            return response()->json($response);
        }
        $discount =$this->applycoupononsample_v2($cart_data,$coupon_data->id,$request->subTotal);
        if ($discount == 0) {
            $response = array(
                "status" => false,
                "discount" => $discount
            );
        } else {
            $response = array(
                "status" => true,
                "discount" => $discount

            );
        }

        return response()->json($response);

    }
     public function show_reschedule_order_sample(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'date' => 'required',
            'time' => 'required',
            'remark' => 'required',
            'order_id'=>'required',
            'sm_boy_id'=>'required'
        ];

        $messages = array(
            'date.required' => "date is required",
            'time.required' => "time is required",
            'remark.required' => "remark is required",
            'order_id.required' => "order_id is required",
            'sm_boy_id.required' => "sm_boy_id is required",
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
        $setting = Setting::first();
        $data = Orders::find($request->order_id);
        $data->date = $request->date;
        $data->time = $request->time;
        $data->remark = $request->remark;
        $data->save();
        $msg = 'Order Rescheduled.';
        if ($data) {
            $notification = new Notification();
            $notification->user_id = $request->sm_boy_id;
            $notification->message = $msg;
            $notification->order_id = $data->id;
            $notification->app = "Sample_boy";
            $notification->save();
            $android = $this->send_notification_order_android($setting->sample_android_server_key, $request->get("sm_boy_id"), $msg, $data->id);
            $ios = $this->send_notification_order_ios($setting->sample_ios_server_key, $request->get("sm_boy_id"), $msg, $data->id);
        }
        $response = array(
                "status" => true,
                "message" => $msg,
                "data" => $data
            );
        }
         return response()->json($response);
    }
    public function cancle_order_sample(Request $request)
    {
        $response = array(
            "status" => false,
            "message" => "Validation error"
        );
        $rules = [
            'remark' => 'required',
            'order_id'=>'required',
            'sm_boy_id'=>'required'
        ];

        $messages = array(
            'remark.required' => "remark is required",
            'order_id.required' => "order_id is required",
            'sm_boy_id.required' => "sm_boy_id is required",
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
        $setting = Setting::first();
        $data = Orders::find($request->order_id);
        $data->sample_status = 5;
        $data->remark = $request->remark;
        $data->save();
        $msg = 'Order Cancled Admin will aprove.';
        $response = array(
                "status" => true,
                "message" => $msg,
                "data" => $data
            );
        }
         return response()->json($response);
    }
     public function send_notification_order_ios($key, $user_id, $msg, $id)
    {
        $getuser = Token::where("type", 2)->where('user_id', $user_id)->get();
        if (count($getuser) != 0) {
            $reg_id = array();
            foreach ($getuser as $gt) {
                $reg_id[] = $gt->token;
            }
            $registrationIds = $reg_id;
            $message = array(
                'message' => $msg,
                'key' => 'Booking',
                'title' => 'Booking Successfull',
                'order_id' => $id
            );
            $fields = array(
                'registration_ids' => $registrationIds,
                'data' => $message
            );

            $url = 'https://fcm.googleapis.com/fcm/send';
            $headers = array(
                'Authorization: key=' . $key, // . $api_key,
                'Content-Type: application/json'
            );
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

            if (isset($response) && $response['success'] > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }
    public function send_notification_order_android($key, $user_id, $msg, $id)
    {
        $getuser = Token::where("type", 1)->where('user_id', $user_id)->get();
        if (count($getuser) != 0) {
            $reg_id = array();
            foreach ($getuser as $gt) {
                $reg_id[] = $gt->token;
            }
            $reg_id[] ="ecMEM745Ri6ClL-pHYlx3y:APA91bGHI9NLEi132tsSk3WQhEc4_TyhPzc-k_Vxb7fW5-iKzHpKXVChUglOC6Jjli7TmGHcD41Tfuo1xNx5gMXk-trWhZmjzXF1ADlOfj3LswYmgcaYJG30NBg_vI04H2bJDN8h85Xt";
            $registrationIds = $reg_id;
            $message = array(
                'message' => $msg,
                'key' => 'Booking',
                'title' => 'Booking Successfull',
                'order_id' => $id
            );

            $fields = array(
                'registration_ids' => $registrationIds,
                'data' => $message
            );

            $url = 'https://fcm.googleapis.com/fcm/send';
            $headers = array(
                'Authorization: key=' . $key, // . $api_key,
                'Content-Type: application/json'
            );

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

            if (isset($response) && $response['success'] > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }
    
    
    // public function searchData(Request $request)
    // {

    //     $tags = $request->get("tags");

    //     $data1 = Package::whereNull('deleted_at')->Where('name', $tags)->first();
    //     if ($data1) {
    //         $result = $this->package_detail_search($data1->id);
    //         return $result;
    //     }
    //     $data2 = Profiles::whereNull('deleted_at')->Where('profile_name', $tags)->first();
    //     if ($data2) {
    //         $result = $this->profile_detail_search($data2->id);
    //         return $result;
    //     }
    //     $data21 = Profiles::whereNull('deleted_at')->Where('test_short_code', $tags)->first();
    //     if ($data21) {

    //         $result = $this->profile_detail_search($data21->id);
    //         return $result;
    //     }
    //     $data3 = Parameter::whereNull('deleted_at')->Where('name', $tags)->first();
    //     if ($data3) {
    //         $result = $this->parameter_detail_search($data3->id);
    //         return $result;
    //     }
    //     $data31 = Parameter::whereNull('deleted_at')->Where('test_short_code', $tags)->first();
    //     if ($data31) {
    //         $result = $this->parameter_detail_search($data31->id);
    //         return $result;
    //     }
    //     $response['status'] = "0";
    //     $response['msg'] = "oops! no data found";
    //     return $response;
    // }
    
    public function searchData(Request $request)
    {
        $tags = $request->get("tags");
        $results = [
            'Package' => [],
            'Profile' => [],
            'Parameter' => [],
        ];
    
        // Search in Package
        $packages = Package::whereNull('deleted_at')
            ->where('name', 'LIKE', "%{$tags}%")
            ->get();
    
        foreach ($packages as $package) {
            $results['Package'][] = $this->package_detail_search($package->id)['data']; // Collect package details
        }
    
        // Search in Profiles by profile_name
        $profilesByName = Profiles::whereNull('deleted_at')
            ->where('profile_name', 'LIKE', "%{$tags}%")
            ->get();
    
        foreach ($profilesByName as $profile) {
            $results['Profile'][] = $this->profile_detail_search($profile->id)['data']; // Collect profile details
        }
    
        // Search in Profiles by test_short_code
        $profilesByCode = Profiles::whereNull('deleted_at')
            ->where('test_short_code', 'LIKE', "%{$tags}%")
            ->get();
    
        foreach ($profilesByCode as $profile) {
            $results['Profile'][] = $this->profile_detail_search($profile->id)['data']; // Collect profile details
        }
    
        // Search in Parameter by name
        $parametersByName = Parameter::whereNull('deleted_at')
            ->where('name', 'LIKE', "%{$tags}%")
            ->get();
    
        foreach ($parametersByName as $parameter) {
            $results['Parameter'][] = $this->parameter_detail_search($parameter->id)['data']; // Collect parameter details
        }
    
        // Search in Parameter by test_short_code
        $parametersByCode = Parameter::whereNull('deleted_at')
            ->where('test_short_code', 'LIKE', "%{$tags}%")
            ->get();
    
        foreach ($parametersByCode as $parameter) {
            $results['Parameter'][] = $this->parameter_detail_search($parameter->id)['data']; // Collect parameter details
        }
    
        // If no data found
        if (empty($results['Package']) && empty($results['Profile']) && empty($results['Parameter'])) {
            return [
                'status' => "0",
                'msg' => "Oops! No data found",
            ];
        }
    
        // Return all results
        return [
            'status' => "1",
            'results' => array_filter($results), // Remove empty types
        ];
    }

    public function package_detail_search($id)
    {

        $package = Package::find($id);
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
            // $package->discount = number_format($total, '2', '.', '');
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
    
    public function profile_detail_search($id)
    {

        $package = Profiles::find($id);
        if ($package) {
            $arr = explode(",", $package->no_of_parameter);
            $ls = array();
            $i = 0;
            foreach ($arr as $a) {
                $k = array();
                $k['name'] = Parameter::find($a) ? Parameter::find($a)->name : '';
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
            foreach ($arr as $a) {
                    if ($i <= 3) {
                        $ls[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                    }
                    $i++;
                }
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
    
    public function parameter_detail_search($id)
    {

        $package = Parameter::find($id);
        if ($package) {
            $package->frqlist = Package_FRQ::select('question', 'ans')->where("package_id", $package->id)->where("type", '3')->get();
            $package->review = Review::select('user_id', 'ratting', 'date', 'description')->where("type", '3')->where("type_id", $package->id)->get();
            foreach ($package->review as $r) {
                $r->username = User::find($r->user_id) ? User::find($r->user_id)->name : '';
                $r->profile_pic = User::find($r->user_id) ? User::find($r->user_id)->profile_pic : '';
            }
            $total = 100 * ($package->mrp - $package->price) / $package->mrp;
            // $package->discount = number_format($total, '2', '.', '');
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


}