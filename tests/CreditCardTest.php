<?php

require_once '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

require_once "../src/CreditCard.php";

// These are weak tests. Explain Why!
Class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Exception
     */
    public function testCrashOnMissingBeholder()
    {
        $params = array(
//            "cc_beholder" => "a",
            "cc_number" => "1234123412341234",
            "cc_cvv" => "123",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "14"
        );

        $cc = new CreditCard($params);

        $this->assertTrue(true);


    }

    /**
     * @expectedException Exception
     */
    public function testCrashOnMissingNumber()
    {
        $params = array(
            "cc_beholder" => "a",
//            "cc_number" => "1234123412341234",
            "cc_cvv" => "123",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "14"
        );

        $cc = new CreditCard($params);

        $this->assertTrue(true);


    }

    /**
     * @expectedException Exception
     */
    public function testCrashOnMissingCvv()
    {
        $params = array(
            "cc_beholder" => "a",
            "cc_number" => "1234123412341234",
//            "cc_cvv" => "123",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "14"
        );

        $cc = new CreditCard($params);

        $this->assertTrue(true);
    }

    /**
     * @expectedException Exception
     */
    public function testCrashOnMissingExpiryMonth()
    {
        $params = array(
            "cc_beholder" => "a",
            "cc_number" => "1234123412341234",
            "cc_cvv" => "123",
//            "cc_expiry_month" => "12",
            "cc_expiry_year" => "14"
        );

        $cc = new CreditCard($params);

        $this->assertTrue(true);
    }

    /**
     * @expectedException Exception
     */
    public function testCrashOnMissingExpiryYear()
    {
        $params = array(
            "cc_beholder" => "a",
            "cc_number" => "1234123412341234",
            "cc_cvv" => "123",
            "cc_expiry_month" => "12",
//            "cc_expiry_year" => "14"
        );

        $cc = new CreditCard($params);

        $this->assertTrue(true);
    }


    public function testValidConstruct()
    {
        $params = array(
            "cc_beholder" => "a",
            "cc_number" => "1234123412341234",
            "cc_cvv" => "123",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "14"
        );

        $cc = new CreditCard($params);

        $this->assertEquals($cc->cc_beholder,"a");
        $this->assertEquals($cc->cc_number,"1234123412341234");
        $this->assertEquals($cc->cc_cvv,"123");
        $this->assertEquals($cc->cc_expiry_month,"12");
        $this->assertEquals($cc->cc_expiry_year,"14");

    }



}