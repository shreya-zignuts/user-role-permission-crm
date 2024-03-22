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
    Schema::create('modules', function (Blueprint $table) {
      $table->string('code', 8)->primary();
      $table->string('name', 64);
      $table->string('description', 256)->nullable();
      $table->string('parent_code', 8)->nullable(); // Foreign key
      $table->tinyInteger('is_active')->default(1);
      $table->timestamps();

      // Add foreign key constraint
      $table
        ->foreign('parent_code')
        ->references('code')
        ->on('modules')
        ->onDelete('set null');

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
    Schema::dropIfExists('modules');
  }
};
