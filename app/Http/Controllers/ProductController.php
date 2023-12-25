<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends BaseController
{   
    private $productRepository;
    private function leaguesFromArrayToJson($leagues){
        $data =[]; 
        foreach($leagues as $league)
        {
            $data[$league->name] = ProductResource::collection($league->products);
        }
        $data = (object) $data;
        return $data;
    }

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        $data = $this->productRepository->index();
        return $this->sendSuccess('Home success', $this->leaguesFromArrayToJson($data));

    }
}
