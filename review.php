<?php 

	require_once("config.php");
	require_once("expressCheckoutAPI.php");

	$token = $_SESSION["TOKEN"];
	if ( $token != "" )
	{
		/*
		* Calls the GetExpressCheckoutDetails API call
		*/
		$resArray = GetExpressCheckoutDetails( $token );
		$ackGetExpressCheckout = strtoupper($resArray["ACK"]);	 
		if( $ackGetExpressCheckout == "SUCCESS" || $ackGetExpressCheckout == "SUCESSWITHWARNING") 
		{
			//person info
			$email 				= $resArray["EMAIL"]; 
			$payerId 			= $resArray["PAYERID"]; 
			$firstName			= $resArray["FIRSTNAME"]; 
			$lastName			= $resArray["LASTNAME"]; 
			
			//shipping info
			$cntryCode			= $resArray["COUNTRYCODE"]; 
			$shipToName			= $resArray["PAYMENTREQUEST_0_SHIPTONAME"]; 
			$shipToStreet		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET"]; 
			$shipToCity			= $resArray["PAYMENTREQUEST_0_SHIPTOCITY"]; 
			$shipToState		= $resArray["PAYMENTREQUEST_0_SHIPTOSTATE"]; 
			$shipToCntryCode	= $resArray["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; 
			$shipToZip			= $resArray["PAYMENTREQUEST_0_SHIPTOZIP"]; 
			
			//payment info
			$totalAmt   		= $resArray["PAYMENTREQUEST_0_AMT"];
			$itemAmt 			= $resArray["PAYMENTREQUEST_0_ITEMAMT"];
			$tax 				= $resArray["PAYMENTREQUEST_0_TAXAMT"];
			$currencyCode       = $resArray["CURRENCYCODE"]; 
			$shippingAmt        = $resArray["PAYMENTREQUEST_0_SHIPPINGAMT"]; 
?>
<html>
<body>
	<div class="review-order"><h1>Review &amp; Submit Order</h1></div>
	<div class="review-order"><p><strong>You're almost done!</strong><br>Review your information before you place your order.</p></div>
	<div class="review-box">
		<div class="review-detail address " style="height: 144px;padding-top:0px"><h3>Shipping Address</h3><?php echo "</br>".$shipToName."</br>".$shipToStreet."</br>".$shipToCity."</br>".$shipToState."</br>".$shipToCntryCode."</br>".$shipToZip;	?></div>
		<div class="review-detail shipping " style="height: 144px;padding-top:0px"><h3>Shipping Method</h3><p>Standard<br>Delivery in 3-5 business days following shipment</p></div>
		<div class="review-detail payment  open" style="height: 144px;padding-top:0px"><h3>Selected Payment</h3><p>PayPal Account</br><?php echo $email ?></p></div>
	</div>
	</br>
	</br>
	<table>
		<tr><td>Subtotal:</td><td><?php echo $itemAmt."  ".$currencyCode?>	  </td></tr>
		<tr><td>Shipping:</td><td><?php echo $shippingAmt."  ".$currencyCode?></td></tr>
		<tr><td>Tax:</td><td><?php echo $tax."  ".$currencyCode?></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Order total:</td><td><?php echo $totalAmt."  ".$currencyCode?></td></tr>
		<form action="return.php" name="order_confirm" method="POST">
			<tr><td><input type="Submit" name="confirm" value="Confirm Order"></td></tr>
		</form>
	</table>
</body>
</html>

<?php
		} 
		else  
		{
			//Display error
			$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
			$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

			echo "</br>GetExpressCheckoutDetails API call failed. ";
			echo "</br>Detailed Error Message: " . $ErrorLongMsg;
			echo "</br>Short Error Message: " . $ErrorShortMsg;
			echo "</br>Error Code: " . $ErrorCode;
			echo "</br>Error Severity Code: " . $ErrorSeverityCode;
		}
	}
?>

