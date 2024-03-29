<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

  
    protected $fillable = ['name', 'size', 'price', 'quantity', 'image'];
    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->hasMany('App\Order')->orderBy('id', 'DESC');;
    }
}
