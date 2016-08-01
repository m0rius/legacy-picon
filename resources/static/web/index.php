<?php
session_start();
include realpath(__DIR__) . "/../vendor/zadochob/picon/lib/Autoload.php";

use \Picon\Lib\Application as Application;

$app = new Application();

