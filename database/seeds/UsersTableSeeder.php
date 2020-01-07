<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = User::create([
            'name' =>'Dheo Prasetyo',
            'email'=>'dheoprasetyo.dp@gmail.com',
            'password'=>bcrypt('admin'),
        ]);

        $owner->assignRole('owner');

        $kasir = User::create([
            'name' =>'Sherien',
            'email'=>'sherien@gmail.com',
            'password'=>bcrypt('admin'),
        ]);
        $kasir->assignRole('kasir');
    }
}
