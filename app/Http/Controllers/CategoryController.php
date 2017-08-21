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
        $categories_model = Category::orderBy('id', 'desc')->paginate(10);
        $categories = $categories_model->map(function ($item, $key) {
            $directory      = '/public/category/'. $item->id."/";
            $file           = Storage::files($directory);
            $item["img"]    = $file; 
            return $item;
        });
        return view('category.index',['categories' => $categories,"categories_model"=>$categories_model]);
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
        $this->validate($request, [
            'name'          => 'required|max:150',
            'description'   => 'required|max:255',
        ]);

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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required|max:150',
            'description'   => 'required|max:255',
        ]);
        
        $category = Category::find($id);
        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->save();
        $file = $request->file('file_category');        

        if (!empty($file)) {
            $ext = $file->extension($file);
            $path = $file->storeAs('/public/category/'. $category->id."/",$category->id.".".$ext);
        }

        
        return redirect('category')->with('message', 'category Saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \shopTest\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('message','category has been deleted!');
    }
}
