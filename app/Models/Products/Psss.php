<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Psss extends Model
{
    protected $table = 'price_stock_shop_setup';

    protected $fillable = ['product_id', 'brand_id', 'size_id', 'shop_id', 'price', 'stock'];
}
