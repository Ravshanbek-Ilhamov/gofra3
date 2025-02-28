<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'type',
        'status',
        'material_id',
        'quantity',
        'previous_value',
        'current_value',
        'from_id',
        'to_id'
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'material_id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'from_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'from_id');
    }
    public function towarehouse()
    {
        return $this->belongsTo(Warehouse::class,'to_id');
    }
    public function toProduct()
    {
        return $this->belongsTo(Product::class,'to_id');
    }
    public function manufacturing()
    {
        return $this->belongsTo(Manufacturing::class,'from_id');
    }
}
