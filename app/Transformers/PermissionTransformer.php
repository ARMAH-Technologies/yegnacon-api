<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 9/10/2016
 * Time: 11:11 AM
 */

namespace App\Transformers;

use App\Entities\Users\Permission;
use League\Fractal\TransformerAbstract;
class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'display_name' => $permission->display_name,
            'description' => $permission->description
        ];
    }
}