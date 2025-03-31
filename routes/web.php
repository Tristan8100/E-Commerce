<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if(Auth::user()->role === "ADMIN"){
        return redirect('/admin/dashboard');
    } elseif (Auth::user()->role === "USER") {
        return redirect('/user/dashboard');
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

    Route::post('/admin/addproduct', [ProductController::class, 'store']);
});


//Por API
Route::get('/admin/getcategories', [CategoryController::class, 'getcategory']);

Route::get('/getallproduct', [ProductController::class, 'getPaginatedInStockProducts']);

Route::post('/addtocart', [ProductController::class, 'addtocart']);

Route::get('/getcart', [ProductController::class, 'getcart']);

Route::post('/updatecart', [ProductController::class, 'updateQuantity']);

Route::post('/removefromcart', [ProductController::class, 'deletefromcart']);

Route::post('/createorder', [OrderController::class, 'initiateorder']);

Route::post('/checkoutpage', [OrderController::class, 'checkoutpage']);

Route::post('/submitorder', [OrderController::class, 'submitOrder']);

Route::get('/processpayment', function(Request $request){
    //cs_9Du3vUc79dHApSsDxNTU3t8u
    if (session()->has('paymongo_session_id')) {
        $sessionId = session()->get('paymongo_session_id');
        echo $sessionId;
    } else {
        echo "Session not set.";
    }
});

//USER
Route::middleware('auth', 'role:USER')->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.userdashboard');
    });

    Route::get('/user/items', function () {
        return view('user.items');
    });

    Route::get('/user/cart', function () {
        return view('user.cart');
    });

    Route::get('/user/checkout', function () {
        return view('user.check');
    });

});


require __DIR__.'/auth.php';
