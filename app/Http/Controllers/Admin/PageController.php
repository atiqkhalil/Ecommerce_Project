<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = Page::latest();

        if (!empty($request->keyword)) {
            $pages = $pages->where('name', 'like', '%' . $request->keyword . '%');
        }        

        $pages =  $pages->paginate(8);
        return view('admin.pages.list',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:pages',
        ]);

        $pages = new Page;
        $pages->name = $request->name;
        $pages->slug = $request->slug;
        $pages->content = $request->content;
        $pages->save();

        return redirect()->route('pages.index')->with('success','✅ Page Added Successfully');
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
        $page = Page::find($id);
        return view('admin.pages.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pages = Page::find($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,' . $pages->id,
        ]);

       
        $pages->name = $request->name;
        $pages->slug = $request->slug;
        $pages->content = $request->content;
        $pages->save();

        return redirect()->route('pages.index')->with('success','✅ Page Edit Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::find($id);
        $page->delete();
        return redirect()->route('pages.index')->with('success','✅ Page Deleted Successfully');
    }
}
