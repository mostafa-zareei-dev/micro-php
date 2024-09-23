<?php

use App\Kernel\Infrastructures\Database\Schema\Blueprint;
use App\Kernel\Migrations\Migration;
use App\Kernel\Migrations\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string("name", 255);
            $table->string("email", 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('users'); 
    }
};