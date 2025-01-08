<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admintimesworld@gmail.com'], 
            [
                'name' => 'Admin',
                'email' => 'admintimesworld@gmail.com',
                'password' => Hash::make('admin@123'),
            ]
        );
    }
}