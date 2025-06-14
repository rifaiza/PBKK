<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        return response()->json(Order::all());
    }

    // POST /api/orders
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'   => 'required|string|exists:customers,customer_id',
            'order_date'    => 'required|date',
            'total_amount'  => 'required|integer',
            'status'        => 'required|string',
        ]);

        $order = Order::create([
            'order_id'      => Str::uuid(),
            'customer_id'   => $request->customer_id,
            'order_date'    => $request->order_date,
            'total_amount'  => $request->total_amount,
            'status'        => $request->status,
        ]);

        return response()->json($order, 201);
    }

    // GET /api/orders/{id}
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    // PUT /api/orders/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id'   => 'required|string|exists:customers,customer_id',
            'order_date'    => 'required|date',
            'total_amount'  => 'required|integer',
            'status'        => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order);
    }

    // DELETE /api/orders/{id}
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}