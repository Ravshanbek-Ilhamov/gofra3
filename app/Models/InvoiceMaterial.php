<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceMaterial extends Model
{
    protected $fillable=[
        'material_id',
        'invoice_id',
        'unit',
        'price',
        'quantity',
        'summa'
    ];
    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
