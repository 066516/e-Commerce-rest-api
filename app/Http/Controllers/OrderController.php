<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index()
    {
        try 
        {
            $orders = Order::all();
            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching orders.'], 500);
        }
    }
    public function withProducts()
    {
        try {
            // Eager load products with orders
            $orders = Order::with('products')->get();
            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching orders.'], 500);
        }
    }
    protected $orderService;

  

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Calculate the total amount
            $totalAmount = $this->orderService->calculateTotalAmount($request->products);

            // Create the order
            $order = Order::create([
                'user_id' => $request->user_id,
                'total_amount' => $totalAmount,
            ]);

            // Attach products to the order with quantities and prices
            foreach ($request->products as $product) {
                $order->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price' => Product::find($product['id'])->price,
                ]);
            }

            return response()->json($order, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User or product not found.'], 404);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create order.'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with('user', 'products')->findOrFail($id);
            return response()->json($order, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching the order.'], 500);
        }
    }
    public function getOrdersByUserId(Request $request){ 
   
        try {
            $user = Auth::user();

            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            $orders = $this->orderService->getOrdersByUserId($user->id);

            return response()->json($orders, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 401);
    }
    }
    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'user_id' => 'sometimes|required|exists:users,id',
                'total_amount' => 'sometimes|required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Update order fields
            if ($request->has('user_id')) {
                $order->user_id = $request->user_id;
            }
            if ($request->has('total_amount')) {
                $order->total_amount = $request->total_amount;
            }
            $order->save();

            return response()->json($order, 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the order.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return response()->json(null, 204);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the order.'], 500);
        }
    }
}
