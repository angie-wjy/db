<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     $products = Product::take(3)->get();
//     $categories = Category::with('products')->get();
//     return view('welcome', compact('products', 'categories'));
// });

// Route::middleware('web')->group(function () {
//     Route::get('/', function () {
//         return view('welcome');
//     });
// });

Route::get('/', function () {
    $products = Product::take(3)->get();
    $categories = Category::with('products')->get();
    return view('welcome', compact('products', 'categories'));
})->name('welcome');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signout', [AuthController::class, 'signout'])->name('signout');


// Customer routes
Route::get('/customer/home', function () {
    return view('customer.home');
})->name('customer.home');

Route::middleware(['auth:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'CartIndex']);

    Route::post('/customer/product/add/{id}', [ProductController::class, 'ProductAdd'])->name('customer.product.add');

    // Route::delete('/cart/remove/{cart_id}/{product_id}', [CartItemController::class, 'CartDelete'])->name('cart.remove');
    Route::post('/cart/update/{cart_id}/{product_id}', [CartItemController::class, 'CartUpdate'])->name('cart.update');
    Route::post('/cart/plus/{product_id}', [CartItemController::class, 'CartPlus'])->name('cart.plus');
    Route::post('/cart/minus/{product_id}', [CartItemController::class, 'CartMinus'])->name('cart.minus');
    Route::delete('/cart/remove/{product_id}', [CartItemController::class, 'CartDelete'])->name('cart.remove');

    Route::get('/customer/checkout', [OrderController::class, 'CheckOutForm'])->name('customer.checkout.form');
    Route::post('/customer/checkout', [OrderController::class, 'CheckOut'])->name('customer.checkout');
    Route::get('/checkout/{orderId}', [OrderController::class, 'ShowCheckOut'])->name('customer.checkout.show');
    Route::get('/checkout/success', [OrderController::class, 'CheckOutSuccess'])->name('customer.checkout.success');

    Route::get('/product/search', [ProductController::class, 'search']);
    Route::get('/product/category/{code?}', [ProductController::class, 'byCategory']);
    Route::get('/product/detail/{id}', [ProductController::class, 'ProductDetail'])->name('product.detail');
    Route::get('/product/topsell', [ProductController::class, 'TopSell']);
    Route::get('/category/{slug}', [ProductController::class, 'ByCategory']);
    Route::get('/category/{slug}', [CategoryController::class, 'showBySlug']);
    Route::get('/category/{slug}', [CategoryController::class, 'showBySlug'])->name('category.show');
});

// Admin routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/branch/index', [AdminController::class, 'BranchIndex'])->name('admin.branch.index');
    Route::get('/admin/branch/add', [AdminController::class, 'BranchAdd'])->name('admin.branch.add');
    Route::post('/admin/branch/create', [AdminController::class, 'BranchCreate'])->name('admin.branch.create');
    Route::get('/admin/branch/edit/{id}', [AdminController::class, 'BranchEdit'])->name('admin.branch.edit');
    Route::put('/admin/branch/update/{id}', [AdminController::class, 'BranchUpdate'])->name('admin.branch.update');
    Route::delete('/admin/branch/{id}', [AdminController::class, 'BranchDelete'])->name('admin.branch.delete');

    Route::get('/admin/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
    Route::get('/admin/product/index', [AdminController::class, 'ProductIndex'])->name('admin.product.index');
    Route::get('/admin/product/add', [AdminController::class, 'ProductAdd'])->name('admin.product.add');
    Route::post('/admin/product/create', [AdminController::class, 'ProductCreate'])->name('admin.product.create');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'ProductEdit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'ProductUpdate'])->name('admin.product.update');
    Route::delete('/admin/product/{id}', [AdminController::class, 'ProductDelete'])->name('admin.product.delete');

    Route::get('/admin/product/bundle/index', [AdminController::class, 'BundleIndex'])->name('admin.product.bundle.index');
    Route::get('/admin/product/bundle/add', [AdminController::class, 'BundleAdd'])->name('admin.product.bundle.add');
    Route::post('/admin/product/bundle/create', [AdminController::class, 'BundleCreate'])->name('admin.product.bundle.create');
    Route::get('/admin/product/bundle/edit/{id}', [AdminController::class, 'BundleEdit'])->name('admin.product.bundle.edit');
    Route::put('/admin/product/bundle/update/{id}', [AdminController::class, 'BundleUpdate'])->name('admin.product.bundle.update');
    Route::delete('/admin/product/bundle/{id}', [AdminController::class, 'BundleDelete'])->name('admin.product.bundle.delete');

    Route::get('admin/product/category/index', [AdminController::class, 'CategoryIndex'])->name('admin.product.category.index');
    Route::get('/admin/product/category/add', [AdminController::class, 'CategoryAdd'])->name('admin.product.category.add');
    Route::post('/admin/product/category/create', [AdminController::class, 'CategoryCreate'])->name('admin.product.category.create');
    Route::get('/admin/product/category/edit/{id}', [AdminController::class, 'CategoryEdit'])->name('admin.product.category.edit');
    Route::put('/admin/product/category/update/{id}', [AdminController::class, 'CategoryUpdate'])->name('admin.product.category.update');
    Route::delete('/admin/product/category/{id}', [AdminController::class, 'CategoryDelete'])->name('admin.product.category.delete');

    Route::get('/admin/product/theme/index', [AdminController::class, 'ThemeIndex'])->name('admin.product.theme.index');
    Route::get('/admin/product/theme/add', [AdminController::class, 'ThemeAdd'])->name('admin.product.theme.add');
    Route::post('/admin/product/theme/create', [AdminController::class, 'ThemeCreate'])->name('admin.product.theme.create');
    Route::get('/admin/product/theme/edit/{id}', [AdminController::class, 'ThemeEdit'])->name('admin.product.theme.edit');
    Route::put('/admin/product/theme/update/{id}', [AdminController::class, 'ThemeUpdate'])->name('admin.product.theme.update');
    Route::delete('/admin/product/theme/{id}', [AdminController::class, 'ThemeDelete'])->name('admin.product.theme.delete');

    Route::get('/admin/product/branch/index', [AdminController::class, 'ProductBranchIndex'])->name('admin.product.branch.index');
    Route::get('/admin/product/branch/add', [AdminController::class, 'ProductBranchAdd'])->name('admin.product.branch.add');
    Route::post('/admin/product/branch/create', [AdminController::class, 'ProductBranchCreate'])->name('admin.product.branch.create');
    Route::get('/admin/product/branch/edit/{id}', [AdminController::class, 'ProductBranchEdit'])->name('admin.product.branch.edit');
    Route::put('/admin/product/branch/update/{id}', [AdminController::class, 'ProductBranchUpdate'])->name('admin.product.branch.update');
    Route::delete('/admin/product/branch/{id}', [AdminController::class, 'ProductBranchDelete'])->name('admin.product.branch.delete');

    Route::get('/admin/product/size/index', [AdminController::class, 'SizeIndex'])->name('admin.product.size.index');
    Route::get('/admin/product/size/add', [AdminController::class, 'SizeAdd'])->name('admin.product.size.add');
    Route::post('/admin/product/size/create', [AdminController::class, 'SizeCreate'])->name('admin.product.size.create');
    Route::get('/admin/product/size/edit/{id}', [AdminController::class, 'SizeEdit'])->name('admin.product.size.edit');
    Route::put('/admin/product/size/update/{id}', [AdminController::class, 'SizeUpdate'])->name('admin.product.size.update');
    Route::delete('/admin/product/size/{id}', [AdminController::class, 'SizeDelete'])->name('admin.product.size.delete');

    Route::get('/admin/order/index', [AdminController::class, 'OrderIndex'])->name('admin.order.index');
    // Route::get('/admin/order/show/{id}', [AdminController::class, 'OrderShow'])->name('admin.order.show');
    Route::get('/admin/order/new/index', [AdminController::class, 'OrderNewIndex'])->name('admin.order.new.index');
    Route::put('/admin/orders/{order}/approve', [AdminController::class, 'OrderApprove'])->name('admin.order.approve');

    Route::get('/admin/order/check/index', [AdminController::class, 'OrderCheckIndex'])->name('admin.order.check.index');
    Route::get('/admin/order/pack/index', [AdminController::class, 'OrderPackIndex'])->name('admin.order.pack.index');
    Route::put('/order/{id}/pack', [AdminController::class, 'OrderPacked'])->name('admin.order.pack');
    Route::get('/admin/order/send/index', [AdminController::class, 'OrderSendIndex'])->name('admin.order.send.index');
    Route::put('/order/{id}/approve-shipping', [AdminController::class, 'OrderAccShip'])->name('admin.order.approveShipping');
    Route::put('/order/{id}/reject-shipping', [AdminController::class, 'OrderRejectShip'])->name('admin.order.rejectShipping');

    Route::get('/admin/user/index', [AdminController::class, 'UserIndex'])->name('admin.user.index');
    Route::get('/admin/user/add', [AdminController::class, 'UserAdd'])->name('admin.user.add');
    Route::post('/admin/user/create', [AdminController::class, 'UserCreate'])->name('admin.user.create');
    Route::get('/admin/user/edit/{id}', [AdminController::class, 'UserEdit'])->name('admin.user.edit');
    Route::put('/admin/user/update/{id}', [AdminController::class, 'UserUpdate'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [AdminController::class, 'UserDelete'])->name('admin.user.delete');
});
// Route::get('/admin/product', [AdminController::class, 'product']);
// Route::get('/admin/add-user', [AdminController::class, 'addUserForm']);
// Route::get('/admin/product/detail/{id}', [AdminController::class, 'productDetail']);
// Route::post('/admin/product/delete/{id}', [AdminController::class, 'deleteProduct']);

// Product routes
// Route::get('/', [ProductController::class, 'index'])->name('welcome');


// Fallback route
Route::fallback(fn() => redirect('/'));

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
