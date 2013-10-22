<?php

require_once "Version1.php";
require_once "Version2.php";

class SecurityCheck_Router
{
    public function getHandlerForVersion($apiId)
    {
        switch ($apiId) {
            case 1:
                $obj = New SecurityCheck_Version1();
                break;
            case 2:
                $obj = New SecurityCheck_Version2();
                break;
            default:
                throw new Exception ("Unknown api version");
                break;
        }
        return $obj;
    }
}