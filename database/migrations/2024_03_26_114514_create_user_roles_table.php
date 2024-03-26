<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('user_roles', function (Blueprint $table) {
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('role_id');

      // Foreign key constraints
      $table
        ->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
      $table
        ->foreign('role_id')
        ->references('id')
        ->on('roles')
        ->onDelete('cascade');

      $table->timestamps();

      $table->unique(['user_id', 'role_id']);

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
    Schema::dropIfExists('user_roles');
  }
};