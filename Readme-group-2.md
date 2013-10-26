Welcome to another Coding Dojo Kata!
In this exercise, you will be required to use the dependency injection concept in order to be able to write testable code.

Preconditions
=============

It's highly encouraged that you open your own github account, and create a repository where you and your pair developer will be
commiting your code. 


Definition
==========


We are going to develop a very basic and simplistic version of a micro payment service provider gateway, a PSP Gateway.
For educative purposes we will keep this simple, although there are more standard ways of transferring parameters.
You can think of it as the central payment service for all the king games, having several games using it. Those games,
at the same time, have more users.

---

Let's develop a function, class-method or anything you prefer. It should accept requests with the next parameters, in the format you prefer
either, array, structs, direct parameters. The size and type is just for those who have static data types, those who use programming languages 
with dynamic data types should not waste time checking the data types. The list is:

* application_id ( 32 alphanumeric characters ) :
 Our system will accept payments from different apps, so we need to keep track of this. 
Let's consider application_id = 1 means CANDY_CRUSH , and application_id = 2 means PAPA_PEAR

* order_id ( 32 alphanumeric characters ) :
 App order ID , to be able to trace the payment back, and for the IPN ( read below ).

* cc_type ( 16 alphanumeric characters ) :
 One of ( VISA | MASTERCARD | AMEX )

* cc_beholder ( 64 alphanumeric characters )

* cc_number ( 16 numeric characters )

* cc_expiry_month ( 2 numeric characters )

* cc_expiry_year ( 2 numeric characters )

* cc_cvv ( 7 numeric characters )

* charge_amount ( 12 digits , with 2 decimals ) . We suppose we only operate in EUR.


* ipn_endpoint : optional, URL where our system will notify of the payment success before printing the output. Explained
below. This feature can be considered an extended feature, and delivered in a second "release".

* api_version ( integer ) : represents the api version used. [1-2]

* security_key ( 32 characters ) :
 The requests to our system include a code to ensure they are real transaction requests. Our system should check 
that the security key matches the algorithm ( see below ) according to the API version.


Our engine will response an array with the next information:

* success: [0-1] , 1 if the credit card has been charged correctly, 0 in case of any error.
* transaction_id: PSP Gateway internal transaction id for debugging purposes. This is the ID of this money movement in our system. 
* error_message: if the transaction fails, it should contain any text message. If the transaction is successful, this should be empty.

---

The Payment Security Engine ( PSE ) is different depending on the Api_id . 

PSE v1:
The security key is just the first character of the next values concatenated in the this order:

* Application ID + Order ID + CC Type + CC Beholder + CC Number + CC Expiry Month + CC Expiry year + CC CVV + Charge Amount


PSE v2:
The security key is a one way authentication algorithm ( md5 ) , using the next values concatenated in this order:

* Application ID + Order ID + CC Type + CC Beholder + CC Number + CC Expiry Month + CC Expiry year + CC CVV + Charge Amount

---

In order to optimize bank fees costs, our engine will connect to a different payment backend depending on the credit card type:

* MASTERCARD : We use Entity A
* AMEX : We use Entity B
* VISA : We use Entity C


We will assume we have 3 different classes , each one of them for one of the bank entities. They are low level classes, used as
a network abstraction object. We will consider they all have a method named "chargeCC" , that is the method we will
use to send a money charge request to that bank entity. 


--

Our class for Entity A expects the next parameters:

* merchant_id : our PSP id, they provided it to us when we created an account. the value is "MCHNT-304x3"
* merchant_transaction_id : A unique key identifying the payment in our system. This is a value just for us, in case we need to trace back
any payment.
* cc_beholder
* cc_expiry_month
* cc_expiry_year ( with 4 digits ) 
* cc_cvv
* charge_amount
* charge_currency
* hash : sha1 of the next concatenated values : merchant_id+merchant_transaction_id+cc_beholder+datetime (example 2013-10-30_12:59:59)


This object method responses an array with the next data :


Where
* success : [0-1] , 0 for failed transactions, 1 when the money has been charged to the credit card.
* bank_transaction_id : 32 characters . 
* error_message: only in case of success = 0 , this one will have any value.


--


Entity B object expects and responses the same as Entity A, although obviously it sends the requests
to a different bank, and therefore the merchant_id is different. For Entity B :

* merchant_id = "0x8a-MCN" 


--

Entity C object expects a request with the next parameters:

* client_id : is the same concept as merchant_id in Entity A and B . the value is "988123xAbC"
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

Entity C responses an array with the next info:
* response_code : 0 in case of success . 1-255 in case of error, being this value the error code. 



--

Ipn , extended feature ( just in case you finish quickly ) :

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


Find a system diagram here ![alt tag](https://raw.github.com/fpalomo/king-kata-di/master/img/King%20Coding%20Dojo%20-%20Exercise%203%20-%20PSP%20Gateway.png)
