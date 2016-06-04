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
        $class          =   get_class($ex);
        $httpErrorCode  =   ($class == "Picon\Lib\HttpException") ? $ex->http_code : 500;

        try{
            http_response_code($httpErrorCode);
            $errorApp   =   new Application("__error__", "__error__");
        } catch (Exception $e){
            http_response_code(500);
            die();
        }

    }

    public function ErrorHandler($errno, $errstr){
        //TODO : replace this
        http_response_code(500);
        die($errno . " :: " . $errstr);
    }

}
