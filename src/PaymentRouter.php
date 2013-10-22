<?php

require "BankEntityDriver/A.php";
require "BankEntityDriver/B.php";
require "BankEntityDriver/C.php";


Class PaymentRouter
{


    public function __construct()
    {
        //load routes
        // for this exercise they are hardcoded
    }

    public function defineDriverFor($cc_type)
    {

        switch($cc_type){
            case "MASTERCARD":
                $driver = new BankEntityDriver_A();
                break;
            case "AMEX":
                $driver = new BankEntityDriver_B();
                break;
            case "VISA":
                $driver =  new BankEntityDriver_C();
                break;
            default:
                throw new exception("unknown cc_type");
        }

        return $driver;

    }
}