<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'phone' => '081111111111',
                'role' => 'admin',
            ],
            [
                'name' => 'Hakim',
                'email' => 'hakim@example.com',
                'phone' => '082111111111',
                'role' => 'user',
            ],
            [
                'name' => 'Siti',
                'email' => 'siti@example.com',
                'phone' => '083111111111',
                'role' => 'user',
            ],
            [
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'phone' => '084111111111',
                'role' => 'user',
            ],
            [
                'name' => 'Rina',
                'email' => 'rina@example.com',
                'phone' => '085111111111',
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'role' => $user['role'],
                    'password' => Hash::make('12345678'),
                ]
            );
        }
    }
}
