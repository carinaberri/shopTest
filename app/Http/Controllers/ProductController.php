<?php

namespace shopTest\Http\Controllers;

use shopTest\Product;
use shopTest\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{

    protected $paginate = 5;
 
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
        $categories     = Category::all();
        $product_model = Product::orderBy('id', 'desc')->paginate($this->paginate);
        
        $products = $product_model->each(function ($item, $key) {
            $directory      = '/public/product/'. $item->id."/";
            $file           = Storage::files($directory);
            $item["img"]    = $file; 
            return $item;
        });
        return view('product.index',['products' => $products, "categories"=>$categories,'product_model'=>$product_model]);
    }

    /**
     * Display a listing of the resource about one or more categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterByCategory($id)
    {
        $categories     = Category::all();
        $product_model  = Product::whereHas('categories', function ($query) use ($id) {
                        $query->where('category_id', '=', $id);
                    })->paginate($this->paginate);
        $products       = $product_model->map(function ($item, $key) {
                                    $directory      = '/public/product/'. $item->id."/";
                                    $file           = Storage::files($directory);
                                    $item["img"]    = $file; 
                                    return $item;
                                });
        return view('product.index',['products' => $products, 'product_model'=>$product_model,"categories"=>$categories]);
    }

    public function search(Request $request){
        $categories     = Category::all();
        if(count($request->categories)>0){
             $product_model  = Product::whereHas('categories', function ($query) use ($request) {
                        $query->whereIn('category_id',array_values($request->categories));
                    })->where('products.name', 'like',"$request->search%")->paginate($this->paginate);
        }
        else{
            $product        = new Product;
            $product_model  = $product->where('name', 'like',"$request->search%")->paginate($this->paginate);
        }
        
        $products       = $product_model->map(function ($item, $key) {
                                    $directory      = '/public/product/'. $item->id."/";
                                    $file           = Storage::files($directory);
                                    $item["img"]    = $file; 
                                    return $item;
                                });
        return view('product.index',['products' => $products, 'product_model'=>$product_model, "categories"=>$categories]);
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
        $this->validate($request, [
            'name'          => 'required|max:150',
            'description'   => 'required|max:255',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'file_product' => 'mimes:jpg,png'
        ]);

        $product = new Product;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = intval($request->quantity);
        $product->price       = number_format($request->price);
        $product->save();
        $file = $request->file('file_product');

        if (!empty($file)) {
            $ext = $file->extension($file);
            $path = $file->storeAs('/public/product/'. $product->id."/",$product->id.".".$ext);
        }

        if(!empty($request->categories)){
            $product->categories()->attach($request->categories);    
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
         $categories_product = [];
         foreach ($product->categories as $category) {
            $categories_product[] = $category->id;
        }
         
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
            'name'          => 'required|max:150',
            'description'   => 'required|max:255',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'file_product' => 'mimes:jpg,png'
        ]);
        
        $product = Product::find($id);
        $product->name         = $request->name;
        $product->description  = $request->description;
        $product->quantity    = intval($request->quantity);
        $product->price       = number_format($request->price);
        $product->save();
        $file = $request->file('file_product');

        // 
        if(!empty($request->categories)){
            $product->categories()->detach();
            $product->categories()->attach($request->categories);    
        }
        

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
    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('message','Product hasbeen deleted!');
    }


}
