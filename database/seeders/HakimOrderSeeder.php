<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HakimOrderSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('hakim_orders')->exists()) {
            return;
        }

        $users = User::where('role', 'user')->take(2)->get();

        if ($users->count() < 2) {
            return;
        }

        DB::table('hakim_orders')->insert([
            [
                'user_id' => $users[0]->id,
                'receiver_name' => $users[0]->name,
                'phone' => $users[0]->phone ?? '082111111111',
                'address' => 'Jl. Mawar No. 10, Bandung',
                'note' => 'Kirim sore hari',
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $users[1]->id,
                'receiver_name' => $users[1]->name,
                'phone' => $users[1]->phone ?? '083111111111',
                'address' => 'Jl. Melati No. 5, Cimahi',
                'note' => null,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
