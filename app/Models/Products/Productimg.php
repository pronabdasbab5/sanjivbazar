<?php

namespace App\Models\Productimg;

use Illuminate\Database\Eloquent\Model;

class Productimg extends Model
{
    protected $table = 'product_add_img';

    protected $fillable = ['product_id', 'image_path'];
}
