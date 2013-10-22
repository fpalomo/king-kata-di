<?php



require_once '../vendor/phpunit/phpunit/PHPUnit/Autoload.php';

require_once "../src/SecurityCheck/Router.php";

Class SecurityCheck_Router1Test extends \PHPUnit_Framework_TestCase
{
    public function testVersion1()
    {
        $router = new SecurityCheck_Router();
        $version = $router->getHandlerForVersion(1);
        $isVersion1 = $version instanceof SecurityCheck_Version1;
        $this->assertTrue($isVersion1);
    }
    public function testVersion2()
    {
        $router = new SecurityCheck_Router();
        $version = $router->getHandlerForVersion(2);
        $isVersion2 = $version instanceof SecurityCheck_Version2;
        $this->assertTrue($isVersion2);
    }

    /**
     * @expectedException Exception
     */
    public function testUnknownVersion()
    {
        $router = new SecurityCheck_Router();
        $version = $router->getHandlerForVersion(3);
        $this->assertTrue(true);
    }

}