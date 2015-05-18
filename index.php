<?php require_once("config.php"); ?>

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
	<title>ExpressCheckOut</title>
	
</head>

<body>
	<div class="container">		
		<table class ="table text-center shoppingCart">
			<div class = "table text-center">
			<caption><h2>Shopping Cart</h2></caption>
			<thead><tr><th> Items</th><th> Details</th><th> Price</th><th> Quantity</th><th> Total</th></tr></thead>
			<tbody><tr class="cart-items"><td><img src="http://st.mngbcn.com/rcs/pics/static/T4/fotos/S6/45059039_05_B.jpg" width ="100" height ="120"><p><?php echo $_SESSION["itemName0"];	?></p></td>
				<td class="cart-details" ><p><?php echo $_SESSION["itemDes0"];	?></p><p> Item #: <?php echo $_SESSION["itemId0"];	?></p></td>
				<td class="cart-price" ><?php echo $_SESSION["itemPirce0"]; ?></td>
				<td class="cart-qty" ><?php echo $_SESSION["itemQty0"]; ?></td>
				<td class="cart-total" ><?php echo $_SESSION["itemAmt"]; ?></td></tr>
			</tbody>												
		</table>
		<div class="container orderSummary col-sm-3">
			<div class = "row"><dl class="dl-horizontal subtotal">
				<dt class="info"> Subtotal:</dt><dd><?php echo $_SESSION["itemAmt"]."  ".$_SESSION["currencyCode"]; ?></dd>
				<dt class="info"> Shipping:</dt><dd><?php echo $_SESSION["shippingAmt"]."  ".$_SESSION["currencyCode"]; ?></dd>
				<dt class="info"> Estimated Tax:</dt><dd><?php echo $_SESSION["tax"]."  ".$_SESSION["currencyCode"]; ?></dd></dl>
			</div>
			<div class = "row orderTotal">
				<dl class="dl-horizontal"><dt> Order Total:</dt><dd><?php echo $_SESSION["totalAmt"]."  ".$_SESSION["currencyCode"]; ?></dd></dl>
			</div>
		</div>

		<form action = "redirect.php" method = "POST" class = "container col-sm2 col-sm-offset-10">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Check out with PayPal"></input>
		</form>
	</div>
</body>
</html>
