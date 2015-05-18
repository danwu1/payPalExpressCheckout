<?php
	if (session_id() == "") 
		session_start();

	/*
		define the shopping item parameters
	*/
	$_SESSION["itemName0"] = "FLOWY PRINTED DRESS";
	$_SESSION["itemId0"] = "45059039";
	$_SESSION["itemDes0"] = "Flowy printed long dress. Adjustable cord straps with tassels, elastic waist and inner lining.";
	$_SESSION["itemQty0"] = 1;
	$_SESSION["itemPirce0"] = 99;
	$_SESSION["shippingAmt"] = 20;
	$_SESSION["currencyCode"] = "SGD";
	$_SESSION["paymentType"] = "Sale";
	$_SESSION["tax"] = 0;
	$_SESSION["itemAmt"] = $_SESSION["itemPirce0"]*$_SESSION["itemQty0"];
	$_SESSION["totalAmt"] = $_SESSION["itemAmt"]+$_SESSION["shippingAmt"]+$_SESSION["tax"];
	


//Seller Sandbox Credentials- Sample credentials already provided
define("PP_USER_SANDBOX", "wudanxxx-facilitator_api1.gmail.com");
define("PP_PASSWORD_SANDBOX", "WC9XUE6EFB6XENH9");
define("PP_SIGNATURE_SANDBOX", "AFcWxV21C7fd0v3bYYYRCpSSRl31AUnKrpLarT3mNnErha7DL-iKOgS4");

//The URL in your application where Paypal returns control to -after success (RETURN_URL) and after cancellation of the order (CANCEL_URL) 
define("RETURN_URL",'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER["PHP_SELF"]).'/review.php');
define("CANCEL_URL",'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER["PHP_SELF"]).'/cancel.php');

//Express Checkout URLs for Sandbox
define("PP_CHECKOUT_URL_SANDBOX", "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=");
define("PP_NVP_ENDPOINT_SANDBOX","https://api-3t.sandbox.paypal.com/nvp");

//Version of the APIs
define("API_VERSION", "109.0");
?>