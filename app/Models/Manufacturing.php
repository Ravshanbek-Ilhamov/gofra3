<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    protected $fillable=[
        'product_id',
        'total_count',
        'quality_count',
        'waste_count',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function machineproducts()
    {
        return $this->hasMany(MachineProduct::class,'manufacturing_id');
    }
}
