<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for main modules
        $modules = [
            [
                'code' => 'ACC',
                'name' => 'Account',
                'description' => 'Main account module',
                'parent_code' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/account',
                'slug' => 'userside-account',
            ],
            [
                'code' => 'CNT',
                'name' => 'Contact',
                'description' => 'Main contact module',
                'parent_code' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/contact',
                'slug' => 'userside-contact',
            ],
            [
                'code' => 'NTS',
                'name' => 'Notes',
                'description' => 'Submodule for account module',
                'parent_code' => 'ACC', // Parent code for submodule under Account module
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/notes',
                'slug' => 'userside-notes',
            ],
            [
                'code' => 'MET',
                'name' => 'Meeting',
                'description' => 'Submodule for account module',
                'parent_code' => 'ACC',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/meeting',
                'slug' => 'userside-meeting',
            ],
            [
                'code' => 'ACT',
                'name' => 'Activity Logs',
                'description' => 'Submodule for account module',
                'parent_code' => 'ACC',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/activityLogs',
                'slug' => 'userside-activityLogs',
            ],
            [
                'code' => 'CMP',
                'name' => 'Company',
                'description' => 'Submodule for contact module',
                'parent_code' => 'CNT',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/company',
                'slug' => 'userside-company',
            ],
            [
                'code' => 'PPL',
                'name' => 'People',
                'description' => 'Submodule for contact module',
                'parent_code' => 'CNT',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'url' => '/userside/modules/people',
                'slug' => 'userside-people',
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(
                [
                    'code' => $module['code'],
                ],
                [
                    'name' => $module['name'],
                    'description' => $module['description'],
                    'is_active' => $module['is_active'],
                    'parent_code' => $module['parent_code'],
                    'url' => $module['url'],
                    'slug' => $module['slug'],
                ]
            );
        }

        Module::whereNotIn('code', array_column($modules, 'code'))->delete();
    }
}
