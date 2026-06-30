<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DateTimeZone;
use Image;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Storage;
use App\Models\Setting;
use App\Models\Token;
use App\Models\TestDetails;
use DateTime;
use Auth;
use DB;
use App\Models\FamilyMember;
use App\Models\Package;
use App\Models\OrdersData;
use App\Models\User;
use App\Models\Profiles;
use App\Models\Coupon;
use App\Models\Parameter;
use App\Models\CartMember;
use App\Models\Discountid;
use App\Models\Discount;
use Carbon\Carbon;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     public $currentDate;
     public function __construct()
    {
         $this->currentDate = Carbon::now();

    }
    
    public function sendSms($to, $data, $templateName)
    {  
        // Prepare the message
        try {
            // $to = 6367289664; 
            $templateNamedata = DB::table('sms_templates')->where('templete_name',$templateName)->first();
            
            if($templateNamedata){
            $message = $templateNamedata->sms;
                foreach ($data as $key => $value) {
                $message = str_replace('{' . $key . '}', $value, $message);
            }
           
            // API request parameters
            $params = [
                'username' => env('username'),
                'password' => env('password'),
                'unicode'  => 'false',
                'from'     => env('from'),
                'to'       => $to,
                'dltPrincipalEntityId' => env('dltPrincipalEntityId'),
                'dltContentId' => $templateNamedata->template_id,
                'text'     => $message,
            ];
    
            // Make the API request
            $response = Http::get(env('url'), $params);
    
            // Check if the request was successful
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'SMS sent successfully',
                    'response' => $response->json(),
                ]);
            }
    
            // Handle the error
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send SMS',
                'details' => $response->body(),
            ], 500);
           }
        
        } catch (Exception $e) {
            // Catch and handle any exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while sending the SMS',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    public static function sendNotification($id, $msg, $title, $key, $image = false, $notificationId = null)
    {
        $ONESIGNAL_APP_ID = '079a2107-0b13-4687-b48e-7e4a9d9b50c4';
        $ONESIGNAL_REST_API_KEY = 'OTk4YzMwNGEtNDNkYi00NDE3LTg4NTItNWE4NTAwMzAyOTgz';
        
        // Validate the user ID (UUID format check)
        if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $id)) {
            Log::error('Invalid player ID format: ' . $id);
            return;
        }
    
        $data = [
            'app_id' => $ONESIGNAL_APP_ID,
            'contents' => [
                'en' => $msg,
            ],
            'headings' => [
                'en' => $title,
            ],
            'sound' => 'default',
            'ios_sound' => 'default',
            'badge' => '1',
            'ios_badgeType' => 'Increase',
            'ios_badgeCount' => 1,
            'data' => [
                'notificationId' => $notificationId,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ],
            'large_icon' => $image,
            'ios_attachments' => [
                'id' => $image,
            ],
            'priority' => 10,
            'include_player_ids' => [$id], // Single player ID in an array
        ];
    
        // Send the notification via OneSignal API
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $ONESIGNAL_REST_API_KEY,
            'Content-Type' => 'application/json',
        ])->post('https://onesignal.com/api/v1/notifications', $data);
    
        // Log the response for debugging
        Log::info($response->json());
    }

    public function base64uploadFileImage(Request $request, $uploadFolderName, $inputFileName){
       // dd($request);
        $img = $request->get($inputFileName);
        // dd($img);
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $fname= uniqid() . '.png';
        $file = Storage_path("app/public/".$uploadFolderName).'/' .$fname;
        $success = file_put_contents($file, $data);        
        return $fname;
    }
    protected function removeImage($image_path)
    {
        $image_path = Storage_path().'/app/public/'.$image_path;
        if(file_exists($image_path)){
            unlink($image_path);
        }        
    }
    public function get_discount($test_id,$type,$mrp){
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
    public function gettotalcartmember(){
        $totalcartmember = count(DB::table('cart_member')
                 ->select('cart_member.family_member_id')
                 ->join('family_member', 'family_member.id', '=', 'cart_member.family_member_id')    
                 ->where("cart_member.user_id",Auth::id())             
                 ->groupBy('cart_member.family_member_id') 
                 ->get());
        return $totalcartmember;
    }

    public function getcartcontent(){
        $data=DB::table('cart_member')
                 ->select('cart_member.family_member_id')
                 ->join('family_member', 'family_member.id', '=', 'cart_member.family_member_id')    
                 ->where("cart_member.user_id",Auth::id())             
                 ->groupBy('cart_member.family_member_id') 
                 ->get();
               $ls1 = array();
              if(count($data)>0){
                   
                    foreach($data as $g){
                        $arr = array();
                        $getfamilyinfo = FamilyMember::find($g->family_member_id);
                        $arr['member_id'] = $g->family_member_id;
                        $arr['member_name'] = $getfamilyinfo->name;
                        $arr['relation'] = $getfamilyinfo->relation;
                        $arr['gender'] = $getfamilyinfo->gender;
                        $arr['age'] = $getfamilyinfo->age;
                        $getcartinfo = CartMember::where("user_id",Auth::id())->where("family_member_id",$g->family_member_id)->get();
                        foreach($getcartinfo as $g){
                            $mrp =0;
                            $b = array();
                            if($g->type==1){
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
                            }else if($g->type==2){
                                $item_data = Parameter::find($g->type_id);
                                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                                $mrp +=$item_data->mrp;
                                $mrpg = $item_data->mrp;
                                $price = $item_data->price;
                                $item_data->mrp = (int)$price;
                                $item_data->price = $mrpg;
                            }else{
                                $item_data = Profiles::find($g->type_id);
                                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                                if($item_data){
                                    // dd($item_data->no_of_parameter);
                                    $al = explode(",", $item_data->no_of_parameter);
                                    foreach ($al as $a) {
                                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                                    }
                                    
                                    $item_data->name = $item_data->profile_name;
                                    
                                }
                            }
                            $b['test_name'] = isset($item_data->name)?$item_data->name:'';
                            $b['mrp'] = isset($item_data->mrp)?$item_data->mrp:'';
                            $b['price']= $mrp;
                            $b['parameter']=$g->parameter;
                            $b['type']=$g->type;
                            $b['discount'] = $dis_pa;
                            $b['id']=$g->id;
                            $b['type_id']=$g->type_id;
                            $arr['testdata'][]=$b;
                        }
                        $ls1[] = $arr;
                    }
                }
                // dd($ls1);
                return $ls1;
    }
    public function getordercontent($order_id){
        $data = OrdersData::where('order_id', $order_id)->get();
        $ls1 = array();
    
        if (count($data) > 0) {
            foreach ($data as $g) {
                $b = array();
                if ($g->type == 1) {
                    $item_data = Package::find($g->item_id);
                    $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                } else if ($g->type == 2) {
                    $item_data = Parameter::find($g->item_id);
                    $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                } else {
                    $item_data = Profiles::find($g->item_id);
                    if ($item_data) {
                        $item_data->name = $item_data->profile_name; // Change 'name' to 'test_name'
                    }
                    $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                }
                $b['discount'] = $dis_pa;
                // Check if $item_data is not null before accessing its properties
                $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                $b['mrp'] = isset($g->mrp) ? $g->mrp : '';
                if($dis_pa['fixed'] > 0.00 ) {
                $per = $dis_pa['per'];
                $price = $g->mrp - $dis_pa['fixed'];
                }else{
                $price = $g->mrp;
                }
                $b['price'] = $price;
                // $b['price'] = isset($g->price) ? $g->price : '';
                $b['parameter'] = $g->parameter;
                $b['type'] = $g->type;
                $b['id'] = $g->id;
                $b['type_id'] = $g->item_id;
                $b['order_id'] = $g->order_id;
                $b['item_id'] = $g->item_id;
                $getfamilyinfo = FamilyMember::find($g->family_member_id);
                $b['member_id'] = $g->family_member_id;
                $b['member_name'] = isset($getfamilyinfo->name)?$getfamilyinfo->name:"";
                $b['relation'] = isset($getfamilyinfo->relation)?$getfamilyinfo->relation:'';
                $b['gender'] = isset($getfamilyinfo->gender)?$getfamilyinfo->gender:'';
                $b['age'] = isset($getfamilyinfo->age)?$getfamilyinfo->age:'';;
                
                $ls1[] = $b; // Append $b to $ls1, not overwriting it
            }
        }
        
        return $ls1;
    }
    
    public function getcartsubtotal(){
      $data=CartMember::where("user_id",Auth::id())->get();
      $total = 0;
      if(count($data)>0){
            foreach($data as $g){
                $b = array();
                if($g->type==1){
                    $item_data = Package::find($g->type_id);
                    $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                }else if($g->type==2){
                    $item_data = Parameter::find($g->type_id);
                    $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                }else{
                    $item_data = Profiles::find($g->type_id);
                    if($item_data){
                        $item_data->name = $item_data->profile_name;
                    }
                    $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                }
                $discount =0;
                if($dis_pa['fixed'] > 0.00 ) {
                $per = $dis_pa['per'];
                $discount = $item_data->mrp - $dis_pa['fixed'];
                }else{
                $discount = $item_data->mrp ;
                }
                
                // $price= isset($item_data->price)?$item_data->price:'';
                $price = $item_data->mrp;
                $total = $total+$price;                            
            }
        }
        return $total;
    }

    public function fileuploadFileImage(Request $request, $uploadFolderName, $inputFileName){
        $image     = $request->file($inputFileName);
        $fileName  = time().rand() . '.' . $image->getClientOriginalExtension();
       
        $img = Image::make($image->getRealPath());
        $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();                 
        });
        $img->stream(); 
        Storage::disk('local')->put('/public/'.$uploadFolderName.'/'.$fileName, $img, 'public');
        return $fileName;
    }
    public function fileuploadFileImageblod(Request $request, $uploadFolderName, $inputFileName){
        $image     = $request->file($inputFileName);
        $fileName  = time().rand() . '.' . $image->getClientOriginalExtension();
       
        $img = Image::make($image->getRealPath());
        $img->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();                 
        });
        $img->stream(); 
        Storage::disk('local')->put('/public/'.$uploadFolderName.'/'.$fileName, $img, 'public');
        return $fileName;
    }


    public function send_notification_order_android($key,$user_id,$msg,$order_id){
          $getuser=Token::where("type","1")->where("user_id",$user_id)->get();
            if(count($getuser)!=0){               
                $reg_id = array();
                foreach($getuser as $gt){
                   $reg_id[]=$gt->token;
                }
                $regIdChunk=array_chunk($reg_id,1000);
                foreach ($regIdChunk as $k) {
                       $registrationIds =  $k;    
                        $message = array(
                            "type"=>'order',
                            "click_action"=>"FLUTTER_NOTIFICATION_CLICK", "order_id"=> $order_id
                          );
                        $message1 = array(
                            'body' => $msg,
                            'title' =>  __('admin.Notification')
                        );
                       $fields = array(
                          'registration_ids'  => $registrationIds,
                          'data'              => $message,
                          'notification'=>$message1
                       );

                       $url = 'https://fcm.googleapis.com/fcm/send';
                       $headers = array(
                         'Authorization: key='.$key,// . $api_key,
                         'Content-Type: application/json'
                       );
                      $json =  json_encode($fields);   
                      $ch = curl_init();
                      curl_setopt($ch, CURLOPT_URL, $url);
                      curl_setopt($ch, CURLOPT_POST, true);
                      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                      curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
                      $result = curl_exec($ch);   
                      if ($result === FALSE){
                         die('Curl failed: ' . curl_error($ch));
                      }     
                     curl_close($ch);
                     $response[]=json_decode($result,true);
               }
              $succ=0;
               if($response){
                 foreach ($response as $k) {
                    if(isset($k['success'])){
                      $succ=$succ+$k['success'];
                    }
                    
                 }
              }
             if($succ>0)
              {
                   return 1;
              }
               {
                  return 0;
               }
        }
        return 0;
   }
   public function send_notification_order_IOS($key,$user_id,$msg,$order_id){
      $getuser=Token::where("type","2")->where("user_id",$user_id)->get();
         if(count($getuser)!=0){               
               $reg_id = array();
               foreach($getuser as $gt){
                   $reg_id[]=$gt->token;
               }
                 $regIdChunk=array_chunk($reg_id,1000);
               foreach ($regIdChunk as $k) {
                       $registrationIds =  $k;    
                       $message = array(
                            "type"=>'order',
                            "click_action"=>"FLUTTER_NOTIFICATION_CLICK", "order_id"=> $order_id
                          );
                       $message1 = array(
                            'body' => $msg,
                            'title' =>  __('admin.Notification')
                        );
                       $fields = array(
                          'registration_ids'  => $registrationIds,
                          'data'              => $message,
                          'notification'=>$message1
                       );
                       $url = 'https://fcm.googleapis.com/fcm/send';
                       $headers = array(
                         'Authorization: key='.$key,// . $api_key,
                         'Content-Type: application/json'
                       );
                      $json =  json_encode($fields);   
                      $ch = curl_init();
                      curl_setopt($ch, CURLOPT_URL, $url);
                      curl_setopt($ch, CURLOPT_POST, true);
                      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                      curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
                      $result = curl_exec($ch);   
                      if ($result === FALSE){
                         die('Curl failed: ' . curl_error($ch));
                      }     
                     curl_close($ch);
                     $response[]=json_decode($result,true);
               }
              $succ=0;
              if($response){
                 foreach ($response as $k) {
                   if(isset($k['success'])){
                      $succ=$succ+$k['success'];
                    }
                 }
              }
              
             if($succ>0)
              {
                   return 1;
              }
            else
               {
                  return 0;
               }
        }
        return 0;
   }

    public function getsitedate(){
            $setting=Setting::find(1);
            $date_zone=array();
            $timezone=$this->generate_timezone_list();
                foreach($timezone as $key=>$value){
                      if($setting->default_timezone==$key){
                              $date_zone=$value;
                      }
                }
            // date_default_timezone_set($date_zone);   
            return date('d-m-Y h:i:s');                    
     }

      public function getsitedateonly(){
            $setting=Setting::find(1);
            $date_zone=array();
            $timezone=$this->generate_timezone_list();
                foreach($timezone as $key=>$value){
                      if($setting->default_timezone==$key){
                              $date_zone=$value;
                      }
                }
            // date_default_timezone_set($date_zone);   
            return date('Y-m-d');                    
     }

      static public function generate_timezone_list(){
          static $regions = array(
                     DateTimeZone::AFRICA,
                     DateTimeZone::AMERICA,
                     DateTimeZone::ANTARCTICA,
                     DateTimeZone::ASIA,
                     DateTimeZone::ATLANTIC,
                     DateTimeZone::AUSTRALIA,
                     DateTimeZone::EUROPE,
                     DateTimeZone::INDIAN,
                     DateTimeZone::PACIFIC,
                 );
                  $timezones = array();
                  foreach($regions as $region) {
                            $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
                  }

                  $timezone_offsets = array();
                  foreach($timezones as $timezone) {
                       $tz = new DateTimeZone($timezone);
                       $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
                  }
                 asort($timezone_offsets);
                 $timezone_list = array();
    
                 foreach($timezone_offsets as $timezone=>$offset){
                          $offset_prefix = $offset < 0 ? '-' : '+';
                          $offset_formatted = gmdate('H:i', abs($offset));
                          $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
                          $timezone_list[] = "$timezone";
                 }

                 return $timezone_list;
                ob_end_flush();
       }

       public function gettimezonename($timezone_id){
              $getall=$this->generate_timezone_list();
              foreach ($getall as $k=>$val) {
                 if($k==$timezone_id){
                     return $val;
                 }
              }
       }
    public function applycoupononcoustomer($userId,$id,$subtotalcp){
           $cart_data = CartMember::where("user_id", $userId)->get();

        foreach ($cart_data as $g) {

            if ($g->type == 1) {
                $item_data = Package::find($g->type_id);
                  $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
            } else if ($g->type == 2) {
                $item_data = Parameter::find($g->type_id);
                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                $mrpg = $item_data->mrp;
                $price = $item_data->price;
                $item_data->mrp = $price;
                $item_data->price = $mrpg;
            } else {
                $item_data = Profiles::find($g->type_id);
                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                if ($item_data) {
                    $item_data->name = $item_data->profile_name;
                }
            }
            $priced =$item_data->mrp;
            if($dis_pa['fixed'] > 0.00 ) {
                $per = $dis_pa['per'];
                $priced = $item_data->mrp - $dis_pa['fixed'];
                }else{
                $priced = $item_data->mrp ;
                }
            $g['price'] = $priced;

        }

        $price = 0;
        $discount = 0;
        $coupon_data = Coupon::find($id);

        $today = date('l');
        $days = explode(',', $coupon_data->day);
        foreach ($days as $dy) {
            if ($dy == $today) {

                if ($coupon_data->type == 4) {
                    $price = $subtotalcp;
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
        return $discount;

    }
    public function applycoupononsample($cart_data,$id,$subtotalcp){
        
        foreach ($cart_data as &$g) {
            
            if ($g['type'] == 1) {
                $item_data = Package::find($g['type_id']);
                  $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
            } else if ($g['type'] == 2) {
                $item_data = Parameter::find($g['type_id']);
                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                $mrpg = $item_data->mrp;
                $price = $item_data->price;
                $item_data->mrp = $price;
                $item_data->price = $mrpg;
            } else {
                $item_data = Profiles::find($g['type_id']);
                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                if ($item_data) {
                    $item_data->name = $item_data->profile_name;
                }
            }
            $priced =$item_data->mrp;
            
            $g['price'] = $priced;

        }

        $price = $subtotalcp;
        $discount = 0;
        $coupon_data = Coupon::find($id);

        $today = date('l');
        $days = explode(',', $coupon_data->day);
        foreach ($days as $dy) {
            if ($dy == $today) {

                if ($coupon_data->type == 4) {
                    
                    
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
        return $discount;

    }
}
