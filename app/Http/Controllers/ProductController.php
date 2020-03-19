<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Str, Alert, Storage;

class ProductController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('product.category', compact('categories'));
    }
    public function index(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();
        return view('product.index', compact('products','category'));
    }

    public function create(Category $category)
    {
        return view ('product.create', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
        ],
        [
            'name.required' => 'Nama Produk Harus Di Isi',
            'price.required' => 'Harga Produk Di Isi',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
        ]);

        Alert::success('Data Produk Baru Berhasil Ditambahkan');
        return redirect()->route('product.index', $category);
    }

    public function edit(Category $category, Product $product)
    {
        return view('product.edit', compact('category','product'));
    }

    public function update(Request $request, Category $category, Product $product)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
        ],
        [
            'name.required' => 'Nama Produk Harus Di Isi',
            'price.required' => 'Harga Produk Di Isi',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        Alert::success('Data Produk Berhasil Diperbarui');
        return redirect()->route('product.index', $category);
    }

   
    public function destroy(Category $category, Product $product)
    {
        $product->delete();
        return redirect()->route('product.index', $category);
    }
}
