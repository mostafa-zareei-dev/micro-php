<?php

namespace App\Kernel\Migrations;

interface IMigration {
    public function up(): void;
    public function down(): void;
}