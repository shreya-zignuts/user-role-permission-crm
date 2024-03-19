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
    public function run() : void
    {
        // Seed data for main modules
        DB::table('modules')->insert([
            [
                'code' => 'ACC',
                'name' => 'Account',
                'description' => 'Main account module',
                'parent_code' => null, // Since it's a main module, parent_code is null
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'CNT',
                'name' => 'Contact',
                'description' => 'Main contact module',
                'parent_code' => null, // Since it's a main module, parent_code is null
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed data for submodules
        DB::table('modules')->insert([
            [
                'code' => 'NTS',
                'name' => 'Notes',
                'description' => 'Submodule for account module',
                'parent_code' => 'ACC', // Parent code for submodule under Account module
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
              'code' => 'MET',
              'name' => 'Meeting',
              'description' => 'Submodule for account module',
              'parent_code' => 'ACC', // Parent code for submodule under Account module
              'is_active' => 1,
              'created_at' => now(),
              'updated_at' => now(),
          ],
          [
            'code' => 'ACT',
            'name' => 'Activity Logs',
            'description' => 'Submodule for account module',
            'parent_code' => 'ACC', // Parent code for submodule under Account module
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
            // Add more submodules for Account module
            [
                'code' => 'CMP',
                'name' => 'Company',
                'description' => 'Submodule for contact module',
                'parent_code' => 'CNT', // Parent code for submodule under Contact module
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PPL',
                'name' => 'People',
                'description' => 'Submodule for contact module',
                'parent_code' => 'CNT', // Parent code for submodule under Contact module
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more submodules for Contact module
        ]);
      }
}