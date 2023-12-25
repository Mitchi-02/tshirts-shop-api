<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface OrderInterface
{
    public function create (Request $request);

    public function myOrders();
}