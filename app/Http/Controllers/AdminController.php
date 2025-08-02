<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Bundle;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsHasBranches;
use App\Models\ProductsHasBundles;
use App\Models\ProductSize;
use App\Models\ProductTheme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function Dashboard()
    {
        // $admins = admin::with('user')->get();
        // return view('admin.home', compact('admins'));
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:admins,user_id',
        ]);

        $admin = admin::create($request->all());
        return response()->json($admin, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $admin = admin::with('user')->findOrFail($id);
        return response()->json($admin);
    }

    public function update(Request $request, $id)
    {
        $admin = admin::findOrFail($id);

        $request->validate([
            'code' => 'integer',
        ]);

        $admin->update($request->all());
        return response()->json($admin);
    }

    public function destroy($id)
    {
        $admin = admin::findOrFail($id);
        $admin->destroy();
        return response()->json(['message' => 'admin deleted successfully']);
    }

    public function ProductIndex(Request $request)
    {
        $products = Product::with('category')->get();
        return view('admin.product.index', compact('products'));
    }

    public function ProductAdd(Request $request)
    {
        $categories = Category::all();
        $themes = ProductTheme::all();
        $sizes = ProductSize::all();
        return view('admin.product.add', compact('categories', 'themes', 'sizes'));
    }

    public function ProductCreate(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|max:5',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'categories_id' => 'required|exists:categories,id',
                'product_themes_id' => 'required|exists:product_themes,id',
                'product_sizes_id' => 'required|exists:product_sizes,id',
            ]);

            $product = Product::create($request->all());

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = 'product_' . $product->id . '.' . $extension;
                $imagePath = $image->storeAs('images/products', $filename, 'public');

                $product->update(['image' => $imagePath]);
            }
            return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function ProductEdit(Request $request, $id)
    {
        // $product = Product::with('category')->findOrFail($id);
        // return view('admin.product.edit', compact('product'));
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $themes = ProductTheme::all();
        $sizes = ProductSize::all();
        return view('admin.product.edit', compact('product', 'categories', 'themes', 'sizes'));
        // try {
        //     $product = Product::findOrFail($id);
        //     $product->update($request->all());
        //     // session()->flash('success', 'Product updated successfully');
        //     return view('admin.product.edit', compact('product'));
        //     // redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage());
        // }
    }

    public function ProductUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // $product->update($request->all());
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->categories_id = $request->category_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'product_' . $product->id . '.' . $extension;
            $imagePath = $image->storeAs('images/products', $filename, 'public');

            $product->update(['image' => $imagePath]);
        }

        $product->save();

        // return redirect()->back()->with('success', 'Product updated successfully');
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
    }

    public function ProductDelete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            session()->flash('success', 'Product deleted successfully');
            return redirect()->route('admin.product.index');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function ProductBranchIndex()
    {
        $producthasbranches = ProductsHasBranches::with(['product', 'branch'])->get();

        return view('admin.product.branch.index', compact('producthasbranches'));
    }

    public function ProductBranchAdd()
    {
        $products = Product::all();
        $branches = Branch::all();
        return view('admin.product.branch.add', compact('products', 'branches'));
    }

    public function ProductBranchCreate(Request $request)
    {
        try {
            $request->validate([
                'products_id' => 'required|exists:products,id',
                'branches_id' => 'required|exists:branches,id',
                'stock' => 'required|numeric|min:0',
            ]);

            $productBranch = ProductsHasBranches::create($request->all());
            return redirect()->route('admin.product.branch.index')->with('success', 'Product branch created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to create product branch: ' . $th->getMessage());
        }
    }

    public function ProductBranchEdit($id)
    {
        try {
            $productBranch = ProductsHasBranches::with(['product', 'branch'])->findOrFail($id);
            $products = Product::all();
            $branches = Branch::all();

            return view('admin.product.branch.edit', compact('productBranch', 'products', 'branches'));
        } catch (\Exception $e) {
            return redirect()->route('admin.product.branch.index')->with('error', 'Failed to load product branch: ' . $e->getMessage());
        }
    }

    public function ProductBranchUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'products_id' => 'required|exists:products,id',
                'branches_id' => 'required|exists:branches,id',
                'stock' => 'required|numeric|min:0',
            ]);

            $productBranch = ProductsHasBranches::findOrFail($id);
            $productBranch->update($request->all());

            return redirect()->route('admin.product.branch.index')->with('success', 'Product branch updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.branch.index')->with('error', 'Failed to update product branch: ' . $e->getMessage());
        }
    }

    public function ProductBranchDelete($id)
    {
        try {
            $productBranch = ProductsHasBranches::findOrFail($id);
            $productBranch->delete();

            return redirect()->route('admin.product.branch.index')->with('success', 'Product branch deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.branch.index')->with('error', 'Failed to delete product branch: ' . $e->getMessage());
        }
    }

    public function BundleIndex(Request $request)
    {
        $bundles = Bundle::with('products')->get();
        return view('admin.product.bundle.index', compact('bundles'));
    }

    public function BundleAdd(Request $request)
    {
        $products = Product::with('branches')->get();
        return view('admin.product.bundle.add', compact('products'));
    }

    public function BundleCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'products' => 'required|array',
                'products.*' => 'exists:products,id',
                'quantities' => 'required|array',
            ]);

            $bundle = Bundle::create([
                'name' => $request->name,
                'price' => $request->price,
            ]);
            // dd($bundle);
            foreach ($request->products as $index => $productId) {
                $products_has_bundles = ProductsHasBundles::create([
                    'bundles_id' => $bundle->id,
                    'products_id' => $productId,
                    'quantity' => $request->quantities[$index],
                    'price'   => $request->prices[$index]
                ]);
            }
            return redirect()->route('admin.product.bundle.index')->with('success', 'Bundle created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create bundle: ' . $e->getMessage());
        }
    }

    public function BundleEdit($id)
    {
        try {
            $bundle = Bundle::with('productsHasBundles')->findOrFail($id);
            $products = Product::all();

            return view('admin.product.bundle.edit', compact('bundle', 'products'));
        } catch (\Exception $e) {
            return redirect()->route('admin.product.bundle.index')->with('error', 'Failed to load bundle: ' . $e->getMessage());
        }
    }

    public function BundleDelete($id)
    {
        try {
            $bundle = Bundle::findOrFail($id);
            $bundle->delete();
            return redirect()->route('admin.product.bundle.index')->with('success', 'Bundle deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.bundle.index')->with('error', 'Failed to delete bundle: ' . $e->getMessage());
        }
    }

    public function BundleUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'products' => 'required|array',
                'products.*' => 'exists:products,id',
                'quantities' => 'required|array',
            ]);
            // dd($request->all());

            $bundle = Bundle::findOrFail($id);

            $bundle->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            foreach ($request->products as $index => $productId) {
                $products_has_bundles = ProductsHasBundles::where('bundles_id', $id)
                    ->where('products_id', $productId)
                    ->first();

                if ($products_has_bundles) {
                    $products_has_bundles->quantity = $request->quantities[$index];
                    $products_has_bundles->save();
                } else {
                    ProductsHasBundles::create([
                        'bundles_id' => $id,
                        'products_id' => $productId,
                        'quantity' => $request->quantities[$index],
                    ]);
                }
            }

            return redirect()->route('admin.product.bundle.index')->with('success', 'Bundle updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.bundle.index')->with('error', 'Failed to update bundle: ' . $e->getMessage());
        }
    }


    public function BranchIndex(Request $request)
    {
        $branches = Branch::all();
        return view('admin.branch.index', compact('branches'));
    }

    public function BranchAdd(Request $request)
    {
        return view('admin.branch.add');
    }

    public function BranchCreate(Request $request)
    {
        try {
            // dd($request->latitude);
            $request->validate([
                'mall' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'latitude' => 'required|string|max:45',
                'longitude' => 'required|string|max:45',
            ]);

            $branch = Branch::create($request->all());
            // return redirect()->back()->with('success', 'Branch created successfully');
            return redirect()->route('admin.branch.index')->with('success', 'Branch created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create branch: ' . $e->getMessage());
        }
    }

    public function BranchEdit($id)
    {
        try {
            $branch = Branch::findOrFail($id);

            return view('admin.branch.edit', compact('branch'));
        } catch (\Exception $e) {
            return redirect()->route('admin.branch.index')->with('error', 'Failed to load branch: ' . $e->getMessage());
        }
    }

    public function BranchUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'mall' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'latitude' => 'required|string|max:45',
                'longitude' => 'required|string|max:45',
            ]);

            $branch = Branch::findOrFail($id);

            $branch->update($request->all());

            // return redirect()->back()->with('success', 'Branch updated successfully');
            return redirect()->route('admin.branch.index')->with('success', 'Branch updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.branch.index')->with('error', 'Failed to update branch: ' . $e->getMessage());
        }
    }

    public function BranchDelete($id)
    {
        try {
            $branch = Branch::findOrFail($id);

            $branch->delete();
            // return redirect()->back()->with('success', 'Branch deleted successfully');
            return redirect()->route('admin.branch.index')->with('success', 'Branch deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.branch.index')->with('error', 'Failed to delete branch: ' . $e->getMessage());
        }
    }

    public function CategoryIndex(Request $request)
    {
        $categories = Category::all();
        return view('admin.product.category.index', compact('categories'));
    }

    public function CategoryAdd(Request $request)
    {
        return view('admin.product.category.add');
    }

    public function CategoryCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $category = Category::create($request->all());
            // return redirect()->back()->with('success', 'Category created successfully');
            return redirect()->route('admin.product.category.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function CategoryEdit($id)
    {
        try {
            $category = Category::findOrFail($id);

            return view('admin.product.category.edit', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('admin.product.category.index')->with('error', 'Failed to load category: ' . $e->getMessage());
        }
    }

    public function CategoryUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $category = Category::findOrFail($id);

            $category->update($request->all());

            // return redirect()->back()->with('success', 'Category updated successfully');
            return redirect()->route('admin.product.category.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.category.index')->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function CategoryDelete($id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->delete();
            // return redirect()->back()->with('success', 'Category deleted successfully');
            return redirect()->route('admin.product.category.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.category.index')->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    public function ThemeIndex(Request $request)
    {
        $themes = ProductTheme::all();
        return view('admin.product.theme.index', compact('themes'));
    }

    public function ThemeAdd(Request $request)
    {
        return view('admin.product.theme.add');
    }

    public function ThemeCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $theme = ProductTheme::create($request->all());
            // return redirect()->back()->with('success', 'Theme created successfully');
            return redirect()->route('admin.product.theme.index')->with('success', 'Theme Created Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create theme: ' . $e->getMessage());
        }
    }

    public function ThemeEdit($id)
    {
        try {
            $theme = ProductTheme::findOrFail($id);

            return view('admin.product.theme.edit', compact('theme'));
        } catch (\Exception $e) {
            return redirect()->route('admin.product.theme.index')->with('error', 'Failed to load theme: ' . $e->getMessage());
        }
    }

    public function ThemeUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $theme = ProductTheme::findOrFail($id);

            $theme->update($request->all());

            // return redirect()->back()->with('success', 'Theme updated successfully');
            return redirect()->route('admin.product.theme.index')->with('success', 'Theme updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.theme.index')->with('error', 'Failed to update theme: ' . $e->getMessage());
        }
    }

    public function ThemeDelete($id)
    {
        try {
            $theme = ProductTheme::findOrFail($id);

            $theme->delete();
            // return redirect()->back()->with('success', 'Theme deleted successfully');
            return redirect()->route('admin.product.theme.index')->with('success', 'Theme deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.theme.index')->with('error', 'Failed to delete theme: ' . $e->getMessage());
        }
    }

    public function SizeIndex(Request $request)
    {
        $sizes = ProductSize::all();
        return view('admin.product.size.index', compact('sizes'));
    }

    public function SizeAdd(Request $request)
    {
        return view('admin.product.size.add');
    }

    public function SizeCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $size = ProductSize::create($request->all());
            // return redirect()->back()->with('success', 'Size created successfully');
            return redirect()->route('admin.product.size.index')->with('success', 'Size created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create size: ' . $e->getMessage());
        }
    }

    public function SizeEdit($id)
    {
        try {
            $size = ProductSize::findOrFail($id);

            return view('admin.product.size.edit', compact('size'));
        } catch (\Exception $e) {
            return redirect()->route('admin.product.size.index')->with('error', 'Failed to load size: ' . $e->getMessage());
        }
    }

    public function SizeUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
            ]);

            $size = ProductSize::findOrFail($id);

            $size->update($request->all());

            // return redirect()->back()->with('success', 'Size updated successfully');
            return redirect()->route('admin.product.size.index')->with('success', 'Size updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.size.index')->with('error', 'Failed to update size: ' . $e->getMessage());
        }
    }

    public function SizeDelete($id)
    {
        try {
            $size = ProductSize::findOrFail($id);

            $size->delete();
            // return redirect()->back()->with('success', 'Size deleted successfully');
            return redirect()->route('admin.product.size.index')->with('success', 'Size deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.size.index')->with('error', 'Failed to delete size: ' . $e->getMessage());
        }
    }

    public function OrderAll(Request $request)
    {
        $orders = Order::with('customer', 'bundles')->get();
        return view('admin.order.index', compact('orders'));
        // return view('admin.order.index');
    }

    public function OrderShow($id)
    {
        // $order = Order::with(['customer', 'orderDetails.product'])->findOrFail($id);
        // return view('admin.orders.show', compact('order'));
        $order = Order::with(['products', 'ship'])->findOrFail($id);
        return view('customer.checkout', compact('order'));
    }

    // public function OrderApprove($id)
    // {
    //     $order = Order::findOrFail($id);
    //     $order->status = 'processed';
    //     $order->is_ready_stock = true;
    //     $order->save();

    //     return redirect()->back()->with('success', 'Order approved and moved to processed!');
    // }

    public function OrderApprove($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'new') {
            return redirect()->back()->with('error', 'Only new orders can be approved.');
        }

        $order->status = 'processed';
        $order->is_ready_stock = true;
        $order->save();

        return redirect()->back()->with('success', 'Order approved and moved to processed!');
    }

    public function OrderCheckIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'paid')->get();
        return view('admin.order.check.index', compact('orders'));
    }

    public function OrderPackIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'checked')->get();
        return view('admin.order.pack.index', compact('orders'));
    }

    public function OrderPacked($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'packed';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as packed and ready to send!');
    }

    public function OrderSendIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'packed')->get();
        return view('admin.order.send.index', compact('orders'));
    }

    public function OrderAccShip($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipping';
        $order->save();

        return back()->with('success', 'Shipping approved successfully.');
    }

    public function OrderRejectShip($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipping_rejected';
        $order->save();

        return back()->with('success', 'Shipping has been rejected.');
    }

    public function showApproveShipping()
    {
        $orders = Order::where('status', 'packed')->get();
        return view('admin.orders.approveShipping', compact('orders'));
    }

    public function OrderCompleteIndex(Request $request)
    {
        $orders = Order::with('customer')->where('status', 'shipping')->get();
        return view('admin.order.completed.index', compact('orders'));
    }

    public function UserIndex(Request $request)
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function UserAdd(Request $request)
    {
        return view('admin.user.add');
    }

    public function UserCreate(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string',
                'address' => 'nullable|string',
                'role' => 'required|in:admin,employee,customer',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('admin.user.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function UserEdit($id)
    {
        try {
            $user = User::findOrFail($id);

            return view('admin.user.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Failed to load user: ' . $e->getMessage());
        }
    }

    public function UserUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user = User::findOrFail($id);

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->update($request->all());

            // return redirect()->back()->with('success', 'User updated successfully');
            return redirect()->route('admin.user.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function UserDelete($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();
            // return redirect()->back()->with('success', 'User deleted successfully');
            return redirect()->route('admin.user.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
