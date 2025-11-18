<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 9/29/2016
 * Time: 3:16 PM
 */

namespace App\Transformers;
use App\Entities\Categories_users;
use App\Entities\Category;

use App\Entities\Users\User;
use App\Transformers\CategoryTransformer;
use League\Fractal\TransformerAbstract;

class MytenderdetailTransformer extends TransformerAbstract
{


   protected $defaultIncludes = ['categories'];

    protected $profileInclude;

    public function __construct($profileInclude = true)
    {
        $this->profileInclude = $profileInclude;
    }

    public function transform(User $user)
    {

        return [
            'id' => $user->id

        ];
    }
    public function includeCategories(User $user)
    {
            return $this->collection($user->categories, new CategoryTransformer());

    }
}