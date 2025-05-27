<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::all();
        return response()->json($bundles);
    }

    public function store(Request $request)
    {
        $bundle = Bundle::create($request->all());
        return response()->json($bundle);
    }

    public function show($id)
    {
        $bundle = Bundle::findOrFail($id);
        return response()->json($bundle);
    }

    public function update(Request $request, $id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->update($request->all());
        return response()->json($bundle);
    }

    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->delete();
        return response()->json(['message' => 'Bundle deleted successfully']);
    }
}
