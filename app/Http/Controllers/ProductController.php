<?php

namespace App\Http\Controllers;

use App\Http\Requests\{ProductStoreRequest, ProductUpdateRequest};
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'images']);
        if ($request->filled('category_id')) $query->where('category_id', (int)$request->get('category_id'));
        if ($request->filled('active')) $query->where('active', filter_var($request->get('active'), FILTER_VALIDATE_BOOLEAN));
        $perPage = min(max((int)$request->get('per_page', 10), 1), 100);
        $page = $query->orderBy('id', 'desc')->paginate($perPage);
        return ProductResource::collection($page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        return new ProductResource($product->load(['category', 'images']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return new ProductResource($product->load(['category', 'images']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return response()->noContent();
    }
}
