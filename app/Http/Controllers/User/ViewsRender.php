<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ViewsRender extends Controller
{
    //
    public function AllItems()
    {
        return view('user.allitems');
    } //

    public function items()
    {
        return view('user.items');
    } //

    public function cart()
    {
        return view('user.cart');
    } //

    public function order()
    {
        return view('user.orders');
    }

   public function orderGet($id)
    {
        $order = Order::with('orderItems.product')
        ->where('user_id', Auth::user()->id)
        ->findOrFail($id);
        // Process the order items
        $order->orderItems->each(function ($item) {
            if ($item->product) {
                $item->product->image_base64 = $item->product->image 
                    ? 'data:image/jpeg;base64,' . base64_encode($item->product->image) 
                    : null;
                $item->product->makeHidden(['image']);
            }
        });
        return view('user.order_one', compact('order'));
    }

    //admin
    public function adminAllproduct()
    {
        return view('admin.allproduct');
    }


}
