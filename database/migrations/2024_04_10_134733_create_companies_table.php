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
    Schema::create('companies', function (Blueprint $table) {
      $table->id();
      $table->string('name', 64);
      $table->string('owner_name', 64);
      $table->string('industry', 64);
      $table->string('address')->nullable();
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
    Schema::dropIfExists('companies');
  }
};