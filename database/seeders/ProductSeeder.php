<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::create([
            'name' => 'Panne Cake',
            'image_url' => 'https://tonsite.netlify.app/images/burger.jpg',
            'usdz_url'  => 'https://tonsite.netlify.app/models/burger.usdz',
        ]);
    }
}
