<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Electrónica', 'description' => 'Móviles, portátiles y más']);
        Category::create(['name' => 'Ropa', 'description' => 'Moda para hombre y mujer']);
        Category::create(['name' => 'Hogar', 'description' => 'Muebles y decoración']);
    }
}
