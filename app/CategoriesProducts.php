<?php

namespace shopTest;

use Illuminate\Database\Eloquent\Model;

class CategoriesProducts extends Model
{
    protected $table 	= 'categories_products';
    protected $fillable = ['category_id','product_id',];
}
