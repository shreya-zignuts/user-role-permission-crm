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
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('designation', 64);
            $table->string('email', 128);
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->unsignedBigInteger('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('peoples');
    }
};
