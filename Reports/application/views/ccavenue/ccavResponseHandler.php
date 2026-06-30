<?php include('Crypto.php') ?>
<?php

error_reporting(0);

$workingKey = 'C31078E961DB1D7BA20CB00D66CE30BB';		//Working Key should be provided here.
$encResponse = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
$rcvdString = decrypt($encResponse, $workingKey);		//Crypto Decryption used as per the specified working key.
$order_status = "";
$decryptValues = explode('&', $rcvdString);
$dataSize = sizeof($decryptValues);

$order_id = "";
$tracking_id = "";
$amount = "";
$UserFID = "";
$TestRegnId = "";

// echo "<center>";

for ($i = 0; $i < $dataSize; $i++) {
	$information = explode('=', $decryptValues[$i]);
	if ($i == 3)	$order_status = $information[1];
	if ($information[0] == "order_id")
		$order_id = $information[1];
	if ($information[0] == "tracking_id")
		$tracking_id = $information[1];
	if ($information[0] == "amount")
		$amount = $information[1];
	if ($information[0] == "merchant_param1")
		$TestRegnId = $information[1];
	if ($information[0] == "merchant_param2")
		$UserFID = $information[1];
}

if ($order_status === "Success") {
	// echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
	// Prepare the parameters
	$params = array(
		'UserFID' => $UserFID,
		'TestRegnId' => $TestRegnId,
		'amount' => $amount
		// Add more parameters as needed
	);

	// Redirect to the 'success' method of the 'Home' controller with parameters
	redirect('home/UpdatePayment?' . http_build_query($params));
} else if ($order_status === "Aborted") {
	echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
} else if ($order_status === "Failure") {
	echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
} else {
	echo "<br>Security Error. Illegal access detected";
}

// echo "<br><br>";

// echo "<table cellspacing=4 cellpadding=4>";
// for ($i = 0; $i < $dataSize; $i++) {
// 	$information = explode('=', $decryptValues[$i]);
// 	echo '<tr><td>' . $information[0] . '</td><td>' . $information[1] . '</td></tr>';
// }
// echo '<tr><td>Test Regn ID</td><td>' . $testregn . '</td></tr>';

// echo "</table><br>";
// echo "</center>";
?>
