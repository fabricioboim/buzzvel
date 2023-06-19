<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'User Buzzvel',
                'email' => 'userBuzz@buzzvel.com',
                'password' => bcrypt('Buzz@123'),
            ],
        ]);
    }
}
