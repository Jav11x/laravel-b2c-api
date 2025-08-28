<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Category, Product};

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beb = Category::firstOrCreate(['name' => 'Bebidas']);
        $sna = Category::firstOrCreate(['name' => 'Snacks']);

        Product::firstOrCreate(
            ['name' => 'Agua 1.5L', 'category_id' => $beb->id],
            ['price' => 0.70, 'stock' => 120, 'active' => true]
        );
        Product::firstOrCreate(
            ['name' => 'Zumo Naranja', 'category_id' => $beb->id],
            ['price' => 1.20, 'stock' => 35, 'active' => true]
        );
    }
}
