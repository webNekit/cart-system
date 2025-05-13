<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('ru_RU');

        for ($i = 1; $i <= 10; $i++) {
            Client::create([
                'name' => $faker->company,
                'email' => $faker->unique()->companyEmail,
                'phone' => $faker->unique()->phoneNumber,
            ]);
        }
    }
}
