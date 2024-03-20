<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Seed data for main modules
    DB::table('modules')->insert([
      [
        'code' => 'ACC',
        'name' => 'Account',
        'description' => 'Main account module',
        'parent_code' => null,
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'CNT',
        'name' => 'Contact',
        'description' => 'Main contact module',
        'parent_code' => null,
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'NTS',
        'name' => 'Notes',
        'description' => 'Submodule for account module',
        'parent_code' => 'ACC', // Parent code for submodule under Account module
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'MET',
        'name' => 'Meeting',
        'description' => 'Submodule for account module',
        'parent_code' => 'ACC',
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'ACT',
        'name' => 'Activity Logs',
        'description' => 'Submodule for account module',
        'parent_code' => 'ACC',
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'CMP',
        'name' => 'Company',
        'description' => 'Submodule for contact module',
        'parent_code' => 'CNT',
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'PPL',
        'name' => 'People',
        'description' => 'Submodule for contact module',
        'parent_code' => 'CNT',
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'DSB',
        'name' => 'Dashboard',
        'description' => 'Main Dashboard Module',
        'parent_code' => 'CNT',
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'MOM',
        'name' => 'Module Management',
        'description' => 'Main Module Management Module',
        'parent_code' => null,
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'PRM',
        'name' => 'Permission Management',
        'description' => 'Main Dashboard Module',
        'parent_code' => null,
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'RLE',
        'name' => 'Role Management',
        'description' => 'Main Dashboard Module',
        'parent_code' => null,
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
      [
        'code' => 'USR',
        'name' => 'User Management',
        'description' => 'Main Dashboard Module',
        'parent_code' => null,
        'is_active' => 0,
        'created_at' => null,
        'updated_at' => null,
      ],
    ]);
  }
}
