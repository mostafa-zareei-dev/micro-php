<?php

namespace App\Kernel\Infrastructures\Database\Providers;

use App\Kernel\Infrastructures\Database\DatabaseProvider;
use PDOStatement;

class PDOProvider extends DatabaseProvider
{
    private PDOStatement $statement;

    public function query(string $query, array $params = []): static
    {
        $this->statement = $this->db->getConnection()->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function all(array $columns = ["*"])
    {
        $columns = implode(", ", $columns);

        $this->query = "SELECT $columns FROM $this->tableName";
        return $this->query($this->query)->statement->fetchAll();
    }

    public function find(array $columns = ["*"], array $params = [], string $where = ''): array | false
    {
        $columns = implode(", ", $columns);

        $this->query = "SELECT $columns FROM $this->tableName WHERE $where";
        return $this->query($this->query, $params)->statement->fetch();
    }

    public function update(array $params = [], string $where = "")
    {
        $params = array_map(fn($col) => "$col = :$col",  array_keys($params));
        $set = implode(", ", $params);

        $this->where = $where;
        $this->query = "UPDATE $this->tableName SET $set WHERE $this->where";

        return $this->query($this->query, $params)->rowCount();
    }

    public function save(array $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $this->query = "INSERT INTO $this->tableName ($columns) VALUES ($placeholders)";

        return $this->query($this->query, $data)->rowCount();
    }

    public function delete(array $params = [], string $condition = ""): int
    {
        $sql = "DELETE FROM $this->tableName WHERE $condition";
        return $this->query($sql, $params)->rowCount();
    }

    private function rowCount(): int
    {
        return $this->statement->rowCount();
    }
}
