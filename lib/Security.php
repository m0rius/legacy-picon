<?php

namespace Picon\Lib;

class Security{

    private $enabled;
    private $pass;
    private $logginAddr;

    public function __construct(){
       $this->enabled       =   Config::get_value("security", "enabled");
       $this->logginAddr    =   Config::get_value("security", "login");
       $this->pass          =   false;
    }

    public function disable(){
        $this->enabled  =   false;
    }

    public function check($levelMin = 1){
        if(!$this->enabled || $_SESSION["security"]["loggedin"] && $_SESSION["security"]["level"] >= $levelMin){
            $this->accept();
        }
        else{
            $this->reject();
        }
    }

    public function setSessionInfos($level, $pseudo, $pass, $mail){
        $_SESSION["security"]["loggedin"]   =   true;
        $_SESSION["security"]["level"]      =   $level;
        $_SESSION["user"]["pseudo"]         =   $pseudo;
        $_SESSION["user"]["pass"]           =   $pass; 
        $_SESSION["user"]["mail"]           =   $mail;
    }

    public function unsetSessionInfos(){
        $_SESSION["security"]["loggedin"]   =   false;
        unset($_SESSION["security"]["level"]); 
        unset($_SESSION["user"]["pseudo"]);    
        unset($_SESSION["user"]["pass"]);       
        unset($_SESSION["user"]["mail"]);         
    }

    public function reject(){
        // Useless ?
        http_response_code(403);
        header("Location: " . $this->logginAddr);
    }

    public function accept(){
        $this->pass =   true;
        return true;
    }

}
