<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Company A',
            'email' => 'company@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'employer'
        ]);

        User::create([
            'name' => 'Freelancer A',
            'email' => 'free@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'freelancer'
        ]);
    }
}
