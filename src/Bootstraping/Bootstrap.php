<?php

namespace App\Kernel\Bootstraping;

class Bootstrap
{
    public static function loadFunctions(): void
    {
        include ROOT_PATH . "src/Utility/functions.php";
    }
}
