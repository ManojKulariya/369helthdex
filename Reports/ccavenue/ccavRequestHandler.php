<html>

<head>
	<title> Non-Seamless-kit</title>
</head>

<body>
	<center>

		<?php include('Crypto.php') ?>
		<?php

		error_reporting(0);

		$merchant_data = '2';
		$working_key = '6490ED616488625316BDEA83DE41CA3A'; //Shared by CCAVENUES
		$access_code = 'AVUK05LD67BJ68KUJB'; //Shared by CCAVENUES

		foreach ($merchant_info as $key => $value) {
			$merchant_data .= $key . '=' . $value . '&';
		}

		$encrypted_data = encrypt($merchant_data, $working_key); // Method for encrypting the data.

		?>
		<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
			<?php
			echo "<input type=hidden name=encRequest value=$encrypted_data>";
			echo "<input type=hidden name=access_code value=$access_code>";
			?>
		</form>
	</center>
	<script language='javascript'>
		document.redirect.submit();
	</script>
</body>

</html>