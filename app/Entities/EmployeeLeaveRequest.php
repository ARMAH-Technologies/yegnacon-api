<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveRequest extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'id', 'approved_date','start_date','number_of_days', 'end_date', 'status', 'remark'
    ];

    public function employee(){
        $this->belongsTo(Employee::class, 'employee_id');
    }

    public function leave(){
        $this->belongsTo(Leave::class, 'leave_id');
    }
}
