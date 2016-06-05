<?php

namespace Picon\Lib;

class Model{

    static protected $db;

    public function __construct(){
        $this->setConnection();
    }

    protected function setConnection($force = false){
        $connectionInfos    =   Config::get_value("db");
        $connectionString   =   "mysql:host=localhost;dbname=" . $connectionInfos["name"];
        if(!isset(self::$db) || $force){
            try{
                self::$db   =   new \PDO($connectionString, $connectionInfos["user"], $connectionInfos["pass"]);
            } catch (PDOException $e){
                throw new HttpException(500, $e->getMessage());
            }
        }
        return self::$db;

    }

    protected function getConnection(){
        if(!isset(self::$db)){
            $this->setConnection();
        }
        return self::$db;
    }

}
