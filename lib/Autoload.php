<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
/*
spl_autoload_register(function($class){
    $directories        =   explode("\\" , $class);
    $sourceDirectory    =   realpath(__DIR__) . "/../";  

    if($directories[0] == "Picon"){
        array_shift($directories);
    } else{
        array_unshift($directories, "App");
    }

    foreach($directories as $key => $directory){
        $directories[$key]  =   isset($directories[$key + 1])
                                        ?   strtolower($directory)
                                        :   ucfirst($directory);
    }

    include $sourceDirectory . implode("/", $directories) . ".php"; 
});

*/
