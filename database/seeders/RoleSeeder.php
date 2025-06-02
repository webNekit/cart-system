<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'slug' => 'sonik32',
                'name' => 'менеджер',
                'permissions' => '{"platform.index": "1", "platform.parts": "0", "platform.clients": "1", "platform.perairs": "1", "platform.repairs": "1", "platform.products": "0", "platform.typeproducts": "0", "platform.systems.roles": "0", "platform.systems.users": "0", "platform.systems.attachment": "1"}'
            ],
            [
                'slug' => 'admin',
                'name' => 'Администратор',
                'permissions' => '{"platform.index": "1", "platform.parts": "1", "platform.clients": "1", "platform.perairs": "1", "platform.repairs": "1", "platform.products": "1", "platform.typeproducts": "1", "platform.systems.roles": "1", "platform.systems.users": "1", "platform.systems.attachment": "1"}'
            ],
            [
                'slug' => 'ingener',
                'name' => 'Инженер',
                'permissions' => '{"platform.index": "1", "platform.parts": "1", "platform.clients": "0", "platform.perairs": "1", "platform.repairs": "1", "platform.products": "1", "platform.typeproducts": "1", "platform.systems.roles": "0", "platform.systems.users": "0", "platform.systems.attachment": "1"}'
            ],
            [
                'slug' => 'user',
                'name' => 'Пользователь',
                'permissions' => '{"platform.index": "1", "platform.parts": "0", "platform.clients": "0", "platform.perairs": "0", "platform.repairs": "1", "platform.products": "0", "platform.typeproducts": "0", "platform.systems.roles": "0", "platform.systems.users": "0", "platform.systems.attachment": "0", "platform.user.repairs.request": "0"}'
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
