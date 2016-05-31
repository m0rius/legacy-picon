<?php

namespace Picon\Lib;


class Application{

    public      $config;
    public      $router;
    public      $error;

    private     $controller;
    protected   $currentRouteInfos;

    public function __construct($app_name = "Picon"){
        $this->config               =   new Config(); 
        $this->router               =   new Router();
        $this->error                =   new Error();
        $this->currentRouteInfos    =   $this->router->route();
        if($this->currentRouteInfos["controller"]   == "_error_")
            throw new HttpException(404, $this->currentRouteInfos);
        ob_start();
        $this->callControllerAction();
        $this->callView();
        ob_end_flush();
    }

    public function callControllerAction(){
        $controller =   "Controllers\\" . ucfirst($this->currentRouteInfos["controller"]) . "Controller";
        $action     =   ucfirst($this->currentRouteInfos["action"]) . "Action";   
        $this->controller   =   new $controller($this->currentRouteInfos, $this->config);
        $this->controller->_call_action($action);
    }

    public function callView(){

    }

}
