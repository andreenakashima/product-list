<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function edit(Product $product)
    {
        return view('admin.products_edit', [
            'product' => $product
        ]);
    }

    public function update(Product $product, ProductStoreRequest $request)
    {
        $input = $request->validate();

        $input['slug'] = Str::slug($input['name']);

        if(!empty($input['cover']) && $input['cover']->isValid()) {
            Storage::delete($product->cover ?? '');
            $file = $input['cover'];
            $path = $file->store('public/products');
            $input['cover'] = $path;
        }

        $product->fill($input);
        $product->save();

        return Redirect::route('admin.products');
    }

    public function create()
    {
        return view('admin.products_create');
    }

    public function store(ProductStoreRequest $request)
    {
        $input = $request->validate();
        $input['slug'] = Str::slug($input['name']);

        if(!empty($input['cover']) && $input['cover']->isValid()) {
            $file = $input['cover'];
            $path = $file->store('public/products');
            $input['cover'] = $path;
        }

        Product::create($input);

        return Redirect::route('admin.products');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Storage::delete($product->cover ?? '');

        return Redirect::route('admin.products');
    }

    public function destroyImage(Product $product)
    {
        Storage::delete($product->cover ?? '');
        $product->cover = null;
        $product->save();

        return Redirect::back();
    }
}
