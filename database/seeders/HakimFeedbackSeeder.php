<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Seeder;

class HakimFeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->take(3)->get();

        foreach ($users as $index => $user) {
            Feedback::updateOrCreate(
                ['user_id' => $user->id, 'message' => 'Feedback dari ' . $user->name],
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $index % 2 === 0 ? 'baru' : 'dibaca',
                ]
            );
        }

        Feedback::updateOrCreate(
            ['user_id' => null, 'email' => 'guest@example.com'],
            [
                'name' => 'Guest',
                'message' => 'Website mudah dipakai, mohon tambah fitur chat.',
                'status' => 'baru',
            ]
        );
    }
}
