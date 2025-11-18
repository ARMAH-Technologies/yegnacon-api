<?php

use App\Entities\ProformaRequest;
use App\Entities\ProformaResponse;
use App\Entities\Users\User;
use App\Repositories\RepositoryHelperTrait;
use App\Repositories\UserTrait;
use Illuminate\Database\Seeder;

class AutoIncrementUserProformaIdTableSeeder extends Seeder
{
    use RepositoryHelperTrait;
    use UserTrait;

    public function run()
    {
        $groupedProformaRequests = ProformaRequest::get()
            ->groupBy('requester_id');

        foreach ($groupedProformaRequests as $groupedProformaRequest) {
            $count = 0;
            foreach ($groupedProformaRequest->sortBy('created_at') as $proformaRequest) {
                $proformaRequest->proforma_request_id = $count + 1;
                $proformaRequest->save();
            }
        }

        $groupedProformaResponses = ProformaResponse::get()
            ->groupBy('requester_id');

        foreach ($groupedProformaResponses as $groupedProformaResponse) {
            $count = 0;
            foreach ($groupedProformaResponse->sortBy('created_at') as $proformaResponse) {
                $proformaResponse->proforma_invoice_id = $count + 1;
                $proformaResponse->save();
            }
        }
    }
}
