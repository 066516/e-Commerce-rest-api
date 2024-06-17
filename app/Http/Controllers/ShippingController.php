<?php
namespace App\Http\Controllers;


use App\Models\Shipping;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Services\AuthService;

class ShippingController extends Controller
{
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }
    // Show all shipments (possibly with filtering/pagination)
    public function index()
    {
        return Shipping::all(); // Basic implementation, adjust as needed
    }
    public function getMyShippings(Request $request)
    {
        try {
            $user = $this->authService->getAuthenticatedUser(); // Assuming this fetches the authenticated user
            
            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401); // Unauthorized
            }
            
            // Assuming 'orders' is a relationship defined in User model and 'shippings' is defined in Order model
            $shippings = Shipping::whereIn('order_id', $user->orders()->pluck('id'))->get();
    
            return response()->json($shippings);
    
        } catch (\Exception $e) {
            \Log::error('Error fetching user shippings: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while fetching your shippings'
            ], 500); 
        }
    }
    
    
        
    

    // Show details of a specific shipment
    public function show($id) 
    {
        try {
            $shipping = Shipping::findOrFail($id);  
            return $shipping;
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Shipment not found'
            ], 404); 
        } catch (\Exception $e) { // Catch any other unexpected exceptions
            \Log::error('Error fetching shipment: ' . $e->getMessage()); // Log the error for debugging
            return response()->json([
                'error' => 'An error occurred while fetching the shipment'
            ], 500); // Internal Server Error
        }
    }
    

    // Create a new shipment
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'status' => 'nullable|string',
                'carrier' => 'nullable|string|max:255', // Limit string length
                'tracking_number' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:500', // Limit address length
                'shipping_cost' => 'required|numeric|min:0',
            ]);

            return Shipping::create($validatedData);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // 422 Unprocessable Entity
        }
    }

    public function update(Request $request, Shipping $shipping)
    {
        try {
            $validatedData = $request->validate([
                'status' => [Rule::in(['pending', 'shipped', 'delivered'])],
                'carrier' => 'nullable|string|max:255',
                'tracking_number' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:500',
                'shipping_cost' => 'nullable|numeric|min:0',
            ]);

            $shipping->update($validatedData);

            return $shipping;

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(Shipping $shipping)
    {
        try {
            $shipping->delete();
            return response(null, 204); 
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Shipment not found'], 404);
        } 
    }
}
