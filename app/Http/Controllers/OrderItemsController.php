<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;

class OrderItemsController extends Controller
{
    // Wajib menggunakan token
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Tampilkan semua order item
    public function index()
    {
        return response()->json(OrderItem::all());
    }

    // Tambah order item
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,order_id',
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $orderItem = OrderItem::create([
            'id' => Str::uuid(), // ID dibuat otomatis
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json($orderItem, 201);
    }

    // Tampilkan satu data order item
    public function show($id)
    {
        $item = OrderItem::findOrFail($id);
        return response()->json($item);
    }

    // Update data order item
    public function update(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'order_id' => 'sometimes|exists:orders,order_id',
            'product_id' => 'sometimes|exists:products,product_id',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item->update($request->all());

        return response()->json($item);
    }

    // Hapus order item
    public function destroy($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Order item deleted successfully.']);
    }
}
