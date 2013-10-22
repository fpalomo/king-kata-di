<?php

require '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

include "../src/RemoteApp.php";

Class RemoteAppTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorSuccess()
    {
        $r = new RemoteApp(1);
        $this->assertTrue(true);

    }

    /**
     * @expectedException Exception
     */
    public function testConstructorFailing()
    {
            $r = new RemoteApp(5);

    }

}