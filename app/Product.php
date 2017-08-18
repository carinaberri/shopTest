<?php

namespace shopTest;

use Illuminate\Database\Eloquent\Model;
use shopTest\Category;

class Product extends Model
{
    protected $table 	= 'products';
    protected $fillable = ['name', 'description', 'quantity', 'price' ];
    
    // public function category(){
    //     return $this->belongsToMany(Category::class);
    // }
    
  	public function categories() {
    	return $this->belongsToMany('shopTest\Category', 'categories_products');
  	}
}
