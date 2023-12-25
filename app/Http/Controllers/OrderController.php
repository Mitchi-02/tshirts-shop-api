<?php

namespace App\Http\Controllers;

use App\Http\Repositories\OrderRepository;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    private $orderRepository;
    private function mergeOrders($orders){
        $result = [];
        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                array_push($result, (object)[
                    "id" => $product->id,
                    "name" => $product->name,
                    "image" => explode('~', $product->images)[0],
                    "size" => $product->pivot->size,
                    "tshirtfeatures" => $product->pivot->tshirtfeatures,
                    "ordered_at" => $order->created_at->format('d M Y - H:i'),
                    "fulladr" => $order->ville.','.$order->address.','.$order->zipcode
                ]);
            }
        }
        return $result;
    }

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(Request $request)
    {
        $response = $this->orderRepository->create($request);
        if(isset($response['error'])) return $this->sendError($response['error']);
        
        return $this->sendSuccess("Commande enregistre avec succes", [], "Succes");
    }

    public function getAuthOrders()
    {
        $response = $this->orderRepository->myOrders();
        return $this->sendSuccess('Commandes recuperes avec success', [
            "orders" => $this->mergeOrders($response)
        ]);
    }
}
