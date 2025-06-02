<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Администратор',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Рекомендуется изменить пароль после создания
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Менеджер',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'), // Рекомендуется изменить пароль после создания
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Инженер',
                'email' => 'engineer@example.com',
                'password' => Hash::make('password'), // Рекомендуется изменить пароль после создания
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Иванов И.И.',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // Рекомендуется изменить пароль после создания
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
