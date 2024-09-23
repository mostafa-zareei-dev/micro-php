<?php

namespace App\Kernel\Infrastructures\Database\Schema;

interface IBlueprint {
    public function generateAlterQuery(): string;
    public function generateDropQuery(): string;
}