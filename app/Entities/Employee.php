<?php

namespace App\Entities;

use App\Entities\Users\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id', 'full_name','employment_title', 'employer_id', 'employment_date','employment_type', 'user_id'
    ];

    public function leaveRequests(){
        return $this->hasMany(EmployeeLeaveRequest::class);
    }

    public function leaves()
    {
        return $this->belongsToMany(Leave::class, 'employees_leaves', 'employee_id', 'leave_id')->withPivot('value2', 'fiscal_year');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
