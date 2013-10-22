<?php

class RemoteApp
{
    protected $registeredApps = array(
        1   => "app1",
        2   => "app2",
        3   => "app3"
    );

    public function __construct($id){
        if(!isset($this->registeredApps[$id])){
            throw new Exception("Not registered app");
        }
    }
}