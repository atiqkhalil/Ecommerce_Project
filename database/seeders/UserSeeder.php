<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect([
            [
                'name' => 'Atiq',
                'email' => 'atiq@gmail.com',
                'password' => Hash::make('1234'),
            ],
            [
                'name' => 'Ayan',
                'email' => 'ayan@gmail.com',
                'password' => Hash::make('1234'),
            ],
        ]);

        $users->each(function ($user){
            User::insert($user);
        });
    }
}
