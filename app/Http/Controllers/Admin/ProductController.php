<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'required|exists:categories,id',
            //'stock' => 'required|integer|min:0'
        ]);

        $imageBinary = file_get_contents($request->file('image')->getRealPath());
        //$imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageBinary,
            'category_id' => $request->category_id,
            //'stock' => $request->stock
        ]);

        return redirect('/admin/addproduct')->with('success', 'Product added successfully!');
    }

    public function getPaginatedInStockProducts()
    {
        $products = Product::with('category')->get()->map(function ($product) {
            // Convert binary image to Base64 (if exists)
            $product->image_url = $product->image 
                ? 'data:image/jpeg;base64,' . base64_encode($product->image) 
                : null;
            
            return $product->makeHidden(['image']); // Remove raw blob
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function addtocart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if(Product::find($request->product_id)->stock <= 0){
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ], 400);
        }

        // Check if the product already exists in the user's cart
        $cartItem = Cart::where('user_id', Auth::user()->id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            // If item exists, increment the quantity
            $cartItem->increment('quantity', $request->quantity);
        } else {
            // Otherwise, add new item to cart
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        // Decrement product stock
        //Product::find($request->product_id)->decrement('stock', $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully'
        ]);
    }

    public function getcart()
    {
        // Get cart items with product data
        $cartItems = Cart::with(['product.category'])
            ->where('user_id', Auth::user()->id)
            ->get()
            ->map(function ($cartItem) {
                $product = $cartItem->product;
                
                // Auto-correct quantity if exceeds available stock
                if ($product && $cartItem->quantity > $product->stock) {
                    $cartItem->quantity = $product->stock;
                    $cartItem->save(); // Save the corrected quantity
                }
                
                // Process image
                if ($product) {
                    $product->image_url = $product->image 
                        ? 'data:image/jpeg;base64,' . base64_encode($product->image) 
                        : null;
                    
                    $product->makeHidden(['image']);
                }
                
                return $cartItem;
            });

        return response()->json([
            'success' => true,
            'data' => $cartItems,
            'message' => 'Cart quantities have been adjusted to available stock'
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'action' => 'required|in:add,subtract',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::with('product')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $product = $cartItem->product;
        $success = true;
        $message = '';
        
        if ($request->action === 'subtract') {
            if ($cartItem->quantity <= 1) {
                $success = false;
                $message = 'Minimum quantity reached (1)';
            } else {
                $newQuantity = max(1, $cartItem->quantity - $request->quantity);
                $cartItem->update(['quantity' => $newQuantity]);
                $message = 'Quantity decreased successfully';
            }
        } else { // 'add'
            if ($cartItem->quantity >= $product->stock) {
                $success = false;
                $message = 'Cannot exceed available stock ('.$product->stock.')';
            } else {
                $newQuantity = min($product->stock, $cartItem->quantity + $request->quantity);
                $cartItem->update(['quantity' => $newQuantity]);
                $message = 'Quantity increased successfully';
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'new_quantity' => $cartItem->fresh()->quantity,
            'max_stock' => $product->stock
        ]);
    }

    public function deletefromcart(Request $request){
        $value = Cart::destroy($request->cart_item_id);

        return response()->json([
            'message' => $value,
            'value' => $request->cart_item_id
        ]);
    }

}
