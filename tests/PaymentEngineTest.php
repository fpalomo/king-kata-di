<?php

require_once '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

require_once "../src/PaymentEngine.php";
require_once "../src/SecurityCheck/Version1.php";

Class PaymentEngineTest extends \PHPUnit_Framework_TestCase
{


    public function testSetBankEntity()
    {
        $engine = new PaymentEngine();
        $entityA = new BankEntityDriver_A();
        $engine->setBankEntity($entityA);
        $this->assertTrue(true);
    }

    public function testSetRemoteApp()
    {
        $engine = new PaymentEngine();
        $app1 = new RemoteApp(1);
        $engine->setRemoteApp($app1);
        $this->assertTrue(true);
    }

    public function testSetCC()
    {
        $engine = new PaymentEngine();
        $ccInfo = array(
            "cc_type" => "VISA",
            "cc_beholder" => "bruce waine",
            "cc_number" => "1234123412341234",
            "cc_expiry_month" => "12",
            "cc_expiry_year" => "17",
            "cc_cvv" => "123",
        );
        $cc1 = new CreditCard($ccInfo);
        $engine->setCC($cc1);
        $this->assertTrue(true);
    }

    public function testSetSecurityCheck()
    {
        $engine = new PaymentEngine();
        $securityCheck1 = new SecurityCheck_Version1();
        $engine->setSecurityCheck($securityCheck1);
        $this->assertTrue(true);

    }
    public function testSetAmount()
    {
        //TODO : exhaustive test
    }

    public function testSetCurrency()
    {
        //TODO exaustive test
    }



    public function testProcessSuccessfulPayment()
    {
        // TODO
    }


    public function testGetXmlResponse()
    {
        // TODO

    }
}