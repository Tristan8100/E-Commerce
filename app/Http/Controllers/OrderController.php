<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    //

    protected $PayMongoService;

    public function __construct(PayMongoService $pay)
    {
        $this->PayMongoService = $pay;
    }

    public function checkoutpage(Request $request) {
        $orderItems = [];

        foreach ($request->dataarray as $product_id) {
            //note: don't forget to validate if has or no input
            $cartvalue = Cart::with('product')
            ->where('user_id', Auth::id())
            ->where('id', $product_id)
            ->first();

            $imageproduct = $cartvalue->product->image
                        ? 'data:image/jpeg;base64,' . base64_encode($cartvalue->product->image) 
                        : null;

            $orderItems[] = [
                'id' => $cartvalue->product->id,
                'name' => $cartvalue->product->name,
                'price' => $cartvalue->product->price,
                'stock' => $cartvalue->product->stock,
                'purchased' => $cartvalue->quantity,
                'imageproduct' => $imageproduct,
            ];
        }
        //if no choice use compact
        $html = view('user.checkouttry')->render();

        return response()->json([
            'status' => 'success',
            'html' => $html, // The rendered view
            'order_items' => $orderItems, // Raw data for further use
            'total' => $request->price,
        ]);
    }

    public function initiateorder(Request $request) {
        // Calculate total price
        $totalPrice = 0;
        $orderItems = [];
    
        // Create order
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'total_price' => $request->price, 
        ]);
    
        // iterate over request array on id
        foreach ($request->dataarray as $product_id) {
            $cartvalue = Cart::firstWhere([
                'user_id' => Auth::user()->id,
                'id' => $product_id,
            ]); //get by PK
            $product = Product::find($cartvalue->product_id); // fetch product
    
            if (!$product) { //POR DEBUGGINHGG
                return response()->json([
                    'status' => 'error',
                    'message' => "Product with ID $product_id not found."
                ], 400);
            }
    
            $price = $product->price;
            $totalPrice += $price;

            $orderItems[] = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $price,
                'quantity' => $cartvalue->quantity,
            ]);
        }

        //decrement by result
    
        return response()->json([
            'status' => 'success',
            'order' => $order,
            'order_items' => $orderItems,
        ]);
    }


    public function submitOrder(Request $request)
    {
        // Validate request data
        $request->validate([
            'total' => 'required|numeric|min:0',
            'address_user' => 'required|string|max:255',
            'payment_user' => 'required|string|max:50',
            'phone_user' => 'required|numeric|min:0',
        ]);

        // Create order
        $order = Order::create([
            'user_id' => Auth::user()->id, // Get logged-in user ID
            'total_price' => $request->total,
            'status' => 'pending', // Default status
            'payment' => $request->payment_user,
            'address' => $request->address_user,
            'phone_number' => $request->phone_user,
        ]);

        foreach ($request->dataarray as $product_id) {
            $product = (object) $product_id; 
            $cartvalue = Cart::with('product')
            ->where('user_id', Auth::id())
            ->where('product_id', $product->id) //pota ka 
            ->first();

            if (!$cartvalue) {
                return response()->json([
                    'error' => 'Cart item not found',
                    'product_id' => $product->id
                ]);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartvalue->product->id,
                'quantity' => $cartvalue->quantity,
                'price' => $cartvalue->product->price,
            ]);
        }

        if ($order) {
            //put here to redirect to paymongo based on payment
            if($request->payment_user === "gcash"){
                //EXECUTE THE PAYMONGO

                $response = $this->PayMongoService->createCheckoutSession(
                    Auth::user()->name,
                    Auth::user()->email
                );

                if (isset($response['data']['attributes']['checkout_url'])) {
                    session()->put('paymongo_session_id', $response['data']['id']); //put on session
                    return response()->json(['status' => 'success',
                    'message' => 'Order placed successfully!', 
                    'pay' => $response['data']['attributes']['checkout_url']]);

                } else {
                    return back()->with('error', 'Failed to create a checkout session.');
                }
            } else {
                //manual redirect if COD
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to place order.'], 500);
        }
    }


    public function getpaymentid(){
        $sessionId = session()->get('paymongo_session_id');

        if ($sessionId) {
            $paymentDetails = $this->PayMongoService->getPaymentId($sessionId);

            if (!$paymentDetails) {
                return back()->with('error', 'Invalid Payment Session.');
            }
        }
    }
    
}
