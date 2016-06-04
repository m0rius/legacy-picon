<?php

namespace Picon\Lib;

class View{

    protected   $layout;
    protected   $view;
    protected   $vars;

    protected   $isRenderedLayout;

    public function __construct($viewInfos, $vars = array()){
        $this->layout           =   $viewInfos["layout"]; 
        $this->view             =   $viewInfos["view"];
        $this->vars             =   $vars;
        $this->isRenderedLayout = false;
    }

    public function setView($viewName){
        $this->view     =  $viewName; 
    }

    public function setLayout($layoutName){
        $this->layout   =   $layoutName;
    }

    public function render($view = ""){
        // Here we render view && layout
        if(!$view && $this->layout && !$this->isRenderedLayout){
            $this->render("layout/" . $this->layout);
            $this->isRenderedLayout =   true;
            return true;
        }
        else if($view) {
           require Config::get_value("VIEW_DIR") . "/script/" . $view . ".phtml"; 
           return true;
        }
        return false;
    }

    public function loadVars(){
        foreach($this->vars as $name => $value){
            $this->$name    =   $value;
        }
    }
}
