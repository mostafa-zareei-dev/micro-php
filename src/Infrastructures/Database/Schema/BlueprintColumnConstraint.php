<?php

namespace App\Kernel\Infrastructures\Database\Schema;

class BlueprintColumnConstraint {
    public const AUTO_INCREMENT = "AUTO_INCREMENT";
    public const PRIMARY_KEY = "PRIMARY KEY";
    public const UNIQUE = "UNIQUE";
    public const DEFAULT = "DEFAULT";
    public const NOT_NULL = "NOT NULL";
    public const FOREIGN_KEY = "FOREIGN KEY";
    public const CHECK = "CHECK";
    public const AFTER = "AFTER";
    public const BEFORE = "BEFORE";
}