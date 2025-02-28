<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'company_name',
        'date',
        'text'
    ];
    // Invoice Model

    public function invoiceMaterials()
    {
        return $this->hasMany(InvoiceMaterial::class,'invoice_id');
    }
}
