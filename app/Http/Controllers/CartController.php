<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        // Fetch the user's cart
        $cart = Auth::user()->carts;
        $user = Auth::user();
        // Check if the user has a cart
        if (!$cart) {
            return view('cart', ['products' => [], 'cartEntries' => []]);
        }
        // Get products in the user's cart
        $products = $cart->products()->get();
        // Get the user's current promotion (if any)
        $promotion = $user->promotion()->latest()->first();
        // Return the view and pass the products to the view
        return view('cart', compact('products', 'user', 'promotion'));
    }
    public function addToCart($productId, $quantity)
    {
        $cart = Auth::user()->carts;
        $product = Products::find($productId);

        if (!$cart || !$product) {
            return redirect()->back()->with('error', 'Cart or Product not found.');
        }
        // Check if the product already exists in the cart
        $existingProduct = $cart->products()->where('products.productId', $productId)->first();
        if ($existingProduct) {
            // Increment the quantity instead of replacing it
            $newQuantity = $existingProduct->pivot->quantity + $quantity;

            // Check if the new quantity exceeds the stock
            if ($newQuantity > $product->stockQuantity) {
                return redirect()->back()->with('error', 'Insufficient stock available.');
            }
            // Update the cart product's quantity
            $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        } else {
            // Add new product to the cart if it doesn't exist
            if ($quantity > $product->stockQuantity) {
                return redirect()->back()->with('error', 'Insufficient stock available.');
            }
            $cart->products()->attach($productId, ['quantity' => $quantity]);
        }
        // Reduce the product's stock by the quantity added to the cart
        $product->save();
        return redirect()->back()->with('success', 'Product added to the cart.');
    }
    public function decreaseFromCart($productId, $quantity)
    {
        $user = Auth::user();
        $cart = $user->carts;

        if ($cart) {
            // Get the product in the cart
            $product = $cart->products()->where('productId', $productId)->first(); // Use 'productId' instead of 'product_id'

            if ($product) {
                // Decrease quantity in cart
                $newQuantity = $product->pivot->quantity - $quantity;

                if ($newQuantity > 0) {
                    // Update the quantity in the cart
                    $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);

                    // Increase the stock in the product table
                    $product->stockQuantity += $quantity;
                    $product->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Quantity decreased and stock updated.');
    }

    public function removeFromCart($productId)
    {
        $user = Auth::user();
        $cart = $user->carts;

        if ($cart) {
            // Get the product in the cart
            $product = $cart->products()->where('productId', $productId)->first(); // Use 'productId' instead of 'product_id'

            if ($product) {
                // Return the quantity to stock
                $product->stockQuantity += $product->pivot->quantity;
                $product->save();

                // Remove the product from the cart
                $cart->products()->detach($productId);
            }
        }

        return redirect()->back()->with('success', 'Product removed from the cart and stock updated.');
    }
    public function saveCustomerInfo(Request $request)
    {
        // Validate the customer data
        $validatedData = $request->validate([
            'customerName' => 'required|string|max:255',
            'customerAddress' => 'required|string|max:500',
            'customerPhone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'customerEmail' => 'required|email|max:255',
        ]);

        // Store the validated customer data in session
        session(['customerInfo' => $validatedData]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Customer information saved successfully.');
    }

}
