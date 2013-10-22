<?php



require '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

include "../src/SecurityCheck/Version1.php";

Class SecurityCheck_Version1Test extends \PHPUnit_Framework_TestCase
{
    public function testSuccessValidate()
    {

        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12Vb11111",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertTrue($valid);

    }

    public function testFailValidate()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);
    }


    /**
     * @expectedException Exception
     */
    public function testMissingApplicationId()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
//            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertTrue(true);

    }

    /**
     * @expectedException Exception
     */
    public function testMissingOrderId()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
//            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }

    /**
     * @expectedException Exception
     */
    public function testMissingCCType()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
//            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }

    /**
     * @expectedException Exception
     */
    public function testMissingCCBeholder()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
//            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }


    /**
     * @expectedException Exception
     */
    public function testMissingCCNumber()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
//            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }


    /**
     * @expectedException Exception
     */
    public function testMissingCCExpiryMonth()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
//            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }


    /**
     * @expectedException Exception
     */
    public function testMissingCCExpiryYear()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
//            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }

    /**
     * @expectedException Exception
     */
    public function testMissingChargeAmount()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
//            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }

    /**
     * @expectedException Exception
     */
    public function testMissingSecurityKey()
    {
        $securityCheck = new SecurityCheck_Version1();
        $requestParams = array(
            "application_id" => 1,
            "order_id" => 2,
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
            "charge_amount" => 124.50,
            "charge_currency" => "EUR",
//            "security_key" => "12XXXXXVbX",
            "api_version" => 1
        );

        $valid = $securityCheck->validate($requestParams);

        $this->assertFalse($valid);

    }

}