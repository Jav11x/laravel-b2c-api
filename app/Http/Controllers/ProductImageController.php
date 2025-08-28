<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageStoreRequest;
use App\Models\{Product, ProductImage};

class ProductImageController extends Controller
{
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductImageStoreRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $image = $product->images()->create($request->validated());
        return response()->json($image, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $image_id)
    {
        $image = ProductImage::where('product_id', $id)->findOrFail($image_id);
        $image->delete();
        return response()->noContent();
    }




}
