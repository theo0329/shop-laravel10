<?php

namespace App\Http\Controllers;

use Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', ['products' => $products]);
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/store/products');
    }

    public function newProduct()
    {
        return view('admin.new');
    }

    public function add()
    {
        $file = request::file('file');

        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($file->getFilename() . '.' . $extension, File::get($file));

        $entry = new \App\Models\File();
        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename() . '.' . $extension;
        $entry->save();

        //$file_id = FILE::id();
        $product = new \App\Models\Product();
        $product->file_id = $entry->id;
        $product->name = Request::input('name');
        $product->description = Request::input('description');
        $product->price = Request::input('price');
        $product->imageurl = Request::input('imageurl');

        $product->save();

        return redirect('/store/products');

    }
}
