<?php

namespace App\Kernel\Migrations;

use App\Kernel\Core\App;
use InvalidArgumentException;

class Schema
{
    private static $methods = ["create", "drop", "alter"];

    public static function __callStatic(string $method, array $arguments): void
    {
        if (!in_array($method, self::$methods)) {
            throw new InvalidArgumentException("method {$method} not allowed.");
        }

        if ($method == "drop") {
            $action = null;
            [$tableName] = $arguments;
        } else {
            [$tableName, $action] = $arguments;
        }


        if (self::isInvalidTableName($tableName)) {
            throw new InvalidArgumentException("table name: $tableName must be string.");
        }

        if ($method !== "drop" && self::isInvalidAction($action)) {
            throw new InvalidArgumentException("action must be a valid function.");
        }

        $schemaManager = App::resolve(SchemaManager::class);

        call_user_func([$schemaManager, $method], $tableName, $action);
    }

    private static function isInvalidTableName(mixed $tableName): bool
    {
        return empty($tableName) && !is_string($tableName);
    }

    private static function isInvalidAction(mixed $action): bool
    {
        return !isset($action) && empty($action) && !is_callable($action);
    }
}
