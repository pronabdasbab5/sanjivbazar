<?php

namespace App\Models\Subsize;

use Illuminate\Database\Eloquent\Model;

class Subsize extends Model
{
    protected $table = 'sub_size';

    protected $fillable = ['id', 'sub_cate_id', 'size_id', 'status'];
}
