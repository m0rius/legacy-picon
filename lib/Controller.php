<?php

namespace Picon\Lib;

class Controller{

    protected   $route;
    protected   $layout;
    protected   $view;
    protected   $viewVars;

    public function __construct($route){
        $this->route    =   $route;
        $this->viewVars =   array();
        $this->setView();
        $this->setLayout();
    }

    public function pre_action(){

    }

    public function post_action(){

    }

    public function set(...$vars){
        $this->viewVars =   array_merge($this->viewVars, $vars);
    }

    public function setView($viewName   =   null, $viewDir = ""){
        !isset($viewName)   && $viewName    =   $this->route["action"]; 
        !$viewDir           && $viewDir     =   $this->route["controller"];
        $this->view =   !$viewName  ? "" : strtolower($viewDir . "/" . $viewName); 
    
    }

    public function setLayout($layout = null){ 
        !isset($layout) &&  $layout =   "default";
        !$this->view    &&  $layout =   "";
        $this->layout   =   $layout;
    }


    public function getViewVars(){
        return $this->viewVars;
    }


    public function getViewInfos(){
        return array(
            "view"      =>  $this->view,
            "layout"    =>  $this->layout
        );
    }

    public function _call_action($action){
        call_user_func(array($this, "pre_action"));
        call_user_func_array(array($this, $action), $this->route["params"]);
        call_user_func(array($this, "post_action"));
    }

}
