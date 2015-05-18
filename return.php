<?php 
	require_once("config.php");
	require_once ("expressCheckoutAPI.php"); 
	
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
			<h4>Thank you! Your order is complete.</h4>
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