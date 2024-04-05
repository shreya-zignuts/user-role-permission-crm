<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ModuleSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    \App\Models\User::create([
      'first_name' => 'Admin',
      'email' => 'admin@gmail.com',
      'password' => Hash::make('Admin@3303'),
      'is_active' => '1',
      'status' => 'A',
    ]);

    $this->call(ModuleSeeder::class);
  }
}
