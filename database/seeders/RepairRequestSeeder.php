<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Product;
use App\Models\RepairRequest;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('ru_RU');
        $statuses = ['in_progress', 'completed', 'pending'];

        $products = Product::all();
        $clients = Client::all();

        foreach ($products as $product) {
            $parts = $product->parts;

            for ($i = 0; $i < 2; $i++) {
                RepairRequest::create([
                    'product_id' => $product->id,
                    'part_id' => $parts->random()->id,
                    'client_id' => $clients->random()->id,
                    'status' => $statuses[array_rand($statuses)],
                    'note' => $faker->sentence,
                    'repair_start_date' => Carbon::now()->subDays(rand(1, 30)),
                    'repair_end_date' => Carbon::now()->addDays(rand(1, 30)),
                ]);
            }
        }
    }
}
