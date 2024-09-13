<?php

function configs(string $key): array
{
    $appConfigs = include ROOT_PATH . "config/app.php";

    if (!array_key_exists($key, $appConfigs)) {
        throw new InvalidArgumentException("undefined $key in configs array.");
    }

    return $appConfigs[$key];
}

function dd(mixed $value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}
