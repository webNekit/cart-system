<?php

namespace Database\Seeders;

use App\Models\TypeProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Гидравлическая тележка', 'is_active' => true],
            ['name' => 'Электротележка', 'is_active' => true],
            ['name' => 'Рохля с весами', 'is_active' => true],
            ['name' => 'Низкоподъемная тележка', 'is_active' => true],
            ['name' => 'Высокоподъемная тележка', 'is_active' => true],
            ['name' => 'Тележка с платформой', 'is_active' => true],
            ['name' => 'Тележка для бочек', 'is_active' => true],
            ['name' => 'Тележка для контейнеров', 'is_active' => true],
            ['name' => 'Тележка с подъемным механизмом', 'is_active' => true],
            ['name' => 'Специальная тележка', 'is_active' => true],
        ];

        foreach ($types as $type) {
            TypeProduct::create($type);
        }
    }
}
