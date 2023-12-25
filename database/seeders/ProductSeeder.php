<?php

namespace Database\Seeders;

use App\Models\League;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        $leagues = League::all();
        foreach($leagues as $league){
            $json = File::get("database/seeders/".$league->name.".json");
            $data = json_decode($json);
            foreach ($data as $key => $value){
                DB::table('products')->insert([
                    'name' => $value->name,
                    'images' => $value->image1.'~'.$value->image2,
                    'league_id'=> $league->id,
                    'sizes' => "S,M,L,XL,XXL",
                    'price' => 55,
                ]);
            }
        }
        
    }
}
