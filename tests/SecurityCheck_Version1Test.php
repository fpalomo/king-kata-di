<?php



require '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

include "../src/SecurityCheck/Version1.php";

Class SecurityCheck_Version1Test extends \PHPUnit_Framework_TestCase
{
    public function testSuccessValidate()
    {

        $securityCheck = new SecurityCheck_Version1();
        $params = array(

        );

        $valid = $securityCheck->validate($params);

        $this->assertTrue($valid);

    }

    public function testFailValidate()
    {

    }
}