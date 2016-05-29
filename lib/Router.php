<?php

namespace Picon\Lib;

use Picon\Lib\Config    as Config;

class Router{

    public  $routesRules;
    
    public function __construct(){
        $this->loadRules();
    }

    public function route(){
        $route  =   array();

        $contentUri     =   $_SERVER["REQUEST_URI"];
        if($_SERVER["QUERY_STRING"]){
            $contentUri =  substr($contentUri, 0, - (strlen($_SERVER["QUERY_STRING"]) + 1)); 
        }


        foreach($this->routesRules as $ruleSet){
            if(preg_match("/^" . preg_quote($ruleSet["pattern"], "/") . "(\/.*)?$/", $contentUri)){
                !(isset($ruleSet["action"]) && $ruleSet["action"]) && $ruleSet["action"] = "index";
                !(isset($ruleSet["params"]) && $ruleSet["params"]) && $ruleSet["params"] = array();

                $params             =   array();
                $unhandled_params   =   array();

                $paramsUri          =   (isset($ruleSet["params"]) && $ruleSet["params"])
                                        ?   explode("/", trim(substr($contentUri, strlen($ruleSet["pattern"])), "/"))
                                        :   array();


                foreach($ruleSet["params"] as $number => $param){
                    $params[$param] =   (isset($paramsUri[$number]))
                                            ?   $paramsUri[$number]
                                            :   "";
                }

                count($paramsUri) > count($ruleSet["params"]) && $unhandled_params =   array_chunk($paramsUri, (count($paramsUri) - count($params)), true)[1];

                $route  =   array(
                    "controller"        =>  $ruleSet["controller"],
                    "action"            =>  (isset($ruleSet["action"]) && $ruleSet["action"]) ? $ruleSet["action"] : "index",
                    "params"            =>  $params,
                    "unhandled_params"  =>  $unhandled_params
                );
                break;
            }

        }

        !$route &&  $route  =   array(
            "controller"        =>  "_error_",
            "action"            =>  "_not_found_",
            "params"            =>  array(),
            "unhandled_params"  =>  array()
        );

        $route["effective_uri"]         =   $contentUri;
        $route["method"]                =   $_SERVER["REQUEST_METHOD"];
        $route["server_query_string"]   =   $_SERVER["QUERY_STRING"];
        $route["server_request_uri"]    =   $_SERVER["REQUEST_URI"];

        return $route;
    }

    public function loadRules($setClassAttribute = true){
        $routesRules    =   array();
        $routesDir      =   Config::get_value("ROUTE_DIR");
        $content        =   scandir($routesDir, SCANDIR_SORT_DESCENDING);
        foreach($content as $f){
            $fPath  =   $routesDir . "/" . $f;
            if(is_file($fPath) && preg_match("/\.ini$/", $f)){
                $routesRules = array_merge(parse_ini_file($fPath, true), $routesRules);
            }
        }
        $setClassAttribute && $this->routesRules = $routesRules;
        return $routesRules;
    }

    public function get_request_infos(){
    }

    public function get_routes_infos(){
    }
    
}
