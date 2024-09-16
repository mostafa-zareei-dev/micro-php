<?php

namespace App\Kernel\Models;

use App\Kernel\Core\App;
use App\Kernel\Infrastructures\Database\IDatabaseProvider;

abstract class Model
{
    protected string $tableName = "";
    protected string $primaryKey = "id";
    protected array $attributes = [];

    protected IDatabaseProvider $dbProvider;

    public function __construct()
    {
        $this->dbProvider = App::resolve(IDatabaseProvider::class);
    }

    public function all(array $columns = ["*"])
    {
        return $this->dbProvider->table($this->tableName)->all($columns);
    }

    public function create(array $data)
    {
        return $this->dbProvider->table($this->tableName)->save($data);
    }

    public function update(array $data, string $condition)
    {
        return $this->dbProvider->table($this->tableName)->update($data, $condition);
    }

    public function delete(string $condition)
    {
        return $this->dbProvider->table($this->tableName)->delete($condition);
    }
}
