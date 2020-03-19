<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Alert, Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));

    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required'
        ],
        [
            'name.required'=> 'Nama Kategori Harus Diisi',
            'description.required'=>'Deskripsi kategori harus di isi'
        ]);

        Category::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'slug'=>Str::slug($request->name)
        ]);
        Alert::success('Data kategori berhasil ditambahkan');
        return redirect()->route('category.index');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required'
        ],
        [
            'name.required'=> 'Nama Kategori Harus Diisi',
            'description.required'=>'Deskripsi kategori harus di isi'
        ]);
        $category->update([
            'name'=>$request->name,
            'description'=>$request->description,
            
        ]);
        Alert::success('Data kategori berhasil diubah');
        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index');
    }
}
