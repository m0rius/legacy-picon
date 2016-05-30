<?php

namespace Picon\Lib;

use Picon\Lib\Config    as Config;
use Picon\Lib\Router    as Router;
use Picon\Lib\Error     as Error;

class Application{

    public      $config;
    public      $router;
    public      $error;

    protected   $currentController;

    public function __construct($app_name = "Picon"){
        $this->config   =   new Config(); 
        $this->router   =   new Router();
        $this->error    =   new Error();
        $route_infos    =   $this->router->route();
        if($route_infos["controller"]   == "_error_")
            throw new HttpException(404, $route_infos);
    }

    public function callControllerAction(){

    }

    public function callView(){

    }

}
