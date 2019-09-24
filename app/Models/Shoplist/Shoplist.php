<?php

namespace App\Models\Shoplist;

use Illuminate\Database\Eloquent\Model;

class Shoplist extends Model
{
    protected $table = 'shoplist';

    protected $fillable = [
        'location', 'shop_name', 'owner_name', 'latitude', 'longitude','status',
    ];
}
