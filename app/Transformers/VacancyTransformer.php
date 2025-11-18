<?php
namespace App\Transformers;

use App\Entities\Vacancy;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class VacancyTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    public function transform(Vacancy $vacancy)
    {
        return [
            'id' => $vacancy->id,
            'title' => $vacancy->title,
            'category' => $vacancy->category,
            'contract' => $vacancy->contract,
            'education_level' => $vacancy->education_level,
            'experience' => $vacancy->experience,
            'salary' => $vacancy->salary,
            'work_place' => $vacancy->work_place,
            'posted_date' => Carbon::parse($vacancy->created_at)->toFormattedDateString(),
            'closing_date' => Carbon::parse($vacancy->closing_date)->toFormattedDateString(),
            'status' => $vacancy->status,
            'company' => $vacancy->item_type === 'Company' ? $vacancy->company->name :
                $this->getProfile($vacancy->item_type, $vacancy->item_id)->user->name,
            'logo' => $vacancy->item_type === 'Company' ? $this->getItemLogo($vacancy->company, 'Company') :
                         $this->getItemLogo($this->getProfile($vacancy->item_type, $vacancy->item_id), 'User')

        ];
    }

    public function includeUser(Tender $tender)
    {
        if($tender->contractor) {
            return $this->item($tender->contractor->user, new UserDetailTransformer());
        }
    }

    public function includeCompany(Tender $tender)
    {
        if($tender->company) {
            return $this->item($tender->company, new CompanyTransformer());
        }
    }
}