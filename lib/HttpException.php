<?php

namespace Picon\Lib;


class HttpException extends \Exception{

    const   EXC_CODE    =   1234567890000;

    public $http_code;
    public $route;

    public function __construct($code = 500, $route = array(), $message = "An http error has been trigerred"){
        $this->http_code    =   $code;
        $this->route        =   $route;
        parent::__construct($message, self::EXC_CODE);
    }
    
    public function __toString(){
        return __CLASS__ . "::" . $this->http_code ." - " . $this->message . " \nROUTE : \n " . print_r($this->route, true);
    }
}

