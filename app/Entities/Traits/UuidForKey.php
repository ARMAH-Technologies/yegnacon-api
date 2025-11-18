<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 5/18/2016
 * Time: 3:31 PM
 */

namespace App\Entities\Traits;

use Webpatser\Uuid\Uuid;

trait UuidForKey
{
    /**
     * Boot the Uuid trait for the model.
     *
     * @return void
     */
    public static function bootUuidForKey()
    {
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->{$model->getKeyName()} = Uuid::generate(4);
        });
    }

    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        return $this->casts;
    }
}