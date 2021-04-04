<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pavlos Kafritsas',
            'email' => 'pavkfr@hotmail.com',
            'password' => Hash::make('!password123!@#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('!password123!@#'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory()->count(30)->create();
    }
}
