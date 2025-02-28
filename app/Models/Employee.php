<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'img',
        'start_time',
        'end_time',
        'daily_hours',
        'monthly_hours',
        'work_schedule',
        'salary_type',
        'salary',
        'rate',
        'task_rate',
        'advance',
        'fine',
        'bonus',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
}
