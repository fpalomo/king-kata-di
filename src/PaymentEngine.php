<?php
require_once "BankEntityDriver/Abstract.php";
require_once "BankEntityDriver/A.php";
require_once "BankEntityDriver/B.php";
require_once "BankEntityDriver/C.php";
require_once "RemoteApp.php";
require_once "CreditCard.php";
require_once "SecurityCheck/Abstract.php";
require_once "IpnEndpoint.php";
require_once "DB/Driver.php";

class PaymentEngine
{
    protected $bankEntity;
    protected $remoteApp;
    protected $cc;
    protected $securityCheck;
    protected $ipnEndpoint;
    protected $dbDriver;
    protected $amount;
    protected $currency;

    protected $success;
    protected $errorMessage;

    public function __construct()
    {

    }

    public function setBankEntity(BankEntityDriver_Abstract $bankEntity)
    {
        $this->bankEntity = $bankEntity;
    }


    public function setRemoteApp(RemoteApp $remoteApp)
    {
        $this->remoteApp = $remoteApp;
    }


    public function setCC(CreditCard $cc)
    {
        $this->cc = $cc;
    }

    public function setSecurityCheck($securityCheck)
    {
        $this->securityCheck = $securityCheck;
    }

    public function setIpnEndpoint(IpnEndpoint $ipnEndpoint)
    {
        $this->ipnEndpoint = $ipnEndpoint;
    }

    public function setDbHandler(DB_Driver $dbDriver)
    {
        $this->dbDriver = $dbDriver;
    }

    public function getXmlResponse()
    {
        // TODO
    }


    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function processPayment()
    {

        try {
            // ensure security check validation
            $this->securityCheck->validate();

            // if ipn, check endpoint
            if (!empty($this->ipnEndpoint)) {
                $this->ipnEndpoint->ping();
            }

            // connect to the bank entity and process the payment
            // TODO
            // $this->bankEntity->requestTransaction();

            // store the payment status in our DB
            // TODO
            // $this->dbDriver->store($requestParams, $requestResponse);


            if (!empty($this->ipnEndpoint)) {
                // TODO
                // $this->ipnEndpoint->notify($this->getXmlResponse());
            }

            // generate response
            $response = $this->getXmlResponse();

            return $response;

        } catch (Exception $e) {
            $this->success = 0;
            $this->errorMessage = $e->getMessage();
        }
    }

}