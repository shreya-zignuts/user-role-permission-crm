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
    Schema::create('permission_modules', function (Blueprint $table) {
      $table->unsignedBigInteger('permission_id');
      $table
        ->foreign('permission_id')
        ->references('id')
        ->on('permissions')
        ->onDelete('cascade');
      $table->string('module_code');
      $table
        ->foreign('module_code')
        ->references('code')
        ->on('modules')
        ->onDelete('cascade');
      $table->tinyInteger('add_access')->default(0);
      $table->tinyInteger('view_access')->default(0);
      $table->tinyInteger('edit_access')->default(0);
      $table->tinyInteger('delete_access')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permission_modules');
  }
};
