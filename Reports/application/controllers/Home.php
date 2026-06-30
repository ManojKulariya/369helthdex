<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		// $this->load->helper('menu');
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('index');
	}

	public function Login()
	{
		/**LOGIN */
		$method = "POST";
		$in = array();
		$in = $this->input->post();
		$postdata = array('objSP' => $in);
		$postdata = json_encode($postdata);
		$url = "http://elabcorpsupport.elabassist.com/services/globaluserservice.svc/UserRegistration";

		$result = $this->callAPI($method, $url, $postdata);
		$returnval = $result;

		$result = json_decode($result, true);
		$result = $result["d"];
		if ($result["Result"] == "Success") {
			$this->session->set_userdata('some_name', $result);
			// $this->report();
		} else if ($result["Result"] == "Failed") {
			echo "<script>alert('Login Failed .')</script>";
			// redirect('home');
		}

		echo $returnval;
	}

	public function BookAppointment()
	{
		// $data = json_decode($_POST['data']);
		// echo $data;
		$this->load->view('appointment');
	}
	public function reports()
	{
		$data['page'] = 'home';
		$sessionset = isset($_SESSION['some_name']);
		if ($sessionset) {
			$user = $_SESSION['some_name'];

			$method = "POST";
			$postdata = [
				"UserFID" => $user["UserFID"],
				"LabID" => LAB_ID, // TEST_LAB_ID
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
			// print_r($data["reportlist"]);
			$this->load->view('reports', $data);
		} else {
			echo "<script>alert('please Log in')</script>";
			redirect('/home', 'refresh');
		}
	}

	public function ccavRequestHandler()
	{
		$formData = [];
		$amount = $this->input->post('paymentAmount');
		$testregnid = $this->input->post('testregnid');
		$user = $_SESSION['some_name'];
		$UserFID = $user['UserFID'];
		$tid = uniqid();

		$formData['tid'] = $tid;
		$formData['merchant_id'] = "2788617";
		$formData['order_id'] = $tid;
		$formData['amount'] = $amount;
		$formData['currency'] = "INR";
		$formData['redirect_url'] = base_url() . "ccavResponseHandler";
		$formData['cancel_url'] = base_url() . "ccavResponseHandler";
		$formData['language'] = "EN";
		$formData['merchant_param1'] = $testregnid;
		$formData['merchant_param2'] = $UserFID;

		$data['merchant_info'] = $formData;
		// print_r($data['merchant_info']);
		$this->load->view('ccavenue/ccavRequestHandler', $data);
	}

	public function ccavResponseHandler()
	{
		$this->load->view('ccavenue/ccavResponseHandler');
	}

	public function quickbook()
	{
		$this->load->view('quickbook');
	}

	public function UpdatePayment()
	{

		$UserFID = $this->input->get('UserFID');
		$TestRegnId = (int)$this->input->get('TestRegnId');
		$amount = $this->input->get('amount');

		$paymentUpdation = [
			"objBillRecieptClass" => [
				"TestRegnID" => $TestRegnId,
				"AmountPaid" => $amount,
				// "GatewayID": Tid,
				"CurrentPayAmt" => $amount,
				"Task" => 3,
				"PaymentMethodType" => "7",
				"UserID" => $UserFID,
				"LabID" => LAB_ID    // TEST_LAB_ID
			]
		];

		//  print_r($paymentUpdation);
		$postdata = json_encode($paymentUpdation);
		// echo $postdata;
		$method = "POST";
		$url = "https://reliabletest.elabassist.com/Services/Test_RegnService.svc/UpdateTestRegnBalAmt";
		$mydata = $this->callAPI($method, $url, $postdata);
		$mydata = json_decode($mydata, true);

		$user = $_SESSION['some_name'];
		$homeurl = base_url() . "home";
		if (isset($_SESSION['some_name'])) {
			if (!empty($_SESSION['some_name'])) {
				$homeurl = base_url() . "reports";
			}
		}
		if ($mydata["d"] == true) {
			$data['page'] = 'home';
			$msg = 'The payment has been updated.';
			echo '
<html>
  <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
  <style>
    body {
      text-align: center;
      padding: 40px 0;
      background: #EBF0F5;
    }
    h1 {
      color: #88B04B;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-weight: 900;
      font-size: 40px;
      margin-bottom: 10px;
    }
    p {
      color: #404F5E;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-size: 20px;
      margin: 0;
    }
    i {
      color: #9ABC66;
      font-size: 100px;
      line-height: 200px;
      margin-left: -15px;
    }
    .card {
      background: white;
      padding: 60px;
      border-radius: 4px;
      box-shadow: 0 2px 3px #C8D0D8;
      display: inline-block;
      margin: 0 auto;
    }
  </style>
  <body>
    <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
      <h1>Success</h1> 
      <p>' . $msg . '</p>
      <a class="btn btn-primary"style="margin-top: 25px;" href="' . $homeurl . '" role="button">Go Back</a>
    </div>
  </body>
</html>';
		} else {
			$data['page'] = 'home';
			$msg = 'The payment has not been updated. Please contact Lab';
			echo '
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
  <style>
    body {
      text-align: center;
      padding: 40px 0;
      background: #EBF0F5;
    }
    h1 {
      color: #88B04B;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-weight: 900;
      font-size: 40px;
      margin-bottom: 10px;
    }
    p {
      color: #404F5E;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-size: 20px;
      margin: 0;
    }
    i {
      color: #9ABC66;
      font-size: 100px;
      line-height: 200px;
      margin-left: -15px;
    }
    .card {
      background: white;
      padding: 60px;
      border-radius: 4px;
      box-shadow: 0 2px 3px #C8D0D8;
      display: inline-block;
      margin: 0 auto;
    }
  </style>
  <body>
    <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
      <h1>Failure</h1> 
      <p>' . $msg . '</p>
      <a class="btn btn-primary"style="margin-top: 25px;" href="' . $homeurl . '" role="button">Go Back</a>
    </div>
  </body>
</html>';
		}
		// redirect('/home', 'refresh');
	}

	public function transactionFailed()
	{
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
}
