<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /**
     * Calculate the total amount for the order.
     *
     * @param array $products
     * @return float
     * @throws \Exception
     */
    public function calculateTotalAmount(array $products)
    {
        $totalAmount = 0;

        foreach ($products as $product) {
            $productModel = Product::find($product['id']);

            if (!$productModel) {
                throw new \Exception('Product not found.');
            }

            $totalAmount += $productModel->price * $product['quantity'];
        }

        return $totalAmount;
    }
    public function getOrdersByUserId(int $userId): Collection
    {
        return Order::with('products')->where('user_id', $userId)->get();
    }
    public function decrementProductQuantities($products)
    {
        foreach ($products as $product) {
            $productModel = Product::find($product['id']);
            
            if (!$productModel) {
                throw new ModelNotFoundException("Product with ID {$product['id']} not found.");
            }

            if ($productModel->quantity < $product['quantity']) {
                throw new \Exception("Insufficient stock for product ID {$product['id']}");
            }

            $productModel->decrement('quantity', $product['quantity']);
        }
    }
    public function attachProductsToOrder(Order $order, array $products)
    {
        foreach ($products as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => Product::find($product['id'])->price,
            ]);
        }
    }
    public function confiremOrder($order)
    {
        $order->confirmed = true;
        $order->save();
        
    }
}
