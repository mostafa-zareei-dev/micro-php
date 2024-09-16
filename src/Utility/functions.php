<?php

function configs(string $value): mixed
{
    list($targetConfig, $key) = explode(".", $value);
    $configs = include ROOT_PATH . "config/" . $targetConfig .".php";

    if(!is_array($configs) && !isset($configs)) {
        throw new Exception("The configs should be provided as an array.");
    }

    if (!array_key_exists($key, $configs)) {
        throw new InvalidArgumentException("undefined $key in configs array.");
    }

    return $configs[$key];
}

function dd(mixed $value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}
