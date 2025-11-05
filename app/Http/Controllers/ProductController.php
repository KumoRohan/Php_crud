<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        Product::create($request->all());
        return redirect()->route('products.index');
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function apiIndex(){
        $productp=  Product::select('id','name','price',)->get();
        return response()->json([
            'status' => 'success',
            'data' => $productp
        ]);
    }

}
