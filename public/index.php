<?php

define("ROOT_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);

require ROOT_PATH . "vendor/autoload.php";

use App\Kernel\Core\App;
use App\Kernel\Bootstraping\Bootstrap;

Bootstrap::loadFunctions();
Bootstrap::loadEnvVariables();

$app = new App();

$app->handle();
