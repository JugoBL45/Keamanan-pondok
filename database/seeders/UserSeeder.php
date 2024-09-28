<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'      => 'Administrator',
                'username'  => 'admin',
                'password'  => bcrypt('admin'),
                'role'      => 1
            ],
            [
                'name'      => 'Pengurus',
                'username'  => 'pengurus',
                'password'  => bcrypt('pengurus'),
                'role'      => 2
            ],
            [
                'name'      => 'Pengasuh',
                'username'  => 'pengasuh',
                'password'  => bcrypt('pengasuh'),
                'role'      => 3
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
