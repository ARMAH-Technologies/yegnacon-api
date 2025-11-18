<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 9/10/2016
 * Time: 11:03 AM
 */

namespace App\Transformers;

use App\Entities\Users\Role;
use League\Fractal\TransformerAbstract;
class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name
        ];
    }
}