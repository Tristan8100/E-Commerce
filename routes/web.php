<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\User\ViewsRender;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if(Auth::user()->role === "ADMIN"){
        return redirect('/admin/dashboard');
    } elseif (Auth::user()->role === "USER") {
        return redirect('/user/home');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//ADMIN
Route::middleware('auth', 'role:ADMIN')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.admindashboard');
    });

    Route::get('/admin/categories', function(){
        return view('admin.category');
    })->name('admin.categories.index');
    
    Route::post('/admin/categories', [CategoryController::class, 'add']);

    Route::get('/admin/addproduct', function(){
        return view('admin.addproduct');
    });

    Route::get('/admin/allproduct', [ViewsRender::class, 'adminAllproduct']);

    Route::post('/admin/addproduct', [ProductController::class, 'store']);
});


//Por API
Route::get('/admin/getcategories', [CategoryController::class, 'getcategory']);

Route::get('/getallproduct', [ProductController::class, 'getPaginatedInStockProducts']);

Route::get('/getproduct/{id}', [ProductController::class, 'getSingleProduct']);

Route::post('/addtocart', [ProductController::class, 'addtocart']);

Route::get('/getcart', [ProductController::class, 'getcart']);

Route::post('/updatecart', [ProductController::class, 'updateQuantity']);

Route::post('/removefromcart', [ProductController::class, 'deletefromcart']);

Route::post('/createorder', [OrderController::class, 'initiateorder']);

Route::post('/checkoutpage', [OrderController::class, 'checkoutpage']);

Route::post('/submitorder', [OrderController::class, 'submitOrder']);

Route::get('/getorder', [OrderController::class, 'getorder']);

Route::get('/processpayment', [OrderController::class, 'processpayment']);

Route::post('/cancelorder', [OrderController::class, 'cancelOrderbyUser']);

//USER
Route::middleware('auth', 'role:USER')->group(function () {
    Route::get('/user/home', [ViewsRender::class, 'AllItems'])->name('user.home');

    Route::get('/user/items', [ViewsRender::class, 'items'])->name('user.items');

    Route::get('/user/cart', [ViewsRender::class, 'cart'])->name('user.cart');

    Route::get('/user/order', [ViewsRender::class, 'order'])->name('user.order');

    Route::get('/user/order/{id}', [ViewsRender::class, 'orderGet'])->name('user.orderget');


    Route::get('/try', function () {
        return view('user.userdashboard');
    });

    Route::get('/try2', function () {
        return view('user.allcart');
    });

    Route::get('/try3', function () {
        return view('user.displayallitems');
    });

});


require __DIR__.'/auth.php';
