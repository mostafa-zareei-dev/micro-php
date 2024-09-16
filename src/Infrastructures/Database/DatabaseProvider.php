<?php

namespace App\Kernel\Infrastructures\Database;

abstract class DatabaseProvider implements IDatabaseProvider
{
    protected IDatabaseConnection $db;
    protected string $query = '';
    protected string $tableName = '';
    protected string $where = '';

    public function __construct(IDatabaseConnection $db)
    {
        $this->db = $db;
    }

    public function table(string $tableName): static
    {
        $this->tableName = $tableName;
        return $this;
    }
}
