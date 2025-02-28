<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'img',
        'price',
        'slug'
    ];
    public function ingredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }
}
