<?php
require '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

include "../src/PaymentRouter.php";

Class PaymentRouterTest extends \PHPUnit_Framework_TestCase
{
    public function testVisa(){
        $router = new PaymentRouter();
        $driver = $router->defineDriverFor("VISA");
        $correctClass =  $driver instanceof BankEntityDriver_C ;
        $this->assertTrue($correctClass);

    }
    public function testMC(){
        $router = new PaymentRouter();
        $driver = $router->defineDriverFor("MASTERCARD");
        $correctClass =  $driver instanceof BankEntityDriver_A ;
        $this->assertTrue($correctClass);

    }
    public function testAmex(){
        $router = new PaymentRouter();
        $driver = $router->defineDriverFor("AMEX");
        $correctClass =  $driver instanceof BankEntityDriver_B ;
        $this->assertTrue($correctClass);

    }

    /**
     * @expectedException Exception
     */
    public function testFailed(){
        $router = new PaymentRouter();
        $driver = $router->defineDriverFor("CRAPPYCARD");
        $this->assertTrue(true);

    }
}