<?php

namespace shopTest\Http\Controllers;

use shopTest\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);
        return view('category.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $category = new Category;
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->save();
        $file = $request->file('file_category');

        if (!empty($file)) {
            $ext = $file->ext();
            $path = $file->storeAs('/public/category/'. $product->id."/",$product->id.".".$ext);   
        }        

        return redirect()->route('category.index')->with('message', 'Category created successfully!');//
    }

    /**
     * Display the specified resource.
     *
     * @param  \shopTest\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \shopTest\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category   = Category::findOrFail($id);
        $directory = '/public/category/'. $category->id."/";
        $files     = Storage::files($directory);
        return view('category.edit',compact('category'))->with('files',$files);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \shopTest\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \shopTest\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
