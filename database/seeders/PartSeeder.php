<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parts = [
            'Гидравлический насос',
            'Ручка управления',
            'Колесо полиуретановое',
            'Колесо чугунное',
            'Подшипник',
            'Вал',
            'Шланг гидравлический',
            'Поршень',
            'Аккумулятор',
            'Электронный блок управления',
        ];

        $products = Product::all();

        foreach ($products as $product) {
            foreach ($parts as $partName) {
                Part::create([
                    'product_id' => $product->id,
                    'name' => $partName,
                    'quantity' => rand(0, 10),
                    'is_active' => true,
                ]);
            }
        }
    }
}
