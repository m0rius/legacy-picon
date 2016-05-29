<?php

namespace Picon\Lib;

class Controller{

    protected   $route;
    protected   $config;
    protected   $layout;

    public function __construct($route, $config){
        $this->config   =   $config;
        $this->route    =   $route;
    }

    public function pre_action(){

    }

    public function post_action(){

    }

}
