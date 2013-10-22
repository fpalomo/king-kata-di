<?php

class CreditCard
{
    public $cc_beholder;
    public $cc_number;
    public $cc_cvv;
    public $cc_expiry_month;
    public $cc_expiry_year;

    public function __construct($ccInfo)
    {
        // sanitize and check existence of required params
        $requiredParams = array(
            "cc_beholder",
            "cc_number",
            "cc_cvv",
            "cc_expiry_month",
            "cc_expiry_year"
        );
        foreach ($requiredParams as $param) {
            if (empty($ccInfo[$param])) {
                throw new exception ("Missing $param");
            }
            $this->$param = $ccInfo[$param];

        }

    }

}