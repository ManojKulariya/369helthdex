<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use validate;
use Sentinel;
use DB;
use DataTables;
use App\Models\Orders;
use DateTime;
use PaytmWallet;
use Razorpay\Api\Api;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use DateInterval;
use App\Models\TokenData;
use App\Models\User;
use Mail;
use App\Models\PaymentGatewayDetail;
class MakePaymentController extends Controller
{

    public function show_make_payment($id){         
        $data = Orders::find($id);
        $amount = $data->final_total; 
        $arr = array();
        $data1 = PaymentGatewayDetail::all();       
        foreach ($data1 as $k) {
            $arr[$k->gateway_name."_".$k->key] = $k->value;
        } 
        $token = "";
        if(isset($arr['braintree_is_active'])&&$arr['braintree_is_active']=='1'){
            $gateway = new \Braintree\Gateway([
                   'environment' => $arr['braintree_environment'],
                   'merchantId' => $arr['braintree_merchant_id'],
                   'publicKey' => $arr['braintree_public_key'],
                   'privateKey' => $arr['braintree_private_key']
            ]);
            $token=$gateway->ClientToken()->generate();
         }
         return view("payment")->with("data",$data)->with("paymentdetail",$arr)->with("braintree_token",$token)->with("amount",$amount);
    }

    public function payment_success(){
       return view('payment_success');
    }

    public function payment_failed(){
        return view('payment_failed');
    }

    public function save_braintree(Request $request){
       $data1 = PaymentGatewayDetail::where("gateway_name","braintree")->get();
       if(count($data1)>0){
             $arr = array(); 
            foreach ($data1 as $k) {
               $arr[$k->gateway_name."_".$k->key] = $k->value;
            }
              $gateway = new \Braintree\Gateway([
                         'environment' => $arr['braintree_environment'],
                         'merchantId' => $arr['braintree_merchant_id'],
                         'publicKey' => $arr['braintree_public_key'],
                         'privateKey' => $arr['braintree_private_key']
              ]);
              $amount = $request->get("amount");
              $nonce = $request->get("payment_method_nonce");

              $result = $gateway->transaction()->sale([
                  'amount' => $amount,
                  'paymentMethodNonce' => $nonce,
                  'options' => [
                      'submitForSettlement' => true
                  ]
              ]);
              if ($result->success) {
                    $transaction = $result->transaction;                            
                    $data = Orders::find($request->get('id'));
                    $data->payment_method="braintree";
                    $data->token=$transaction->id;
                    $data->is_completed='1';
                    $data->save();
                    return redirect()->route('payment-success');
              } else {
                  $errorString = "";
                  foreach($result->errors->deepAll() as $error) {
                      $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                  }
                  return redirect()->route('payment-failed');
              }
       }else{
           return redirect()->route('payment-failed');
       }
   }

   public function razor_payment(Request $request){    
       
        $data = Orders::find($request->get('id'));
        $amount = $data->final_total;      
        $data1 = PaymentGatewayDetail::where("gateway_name","razorpay")->get();
        // dd(count($data1));
        if(count($data1)>0){
           
         $arr = array(); 
           foreach ($data1 as $k) {
              $arr[$k->gateway_name."_".$k->key] = $k->value;
           }
           
           $input = $request->all();  
            
           $api = new Api($arr['razorpay_razorpay_key'],$arr['razorpay_razorpay_secert']);
            //   dd($arr['razorpay_razorpay_key']);
        //   $payment = $api->payment->fetch($request->razorpay_payment_id);
        
        
           if($request->razorpay_payment_id)
           {
                
              try 
              {
                 
                    $data->payment_method="razorpay";
                    $data->token=$request->razorpay_payment_id;
                    $data->is_completed='1';
                    $data->save();
                    Session::flash('message', __('message.Test Book Successfully'));
                    Session::flash('alert-class', 'alert-success');
                    return redirect('user_dashboard');
                    // return redirect()->route('payment-success');
                    //  dd($data);
                  
              }
              catch (\Exception $e) 
              {
                  return redirect()->route('payment-failed');
              }           
           }
       }else{
           echo 'F';
            // return redirect()->route('payment-failed');
       }
      
   }


   public function show_paystack_payment(Request $request){        
        $data1 = PaymentGatewayDetail::where("gateway_name","paystack")->get();        
        $data = Orders::find($request->get('id'));
        $amount = (int)$data->final_total;        
        $arr = array(); 
          foreach ($data1 as $k) {
            $arr[$k->gateway_name."_".$k->key] = $k->value;
          }
        $curl = curl_init();
          $email = 'admin@gmail.com';
          $callback_url = route('paystackcallback');
          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
              'amount'=>$amount,
              'email'=>$email,
              'callback_url' => $callback_url
            ]),
            CURLOPT_HTTPHEADER => [
              "authorization: Bearer ".$arr['paystack_secert_key']."", 
              "content-type: application/json",
              "cache-control: no-cache"
            ],
          ));
          $response = curl_exec($curl);
          $err = curl_error($curl);
          if($err){
            die('Curl returned error: ' . $err);
          }
            $tranx = json_decode($response, true);    
            //echo "<pre>";print_r($tranx);exit;
            $data1 = Orders::find($request->get('id'));
            $data1->payment_method="paystack";           
            $data1->token=$tranx['data']['reference'];
            $data1->is_completed='0';
            $data1->save();  
           
             if(!$tranx['status']){
               print_r('API returned error: ' . $tranx['message']);
             }
             return Redirect($tranx['data']['authorization_url']);
   }

    public function paystackcallback(Request $request){      
      $data1 = PaymentGatewayDetail::where("gateway_name","paystack")->get();
      
      $arr = array(); 
      foreach ($data1 as $k) {
            $arr[$k->gateway_name."_".$k->key] = $k->value;
      }
      $curl = curl_init();
        $reference = $request->get("reference");
        if(!$reference){
          die('No reference supplied');
        }
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Bearer ".$arr['paystack_secert_key']."", 
            "cache-control: no-cache"
          ],
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err){
         return redirect()->route('payment-failed');
        }
        $tranx = json_decode($response);
        if(!$tranx->status){
         return redirect()->route('payment-failed');
        }
        if('success' == $tranx->data->status){
                           
                                $data = Orders::where("token",$reference)->first();                               
                                $data->payment_method="paystack";
                                $data->token=$reference;
                                $data->is_completed='1';
                                $data->save();
                               
                           
            return redirect()->route('payment-success');
        }else{ //fail
            return redirect()->route('payment-failed');
        }
    }


    public function show_rave_payment(Request $request){
       // dd($request->all());
        $reference = Flutterwave::generateReference();
        $data1 = PaymentGatewayDetail::where("gateway_name","rave")->get();
          $arr = array(); 
          foreach ($data1 as $k) {
                $arr[$k->gateway_name."_".$k->key] = $k->value;
          }
        
            $data1 = Orders::find($request->get('id'));
            $userinfo = User::find($data1->user_id);
            $data = [
                        'payment_options' => 'card,banktransfer',
                        'amount' => $data1->final_total,
                        'email' => $userinfo->email,
                        'tx_ref' => $reference,
                        'currency' => $arr['rave_currency'],
                        'redirect_url' => route('rave-callback'),
                        'customer' => [
                            'email' => $userinfo->email,
                            "phonenumber" => $userinfo->phone,
                            "name" => $userinfo->name
                        ],
            
                        "customizations" => [
                            "title" => 'Order Payment',
                            "description" => "Order Payment"
                        ]
            ];
        
         
        
       
       
          


        $payment = Flutterwave::initializePayment($data);  
       
        
            $data = Orders::find($request->get('id'));
            $data->token=$reference;
            $data->is_completed='0';
            $data->save(); 
       
        if ($payment['status'] !== 'success') {
            return redirect()->route('payment-failed');
        }

        return redirect($payment['data']['link']);
        
    }


    public function rave_callback(Request $request){
        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);
        $data1 = Orders::where("token",$data['data']['tx_ref'])->first();
        $data1->is_completed = '1';
        $data1->save();       
        return redirect()->route('payment-success');
    }

    public function store_paytm_data(Request $request){       
      $data1 = PaymentGatewayDetail::where("gateway_name","paytm")->get();
      $arr = array(); 
      foreach ($data1 as $k) {
            $arr[$k->gateway_name."_".$k->key] = $k->value;
      }

            $data = Orders::find($request->get('id'));
            $user = User::find($data->user_id);
            $input['order_id'] = uniqid();
            $input['fee'] = $data->final_total;
            $payment = PaytmWallet::with('receive');
            // $payment->prepare([
            //     'order' => $data->id,
            //     'user' => $user->name,
            //     'mobile_number' => '9904444091',
            //     'email' => $user->email,
            //     'amount' => $input['fee'],
            //     'callback_url' => route('paytmstatus')
            // ]);     

            $payment->prepare([
          'order' => $data->id,
          'user' => 'redixbit',
          'mobile_number' => '9904444091',
          'email' => 'redixbit.user10@gmail.com',
          'amount' => $input['fee'],
          'callback_url' => route('paytmstatus')
        ]);   


        
        return $payment->receive();
    }

    public function paymentpaytmCallback(Request $request){
       
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
        $data = Orders::find($order_id);
        if($transaction->isSuccessful()){
            $data->payment_method="paystack";
            $data->token=$transaction->getTransactionId();
            $data->is_completed='1';
            $data->save();
            return redirect()->route('payment-success');
        }else if($transaction->isFailed()){
            return redirect()->route('payment-failed');
        }
    }
    
    public function send_notification_android($key,$msg,$id,$field,$order_id){
        $getuser=TokenData::where("type",1)->where($field,$id)->get();
        
        $i=0;
        if(count($getuser)!=0){   

               $reg_id = array();
               foreach($getuser as $gt){
                   $reg_id[]=$gt->token;
               }
               $regIdChunk=array_chunk($reg_id,1000);
               foreach ($regIdChunk as $k) {
                       $registrationIds =  $k;    
                        $message = array(
                            'message' => $msg,
                            'title' =>  __('message.notification')
                          );
                        $message1 = array(
                            'body' => $msg,
                            'title' =>  __('message.notification'),
                            'type'=>$field,
                            'order_id'=>$order_id,
                            'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
                        );
                        //echo "<pre>";print_r($message1);exit;
                       $fields = array(
                          'registration_ids'  => $registrationIds,
                          'data'              => $message1,
                          'notification'      =>$message1
                       );
                       
                      // echo "<pre>";print_r($fields);exit;
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
                      //echo "<pre>";print_r($result);exit;
                      if ($result === FALSE){
                         die('Curl failed: ' . curl_error($ch));
                      }     
                     curl_close($ch);
                     $response[]=json_decode($result,true);
               }
              $succ=0;
               foreach ($response as $k) {
                  $succ=$succ+$k['success'];
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
    public function send_notification_IOS($key,$msg,$id,$field,$order_id){
      $getuser=TokenData::where("type",2)->where($field,$id)->get();
         if(count($getuser)!=0){               
               $reg_id = array();
               foreach($getuser as $gt){
                   $reg_id[]=$gt->token;
               }
                
              $regIdChunk=array_chunk($reg_id,1000);
               foreach ($regIdChunk as $k) {
                       $registrationIds =  $k;    
                       $message = array(
                            'message' => $msg,
                            'title' =>  __('message.notification')
                          );
                        $message1 = array(
                            'body' => $msg,
                            'title' =>  __('message.notification'),
                            'type'=>$field,
                            'order_id'=>$order_id,
                            'click_action'=>'FLUTTER_NOTIFICATION_CLICK'
                        );
                       $fields = array(
                          'registration_ids'  => $registrationIds,
                          'data'              => $message1,
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
               foreach ($response as $k) {
                  $succ=$succ+$k['success'];
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



}
