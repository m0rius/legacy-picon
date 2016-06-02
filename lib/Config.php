<?php

namespace Picon\Lib;

class Config{

    public static $config_array;

    public function __construct($config_name = "default", $config_overload =   array()){
        $config                 =   parse_ini_file(realpath(__DIR__) . "/../app/configs/" . $config_name . ".ini", true);
        self::$config_array     =   ($config_overload) 
                                        ?   array_merge($config,$config_overload)
                                        :   $config;
        $this->populate_config();
    }

    private function populate_config(){
        self::$config_array["ROOT"]         =   realpath(__DIR__) . "/../";
        self::$config_array["LIB_DIR"]      =   realpath(__DIR__) . "/../lib";
        self::$config_array["APP_DIR"]      =   realpath(__DIR__) . "/../app";
        self::$config_array["ROUTE_DIR"]    =   self::$config_array["APP_DIR"]  . "/routes";
        self::$config_array["VIEW_DIR"]     =   self::$config_array["APP_DIR"]  . "/views"; 
        self::$config_array["CTRL_DIR"]     =   self::$config_array["APP_DIR"]  . "/controllers"; 
        self::$config_array["MODL_DIR"]     =   self::$config_array["APP_DIR"]  . "/models"; 
    }

    public static function get_value(...$levels){
        self::check_config();
        $toReturn   =   self::$config_array;
        foreach($levels as $level){
            $toReturn   =   $toReturn[$level];
        }
        return $toReturn;
    }

    public static function set_value($config_set    =   array()){
        self::check_config();
        self::$config_array =   array_merge(self::$config_array, $config_set);
    }

    private static function check_config(){
        if(!self::$config_array){
            die("CONFIG CLASS NEEDS TO BE INSTANCIATED AT LEAST ONCE!");
        }

    }

}
