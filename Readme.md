Welcome to our 3rd exercise!
Today, you will be required to use the dependency injection concept in order to be able to write testable code.


Definition
==========


We are going to develop a very basic and simplistic version of a micro payment service provider gateway, PSP Gateway.
For educative purposes we will keep this simple, although there are more standard ways of transferring parameters.

---

Our engine should accept HTTP Requests with the next POST parameters:

* Application ID ( 32 characters ) :
 Our system will accept payments from different apps, so we need to keep track of this.

* Order ID ( 32 characters ) :
 App order ID , to be able to trace the payment back, and for the IPN ( read below ).

* CC type ( 16 characters ) :
 One of ( VISA | MASTERCARD | AMEX )

* CC Beholder ( 64 characters )

* CC Number ( 16 digits )

* CC Expiry Month ( 2 digits )

* CC Expiry Year ( 2 digits )

* CC CVV ( 7 digits )

* Charge Amount ( 12 digits , dot separated decimals )

* Charge Currency ( 3 digits ) :
 Optional parameter, ISO 4217 http://en.wikipedia.org/wiki/ISO_4217 , Default EUR

* Transaction request security key ( 32 characters ) :
 The requests include a code to ensure they are real transaction requests.

* ipn_endpoint : optional, URL where our system will notify of the payment success before printing the output. Explained
below.


Our engine will response a simple XML with the next format:

```
<xml>
<success></success>
<transaction_id></transaction_id>
<error_message></error_message>
</xml>
```

Where
- success: [0-1]
- transaction_id: PSP Gateway internal transaction id for debugging purposes.
- error_message: optional, in case of success being 0, for debugging purposes.

---

The Payment Security Engine ( PSE ) is different depending on the Application ID . Older applications use a less secure engine, v1,
newer apps use one of the newer algorithms, v2 or v3 .

PSE v1:
The security key is just the first character of the next values concatenated in the this order:

* Application ID + Order ID + CC Type + CC Beholder + CC Number + CC Expiry Month + CC Expiry year + CC CVV + Charge Amount + Day of the Month using 2 characters


PSE v2:
The security key is a one way authentication algorithm ( md5 ) , using the next values concatenated in this order:

* Application ID + Order ID + CC Type + CC Beholder + CC Number + CC Expiry Month + CC Expiry year + CC CVV + Charge Amount + Current Month Day using 2 characters


PSE V3:
The security key is a hybrid encryption algorithm ( GPG , http://en.wikipedia.org/wiki/GNU_Privacy_Guard ) . However,
this version has still not been released . It is an improvement to add for those who finish the exercise earlier.
this PSE version.


In order to limit the systems that we need to audit to obtain our PCI Compliance certification ( http://www.pcicomplianceguide.org/ )
We have designed a system that allows our apps to generate the orders, and have their users connecting directly to our servers.
In case the app uses it, we need to have an Instant Payment Notification ( IPN ) end point. If the request includes this ipn, we should
connect to it and send the next parameters in a POST request:

- order_id : The same coming in the request
- transaction_id : PSP Gateway internal transaction id
- success : [0-1]
- error_message : In case of success 0

If the request includes IPN endpoint, we should ensure we can connect to it before executing the payment.


---

In order to optimize bank fees costs, our engine will connect to a different payment backend depending on the credit card type:


* MASTERCARD : We use Entity A

* AMEX : We use Entity B

* VISA : We use Entity C

--

Entity A expects a XML Request with the next format:
```
<xml>
<merchant_id></merchant_id>
<merchant_transaction_id></merchant_transaction_id>
<cc_beholder></cc_beholder>
<cc_number></cc_number>
<cc_expiry_month></cc_expiry_month>
<cc_expiry_year></cc_expiry_year>
<cc_cvv></cc_cvv>
<charge_amount></charge_amount>
<charge_currency></charge_currency>
<hash></hash>
</xml>
```

Where:
- merchant_id : our PSP id, they provided it to us when we created an account. the value is "MCHNT-304x3"
- merchant_transaction_id : A unique key identifying the payment in our system. This is a value just for us, in case we need to trace back
any payment.
- hash : sha1 of the next concatenated values : merchant_id+merchant_transaction_id+cc_beholder+datetime (example 2013-10-30_12:59:59)


Entity A responses :

```
<xml>
<success></success>
<entity_transaction_id></entity_transaction_id>
<error_message></error_message>
</xml>
```

Where
- success : [0-1]
- entity_transaction_id : 32 characters
- error_message: optional, only in case of success = 0


--


Entity B expects and responses exactly the same as Entity A, but with JSON format and using sha256.


--

Entity C expects a POST request with the next parameters:

* client_id : is the same concept as merchant_id for Entity A and B . the value is "988123xAbC"
* client_transaction: same concept as merchant_transaction_id in Entity A.
* transaction_date: They want us to send them the date the transaction was created in our system. It is not a feature we
will use, so we will always send them the current date. the format is 2013-12-31_12:59:59 .
* cc_name : matches to cc_beholder
* cc_code1 : matches to the first 4 digits block of cc_number
* cc_code2 : matches to the second 4 digits block of cc_number
* cc_code3 : matches to the third 4 digits block of the cc_number
* cc_code4 : matches to the forth 4 digits block of the cc_number
* cc_expiry : year + month , 2 digits for each, and concatenated separated by a "-" . Example: 2017-12
* cvv : matches to cc_cvv
* eur_amount : amount to charge, in EUR , using comma separated decimals.
* hash : md5 of the concatenation of : client_id + client_transaction +  cc_name + eur_amount

Entity C responses :

```
<xml>
<response_code></response_code>
</xml
```
Where
- response_code : 0 in case of success . 1-255 in case of error, being this value the error code.


---

Find a system diagram here ![alt tag](https://raw.github.com/fpalomo/king-kata-di/master/img/King%20Coding%20Dojo%20-%20Exercise%203%20-%20PSP%20Gateway.png)