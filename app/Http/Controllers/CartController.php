<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // Get the product from the request data
            $product = Product::findOrFail($request->product_id);

            // Create or update the cart item
            $cartItem = Cart::updateOrCreate(
                ['user_id' => auth()->id(), 'product_id' => $product->id],
                ['quantity' => $request->quantity]
            );

            // Return a success response
            return response()->json(['message' => 'Product added to cart successfully', 'cart_item' => $cartItem]);
        } catch (\Exception $e) {
            // Return an error response if something went wrong
            return response()->json(['message' => 'Error adding product to cart', 'error' => $e->getMessage()], 500);
        }
    }
    
}
