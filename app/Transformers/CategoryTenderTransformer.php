<?php
/**
 * Created by PhpStorm.
 * User: yaye
 * Date: 10/4/2016
 * Time: 9:58 AM
 */

namespace App\Transformers;
use App\Entities\Tender;
use League\Fractal\TransformerAbstract;

class CategoryTenderTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user', 'company'];

    public function transform(Tender $tender)
    {
        return [
            'id' => $tender->id,
            'title' => $tender->title,
            'document_price' => $tender->document_price,
            'bid_bond' => $tender->bid_bond,
            'opening_date' => $tender->opening_date,
            'closing_date' => $tender->closing_date,
            'description' => $tender->description,
            'status' => $tender->status
        ];
    }

    public function includeUser(Tender $tender)
    {
        if($tender->contractor) {
            return $this->item($tender->contractor->user, new UserDetailTransformer());
        } else if ($tender->consultant){
            return $this->item($tender->consultant->user, new UserDetailTransformer());
        } else if ($tender->supplier) {
            return $this->item($tender->supplier->user, new UserDetailTransformer());
        }
    }

    public function includeCompany(Tender $tender)
    {
        if($tender->company) {
            return $this->item($tender->company, new CompanyTransformer());
        }
    }


}