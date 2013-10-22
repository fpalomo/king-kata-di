<?php

class IpnEndpoint
{
    protected $endpointUrl;

    public function __construct($endpointUrl)
    {
        $this->endpointUrl = $endpointUrl;
    }


    public function ping()
    {
        // TODO
    }

}