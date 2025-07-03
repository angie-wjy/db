<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::post('/notification', [OrderController::class, 'Notification'])->name('midtrans.notification');

Route::get('/', function () {
    $products = Product::withCount(['orders as total_qty' => function ($query) {
        $query->select(DB::raw('SUM(quantity) as total_qty'));
    }])->orderBy('total_qty', 'desc')->take(3)->get();

    // select 3 trending products
    $trending_product = Product::withCount(['orders as total_qty' => function ($query) {
        $query->select(DB::raw('SUM(quantity) as total_qty'));
    }])->orderBy('total_qty', 'desc')->take(8)->get();

    // select b.*, sum(ohb.amount) from bundles b join products_has_bundles phb on (b.id = phb.bundles_id) join orders_has_bundles ohb on (b.id = ohb.bundles_id);
    $trending_bundle = DB::table('bundles')
        ->select('bundles.id', 'bundles.name', 'bundles.price', DB::raw('SUM(orders_has_bundles.amount) as total_qty'))
        ->join('products_has_bundles', 'bundles.id', '=', 'products_has_bundles.bundles_id')
        ->join('orders_has_bundles', 'bundles.id', '=', 'orders_has_bundles.bundles_id')
        ->groupBy('bundles.id', 'bundles.name', 'bundles.price')
        ->orderBy('total_qty', 'desc')
        ->take(3)
        ->get();

    // print_r($trending_product->toArray());

    $categories = Category::with('products')->get();

    $bundles = Bundle::with('products')->get();
    return view('welcome', compact('products', 'categories', 'trending_product', 'trending_bundle', 'bundles'));
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


Route::middleware(['auth:customer'])->group(function () {
    Route::get('/profile', [CustomerController::class, 'Profile'])->name('customer.profile.index');
    Route::get('/orders/{id}', [CustomerController::class, 'ShowOrder'])->name('customer.order.show');

    Route::get('/cart', [CartController::class, 'CartIndex']);
    Route::post('/customer/address/create', [CustomerController::class, 'AddressAdd'])->name('customer.address.create');
    Route::get('/customer/address/index', [CustomerController::class, 'AddressIndex'])->name('customer.address.index');

    // Route::delete('/cart/remove/{cart_id}/{product_id}', [CartItemController::class, 'CartDelete'])->name('cart.remove');
    Route::post('/cart/update/{cart_id}/{product_id}', [CartItemController::class, 'CartUpdate'])->name('cart.update');
    Route::post('/cart/plus/{product_id}', [CartItemController::class, 'CartPlus'])->name('cart.plus');
    Route::post('/cart/minus/{product_id}', [CartItemController::class, 'CartMinus'])->name('cart.minus');
    Route::delete('/cart/remove/{product_id}', [CartItemController::class, 'CartDelete'])->name('cart.remove');

    Route::get('/checkout/success/{orderId}', [OrderController::class, 'CheckOutSuccess'])->name('customer.checkout.success');
    Route::get('/checkout/{orderId}', [OrderController::class, 'ShowCheckOut'])->name('customer.checkout.show');
    Route::post('/customer/ship', [OrderController::class, 'Ship'])->name('customer.ship');
    Route::get('/customer/checkout', [OrderController::class, 'CheckOutForm'])->name('customer.checkout.form');
    Route::get('/customer/payment/{orderId}', [OrderController::class, 'Payment'])->name('customer.payment');
    Route::post('/customer/payment/{orderId}', [OrderController::class, 'SubmitPayment'])->name('customer.payment.submit');
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

    Route::get('/checkout/payment/{id}', [OrderController::class, 'Payment'])->name('customer.checkout.payment');
    Route::get('/product/search', [ProductController::class, 'search']);

    Route::get('/category/{slug}', [CategoryController::class, 'ShowBySlug'])->name('category.show');
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::post('/customer/product/add/{id}', [ProductController::class, 'ProductAdd'])->name('customer.product.add');
    Route::get('/product/detail/{id}', [ProductController::class, 'ProductDetail'])->name('product.detail');
    Route::get('/product/topsell', [ProductController::class, 'TopSell']);

    Route::get('/bundles/list', [BundleController::class, 'BundleIndex'])->name('customer.bundle.index');
    Route::get('/bundles', [BundleController::class, 'BundleShow'])->name('customer.bundle.show');
    Route::post('/bundle/buy/{id}', [BundleController::class, 'BundleBuy'])->name('customer.bundle.buy');
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
    Route::get('/admin/products/restock/{id}', [ProductController::class, 'RestockForm'])->name('admin.product.restock.form');
    Route::post('/admin/products/restock', [ProductController::class, 'RestockStore'])->name('admin.product.restock.store');

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

    Route::get('/admin/order/index', [AdminController::class, 'OrderAll'])->name('admin.order.index');
    Route::get('/admin/order/show/{id}', [AdminController::class, 'OrderShow'])->name('admin.order.show');
    Route::put('/admin/orders/{order}/approve', [AdminController::class, 'OrderApprove'])->name('admin.order.approve');

    Route::get('/admin/order/check/index', [AdminController::class, 'OrderCheckIndex'])->name('admin.order.check.index');
    Route::put('/admin/order/check/ready/{id}', [OrderController::class, 'OrderCheckReady'])->name('admin.order.check.ready');
    Route::put('/admin/order/check/notready/{id}', [OrderController::class, 'OrderCheckNotReady'])->name('admin.order.check.notready');

    Route::get('/admin/order/pack/index', [AdminController::class, 'OrderPackIndex'])->name('admin.order.pack.index');
    Route::put('/order/{id}/pack', [AdminController::class, 'OrderPacked'])->name('admin.order.pack');
    Route::get('/admin/order/send/index', [AdminController::class, 'OrderSendIndex'])->name('admin.order.send.index');
    Route::put('/order/{id}/approve-shipping', [AdminController::class, 'OrderAccShip'])->name('admin.order.approveShipping');
    Route::put('/order/{id}/reject-shipping', [AdminController::class, 'OrderRejectShip'])->name('admin.order.rejectShipping');
    route::get('/admin/order/completed/index', [AdminController::class, 'OrderCompleteIndex'])->name('admin.order.completed.index');

    Route::get('/admin/user/index', [AdminController::class, 'UserIndex'])->name('admin.user.index');
    Route::get('/admin/user/add', [AdminController::class, 'UserAdd'])->name('admin.user.add');
    Route::post('/admin/user/create', [AdminController::class, 'UserCreate'])->name('admin.user.create');
    Route::get('/admin/user/edit/{id}', [AdminController::class, 'UserEdit'])->name('admin.user.edit');
    Route::put('/admin/user/update/{id}', [AdminController::class, 'UserUpdate'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [AdminController::class, 'UserDelete'])->name('admin.user.delete');
});

Route::middleware(['auth:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'Dashboard'])->name('employee.dashboard');
    Route::get('/employee/order/index', [EmployeeController::class, 'OrderIndex'])->name('employee.order.index');
    Route::get('/employee/order/check/index', [EmployeeController::class, 'OrderCheckIndex'])->name('employee.order.check.index');
    Route::get('/employee/order/pack/index', [EmployeeController::class, 'OrderPackIndex'])->name('employee.order.pack.index');
    Route::get('/employee/order/send/index', [EmployeeController::class, 'OrderSendIndex'])->name('employee.order.send.index');
    Route::get('/employee/order/completed/index', [EmployeeController::class, 'OrderCompleteIndex'])->name('employee.order.completed.index');
    Route::get('/employee/order/show/{id}', [EmployeeController::class, 'OrderShow'])->name('employee.order.show');
    Route::put('/employee/orders/{order}/approve', [EmployeeController::class, 'OrderApprove'])->name('employee.order.approve');
    Route::put('/order/{id}/approve-shipping', [EmployeeController::class, 'OrderAccShip'])->name('admin.order.approveShipping');
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
