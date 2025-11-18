<?php

namespace App\Transformers;

use App\Entities\Company;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['address', 'file'];

    public function transform(Company $company)
    {
        return [
            'id' => $company->id,
            'name' => $company->name,
            'email' => $company->email
        ];
    }

    public function includeAddress(Company $company)
    {
        return $this->item($company->address, new AddressTransformer());
    }

    public function includeFile(Company $company)
    {
        if ($company->file) {
            return $this->item($company->file, new FileTransformer());
        }
    }
}