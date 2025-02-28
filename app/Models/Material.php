<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable=[
        'name',
        'slug'
    ];
    public function invoiceMaterials()
    {
        return $this->hasMany(InvoiceMaterial::class, 'material_id');
    }
}
