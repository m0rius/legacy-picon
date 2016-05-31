<?php

namespace Picon\Lib;

class Controller{

    protected   $route;
    protected   $config;
    protected   $layout;
    protected   $viewVars;

    public function __construct($route, $config){
        $this->config   =   $config;
        $this->route    =   $route;
        $this->layout   =   "default";
        $this->viewVars =   array();
    }

    public function pre_action(){

    }

    public function post_action(){

    }

    public function set(...$vars){
        $this->viewVars =   array_merge($this->viewVars, $vars);

    }

    public function getViewVars(){
        return $this->viewVars;
    }

    public function _call_action($action){
        call_user_func(array($this, "pre_action"));
        call_user_func_array(array($this, $action), $this->route["params"]);
        call_user_func(array($this, "post_action"));
    }

}
