<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;


use App\Entities\Category;
use App\Entities\Tender;
use App\Entities\Users\User;
use App\Entities\UserSubscription;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TenderRepository
{
    use RepositoryHelperTrait;
    use StatusTrait;
    use UserTrait;

    public function getTendersCount()
    {
        $tendersCount = Tender::count();

        $response = array("tender" => array());
        $response["tender"]["itemCount"] = $tendersCount;

        $profileTypes = $this->profileTypes();


        //Data for line Chart

        $response["tender"]["chart"] = array('categories' => array(), 'series' => array("name" => "Tenders", "data" => []));

        $response["tender"]["chart"]["categories"] = array_values($profileTypes);

        foreach ($profileTypes as $dbName => $displayName) {
            $response["tender"]["chart"]["series"]["data"][] = Tender::where(["item_type" => $dbName])->count();
        }

        return $response;
    }

    public function getAllTenders(Request $request, $n)
    {

        return Tender::searchByName($request)
            ->filterByCategory($request)
            ->filterByStatus($request)
            ->latest()
            ->paginate($n);
    }

    public function getUserTenders($user_id, $n)
    {
        $profileId = $this->getUserProfile($user_id)->id;

        return Tender::where('item_id', $profileId)->latest()->paginate($n);
    }

    public function sendYesterdayTendersToUsers()
    {
        $users = User::where('status', 'active')->where(function ($query) {
            $query->where('profile_type', 'Contractor')->orWhere('profile_type', 'ContractorAndConsultant')
                ->orWhere('profile_type', 'Consultant')->orWhere('profile_type', 'Supplier');
        })->get();



        $categories = $this->getYesterdayTendersCategories()->get();


        foreach($categories as $category) {
            $details = Category::find($category->category_id);
            $category->details = $details;
        }


        if($categories->count()) {
            foreach ($users as $user) {
            if($this->getUserCategories($user->id, 'Tender')->count()) {
                     $cat = $this->getUserCategories($user->id, 'Tender');
                     $details = Category::find($category->category_id);
                     $cat->details;
                     Mail::queue('emails.daily_tender_email', ['categories' => $cat], function($message) use($user)  {
                            $message->to($user->email)->subject(Carbon::yesterday()->toFormattedDateString() . " Tenders");
                     });

            } else {
                    Mail::queue('emails.daily_tender_email', ['categories' => $categories], function($message) use($user)  {
                        $message->to($user->email)->subject(Carbon::yesterday()->toFormattedDateString() . " Tenders");
                   });

            }
             }
        }

         
         return $categories;
    }

    public function getUserYesterdayTenders($userId)
    {
        $categories = $this->getUserYesterdayTendersCategories($userId);

        $categories->map(function ($category) {

            $tenders = Tender::where('category_id', $category->id)
                ->yesterday()
                ->get();

            return $category['tenders'] = $tenders;
        });

        return $categories;
    }

    public function getUsersSendEmail()
    {
        $users = UserSubscription::all();

        $u = null;

        foreach ($users as $user) {
            if(count($this->getUserCategories($user->id, 'Tender'))) {

            }
        }

        /*$categoryIds = $this->getYesterdayTendersCategoryIds();

        $users = User::where('status', 'active')
            ->whereHas('contractor.tenderCategories', (function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            }))
            ->orWhereHas('consultant.tenderCategories', (function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            }))
            ->orWhereHas('contractorAndConsultant.tenderCategories', (function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            }))
            ->orWhereHas('supplier.tenderCategories', (function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            }))
            ->get();
        */
        return $users;
    }

    public function getCompanyTenders($companyId, $n)
    {
        return Tender::where('item_id', $companyId)->latest()->paginate($n);
    }

    public function getTenderDetail($tenderId)
    {
        return Tender::find($tenderId);
    }

    public function getUserTendersByCategories(Request $request, $userId, $n)
    {
        $categoryIds = $this->getUserCategoryIds($userId, 'Tender');

        if ($categoryIds->count()) {
            return $tenders = Tender::whereIn('category_id', $categoryIds)
                ->searchByName($request)
                ->filterByCategory($request)
                ->filterByStatus($request)
                ->latest()
                ->paginate($n);
        } else {
            return $this->getAllTenders($request, $n);
        }
    }

    public function store($input)
    {
        $vacancy = null;
        if ($input->userId) {
            $vacancy = $this->storeUserTender($input, $input->userId);
        } else {
            $vacancy = $this->storeCompanyTender($input);
        }

        return $vacancy;
    }

    public function storeUserTender($input, $userId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $vacancy = $this->saveTender($input->tender, $profileId, $profileType);

        return $vacancy;
    }

    public function storeCompanyTender($input)
    {
        $company = $this->saveCompany($input->company);

        $this->saveAddress($input->address, $company->id, 'Company');

        $vacancy = $this->saveTender($input->tender, $company->id, 'Company');

        return $vacancy;
    }

    public function update($input)
    {
        $vacancy = $this->saveTender($input->tender);

        return $vacancy;
    }

    public function delete($tenderId)
    {
        $vacancy = Tender::find($tenderId);
        $vacancy->delete();

        return $vacancy;
    }

    private function saveTender($input, $item_id = null, $item_type = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $tender = Tender::find($id);
            $tender->title = $input['title'];
            $tender->document_price = isset($input['document_price']) ? $input['document_price'] : $tender->document_price;
            $tender->bid_bond = isset($input['bid_bond']) ? $input['bid_bond'] : $tender->bid_bond;
            $tender->opening_date = isset($input['opening_date']) ? $input['opening_date'] : $tender->opening_date;
            $tender->closing_date = isset($input['closing_date']) ? $input['closing_date'] : $tender->closing_date;
            $tender->description = isset($input['description']) ? $input['description'] : $tender->description;
            $tender->save();
        } else {
            $tender = new Tender();
            $tender->id = $id = Uuid::generate(4);
            $tender->item_id = $item_id;
            $tender->item_type = $item_type;
            $tender->title = $input['title'];
            $tender->category_id = $input['category_id'];
            $tender->document_price = isset($input['document_price']) ? $input['document_price'] : null;
            $tender->bid_bond = isset($input['bid_bond']) ? $input['bid_bond'] : null;
            $tender->opening_date = isset($input['opening_date']) ? $input['opening_date'] : null;
            $tender->closing_date = isset($input['closing_date']) ? $input['closing_date'] : null;
            $tender->description = isset($input['description']) ? $input['description'] : null;
            $tender->status = $this->tenderStatus;
            $tender->save();
        }

        return Tender::find($id);
    }

    protected function getYesterdayTendersCategoryIds()
    {
        $categoryIds = Category::yesterdayTender()
            ->get(['id']);

        return $categoryIds;
    }

    protected function getYesterdayTendersCategories() {
       return Tender::whereDate('created_at', '=', Carbon::yesterday()->toDateString());
    }

    protected function getUserYesterdayTendersCategories($userId)
    {
        $profile = $this->getUserProfile($userId);

        $categories = $profile->tenderCategories()
            ->yesterdayTender()
            ->get();

        return $categories;
    }

}
