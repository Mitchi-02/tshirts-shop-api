<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\OrderInterface;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

Class OrderRepository implements OrderInterface{
    
    
    public function create($request)
    {
        $response = [];
        
        $validator = Validator::make($request->all(), [
            'products' => 'required',
            'ville' => 'required|string',
            'adresse' => 'required|string',
            'zipcode' => 'required|string',
        ]);
        if($validator->fails()){
            $response['error'] = "Some fields are missing or incorrect";
            return $response;
        }

        if(!is_array($request->products)){
            $response['error'] = "Products must be an array";
            return $response;
        }
 
        $user = User::find(auth('sanctum')->id());
        $order = Order::create([
            'user_id' => $user->id,
            'zipcode' => $request->zipcode,
            'ville' => $request->ville,
            'address' => $request->adresse,
        ]);
        try {
            foreach ($request->products as $product) {
                $product =json_decode($product);
                $time = Carbon::now();
                $new = DB::table('order_product')->insert([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'size' => $product->size,
                    'tshirtfeatures' => $product->tshirtfeatures,
                    'created_at' => $time,
                    'updated_at' => $time
                ]);
            }
            $user->sendOrderCreatedMail($order);
        } catch (Throwable $th) { //error in insertion 
            $order->delete();
            $response['error'] = "Error in products array. Please validate the inputs";
        }
        
        return $response;
    }

    public function myOrders(){
        return Order::where('user_id', auth('sanctum')->id())->get();
    }
}