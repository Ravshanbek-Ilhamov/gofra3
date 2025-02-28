<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineProduct extends Model
{
    protected $fillable=[
        'manufacturing_id',
        'machine_id',
        'user_id',
        'total_count',
        'waste_count',
        'status'
    ];
    public function manufacturing()
    {
        return $this->belongsTo(Manufacturing::class,'manufacturing_id');
    }
    public function machine()
    {
        return $this->belongsTo(Machine::class,'machine_id');
    }
}
