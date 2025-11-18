<?php

namespace App\Transformers;

use App\Entities\Tender;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class TenderDetailTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user', 'company'];

    public function transform(Tender $tender)
    {
        return [
            'id' => $tender->id,
            'title' => $tender->title,
            'category' => $tender->category->category,
            'document_price' => $tender->document_price,
            'bid_bond' => $tender->bid_bond,
            'opening_date' => $tender->opening_date,
            'closing_date' => $tender->closing_date,
            'description' => $tender->description,
            'status' => $tender->status,
            'created_at' => Carbon::parse( $tender->created_at)->toDateString(),
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