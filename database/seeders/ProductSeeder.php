<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products')->insert([
            ['productName' => 'Heart', 'price' => 1000000, 'stockQuantity' => 50, 'products_photo' => 'img/heart.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Liver', 'price' => 850000, 'stockQuantity' => 30, 'products_photo' => 'img/liver.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Kidney', 'price' => 600000, 'stockQuantity' => 100, 'products_photo' => 'img/kidney.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Lung', 'price' => 750000, 'stockQuantity' => 40, 'products_photo' => 'img/lung.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Pancreas', 'price' => 700000, 'stockQuantity' => 20, 'products_photo' => 'img/pancreas.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Cornea', 'price' => 200000, 'stockQuantity' => 80, 'products_photo' => 'img/cornea.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Bone Marrow', 'price' => 500000, 'stockQuantity' => 60, 'products_photo' => 'img/bone marrow.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Intestine', 'price' => 400000, 'stockQuantity' => 30, 'products_photo' => 'img/intestine.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Spleen', 'price' => 250000, 'stockQuantity' => 70, 'products_photo' => 'img/spleen.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Thyroid', 'price' => 300000, 'stockQuantity' => 50, 'products_photo' => 'img/thyroid.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['productName' => 'Bladder', 'price' => 350000, 'stockQuantity' => 60, 'products_photo' => 'img/bladder.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
