<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->when(request()->q, function ($products) {
            $products = $products->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'         => 'required|image|mimes:jpeg,jpg,png,png|max:2000',
            'title'         => 'required|unique:products',
            'category_id'   => 'required',
            'content'       => 'required',
            'weight'        => 'required',
            'price'         => 'required',
            'discount'      => 'required',
        ]);

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        // Dave to DB
        $product = Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'category_id'   => $request->category_id,
            'content'       => $request->content,
            'unit'          => $request->unit,
            'weight'        => $request->weight,
            'price'         => $request->price,
            'discount'      => $request->discount,
            'keywords'      => $request->keywords,
            'description'   => $request->description
        ]);

        if($product){
            // Redirect with success message
            return redirect()->route('admin.product.index')->with(['success' => 'Save successfull!']);
        } else {
            // Redirect with error message
            return redirect()->route('admin.product.index')->with(['error' => 'Save failed!']);
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::latest()->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'title'         => 'required|unique:products,title,'.$product->id,
            'category_id'   => 'required',
            'content'       => 'required',
            'weight'        => 'required',
            'price'         => 'required',
            'discount'      => 'required'
        ]);

        // Check if image is empty
        if($request->file('image') == '') {
            // Update without image
            $product = Product::findOrFail($product->id);
            $product->update([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'category_id'   => $request->category_id,
                'content'       => $request->content,
                'unit'          => $request->unit,
                'weight'        => $request->weight,
                'price'         => $request->price,
                'discount'      => $request->discount,
                'keywords'      => $request->keywords,
                'description'   => $request->description
            ]);
        } else {
            // Delete old image
            Storage::disk('local')->delete('public/products/' . basename($product->image));

            // Upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            // Update with image
            $product = Product::findOrFail($product->id);
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'category_id'   => $request->category_id,
                'content'       => $request->content,
                'unit'          => $request->unit,
                'weight'        => $request->weight,
                'price'         => $request->price,
                'discount'      => $request->discount,
                'keywords'      => $request->keywords,
                'description'   => $request->description
            ]);
        }

        if($product){
            // Redirect with success message
            return redirect()->route('admin.product.index')->with(['success' => 'Update Successfull!']);
            
            // Redirect with error message
            return redirect()->route('admin.product.index')->with(['error' => 'Update Failed!']);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $image = Storage::disk('local')->delete('public/products/' . basename($product->image));
        $product->delete();

        if($product){
            return response()->json([
                'status' => 'success',

            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
