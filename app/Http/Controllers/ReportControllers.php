<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DataTables;
use Session;
use Auth;
use App\Models\Setting;
use Hash;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class ReportControllers extends Controller
{
    public function show_login(){
        $setting = Setting::find(1);
        return view("front.reportlogin")->with('title','Download Report')->with('setting',$setting);
    }
    
    public function check_login(Request $request)
	{
		/**LOGIN */
		$method = "POST";
		$in = array();
		$in =$request->all();
		$postdata = array('objSP' => $in);
		$postdata = json_encode($postdata);
		$url = "http://elabcorpsupport.elabassist.com/services/globaluserservice.svc/UserRegistration";

		$result = $this->callAPI($method, $url, $postdata);
		$returnval = $result;

		$result = json_decode($result, true);
		$result = $result["d"];
		if ($result["Result"] == "Success") {
		    session(['some_name' => $result]);
		} else {
			return redirect()->route('home');
			
		}
		echo $returnval;

	}
	public function check_login_api(Request $request)
	{   
	    $num = $request->get("phone");
            if($num == ''){
            return response()->json(['success' => false, 'msg' => 'please enter mobile no!']);
            }
	   // $num = 6367289664;
	   // $num = 7976526802;
	    $in = ['UserName'=> $num,
                'Password'=> $num,
                'Task'=> 3,
                'AppID'=> "4bee96ca-3ea8-4e89-a575-04d2beed400c"];
		$method = "POST";
// 		$in = array();
// 		$in =$request->all();
		$postdata = array('objSP' => $in);
		$postdata = json_encode($postdata);
		$url = "http://elabcorpsupport.elabassist.com/services/globaluserservice.svc/UserRegistration";

		$result = $this->callAPI($method, $url, $postdata);
		$returnval = $result;

		$result = json_decode($result, true);
		$result = $result["d"];
		
		if ($result["Result"] == "Success") {
		  //  dd($result);
            return response()->json(['success' => true,'data'=>$result, 'msg' => 'Reports Get successfuly!']);
		} else {
            return response()->json(['success' => false,'msg' =>'Reports Not Found!']);
		}
		

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
	 public function otpsend(Request $request)
    {
            
            $url = 'https://msg.smsguruonline.com/fe/api/v1/send?';
            $user = 'Healthwave';
            $password = 'XVGY7XU1';
            $msisdn = $request->get("phone");
            if($msisdn == ''){
                
            return response()->json(['success' => false, 'msg' => 'please enter mobile no!']);
            }
            $sid = 'RDCPLR';
            $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            
            if($msisdn == 6367289664 || $msisdn == 9799983646 || $msisdn == 7976526802 || $msisdn == 9166700355 || $msisdn == 8523697412){
                $otp = 1234;
            }
            // log::info($otp);
            session(['report_otp' => $otp]);
            $msg = 'Your OTP for 369 HealthDex login is ' . $otp . ' Do not share this code with anyone. Team 369 HealthDex.';
            $fl = '0';
            $gwid = '2';
            $response = Http::get($url, [
                'username' => '369healthdex.trans',
                'password' => 'DBLD2',
                'to' => $msisdn,
                'from' => 'HLTHDX',
                'text' => $msg,
                'dltPrincipalEntityId' => 1701176959781053032,
                'dltContentId' => 1707176967358120748,
                'unicode' => false  // corrected this line
            ]);
        
        
            return response()->json(['success' => true,'otp'=>$otp, 'msg' => 'otp send successfuly!']);
        
    }
     public function otp_verify(Request $request)
    {
        $otp = $request->input('otp');
        if (session('report_otp') == $otp) {
            session()->forget('report_otp');
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function show_reports(){
        
		if (session('some_name')) {
			$user = session('some_name');
			$method = "POST";
			$postdata = [
				"UserFID" => $user["UserFID"],
				"LabID" => env('REPORT_LAB_ID'), // TEST_LAB_ID
				"FromDate" => "",
				"ToDate" => "",
				"LabCode" => "",
				"PatientName" => "",
				"UserType" => "1",
				"EntityId" => 0,
				"EntityTypeId" => 0,
			];
			$postdata = json_encode($postdata);
			$url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/TestReportList";
			$result = $this->callAPI($method, $url, $postdata);
			$result = json_decode($result, true);
			$data["reportlist"] = $result["d"];
// 			dd($data["reportlist"]);
			$setting = Setting::find(1);
			return view("front.report_list")->with('data',$data)->with('title','Patient Report With Details')->with('setting',$setting);
		} else {
			return redirect()->route('reliable-report');
		}
    }
    public function show_reports_api(Request $request){
    $UserFID = $request->get("UserFID");
    
    if ($UserFID != '') {
        $method = "POST";
        $postdata = [
            "UserFID" => $UserFID,
            "LabID" => env('REPORT_LAB_ID'),
            "FromDate" => "",
            "ToDate" => "",
            "LabCode" => "",
            "PatientName" => "",
            "UserType" => "1",
            "EntityId" => 0,
            "EntityTypeId" => 0,
        ];
        $postdata = json_encode($postdata);
        $url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/TestReportList";
        $result = $this->callAPI($method, $url, $postdata);
        $result = json_decode($result, true);

        // ✅ Guard: check if API response and "d" key are valid
        if (!$result || !isset($result["d"]) || !is_array($result["d"])) {
            return response()->json(['success' => false, 'msg' => 'Invalid or empty response from report server.']);
        }

        $reportlist = $result["d"];
        $reports = [];

        foreach ($reportlist as $row) {
            $reports[] = [
                'PatientName'         => $row['PatientName'] ?? '',
                'TestRegnID'          => $row['TestRegnID'] ?? '',
                'BalanceAmt'          => $row['BalanceAmt'] ?? '',
                'RegnDateTimeString'  => $row['RegnDateTimeString'] ?? '',
                'SelectedTest'        => $row['SelectedTest'] ?? '',
                'Net'                 => $row['Net'] ?? '',
                'AmountPaid'          => $row['AmountPaid'] ?? '',
            ];
        }

        return response()->json(['success' => true, 'data' => $reports, 'msg' => 'Reports fetched successfully!']);
    } else {
        return response()->json(['success' => false, 'msg' => 'Please enter UserFID']);
    }
}
    public function getPatientReport(Request $request)
    {
        $labID = "4bee96ca-3ea8-4e89-a575-04d2beed400c";
        // $testRegnID ='1125365' ;
        $testRegnID = $request->testRegnID;
        // Check if TestRegnID is valid
        if ($testRegnID > 0 || $testRegnID != "") {
            
                // Make the GET request to the external service
                $response = Http::get('http://reliable.elabassist.com/Services/Test_RegnService.svc/GetReleaseTestReport_Global', [
                    'LabID' => $labID,
                    'UserTypeID' => 6,
                    'TestRegnID' => $testRegnID,
                ]);

                // Check if the response is successful
                if ($response->successful()) {
                    $data = $response->json();

                    // Check if data is available and valid
                    if (isset($data['d'][0])) {
                        $result = $data['d'][0];

                        // Check if PDF file exists
                        if (!empty($result['PdfName'])) {
                            $filename = str_replace(["../", "~"], "", $result['PdfName']);
                            $fileUrl = 'http://reliable.elabassist.com/' . $filename;

                            // Fetch the file and download it
                            $fileResponse = Http::get($fileUrl);

                            if ($fileResponse->ok()) {
                                // Create the response for file download
                                return response($fileResponse->body())->header('Content-Type', 'application/pdf')->header('Content-Disposition', 'attachment; filename="report.pdf"');
                                // return response()->json(['success' => true,'data'=>$fileUrl ,'msg' => 'PDF FILE']);
                            } else {
                                return response()->json(['success' => false, 'msg' => 'Your report is not ready yet. Please contact coustomer support +91-9828112340']);
                            }
                        } else {
                            return response()->json(['success' => false, 'msg' => 'Your report is not ready yet. Please contact coustomer support +91-9828112340 ']);
                        }
                    } else {
                    return response()->json(['success' => false, 'msg' => 'No data found.']);
                    }
                } else {
                    
                    return response()->json(['success' => false, 'msg' => 'Error retrieving data from external service.']);
                }
           
        } else {
            return response()->json(['success' => false,'msg' => 'Invalid TestRegnID.']);
	
        }
    }
    public function encryptCC($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    public function decryptCC($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    public function pkcs5_padCC($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    public function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }
    public function cc_request(Request $request){

		$amount = $request->paymentAmount;
		$testregnid = $request->testregnid;
		$user = session('some_name');
		$UserFID = $user['UserFID'];
		$tid = uniqid();
// 		$amount =1;
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    $orderData = [
        'receipt'         => 'rcptid_11',
        'amount'          => $amount * 100, // amount in the smallest currency unit
        'currency'        => 'INR',
    ];

    $razorpayOrder = $api->order->create($orderData);

    $orderId = $razorpayOrder['id'];
    
    return view('front.payment', compact('orderId','orderData','testregnid','UserFID','tid'));


    }
    public function reliableReport()
    {
        if (request('status') === 'payment_canceled') {
            session()->flash('payment_status', 'Payment was canceled by the user.');
        }
        
        return view('reliable-report'); // Adjust the view as needed
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        // Extract custom data
        $amount = $request->amount/100;
        $testregnid = $request->testregnid;
        $UserFID = $request->UserFID;
        $tid = $request->tid;
    
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];
    
        try {
            $api->utility->verifyPaymentSignature($attributes);
            $this->UpdatePayment($UserFID,$testregnid,$amount);
            session()->flash('payment_status', 'Payment Successful!');
            return redirect()->route('reliable-report');
            
            // return response()->json(['status' => 'Payment Successful', 'amount' => $amount, 'testregnid' => $testregnid, 'UserFID' => $UserFID, 'tid' => $tid]);
        } catch (\Exception $e) {
            session()->flash('payment_status', 'Payment Verification Failed!');
    		return redirect()->route('reliable-report');
            // return response()->json(['status' => 'Payment Verification Failed']);
        }
    }

    public function UpdatePayment($UserFID,$TestRegnId,$amount)
	{
	   
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
// 		return;
        // $url = route('reliable-report');
        // return redirect($url);

	}
}

