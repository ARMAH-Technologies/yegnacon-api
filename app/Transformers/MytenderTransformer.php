<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 9/29/2016
 * Time: 2:09 PM
 */

namespace App\Transformers;
use App\Entities\Categories_users;
use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class MytenderTransformer extends TransformerAbstract
{
    public function transform(Categories_users $mytender)
    {
        return [
            'id' => $mytender->id,
            'category_id' => $mytender->category_id,
            'user_id' => $mytender->user_id

        ];
    }

}