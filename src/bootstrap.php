<?php

require_once "RemoteApp.php";
require_once "PaymentEngine.php";
require_once "PaymentRouter.php";
require_once "CreditCard.php";
require_once "SecurityCheck.php";

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

            // create security check object
            $securityCheckRouter = new SecurityCheck_Router();
            $securityCheck = $securityCheckRouter->version($params["api_version"]);

            // create paymentEngine object
            $engine = new PaymentEngine();

            // inject dependencies
            $engine->setBankEntity($bankEntity);
            $engine->setRemoteApp($remoteApp);
            $engine->setCC($ccData);
            $engine->setSecurityCheck($securityCheck);
            if (!empty($params["ipn_endpoint"])) {
                $ipnEndpoint = new IpnEndpoint($params["ipn_endpoint"]);
                $engine->setIpnEndpoint($ipnEndpoint);
            }

            $result = $engine->processPayment();

            return $result;

        } catch (Exception $e) {
            echo $e->getMessage();

            return "<xml><success>0</success><error_message>" . $e->getMessage() . "</error_message></xml>";
        }

        return "<xml><success>1</success></xml>";
    }
}

