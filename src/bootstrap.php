<?php

include "RemoteApp.php";
include "PaymentEngine.php";
include "PaymentRouter.php";



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

            $engine = new PaymentEngine();
            $engine->setBankEntity($bankEntity);
            $engine->setRemoteApp($remoteApp);
            $engine->setTransactionInfo($ccData);
            $engine->setSecurityCheck($securityCheck);

        } catch (Exception $e) {
            return "<xml><success>0</success><error_message>".$e->getMessage()."</error_message></xml>";
        }

        return "<xml><success>1</success></xml>";
    }
}

