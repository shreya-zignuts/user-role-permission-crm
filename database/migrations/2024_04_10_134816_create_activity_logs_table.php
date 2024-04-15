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
    Schema::create('activity_logs', function (Blueprint $table) {
      $table->id();
      $table->string('title', 64);
      $table->string('log');
      $table
        ->enum('type', ['C', 'M', 'P', 'V'])
        ->default('C')
        ->comment('C: Coding, M: Meeting, P: Playing, V: Watching Video');
      $table->tinyInteger('is_active')->default(1);
      $table->unsignedBigInteger('user_id');
      $table
        ->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('activity_logs');
  }
};
