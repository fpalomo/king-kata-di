<?php

require_once '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

require_once "../src/SecurityCheck/Version2.php";

Class SecurityCheck_Version2Test extends \PHPUnit_Framework_TestCase
{
    public function testSuccessValidate()
    {

        $securityCheck = new SecurityCheck_Version2();
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
            "api_version" => 1
        );
        $concatenatedParams =
            $requestParams["application_id"]
            . $requestParams["order_id"]
            . $requestParams["cc_type"]
            . $requestParams["cc_beholder"]
            . $requestParams["cc_number"]
            . $requestParams["cc_expiry_month"]
            . $requestParams["cc_expiry_year"]
            . $requestParams["cc_cvv"]
            . $requestParams["charge_amount"];

        $requestParams["security_key"] = md5($concatenatedParams);

        $valid = $securityCheck->validate($requestParams);

        $this->assertTrue($valid);

    }

    public function testFailValidate()
    {
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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
        $securityCheck = new SecurityCheck_Version2();
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