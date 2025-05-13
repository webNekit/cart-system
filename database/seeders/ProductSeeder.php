<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (TypeProduct::count() === 0) {
            $this->call(TypeProductSeeder::class);
        }

        $drives = ['механический', 'гидравлический', 'электрический'];
        $constructions = ['стальная', 'алюминиевая', 'комбинированная'];
        $typeIds = TypeProduct::pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Рохля модель ' . $i,
                'sku' => 'ROX-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'capacity' => rand(1000, 5000),
                'drive' => $drives[array_rand($drives)],
                'construction' => $constructions[array_rand($constructions)],
                'is_active' => true,
                'type_product_id' => $typeIds[array_rand($typeIds)], // Берем существующий ID
            ]);
        }
    }
}
