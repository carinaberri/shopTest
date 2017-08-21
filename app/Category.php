<?php

namespace shopTest;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table 	= 'categories';
    protected $fillable = ['name','description',];

    // public function products(){
    //     return $this->hasMany(Products::class);
    // }
    public function products() {
    	return $this->belongsToMany('shopTest\Product', 'categories_products');
  	}

   	
}
