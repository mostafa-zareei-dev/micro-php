<?php

namespace App\Kernel\Infrastructures\Database;

interface IDatabaseProvider
{
    public function query(string $query, array $params): static;
    public function table(string $tableName): static;
    public function all(array $columns);
    public function update(array $params, string $where);
    public function save(array $data);
    public function delete(string $condition);
}
