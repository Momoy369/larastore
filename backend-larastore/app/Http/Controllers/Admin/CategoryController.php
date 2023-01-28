<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);


        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name' => 'required|unique:categories'
        ]);

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // Save to DB
        $category = Category::create([
            'image' => $image->hashName(),
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        if($category) {
            // Redirect with success message
            return redirect()->route('admin.category.index')->with(['success' => 'Successfully saved!']);
        } else {
            // Redirect with error message
            return redirect()->route('admin.category.index')->with(['error' => 'Save fail!']);
        }
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        // Check if image is empty
        if($request->file('image') == '') {
            // Update data without image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-')
            ]);
        } else {
            // Delete old image
            Storage::disk('local')->delete('public/categories/'.basename($category->image));

            // Upload new image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // Update with new image
            $category = Category::findOrFail($category->id);
            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-')
            ]);
        }

        if($category) {
            // Redirect with success message
            return redirect()->route('admin.category.index')->with(['success' => 'Successfully updated!']);
        } else {
            // Redirect with error message
            return redirect()->route('admin.category.index')->with(['error' => 'Error updating category!']);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $image = Storage::disk('local')->delete('public/categories/'.basename($category->image));

        $category->delete();

        if($category) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
