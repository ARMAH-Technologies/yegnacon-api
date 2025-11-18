<?php

namespace App\Transformers;

use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class UserDropDownTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' =>$user->id,
            'name' => $user->name,

        ];
    }
}