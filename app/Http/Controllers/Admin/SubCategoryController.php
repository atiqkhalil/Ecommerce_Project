<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subcategories = SubCategory::latest()->with('category');

        if (!empty($request->keyword)) {
            $subcategories = $subcategories->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%'); // Search in category name
                });
        }      

        $subcategories =  $subcategories->paginate(10);
        return view('admin.sub-categories.list',compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name','ASC')->get();
        return view('admin.sub-categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
        ]);

        $subcategories = new SubCategory;
        $subcategories->name = $request->name; 
        $subcategories->slug = $request->slug;
        $subcategories->status = $request->status;
        $subcategories->showonhome = $request->showonhome;
        $subcategories->category_id = $request->category;
        $subcategories->save();

        return redirect()->route('sub-categories.index')->with('success','✅ Sub Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subcategories = SubCategory::with('category')->findOrFail($id);
        $categories = Category::all(); // Fetch all categories for the dropdown
        return view('admin.sub-categories.edit', compact('subcategories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subcategories = SubCategory::find($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subcategories->id,
            'category_id' => 'required',
        ]);

        $subcategories->name = $request->name; 
        $subcategories->slug = $request->slug;
        $subcategories->status = $request->status;
        $subcategories->showonhome = $request->showonhome;
        $subcategories->category_id = $request->category_id;
        $subcategories->save();

        return redirect()->route('sub-categories.index')->with('success','✅ Sub Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategories = SubCategory::find($id);
        $subcategories->delete();

        return redirect()->route('sub-categories.index')->with('success','✅ Sub Category Deleted Successfully');
    }
}
