<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\Vacancy;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class VacancyRepository
{
    use RepositoryHelperTrait;
    use UserTrait;
    use StatusTrait;

    public function getVacanciesCount(){
        $count = Vacancy::count();
        $response = array("vacancy"=>array());
        $response["vacancy"]["itemCount"] =  $count;

        $profileTypes = $this->profileTypes();


        //Data for line Chart

        $response["vacancy"]["chart"] = array('categories'=> array(),'series'=> array("name"=>"Vacancies","data"=>array()));

        $response["vacancy"]["chart"]["categories"] = array_values($profileTypes);

        foreach ($profileTypes as $dbName => $displayName){
            $response["vacancy"]["chart"]["series"]["data"][] = Vacancy::where(["item_type" => $dbName])->count();
        }

        return $response;

    }

    public function getAllVacancies(Request $request, $n)
    {
        return Vacancy::searchByName($request)
            ->filterVacancy($request)
            ->latest()->paginate($n);
    }

    public function getUserVacancies($user_id, $n)
    {
        $profileId = $this->getUserProfile($user_id)->id;

        return Vacancy::where('item_id', $profileId)->latest()->paginate($n);
    }

    public function getCompanyVacancies($companyId, $n)
    {
        return Vacancy::where('item_id', $companyId)->latest()->paginate($n);
    }

    public function getVacancyDetail($vacancyId)
    {
        return Vacancy::find($vacancyId);
    }

    public function store($input)
    {
        $vacancy = null;
        if($input->userId){
            $vacancy = $this->storeUserVacancy($input, $input->userId);
        }
        else{
            $vacancy = $this->storeCompanyVacancy($input);
        }

        return $vacancy;
    }
    

    public function storeUserVacancy($input, $userId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $vacancy = $this->saveVacancy($input->vacancy, $profileId, $profileType);

        return $vacancy;
    }

    public function storeCompanyVacancy($input)
    {
        $company = $this->saveCompany($input->company);

        $this->saveAddress($input->address, $company->id, 'Company');

        $vacancy = $this->saveVacancy($input->vacancy, $company->id, 'Company');

        return $vacancy;
    }

    public function update($input)
    {
        $vacancy = $this->saveVacancy($input->vacancy);

        return $vacancy;
    }

    public function delete($vacancyId)
    {
        $vacancy = Vacancy::find($vacancyId);
        $vacancy->delete();

        return $vacancy;
    }

    private function saveVacancy($input, $item_id = null, $item_type = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $vacancy = Vacancy::find($id);
            $vacancy->title = $input['title'];
            $vacancy->category = isset($input['category']) ? $input['category'] : $vacancy->category;
            $vacancy->contract = isset($input['contract']) ? $input['contract'] : $vacancy->contract;
            $vacancy->education_level = isset($input['education_level']) ? $input['education_level'] : $vacancy->education_level;
            $vacancy->experience = isset($input['experience']) ? $input['experience'] : $vacancy->experience;
            $vacancy->salary = isset($input['salary']) ? $input['salary'] : $vacancy->salary;
            $vacancy->experience = isset($input['experience']) ? $input['experience'] : $vacancy->experience;
            $vacancy->work_place = isset($input['work_place']) ? $input['work_place'] : $vacancy->work_place;
            $vacancy->description = isset($input['description']) ? $input['description'] : $vacancy->description;
            $vacancy->closing_date = isset($input['closing_date']) ? $input['closing_date'] : $vacancy->closing_date;
            $vacancy->status = isset($input['status'])? $input['status']: $vacancy->status;
            $vacancy->save();
        } else {
            $vacancy = new Vacancy();
            $vacancy->id = $id = Uuid::generate(4);
            $vacancy->item_id = $item_id;
            $vacancy->item_type = $item_type;
            $vacancy->title = $input['title'];
            $vacancy->category = isset($input['category']) ? $input['category'] : null;
            $vacancy->contract = isset($input['contract']) ? $input['contract'] : null;
            $vacancy->education_level = isset($input['education_level']) ? $input['education_level'] : null;
            $vacancy->experience = isset($input['experience']) ? $input['experience'] : null;
            $vacancy->salary = isset($input['salary']) ? $input['salary'] : null;
            $vacancy->experience = isset($input['experience']) ? $input['experience'] : null;
            $vacancy->work_place = isset($input['work_place']) ? $input['work_place'] : null;
            $vacancy->description = isset($input['description']) ? $input['description'] : null;
            $vacancy->closing_date = isset($input['closing_date']) ? $input['closing_date'] : null;
            $vacancy->status =  $this->vacancyStatus;
            $vacancy->save();
        }

        return Vacancy::find($id);
    }

}