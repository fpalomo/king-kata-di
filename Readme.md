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
 App order ID , to be able to trace the payment back.

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


---

In order to optimize bank fees costs, our engine will connect to a different payment backend depending on the credit card type:

* VISA : We use Entity A

* MASTERCARD : We use Entity B

* AMEX : We use Entity C



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
- hash: sha1 of the next concatenated values : merchant_id+merchant_transaction_id+cc_beholder+datetime (example 2013-10-30_12:59:59)


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

*
