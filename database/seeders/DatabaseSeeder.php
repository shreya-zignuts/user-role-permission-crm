<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'phone_number' => null,
                'address' => null,
                'is_active' => 1,
                'invitation_token' => null,
                'status' => 'A',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email'],
                ],
                [
                    'first_name' => 'Admin',
                    'last_name' => null,
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('password'),
                    'phone_number' => null,
                    'address' => null,
                    'is_active' => 1,
                    'invitation_token' => null,
                    'status' => 'A',
                ],
            );
        }

        User::whereNotIn('email', array_column($users, 'email'))->delete();

        $this->call(ModuleSeeder::class);
    }
}
