<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function Dashboard()
    {
        // $employees = Employee::with('user')->get();
        // return view('employee.home', compact('employees'));
        return view('employee.dashboard');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
        ]);

        $employee = Employee::create($request->all());
        return response()->json($employee, Response::HTTP_CREATED);
    }

    /**
     * Display the specified employee.
     */
    public function show($id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        return response()->json($employee);
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'code' => 'integer',
        ]);

        $employee->update($request->all());
        return response()->json($employee);
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->destroy();
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function index(Request $request)
    {
        $products = Product::with('category')->get();
        return view('employee.product.index', compact('products'));
    }

    public function add(Request $request)
    {
        $categories = Category::all();
        return view('employee.product.add', compact('categories'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'required|exists:categories,id',
            ]);

            $product = Product::create($request->all());
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = 'product_' . $product->id . '.' . $extension;
                $imagePath = $image->storeAs('images/products', $filename, 'public');

                $product->update(['image' => $imagePath]);
            }

            return redirect()->back()->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function branchIndex(Request $request)
    {
        $branches = Branch::all();
        return view('employee.branch.index', compact('branches'));
    }

    public function branchAdd(Request $request)
    {
        return view('employee.branch.add');
    }

    public function branchCreate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'mall' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $branch = Branch::create($request->all());
            return redirect()->back()->with('success', 'Branch created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create branch: ' . $e->getMessage());
        }
    }
}
