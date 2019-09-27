<?php

namespace App\Models\Brands;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $table = 'brands';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'brands'];
}
