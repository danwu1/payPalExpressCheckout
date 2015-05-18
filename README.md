paypal expressCheckout API test

#Introudction
1. This API test is running under the payPal sandbox envorinment with the following accounts:
  *merchant account:
      userName:   wudanxxx-facilitator_api1.gmail.com
      password:   WC9XUE6EFB6XENH9
      signature:  AFcWxV21C7fd0v3bYYYRCpSSRl31AUnKrpLarT3mNnErha7DL-iKOgS4 
  *buyer account:
      wudanxxx-buyer@gmail.com
      password:   1213175839

2. The website is using Amazon EC2 services and can be visited at 52.25.120.237

#The ExpressCheckout flow
1. Chooses Express Checkout by clicking Check out with PayPal (calles SetExpressCheckout API)
2. Logs into PayPal to authenticate his or her identity
3. Reviews the transaction on PayPal
4. Confirms the order and pays from your site (calles GetExpressCheckoutDetails API)
5. Receives an order confirmation   (calles DoExpressCheckoutPayement API)

