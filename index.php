<?php require_once("config.php"); ?>

<html>
<head><title>ExpressCheckOut</title></head>

<body>
	<!--Form containing item parameters needed for SetExpressCheckout Call-->
	<form action = "redirect.php" method = "POST">
		<table border = "2">
			<caption><h1>Shopping Cart</h1></caption>
			<thead><tr><th> Items</th><th> Details</th><th> Price</th><th> Quantity</th><th> Total</th></tr></thead>
			<tbody><tr class="cart-items"><td align ="center"><img src="http://st.mngbcn.com/rcs/pics/static/T4/fotos/S6/45059039_05_B.jpg" width ="100" height ="120"><p><?php echo $_SESSION["itemName0"];	?></p></td>
				<td class="cart-details" align ="center"><p><?php echo $_SESSION["itemDes0"];	?></p><p> Item #: <?php echo $_SESSION["itemId0"];	?></p></td>
				<td class="cart-price" align ="center"><?php echo $_SESSION["itemPirce0"]; ?></td>
				<td class="cart-qty" align ="center"><?php echo $_SESSION["itemQty0"]; ?></td>
				<td class="cart-total" align ="center"><?php echo $_SESSION["itemAmt"]; ?></td></tr>
			</tbody>												
		</table>
		<div class="order-details">
			<dl class="subtotal"><dt> Subtotal:</dt><dd><?php echo $_SESSION["itemAmt"]; ?></dd>
				<dt class="info"> Shipping:</dt><dd><strong><?php echo $_SESSION["shippingAmt"]; ?></strong></dd>
				<dt class="info"> Estimated Tax</dt><dd>--</dd></dl>
			<dl class="total"><dt> Order Total</dt><dd><?php echo $_SESSION["totalAmt"]; ?></dd></dl></div>
        
		    <tr><td colspan="2"><br/><br/>
		    	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Check out with PayPal">
		    	</input></td></tr>
	</form>
	
</body>
</html>
