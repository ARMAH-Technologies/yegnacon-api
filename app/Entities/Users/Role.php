<?php

namespace App\Entities\Users;

use App\Entities\Traits\UuidForKey;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 *
 * @package App\Entities\Users
 */
class Role extends EntrustRole
{
    use SoftDeletes;
    use UuidForKey;

    protected $fillable = ["name", "display_name"];
}
