<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::latest();

        if (!empty($request->keyword)) {
            $brands = $brands->where('name', 'like', '%' . $request->keyword . '%');
        }

        $brands =  $brands->paginate(10);
        return view('admin.brands.list', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:3000',
        ]);

        //image upload logic
        $file = $request->file('photo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $request->file('photo')->storeAs('images', $fileName, 'public');

        $brands = new Brand;
        $brands->name = $request->name;
        $brands->description = $request->desc;
        $brands->slug = $request->slug;
        $brands->status = $request->status;
        $brands->image = $filePath;
        $brands->save();

        return redirect()->route('brand.index')->with('success', '✅ Brand Added Successfully');
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
        $branddetails = Brand::find($id);
        return view('admin.brands.edit', compact('branddetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brands = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $brands->id, 
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:3000',
        ]);

        // Image upload logic
        if ($request->hasFile('photo')) {
            // Check if the old image exists and delete it
            $imagePath = public_path('/storage/' . $brands->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }

            // Upload the new image
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images', $fileName, 'public');
            $brands->image = $filePath; // Update the image field
        }

        // Update other fields
        $brands->name = $request->name;
        $brands->description = $request->desc;
        $brands->slug = $request->slug;
        $brands->status = $request->status;
        $brands->save();

        return redirect()->route('brand.index')->with('success', '✅ Brand Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        $brand->delete();

        $imagePath = public_path('/storage/' . $brand->image);

        if (file_exists($imagePath)) {
            @unlink($imagePath);
        }

        return redirect()->route('brand.index')->with('success', '✅ Brand Deleted Successfully');
    }
}
