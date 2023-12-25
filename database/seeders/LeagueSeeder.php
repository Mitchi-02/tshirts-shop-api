<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leagues')->insert([
            'name' => 'spain',
        ]);

        DB::table('leagues')->insert([
            'name' => 'france',
        ]);

        DB::table('leagues')->insert([
            'name' => 'england',
        ]);

        DB::table('leagues')->insert([
            'name' => 'germany',
        ]);

        DB::table('leagues')->insert([
            'name' => 'italy',
        ]);

        DB::table('leagues')->insert([
            'name' => 'worldcup',
        ]);
    }
}
