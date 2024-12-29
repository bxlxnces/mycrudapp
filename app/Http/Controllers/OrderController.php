<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerName' => 'required|string|max:255',
            'customerEmail' => 'required|email',
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric',
        ]);

        $order = Order::create([
            'customer_name' => $validated['customerName'],
            'customer_email' => $validated['customerEmail'],
            'total_price' => array_sum(array_column($validated['items'], 'price')),
            'items' => json_encode($validated['items']),
        ]);

        return response()->json(['message' => 'Order created successfully!', 'order' => $order], 201);
    }
}
