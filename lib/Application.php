<?php

namespace Picon\Lib;

use Picon\Lib\Config    as Config;
use Picon\Lib\Exception as Exception_Handler;
use Picon\Lib\Router    as Router;

class Application{

    public      $config;
    public      $router;

    protected   $currentController;
    public function __construct($app_name = "Picon"){
        $this->config   =   new Config(); 
        $this->router   =   new Router();

        $route_infos    =   $this->router->route();
        //$this->currentController    =  $route_infos["controller"]; 
    }

}
