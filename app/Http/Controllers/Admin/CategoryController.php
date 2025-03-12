<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->keyword)) {
            $categories = $categories->where('name', 'like', '%' . $request->keyword . '%');
        }        

        $categories =  $categories->paginate(10);
        return view('admin.categories.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'photo' => 'required|mimes:png,jpg|max:3000',
        ]);

        //image upload logic
        $file = $request->file('photo');
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $request->file('photo')->storeAs('images',$fileName,'public');

        $categories = new Category;
        $categories->name = $request->name; 
        $categories->slug = $request->slug;
        $categories->status = $request->status;
        $categories->showonhome = $request->showonhome;
        $categories->image = $filePath;
        $categories->save();

        return redirect()->route('categories.index')->with('success','✅ Category Added Successfully');
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
        $categorydetails = Category::find($id);
        return view('admin.categories.edit',compact('categorydetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categories = Category::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $categories->id,
            'photo' => 'nullable|mimes:png,jpg|max:3000',
        ]);

        // Image upload logic
        if ($request->hasFile('photo')) {
            // Check if the old image exists and delete it
            $imagePath = public_path('/storage/' . $categories->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }

            // Upload the new image
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images', $fileName, 'public');
            $categories->image = $filePath; // Update the image field
        }

        // Update other fields
        $categories->name = $request->name;
        $categories->slug = $request->slug;
        $categories->status = $request->status;
        $categories->showonhome = $request->showonhome;
        $categories->save();

        return redirect()->route('categories.index')->with('success', '✅ Category Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        $imagePath = public_path('/storage/'.$category->image);

        if(file_exists($imagePath)){
            @unlink($imagePath);
        }

        return redirect()->route('categories.index')->with('success','✅ Category Deleted Successfully'); 
    }
}
