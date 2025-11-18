<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'name', 'id'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_leaves', 'employee_id', 'leave_id')->withPivot('value2', 'fiscal_year');
    }

    public function contractors()
    {
        return $this->belongsToMany(Contractor::class, 'contractors_leaves', 'contractor_id', 'leave_id')->withPivot('value');
    }

    public function consultants()
    {
        return $this->belongsToMany(Consultant::class, 'consultants_leaves', 'consultant_id', 'leave_id')->withPivot('value');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'leaves_suppliers', 'supplier_id', 'leave_id')->withPivot('value');
    }

    public function employeeLeaveRequest()
    {
        return $this->hasMany(EmployeeLeaveRequest::class);
    }
}
