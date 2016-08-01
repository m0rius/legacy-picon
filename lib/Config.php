<?php

namespace Picon\Lib;

class Config{

    public static $config_array;
    
    const   ROOT_DIR    =   __DIR__ . "/../../../../";
    const   VEND_DIR    =   __DIR__ . "../";

    public function __construct($config_name = "default", $config_overload =   array()){
        $this->loadFromConfigFiles(); 
        $config_overload && self::$config_array = array_merge(self::$config_array,$config_overload);
        $this->populate_config();
    }

    private function populate_config(){
        self::$config_array["ROOT"]         =   realpath(self::ROOT_DIR); 
        self::$config_array["LIB_DIR"]      =   realpath(self::VEND_DIR) . "/lib";
        self::$config_array["APP_DIR"]      =   realpath(self::ROOT_DIR) . "/app";
        self::$config_array["CONF_DIR"]     =   self::$config_array["APP_DIR"]  . "/configs";
        self::$config_array["ROUTE_DIR"]    =   self::$config_array["APP_DIR"]  . "/routes";
        self::$config_array["VIEW_DIR"]     =   self::$config_array["APP_DIR"]  . "/views"; 
        self::$config_array["CTRL_DIR"]     =   self::$config_array["APP_DIR"]  . "/controllers"; 
        self::$config_array["MODL_DIR"]     =   self::$config_array["APP_DIR"]  . "/models"; 
    }

    private function loadFromConfigFiles($setClassAttribute = true){
       $configEntries   =   array(); 
       $configDir       =   self::$config_array["CONF_DIR"];
       $content         =   scandir($configDir, SCANDIR_SORT_DESCENDING);
       foreach($content as $f){
            $fPath  =   $configDir  . "/" . $f;
            if(is_file($fPath) && preg_match("/\.ini$/", $f)){
                $configEntries = array_merge(parse_ini_file($fPath, true), $configEntries);
            }
       }
        $setClassAttribute && self::$config_array = $configEntries;  
        return $configEntries;
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
