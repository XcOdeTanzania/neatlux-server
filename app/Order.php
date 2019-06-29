<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'size', 'price', 'quantity', 'image'];

    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasOne('App\Product');
    }
}
