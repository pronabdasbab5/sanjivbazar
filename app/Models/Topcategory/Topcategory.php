<?php

namespace App\Models\Topcategory;

use Illuminate\Database\Eloquent\Model;

class Topcategory extends Model
{
    protected $table = 'top_category';

    protected $fillable = ['cate_name', 'img_path', 'status'];
}
