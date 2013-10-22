<?php

require_once "BankEntityDriver/A.php";
require_once "BankEntityDriver/B.php";
require_once "BankEntityDriver/C.php";


Class PaymentRouter
{


    public function __construct()
    {
        //load routes
        // for this exercise they are hardcoded
    }

    public function defineRouteFor($cc_type)
    {

        switch ($cc_type) {
            case "MASTERCARD":
                $driver = new BankEntityDriver_A();
                break;
            case "AMEX":
                $driver = new BankEntityDriver_B();
                break;
            case "VISA":
                $driver = new BankEntityDriver_C();
                break;
            default:
                throw new exception("unknown cc_type");
        }

        return $driver;

    }
}