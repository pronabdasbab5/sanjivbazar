<?php

namespace App\Models\Subcategory;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'sub_category';

    protected $fillable = ['pro_cate_id', 'sub_cate', 'img_path', 'status'];

    public function top_category() {

    	return $this->belongsTo('App\Models\Topcategory\Topcategory', 'pro_cate_id', 'id');
    }

    public function products() {

    	return $this->hasMany('App\Models\Products\Products', 'sub_cate_id', 'id');
    }
}
