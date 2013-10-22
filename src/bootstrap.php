<?php

require_once "RemoteApp.php";
require_once "PaymentEngine.php";
require_once "PaymentRouter.php";
require_once "CreditCard.php";
require_once "SecurityCheck.php";
require_once 'DB/Driver.php';

class Bootstrap
{
    public function run($params = null)
    {

        try {
            // constructor should throw exception in case of unknown id
            $remoteApp = new RemoteApp($params["application_id"]);


            $paymentRouter = new PaymentRouter();

            // should throw exception in case of inexistent route
            $bankEntity = $paymentRouter->defineRouteFor($params["cc_type"]);

            // create cc object
            $ccData = new CreditCard($params);

            // create security check object and charge the data
            $securityCheckRouter = new SecurityCheck_Router();
            $securityCheck = $securityCheckRouter->version($params["api_version"]);
            $securityCheck->setParams($params);

            // Create DB Driver object
            $dbDriver = new DB_Driver();

            // create paymentEngine object
            $engine = new PaymentEngine();

            $amount = $params["charge_amount"];
            $currency = $params["charge_currency"];


            // inject dependencies
            $engine->setBankEntity($bankEntity);
            $engine->setRemoteApp($remoteApp);
            $engine->setCC($ccData);
            $engine->setSecurityCheck($securityCheck);
            $engine->setDbHandler($dbDriver);
            $engine->setAmount($amount);
            $engine->setCurrency($currency);
            if (!empty($params["ipn_endpoint"])) {
                $ipnEndpoint = new IpnEndpoint($params["ipn_endpoint"]);
                $engine->setIpnEndpoint($ipnEndpoint);
            }

            $engine->processPayment();

            // we should create another object to format the output
            return $engine->getXmlResponse();

        } catch (Exception $e) {
            echo $e->getMessage();

            return "<xml><success>0</success><error_message>" . $e->getMessage() . "</error_message></xml>";
        }

        return "<xml><success>1</success></xml>";
    }
}

