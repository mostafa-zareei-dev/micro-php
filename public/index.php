<?php

define("ROOT_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);

require ROOT_PATH . "vendor/autoload.php";

use App\Kernel\Core\App;

$app = new App();

$app->handle();