<?php

namespace shopTest\Http\Controllers;

use shopTest\Product;
use shopTest\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('product.index',['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $product = new Product;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;
        $product->save();
        $file = $request->file('file_product');

        if (!empty($file)) {
            $ext = $file->ext();
            $path = $file->storeAs('/public/product/'. $product->id."/",$product->id.".".$ext);
        }

        

        return redirect()->route('product.index')->with('message', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \shopTest\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product){
            abort(404);
        }
       
        return view('product.view')->with('product', $product);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \shopTest\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product   = Product::findOrFail($id);
         $categories = Category::all();
         $directory = '/public/product/'. $product->id."/";
         $files     = Storage::files($directory);
         $categories_product = $product->categories()->orderBy('name')->get();
         var_dump($categories_product);
         die;
        return view('product.edit',compact('product'))->with(array('files'=>$files,'categories'=>$categories,'categories_product'=>$categories_product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \shopTest\Product  $product_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
        
        $product = Product::find($id);
        $product->name         = $request->name;
        $product->description  = $request->description;
        $product->price        = $request->price;
        $product->quantity     = $request->quantity;
        $product->save();
        $file = $request->file('file_product');

        $product->categories()->detach();
        $product->categories()->attach($request->categories);

        if (!empty($file)) {
            $ext = $file->extension($file);
            $path = $file->storeAs('/public/product/'. $product->id."/",$product->id.".".$ext);
        }

        
        return redirect('product')->with('message', 'Product Saved!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \shopTest\Product  $product_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('alert-success','Product hasbeen deleted!');
    }


}
