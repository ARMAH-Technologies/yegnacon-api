<?php
namespace App\Transformers;

use App\Entities\Tender;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class TenderTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(Tender $tender)
    {
        return [
            'id' => $tender->id,
            'title' => $tender->title,
            'category' => $tender->category ? $tender->category->category : null,
            'document_price' => $tender->document_price,
            'bid_bond' => $tender->bid_bond,
            'opening_date' => $tender->opening_date,
            'closing_date' => $tender->closing_date,
            'description' => $tender->description,
            'created_at' => Carbon::parse( $tender->created_at)->toDateString(),
            'status' => $tender->status,
            'company' => $tender->item_type === 'Company' ? $tender->company->name :
                $this->getProfile($tender->item_type, $tender->item_id)->user->name,
            'logo' => $tender->item_type === 'Company' ? $this->getItemLogo($tender->company, 'Company') :
                $this->getItemLogo($this->getProfile($tender->item_type, $tender->item_id), 'User')
        ];
    }
}