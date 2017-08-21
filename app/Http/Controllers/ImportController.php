<?php

namespace shopTest\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    //
   	public function __construct()
    {
        $this->middleware('auth');

    }

    public function showProduct(){    	
    	return view('import.product');    
    }

    public function uploadProduct(Request $request){
    	 // $this->validate($request, [
      //       	'file_product' => 'mimes:text,csv'
      //   	]);
    	$file = $request->file('file_product');
    	if (!empty($file)) {
            $ext = $file->extension($file);
            $name = date("Y_m_d")."_".$file->getClientOriginalName($file);
            $path = $file->storeAs('/import/product/',$name);
        }
    	return view('import.product');
    }
}
