<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:21 PM
 */

namespace App\Repositories;


use App\Contractor;
use App\Rate;
use App\Supplier;
use Auth;

class RateRepository
{

    public function updateRatingContractor($input)
    {
            $rate = Contractor::find($input->id)->rates()->create([
                'rate' => $input['star'],
                'type' => 'contractor',
                'user_id' => Auth::user()->id,
            ]);

        return $rate->id;
    }
    public function updateRatingSupplier($input)
    {
        $rate = Supplier::find($input->id)->rates()->create([
            'rate' => $input['star'],
            'type' => 'supplier',
            'user_id' => Auth::user()->id,
        ]);

        return $rate->id;
    }

}