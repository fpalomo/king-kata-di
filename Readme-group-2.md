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
with dynamic data types please do not waste time checking the data types. The list is:

* application_id ( 32 alphanumeric characters ) :
 Our system will accept payments from different apps, so we need to keep track of this. 
Let's consider application_id = 1 means CANDY_CRUSH , and application_id = 2 means PAPA_PEAR

* order_id ( 32 alphanumeric characters ) :
 App order ID , to be able to trace the payment back, and for the IPN ( read below ).

* cc_type ( 16 alphanumeric characters ) :
 One of ( VISA | MASTERCARD | AMEX )

* cc_beholder ( 64 alphanumeric characters )

* cc_number ( 16 numeric characters )

* charge_amount ( 12 digits , with 2 decimals ) . We suppose we only operate in EUR.

* api_version ( integer ) : represents the api version used. [1-2]

* security_key ( 32 characters ) :
 The requests to our system include a code to ensure they are real transaction requests. Our system should check 
that the security key matches the algorithm ( see below ) according to the API version.


Our engine will response an array with the next information:

* success: [0-1] , 1 if the credit card has been charged correctly, 0 in case of any error.
* transaction_id: PSP Gateway internal transaction id for debugging purposes. This is the ID of this money movement in our system. 
* error_message: if the transaction fails, it should contain any text message. If the transaction is successful, this should be empty.

---

The Payment Security Engine ( PSE ) is different depending on the Api_version . So, if the request is for api_version = 1 ,
the PSEv1 will be used. If the request specifies api_version=2 , the PSEv2 will be used.

PSE v1:
The security key is composed by the first character of the next values concatenated in the this order:

* Application ID + Order ID + CC Type + Charge Amount


PSE v2:
The security key is a one way authentication algorithm ( md5 ) , using the next values concatenated in this order:

* Application ID + Order ID + CC Type + Charge Amount

---

In order to optimize bank fees costs, our engine will connect to a different payment backend depending on the credit card type:

* MASTERCARD : We use Entity A
* AMEX : We use Entity B
* VISA : We use Entity C

We will assume we have 3 different classes ( "EntityA_Driver", "EntityB_Driver", "EntityC_Driver" ) each one of them for one of the bank entities. They are low level classes, used as
a network abstraction object. We will consider they all have a method named "chargeCC" , that is the method we will
use to send a money charge request to that bank entity. You don't actually need to implement this class, we will use mocks
when we need to write the tests.

--

The method "chargeCC" in the EntityA_Driver expects the next parameters:

* merchant_id : our PSP id, they provided it to us when we created an account. the value is "MCHNT-304x3"
* merchant_transaction_id : A unique key identifying the payment in our system. This is a value just for us, in case we need to trace back
any payment.
* cc_beholder
* cc_number
* charge_amount
* charge_currency
* hash : sha1 of the next concatenated values : merchant_id+merchant_transaction_id+cc_beholder+datetime (example 2013-10-30_12:59:59)


This object method responses an array with the next data :


Where
* success : [0-1] , 0 for failed transactions, 1 when the money has been charged to the credit card.
* bank_transaction_id : 32 characters . 
* error_message: only in case of success = 0 , this one will have any value.


--


EntityB_Driver's chargeCC method expects and responses the same as Entity A, although obviously it sends the requests
to a different bank, and therefore the merchant_id is different. The return value is exactly the same as EntityA_Driver. 
So, for Entity B :

* merchant_id = "0x8a-MCN" 


--

EntityC_Driver's method expects a request with basically the same parameters, although with different names:

* merc_id : our PSP id, they provided it to us when we created an account. the value is "MCHNT-304x3"
* merc_trans_id : A unique key identifying the payment in our system. This is a value just for us, in case we need to trace back
any payment.
* cc_name
* cc_number
* amount
* currency
* hash : sha1 of the next concatenated values : merchant_id+merchant_transaction_id+cc_beholder+datetime (example 2013-10-30_12:59:59)

Entity C responses an array with the next info:
* response_code : 0 in case of success . 1-255 in case of error, being this value the error code. 


---


Find a system diagram here ![alt tag](https://raw.github.com/fpalomo/king-kata-di/master/img/King%20Coding%20Dojo%20-%20Exercise%203.2%20-%20PSP%20Gateway.png)


---

The goal is to implement the main code block that will process the requests and will make a call to the necessary bank. Have in consideration that
the code must be testable, and must match the SOLID Principles.
http://en.wikipedia.org/wiki/SOLID_(object-oriented_design)

I would suggest to start by writing a test for our code. Then, write the code, and continue writing the necesary tests for all that new code.



