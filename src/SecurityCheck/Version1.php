<?php

require_once "Abstract.php";

class SecurityCheck_Version1 extends SecurityCheck_Abstract
{
    protected $params;

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function validate($params)
    {

        $requiredParams = array(
            "application_id",
            "order_id",
            "cc_type",
            "cc_beholder",
            "cc_number",
            "cc_expiry_month",
            "cc_expiry_year",
            "cc_cvv",
            "charge_amount",
        );

        $concatenatedResult = "";
        foreach ($requiredParams as $key) {
            if (!empty($this->params[$key])) {
                $value = $this->params[$key];
            } else {
                if (!isset($params[$key])) {
                    throw new exception ("Missing param $key");
                }
                $value = $params[$key];
            }
            $concatenatedResult .= substr($value, 0, 1);

        }


        return $concatenatedResult == $params["security_key"];
    }


}