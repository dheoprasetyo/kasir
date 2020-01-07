<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'category_id'=>'1',
            'name'=>'Indomie',
            'slug'=>'indomie',
            'price'=>'2500'
        ]);
        
        Product::create([
            'category_id'=>'1',
            'name'=>'Mie Sedap',
            'slug'=>'mie-sedap',
            'price'=>'2500'
        ]);

        Product::create([
            'category_id'=>'2',
            'name'=>'Teh Gelas',
            'slug'=>'teh-gelas',
            'price'=>'1000'
        ]);

        Product::create([
            'category_id'=>'2',
            'name'=>'Granita',
            'slug'=>'granita',
            'price'=>'1500'
        ]);

    }
}
