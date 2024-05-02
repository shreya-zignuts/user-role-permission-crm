<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('description', 256)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table
                ->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table
                ->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
