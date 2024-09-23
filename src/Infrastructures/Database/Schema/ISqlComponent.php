<?php

namespace App\Kernel\Infrastructures\Database\Schema;

interface ISqlComponent {
    public function generateQuery(): string;
}