<?php

return [
    "driver" => "mysql",
    "provider" => "pdo",
    "configs" => [
        "host" => $_ENV['DB_HOST'],
        "db_name" => $_ENV['DB_NAME'],
        "user" => $_ENV['DB_USER'],
        "port" => $_ENV['DB_PORT'],
        "password" => $_ENV['DB_PASSWORD'],
        "charset" => $_ENV['DB_CHARSET']
    ],
];
