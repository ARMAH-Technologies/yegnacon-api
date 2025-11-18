<?php

namespace App\Http\Controllers;

use App\Entities\ProformaRequest;
use App\Entities\Users\User;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationTrait;
use App\Repositories\RepositoryHelperTrait;
use App\Repositories\TenderRepository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    use Helpers;
    use NotificationTrait;
    use RepositoryHelperTrait;
    protected $notificationRepository;
    protected $tenderRepository;

    public function __construct(NotificationRepository $notificationRepository,
                                TenderRepository $tenderRepository)
    {
        $this->notificationRepository = $notificationRepository;
        $this->tenderRepository = $tenderRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $this->testProductProformaReceiverMethod();
        //return $this->testMultipleNotificationReadMethod();
        //return $this->testSendEmailToUsersTenderMethod();
        $this->sendEmail('nejib@yokidaconsult.com', [],'emails.test', 'test');
    }

    public function testProductProformaReceiverMethod()
    {
        $proformaRequest = ProformaRequest::find("4420bc74-61da-4a77-a18f-f26a28957c2a");

        //return $this->getProformaRequestCategoryIds($proformaRequest->id);

        $proformaRequestItems = $proformaRequest->proformaRequestItems;

        //return $this->getSupplierReceivers($proformaRequest->id);

        return $this->getProformaRequestItemSuppliers($proformaRequestItems->first());
    }

    public function testMultipleNotificationReadMethod()
    {
        $userId = "0157d1ab-4f50-4fe9-98bd-be3ba129e88e";
        $notificationId = "e0029f7d-6f0d-4486-94df-77638815d4cc";

        return $this->notificationRepository->readNotification($userId, $notificationId);
    }

    public function testSendEmailToUsersTenderMethod()
    {
        $userId = "0157d1ab-4f50-4fe9-98bd-be3ba129e88e";

        //return $this->tenderRepository->getUserYesterdayTenders($userId);

        //return $this->tenderRepository->getUserCategories($userId, 'Tender');

        //return $this->tenderRepository->getUsersSendEmail();

        /*return  $users = User::where('status', 'active')
            ->whereIn('profile_type',['Contractor', 'Consultant', 'ContractorAndConsultant', 'Supplier'] )
            ->get();*/

        // return $users = User::where('email', 'mohe1muzemil@gmail.com')->get();;

        // $this->tenderRepository->sendYesterdayTendersToUsers();
    }

}
