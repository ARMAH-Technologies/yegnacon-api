<?php

namespace App\Http\Controllers;

use App\Repositories\RateRepository;
use Illuminate\Http\Request;

class RateController extends Controller
{
    protected $rateRepository;
    public function __construct(RateRepository $rateRepository )
    {
        $this->rateRepository=$rateRepository;
    }

    public function updateRatingContractor(Request $request)
    {
        $this->rateRepository->updateRatingContractor($request);
        return redirect()->back();

    }
    public function updateRatingSupplier(Request $request)
    {
        $this->rateRepository->updateRatingSupplier($request);
        return redirect()->back();

    }
}
