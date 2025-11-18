<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Entities\Vacancy;
use League\Fractal\TransformerAbstract;

class VacancyDetailTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;
    protected $defaultIncludes = ['user', 'company'];

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
            'description' => $vacancy->description,
            'posted_date' => Carbon::parse($vacancy->created_at)->toFormattedDateString(),
            'closing_date' => $vacancy->closing_date,
            'status' => $vacancy->status,
            'company' => $vacancy->item_type === 'Company' ? $vacancy->company->name :
                $this->getProfile($vacancy->item_type, $vacancy->item_id)->user->name,
        ];
    }

    public function includeUser(Vacancy $vacancy)
    {
        if ($vacancy->contractor) {
            return $this->item($vacancy->contractor->user, new UserDetailTransformer());
        } else if ($vacancy->consultant) {
            return $this->item($vacancy->consultant->user, new UserDetailTransformer());
        } else if ($vacancy->supplier) {
            return $this->item($vacancy->supplier->user, new UserDetailTransformer());
        }
    }

    public function includeCompany(Vacancy $vacancy)
    {
        if ($vacancy->company) {
            return $this->item($vacancy->company, new CompanyTransformer());
        }
    }
}