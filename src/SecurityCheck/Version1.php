<?php

class SecurityCheck_Version1
{
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
            if (!isset($params[$key])) {
                throw new exception ("Missing param $key");
            }
            $concatenatedResult .= substr($params[$key], 0, 1);

        }


        return $concatenatedResult == $params["security_key"];
    }


}