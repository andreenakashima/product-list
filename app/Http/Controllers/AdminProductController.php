<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function edit()
    {
        return view('admin.products_edit');
    }

    public function update()
    {

    }

    public function create()
    {
        return view('admin.products_create');
    }

    public function store()
    {

    }
}
