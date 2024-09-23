<?php

namespace App\Kernel\Infrastructures\Database\Schema;

class BlueprintColumn implements ISqlComponent
{
    private string $name = '';
    private string $type = '';
    private string $typeLength = '';
    private array $constraints = [];

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function typeLength(): string
    {
        return $this->typeLength;
    }

    public function rename(string $value): static
    {
        $this->name = $value;
        return $this;
    }

    public function setType(string $value): static
    {
        $this->type = $value;
        return $this;
    }

    public function setTypeLength(string $value): static
    {
        $this->typeLength = $value;
        return $this;
    }

    public function autoIncrement(): static
    {
        $this->constraints['auto_increment'] = BlueprintColumnConstraint::AUTO_INCREMENT;
        return $this;
    }

    public function primary(): static
    {
        $this->constraints['primary'] = BlueprintColumnConstraint::PRIMARY_KEY;
        return $this;
    }

    public function nullable(bool $value = true): static
    {
        if (!$value) {
            $this->constraints['nullable'] = BlueprintColumnConstraint::NOT_NULL;
        }

        return $this;
    }

    public function default(string $value): static
    {
        $this->constraints['default'] = BlueprintColumnConstraint::DEFAULT . " $value";
        return $this;
    }

    public function unique(): static
    {
        $this->constraints['unique'] = BlueprintColumnConstraint::UNIQUE;
        return $this;
    }

    public function check(string $condition): static
    {
        $this->constraints['check'] = BlueprintColumnConstraint::CHECK . "($condition)";
        return $this;
    }

    public function after(string $columnName): static
    {
        $this->constraints['after'] = BlueprintColumnConstraint::AFTER . " $columnName";
        return $this;
    }

    public function before(string $columnName): static
    {
        $this->constraints['before'] = BlueprintColumnConstraint::BEFORE . " $columnName";
        return $this;
    }

    public function generateQuery(): string
    {
        $typeLength = !empty($this->typeLength()) ? "({$this->typeLength()})" : "";

        $query = "{$this->name()} {$this->type()}{$typeLength}";

        foreach ($this->constraints as $key => $constraint) {
            $query .= " $constraint";
        }

        return $query;
    }
}
