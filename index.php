<?php

declare(strict_types=1);

use app\Models\Utils\DatabaseUtility;
use app\Controllers\RouteController;

function autoLoad($class)
{
    require (\str_replace('\\', '/', $class) . '.php');
}

spl_autoload_register("autoload");
DatabaseUtility::connect("localhost", "root", "1234", "imagelibrary");
$router = new RouteController();
$router->process($_SERVER['REQUEST_URI']);
