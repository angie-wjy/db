<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return response()->json($branches);
    }

    public function show($id)
    {
        $branch = Branch::findOrFail($id);
        return response()->json($branch);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:100',
            'mall' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|string|max:45',
            'longitude' => 'nullable|string|max:45',
            'created_id' => 'nullable|integer',
            'updated_id' => 'nullable|integer',
            'deleted_id' => 'nullable|integer',
        ]);

        $branch = Branch::create($validatedData);
        return response()->json($branch, 201);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:100',
            'mall' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|string|max:45',
            'longitude' => 'nullable|string|max:45',
            'updated_id' => 'nullable|integer',
        ]);

        $branch->update($validatedData);
        return response()->json($branch);
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
