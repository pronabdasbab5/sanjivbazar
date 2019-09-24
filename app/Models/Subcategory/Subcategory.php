<?php

namespace App\model\Subcategory;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'sub_category';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['pro_cate_id', 'sub_cate', 'img_path', 'status'];

    public function main_category() {

    	return $this->belongsTo('App\model\Maincategory\Maincategory', 'pro_cate_id', 'id');
    }

    public function products() {

    	return $this->hasMany('App\model\Products\Products', 'sub_cate_id', 'id');
    }
}
