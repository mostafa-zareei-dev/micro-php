<?php

namespace App\Kernel\Infrastructures\Database\Schema;

use InvalidArgumentException;

class Blueprint implements IBlueprint, ISqlComponent
{
    private string $name = '';
    private array $columns = [];
    private array $dropColumns = [];

    public function __call(string $type, array $arguments)
    {
        $type = strtoupper($type);

        if (!defined(BlueprintColumnTypes::class . "::$type")) {
            throw new InvalidArgumentException("Invalid column type.");
        }

        [$columnName, $columnLength] = $arguments;

        $reflection = new \ReflectionClass(BlueprintColumnTypes::class);
        $columnType = $reflection->getConstant($type);
        $column = $this->createColumn($columnName, $columnType, $columnLength);
        $this->columns[$columnName] = $column;
    }

    public static function build(): static
    {
        return new static();
    }

    public function id(string $columnName = 'id'): BlueprintColumn
    {
        $column = $this->createColumn($columnName, BlueprintColumnTypes::INT, "11");
        $column->autoIncrement()->primary();
        $this->columns[$columnName] = $column;

        return $column;
    }

    public function timestamps(): BlueprintColumn
    {

        $column = $this->createColumn('created_at', BlueprintColumnTypes::DATETIME, "");
        $column->default('CURRENT_TIMESTAMP');
        $this->columns['created_at'] = $column;

        $column = $this->createColumn('updated_at', BlueprintColumnTypes::DATETIME, "");
        $column->default('CURRENT_TIMESTAMP');
        $this->columns['updated_at'] = $column;

        return $column;
    }

    public function dropColumn(string $columnName)
    {
        $this->dropColumns[] = $columnName;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function generateQuery(): string
    {
        $query = "CREATE TABLE IF NOT EXISTS $this->name (";

        $columns = array_map(function ($column) {
            return $column->generateQuery();
        }, $this->columns);
        $columns = implode(",\n", $columns);

        $query .= "\n{$columns}\n";
        $query .= ");";

        return $query;
    }

    public function generateAlterQuery(): string
    {
        $query = "ALTER TABLE {$this->name} ";

        $addSql = [];
        foreach ($this->columns as $column) {
            $addSql[] = "ADD COLUMN " . $column->generateQuery();
        }

        $dropSql = [];
        foreach ($this->dropColumns as $columnName) {
            $dropSql[] = "DROP COLUMN " . $columnName;
        }

        $query .= implode(", ", array_merge($addSql, $dropSql));

        return $query . ";";
    }

    public function generateDropQuery(): string
    {
        return "DROP TABLE IF EXISTS {$this->name};";
    }

    private function createColumn(string $columnName = "", string $type = BlueprintColumnTypes::STRING, string $columnLength = ""): BlueprintColumn
    {
        $column = new BlueprintColumn();
        $column->rename($columnName)->setType($type)->setTypeLength($columnLength);

        return $column;
    }
}
