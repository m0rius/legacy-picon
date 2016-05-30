<?php

namespace Picon\Lib;

use Picon\Lib\Config as Config;

class Error{

    public function __construct(){
        $this->loadExceptionHandler();
        
    }

    public function loadExceptionHandler(){
        set_exception_handler("Picon\Lib\Error::ExceptionHandler");
    }

    public function loadErrorHandler(){
        set_error_handler("Picon\Lib\Error::ErrorHandler");

    }

    public function ExceptionHandler( $ex ){
        $class  =   get_class($ex);
        if($class == "Picon\Lib\HttpException"){
            http_response_code($ex->http_code);
        }
        else{
            http_response_code(500);
        }
        die($ex);
    }

    public function ErrorHandler(){

    }

}
