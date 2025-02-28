<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable=[
        'name',
        'status'
    ];
    public function machineproducts()
    {
        return $this->hasMany(MachineProduct::class);
    }
}
