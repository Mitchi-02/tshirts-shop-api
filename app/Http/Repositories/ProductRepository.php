<?php
namespace App\Http\Repositories;
use App\Http\Interfaces\ProductInterface;
use App\Models\League;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

Class ProductRepository implements ProductInterface {

    public function index()
    {
        return League::all();
    } 

}