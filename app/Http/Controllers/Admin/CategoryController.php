<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function add(Request $request){
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        // Create the category
        Category::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        // Redirect with a success message
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    //fetch through ajax
    public function getcategory()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    
}
