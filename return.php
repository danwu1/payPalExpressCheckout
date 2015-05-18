<?php 
	require_once("config.php");
	require_once ("expressCheckoutAPI.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<title>OrderComplete!</title>

</head>
</html>

<?php
	
	/*
	* Calls the DoExpressCheckoutPayment API call
	*/
	$resArray= DoExpressCheckoutPayment ( $_SESSION["finalPaymentAmt"] );
	$ack = strtoupper($resArray["ACK"]);

	session_unset();   // free all session variables
	session_destroy(); //destroy session
	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{
		?>
			<div class= "container title"><h1>Confirmation</h1></div>
			<div class= "container well"><h4>Thank you! Your order is complete.</h4></div>
		<?php
	}
	else  
	{
		//Display error msg

		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "</br>call to DoExpressCheckoutPayment API fail</br>";
		echo "</br>Detailed Error Message: " . $ErrorLongMsg;
		echo "</br>Short Error Message: " . $ErrorShortMsg;
		echo "</br>Error Code: " . $ErrorCode;
		echo "</br>Error Severity Code: " . $ErrorSeverityCode;

	}		
?>