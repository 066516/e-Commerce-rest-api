<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
}
