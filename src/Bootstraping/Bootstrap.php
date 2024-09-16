<?php

namespace App\Kernel\Bootstraping;

use Dotenv\Dotenv;

class Bootstrap
{
    public static $envPath = ROOT_PATH;

    public static function loadFunctions(): void
    {
        include ROOT_PATH . "src/Utility/functions.php";
    }

    public static function loadEnvVariables(string $path = '')
    {
        $dotenv = Dotenv::createImmutable(
            empty($path) ? self::$envPath : $path
        );
        $dotenv->load();
    }
}
