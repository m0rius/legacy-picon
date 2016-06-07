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

    public function setSessionInfos($id, $level, $pseudo, $pass){
        $_SESSION["security"]["loggedin"]   =   true;
        $_SESSION["security"]["level"]      =   $level;
        $_SESSION["user"]["id"]             =   $id;
        $_SESSION["user"]["pseudo"]         =   $pseudo;
        $_SESSION["user"]["pass"]           =   $pass; 
    }

    public function unsetSessionInfos(){
        $_SESSION["security"]["loggedin"]   =   false;
        unset($_SESSION["security"]["level"]); 
        unset($_SESSION["user"]["id"]);    
        unset($_SESSION["user"]["pseudo"]);    
        unset($_SESSION["user"]["pass"]);       
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

    public function isLoggedIn(){
        return isset($_SESSION["security"]["loggedin"])
                    ?   $_SESSION["security"]["loggedin"]
                    :   false;
    }

    public function getAuthLevel(){
        return isset($_SESSION["security"]["level"])
                    ?   $_SESSION["security"]["level"]
                    :   false;
    }

}
