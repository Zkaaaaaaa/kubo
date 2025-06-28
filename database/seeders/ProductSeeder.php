<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(100)->create();
        $product = [
            // Makanan
            [
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng dengan rempah khas nusantara dan daging ayam',
                'price' => 28000,
                'category_id' => 1,
                'photo' => 'nasi_goreng.jpeg',
            ],
            [
                'name' => 'Mie Goreng',
                'description' => 'Mie goreng dengan rempah khas nusantara dan daging ayam',
                'price' => 30000,
                'category_id' => 1,
                'photo' => 'mie_goreng.jpeg',
            ],
            [
                'name' => 'Soto Betawi',
                'description' => 'Soto Betawi dengan rempah khas nusantara dan daging sapi dan nasi',
                'price' => 35000,
                'category_id' => 1,
                'photo' => 'soto_betawi.jpg',
            ],
            [
                'name' => 'Tekwan',
                'description' => 'Tekwan spesial ikan tenggiri',
                'price' => 25000,
                'category_id' => 1,
                'photo' => 'tekwan.jpg',
            ],
            // Kopi
            [
                'name' => 'Cappuccino',
                'description' => 'Kapuccino Arabika dan Robusta ice/hot ',
                'price' => 20000,
                'category_id' => 2,
                'photo' => 'kapucino.jpg',
            ],
            [
                'name' => 'Latte',
                'description' => 'Latte Arabika dan Robusta ice/hot',
                'price' => 22000,
                'category_id' => 2,
                'photo' => 'latte.jpeg',
            ],
            [
                'name' => 'Americano',
                'description' => 'Americano Arabika dan Robusta ice/hot',
                'price' => 18000,
                'category_id' => 2,
                'photo' => 'americano.jpg',
            ],
            [
                'name' => 'Kopi Tubruk',
                'description' => 'Kopi Tubruk Arabika dan Robusta ice/hot',
                'price' => 15000,
                'category_id' => 2,
                'photo' => 'tubruk.jpg',
            ],
            // Non Coffee
            [
                'name' => 'Ice Tea',
                'description' => 'Es teh dengan rempah khas nusantara',
                'price' => 13000,
                'category_id' => 3,
                'photo' => 'teh.jpg',
            ],
            [
                'name' => 'Milkshake',
                'description' => 'Es krim dan susu',
                'price' => 22000,
                'category_id' => 3,
                'photo' => 'milkshake.jpg',
            ],
            [
                'name' => 'Es Teler',
                'description' => 'Es Teler',
                'price' => 25000,
                'category_id' => 3,
                'photo' => 'teler.jpg',
            ],
            [
                'name' => 'Soda Gembira',
                'description' => 'Soda Gembira',
                'price' => 22000,
                'category_id' => 3,
                'photo' => 'soda.jpg',
            ],
            // Snack
            [
                'name' => 'Nugget',
                'description' => 'Nugget',
                'price' => 15000,
                'category_id' => 4,
                'photo' => 'naget.jpg',
            ],
            [
                'name' => 'Pisang Goreng',
                'description' => 'Pisang Goreng',
                'price' => 15000,
                'category_id' => 4,
                'photo' => 'pisang.jpeg',
            ],
            [
                'name' => 'Tahu Goreng',
                'description' => 'Tahu Goreng',
                'price' => 15000,
                'category_id' => 4,
                'photo' => 'tahu.jpg',
            ],
            [
                'name' => 'Kentang Goreng',
                'description' => 'Kentang Goreng',
                'price' => 15000,
                'category_id' => 4,
                'photo' => 'kentang.jpg',
            ],
            // Dessert
            [
                'name' => 'Puding',
                'description' => 'Puding',
                'price' => 15000,
                'category_id' => 5,
                'photo' => 'puding.jpg',
            ],
            [
                'name' => 'Donat',
                'description' => 'Donat',
                'price' => 15000,
                'category_id' => 5,
                'photo' => 'donat.jpg',
            ],
            [
                'name' => 'Kue',
                'description' => 'Kue',
                'price' => 15000,
                'category_id' => 5,
                'photo' => 'kue.jpg',
            ],
            [
                'name' => 'Ice Cream',
                'description' => 'Ice Cream',
                'price' => 15000,
                'category_id' => 5,
                'photo' => 'eskrim.png',
            ],
            
        ];

        Product::insert($product);
    }
}