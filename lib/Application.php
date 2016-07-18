<?php

namespace Picon\Lib;


class Application{

    public      $config;
    public      $router;
    public      $error;

    private     $controller;
    private     $view;
    protected   $currentRouteInfos;

    public function __construct($app_name = "Picon", $mode = ""){
        // Bootstraping main services
        $this->config               =   new Config(); 
        $this->router               =   new Router($mode);
        $this->error                =   new Error();

        // Get route infos 
        $this->currentRouteInfos    =   $this->router->route();
        if($this->currentRouteInfos["controller"]   == "_error_")
            throw new HttpException(404, $this->currentRouteInfos);

        //ob_start();
        $this->callControllerAction();
        $this->callView();
        //ob_end_flush();
    }

    public function callControllerAction(){
        $controller =   "App\\Controllers\\" . ucfirst($this->currentRouteInfos["controller"]) . "Controller";
        $action     =   ucfirst($this->currentRouteInfos["action"]) . "Action";   
        $this->controller   =   new $controller($this->currentRouteInfos, $this->config);
        $this->controller->_call_action($action);
    }

    public function callView(){
        $this->view =   new View($this->controller->getViewInfos(), $this->controller->getViewVars());
        $this->view->render();
    }

}
