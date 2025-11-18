<?php

namespace App\Transformers;

use App\Entities\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'id' => $address->id,
            'phone_number_1' => $address->phone_number_1,
            'phone_number_2' => $address->phone_number_2,
            'country' => $address->country,
            'city' => $address->city,
            'sub_city' => $address->sub_city,
            'house_no' => $address->house_no,
            'specific_address' => $address->specific_address,
            'latitude' => $address->latitude,
            'longitude' => $address->longitude,
            'website' => $address->website,
            'facebook_link' => $address->facebook_link,
            'twitter_link' => $address->twitter_link,
            'linkidin_link' => $address->linkidin_link,
            'google_link' => $address->google_link,
            'instagram_link' => $address->instagram_link
        ];
    }
}