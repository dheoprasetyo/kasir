<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'name' =>'Doa Ibu',
            'address'=>'jl Jalan',
            'city'=>'Jakarta',
            'phone'=>'082226360005'
        ]);
    }
}
