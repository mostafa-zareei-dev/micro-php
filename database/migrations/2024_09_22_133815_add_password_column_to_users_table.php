<?php

use App\Kernel\Infrastructures\Database\Schema\Blueprint;
use App\Kernel\Migrations\Migration;
use App\Kernel\Migrations\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::alter('users', function(Blueprint $table) {
            $table->string("password", 255);
        });
    }

    public function down(): void
    {
        Schema::alter('users', function(Blueprint $table) {
            $table->dropColumn("password");
        }); 
    }
};