<?php

namespace App\Kernel\Infrastructures\Database;

interface IDatabaseConnection {
    public function connect(array $configs): void;
    public function getConnection(): mixed;
}