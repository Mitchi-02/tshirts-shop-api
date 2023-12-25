<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            'client_name'=> 'ilyas',
            'client_img' => '',
            'product_id' => 2,
            'description' => 'smth',
        ]);

        DB::table('reviews')->insert([
            'client_name'=> 'ilyas',
            'client_img' => '',
            'product_id' => 3,
            'description' => 'smth',
        ]);

        DB::table('reviews')->insert([
            'client_name'=> 'ilyas',
            'client_img' => '',
            'product_id' => 3,
            'description' => 'smth',
        ]);

        DB::table('reviews')->insert([
            'client_name'=> 'ilyas',
            'client_img' => '',
            'product_id' => 5,
            'description' => 'smth',
        ]);
    }
}
