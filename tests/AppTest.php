<?php


require '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

include "../src/app.php";

Class AppTest extends \PHPUnit_Framework_TestCase
{
    public function testValidRequest()
    {

        $requestParams = array (
            "application_id"    => 1,
            "order_id"          => 2,
            "cc_type"           => "VISA",
            "cc_beholder"       => "bruce waine",
            "cc_number"         => "1234123412341234",
            "cc_expiry_month"   => "12",
            "cc_expiry_year"    => "17",
            "cc_cvv"            => "123",
            "charge_amount"     => 124.50,
            "charge_currency"   =>  "EUR",
            "security_key"      => "my_seck_key_to_be_generated_properly",
            "api_version"       => 1
        );

        $app = new App($requestParams);

        $response = $app->run();

        $xmlResponseObject = simplexml_load_string($response);
        $successElement = $xmlResponseObject->success;
        $foundSuccess= (bool) sprintf ($successElement[0]);

        $this->assertTrue($foundSuccess);
    }
}