<?php

include "RemoteApp.php";


class Bootstrap
{
    public function run($params = null)
    {

        try {
            // constructor should throw exception in case of unknown id
            $remoteApp = new RemoteApp($params["application_id"]);


        } catch (Exception $e) {
            return "<xml><success>0</success><error_message>".$e->getMessage()."</error_message></xml>";
        }

        return "<xml><success>1</success></xml>";
    }
}

