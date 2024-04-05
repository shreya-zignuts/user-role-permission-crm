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
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('first_name');
      $table->string('last_name')->nullable();
      $table->string('email')->unique();
      $table->string('address')->nullable();
      $table->string('phone_number')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->tinyInteger('is_active')->default(1);
      $table
        ->enum('status', ['I', 'A', 'R'])
        ->default('I')
        ->comment('I: Inactive, A: Active, R: Rejected');
      $table->string('invitation_token')->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
};