<?php

namespace Picon\Lib;

class View{

    protected   $layout;
    protected   $view;
    protected   $vars;

    protected   $_messages;
    protected   $_errors;

    protected   $isRenderedLayout;

    public function __construct($viewInfos, $vars = array()){
        $this->layout           =   $viewInfos["layout"]; 
        $this->view             =   $viewInfos["view"];
        $this->vars             =   $vars;
        $this->loadVars();
        $this->loadMessages();
        $this->loadErrors();
        $this->isRenderedLayout = false;
    }

    public function setView($viewName){
        $this->view     =  $viewName; 
    }

    public function setLayout($layoutName){
        $this->layout   =   $layoutName;
    }

    public function loadMessages(){
        $this->_messages        =   array();
        $updatedArray           =   array();
        !isset($_SESSION["voice"]["messages"]) && $_SESSION["voice"]["messages"] = array();
        foreach($_SESSION["voice"]["messages"] as $message){
            $this->_messages[]    =   $message["msg"];
            $message["timeleft"]    -= 1;
            if($message["timeleft"]){
               $updatedArray[]  =   $message;  
            };
        }
        $_SESSION["voice"]["messages"]    =   $updatedArray;
    }

    public function loadErrors(){
        $this->_errors          =   array();
        $updatedArray           =   array();
        !isset($_SESSION["voice"]["errors"]) && $_SESSION["voice"]["errors"] = array();
        foreach($_SESSION["voice"]["errors"] as $level => $levelGroup){
            foreach($levelGroup as $error){ 
                $this->_errors[$level][]    =   $error["msg"];
                $error["timeleft"]  -= 1;
                if($error["timeleft"]){
                   $updatedArray[$level][]  =   $error;  
                };
            }
        }
        $_SESSION["voice"]["errors"] = $updatedArray;
    }

    public function render($view = ""){
        // Here we render view && layout
        if(!$view && $this->layout && !$this->isRenderedLayout){
            $this->isRenderedLayout =   true;
            $this->render("_layout/" . $this->layout);
            return true;
        }
        !$view && $this->view && $view = $this->view;
        if($view) {
           require Config::get_value("VIEW_DIR") . "/" . $view . ".phtml"; 
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
