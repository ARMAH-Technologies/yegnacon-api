<?php

namespace App\Entities\Users;

use App\Entities\Traits\UuidForKey;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission
 *
 * @package App\Entities\Users
 */
class Permission extends EntrustPermission
{
    use SoftDeletes;
    use UuidForKey;

    protected $fillable = ["name", "display_name", "description"];
}
