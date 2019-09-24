<?php

namespace App\model\Subbrands;

use Illuminate\Database\Eloquent\Model;

class Subbrands extends Model
{
    protected $table = 'sub_brand';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'sub_cate_id', 'brand_id', 'status'];
}
