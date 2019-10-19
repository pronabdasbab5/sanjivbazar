<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'product';

    protected $fillable = ['pro_name', 'cate_id', 'sub_cate_id', 'desc', 'cover_img_path', 'status'];

    public function sub_category() {

    	return $this->belongsTo('App\Models\Subcategory\Subcategory', 'sub_cate_id', 'id');
    }
}
