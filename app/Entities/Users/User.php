<?php

namespace App\Entities\Users;

use App\Entities\Address;
use App\Entities\Category;
use App\Entities\Consultant;
use App\Entities\Contractor;
use App\Entities\ContractorAndConsultant;
use App\Entities\Employee;
use App\Entities\File;
use App\Entities\Notification;
use App\Entities\Professional;
use App\Entities\ProjectOwner;
use App\Entities\Supplier;
use App\Entities\Traits\UserTrait;
use App\Entities\Categories_users;
use App\Entities\UserSubscription;
use App\ProfileType;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes, EntrustUserTrait, UserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    protected $fillable = ["name", "email", "password", "profile_type", "status", 'id'];

    protected $guerd = [];

    protected $hidden = ['password'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public function contractor()
    {
        return $this->hasOne(Contractor::class);
    }

    public function consultant()
    {
        return $this->hasOne(Consultant::class);
    }

    public function contractorAndConsultant()
    {
        return $this->hasOne(ContractorAndConsultant::class);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function professional()
    {
        return $this->hasOne(Professional::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function projectOwner()
    {
        return $this->hasOne(ProjectOwner::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'item_id');
    }

    public function file()
    {
        return $this->hasOne(File::class, 'item_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user', 'user_id', 'notification_id')
            ->withPivot('status', 'from_id')->withTimestamps();
    }
    public function subscriptions(){
        return $this->hasMany(UserSubscription::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'categories_users','user_id','category_id')->withTimestamps();
    }

}
