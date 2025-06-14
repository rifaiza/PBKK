<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        // Pagination
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);
        
        // Search
        $search = $request->query('search');
        
        $query = Customer::query();
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        $customers = $query->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json([
            'data' => $customers->items(),
            'meta' => [
                'current_page' => $customers->currentPage(),
                'per_page' => $customers->perPage(),
                'total' => $customers->total(),
                'last_page' => $customers->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:customers',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'message' => 'Customer created successfully',
            'data' => $customer
        ], 201);
    }

    /**
     * Display the specified customer.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:50',
            'email' => [
                'sometimes',
                'email',
                'max:50',
                Rule::unique('customers')->ignore($customer->customer_id, 'customer_id')
            ],
            'password' => 'sometimes|string|min:8',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only(['name', 'email', 'phone', 'address']);
        
        if ($request->has('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $customer->update($updateData);

        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}