<?php
	require_once("config.php");
/*   
	* This function calls the paypal setExpressCheckOut API
	* @parameterArray:		the item details, prices and taxes
	* @returnURL:			the page where buyers return to after they are done with the payment review on PayPal
	* @cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
	*/
	function setExpressCheckOut( $paramsArray, $returnURL, $cancelURL) 
	{

		//mandatory paramaters
		if(isset($paramsArray["totalAmt"]))
			$nvpstr = "&PAYMENTREQUEST_0_AMT=". $paramsArray["totalAmt"];
		
		if(isset($paramsArray["paymentType"]))
			$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" .  $paramsArray["paymentType"];

		if(isset($returnURL))
			$nvpstr = $nvpstr . "&RETURNURL=" . $returnURL;

		if(isset($cancelURL))
			$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;

		//Optional parameters for SetExpressCheckout API call
		if(isset($paramsArray["currencyCode"]))  
			$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $paramsArray["currencyCode"];

		if(isset($paramsArray["itemAmt"]))
			$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_ITEMAMT=" . $paramsArray["itemAmt"];

		if(isset($paramsArray["tax"]))
			$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_TAXAMT=" . $paramsArray["tax"];

		if(isset($paramsArray["shippingAmt"]))
			$nvpstr = $nvpstr . "&PAYMENTREQUEST_0_SHIPPINGAMT=" . $paramsArray["shippingAmt"];

		if(isset($paramsArray["itemName0"]))
			$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_NAME0=" . $paramsArray["itemName0"];

		if(isset($paramsArray["itemId0"]))
			$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_NUMBER0=" . $paramsArray["itemId0"];

		if(isset($paramsArray["itemDes0"]))
			$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_DESC0=" . $paramsArray["itemDes0"];

		if(isset($paramsArray["itemPirce0"]))
			$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_AMT0=" . $paramsArray["itemPirce0"];

		if(isset($paramsArray["itemQty0"]))
			$nvpstr = $nvpstr . "&L_PAYMENTREQUEST_0_QTY0=" . $paramsArray["itemQty0"];
		
		/*
		 *call SetExpressCheckout API in paypal with nvpstr
		 *if success store token
		*/
	    $resArray=executeMethod("SetExpressCheckout", $nvpstr);	
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
			$_SESSION['TOKEN']=$resArray["TOKEN"];
		else
			echo $nvpstr;
		
	    return $resArray;
	}

	/*
	* This function redirect user to PayPal.com site.
	* Inputs:  token get from setExpressCheckout.
	*/
	function RedirectToPayPal ( $token )
	{
		$payPalURL = PP_CHECKOUT_URL_SANDBOX;
		
		$payPalURL = $payPalURL. $token ;

		header("Location:".$payPalURL);
		exit;
	}

	/*  	
	* This function calls the paypal GetExpressCheckoutDetails API
	* Inputs:  token get from setExpressCheckout.
	* Returns: The NVP Arrray storing transaction details set in SetExpressCheckout
	*/
	function GetExpressCheckoutDetails( $token )
	{
	    $nvpstr="&TOKEN=" . $token;

		/*
		 *call GetExpressCheckoutDetails API in paypal with nvpstr
		 *if success store payer_id and atest payment details for doExpressCheckoutPayment API call
		*/
	    $resArray=executeMethod("GetExpressCheckoutDetails",$nvpstr);
	    $ack = strtoupper($resArray["ACK"]);
		if($ack == "SUCCESS" || $ack=="SUCCESSWITHWARNING")
		{
			$_SESSION['payerId'] =	$resArray['PAYERID'];
			$_SESSION["finalPaymentAmt"] = $resArray["PAYMENTREQUEST_0_AMT"];
		}

		return $resArray;
	}

	/*
	* This function calls the paypal GetExpressCheckoutDetails API
	* Inputs:   FinalPaymentAmount:	The total transaction amount.
	* Returns: 	The NVP Arrray storing transaction details
	*/
	function DoExpressCheckoutPayment( $FinalPaymentAmt )
	{

		//mandatory parameters
		if(isset($_SESSION['TOKEN']))
			$nvpstr = '&TOKEN=' . urlencode($_SESSION['TOKEN']);

		if(isset($_SESSION['payerId']))
			$nvpstr .= '&PAYERID=' . urlencode($_SESSION['payerId']);

		if(isset($_SESSION['paymentType']))
			$nvpstr .= '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode($_SESSION['paymentType']); 
		
		if(isset($_SERVER['SERVER_NAME']))
			$nvpstr .= '&IPADDRESS=' . urlencode($_SERVER['SERVER_NAME']);
	
		$nvpstr .= '&PAYMENTREQUEST_0_AMT=' . $FinalPaymentAmt;

		//optional parameters
		if(isset($_SESSION['currencyCode']))
			$nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($_SESSION['currencyCode']);
		
		if(isset($_SESSION['itemAmt']))
			$nvpstr = $nvpstr . '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($_SESSION['itemAmt']);

		if(isset($_SESSION['tax']))
			$nvpstr = $nvpstr . '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($_SESSION['tax']);

		if(isset($_SESSION['shippingAmt']))
			$nvpstr = $nvpstr . '&PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($_SESSION['shippingAmt']);

		 /*
		 *call DoExpressCheckoutPayment API in paypal with nvpstr
		*/
		$resArray=executeMethod("DoExpressCheckoutPayment", $nvpstr);

		return $resArray;
	}
	
	/**
	  * executeMethod: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	**/
	function executeMethod($methodName,$nvpStr)
	{
		//API Credentials and URLs for Sandbox
		$API_UserName=PP_USER_SANDBOX;
		$API_Password=PP_PASSWORD_SANDBOX;
		$API_Signature=PP_SIGNATURE_SANDBOX;
		$API_Endpoint = PP_NVP_ENDPOINT_SANDBOX;
		$version=API_VERSION;

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION ,CURL_SSLVERSION_TLSv1);
		
		//NVPRequest for submitting to server
		$nvpreq="USER=" . urlencode($API_UserName) . "&PWD=" . urlencode($API_Password) . "&SIGNATURE=" . urlencode($API_Signature) . "&METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($version) .$nvpStr;

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

		//getting response from server
		$response = curl_exec($ch);

		//convrting NVPResponse to an Associative Array
		$nvpReqArray=arrayFromNVPStr($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;
		$nvpResArray=arrayFromNVPStr($response);

		//display eror and close curl
		if (curl_errno($ch)) 
		{
			echo "curl error number: ".curl_errno($ch) ;
			echo "curl error message: ".curl_error($ch);
			curl_close($ch);
		} 
		else 
		{
		  	curl_close($ch);
		}

		return $nvpResArray;
	}

	/* 
	  * This function takes in NVPString and convert it to an array with the decoded response.
	  * The result array uses the keys in nvpstr as the indexes and values in nvpstr as valuses. 
	  * @nvpstr is NVPString.
	  * @nvpArray is the result array.
	 */
	function arrayFromNVPStr($nvpstr)
	{
		$intial=0;
	 	$nvpArray = array();
		while(strlen($nvpstr))
		{
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
			// echo "</br>";
			// echo $nvpArray[urldecode($keyval)]."     ".urldecode($keyval);
	     }
		return $nvpArray;
	}
?>