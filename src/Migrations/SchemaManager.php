<?php

namespace App\Kernel\Migrations;

use App\Kernel\Infrastructures\Database\IDatabaseProvider;
use App\Kernel\Infrastructures\Database\Schema\Blueprint;

class SchemaManager
{
    private IDatabaseProvider $dbProvider;

    public function __construct(IDatabaseProvider $dbProvider)
    {
        $this->dbProvider = $dbProvider;
    }

    public function create(string $tableName, callable $handler)
    {
        $blueprint = Blueprint::build();
        $blueprint->setName($tableName);
        call_user_func($handler, $blueprint);

        $query = $blueprint->generateQuery();
        $this->dbProvider->query($query, []);
    }

    public function alter(string $tableName, callable $handler)
    {
        $blueprint = Blueprint::build();
        $blueprint->setName($tableName);
        call_user_func($handler, $blueprint);

        $query = $blueprint->generateAlterQuery();
        $this->dbProvider->query($query, []);
    }

    public function drop(string $tableName)
    {
        $blueprint = Blueprint::build();
        $blueprint->setName($tableName);
        $query = $blueprint->generateDropQuery();
        $this->dbProvider->query($query, []);
    }
}
