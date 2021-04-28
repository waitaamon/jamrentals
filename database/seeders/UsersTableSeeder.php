<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Amon Waita',
                'email' => 'devwaita@gmail.com',
                'password' => 'amon@100',
                'is_admin' => true
            ],
            [
                'name' => 'Migwi Mwangi',
                'email' => 'migwimwangi@gmail.com',
                'password' => 'mmwangi@100',
                'is_admin' => true
            ],
            [
                'name' => 'James Muchoki',
                'email' => 'jamuchoki@yahoo.com',
                'password' => 'jmuchoki@100',
                'is_admin' => true
            ],
        ];

        collect($users)->each(function ($user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'is_admin' => $user['is_admin']
            ]);
        });
    }
}
