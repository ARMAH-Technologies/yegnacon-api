<?php

namespace App\Console\Commands;

use App\Repositories\TenderRepository;
use Illuminate\Console\Command;

class YesterdayTenderEmailCommand extends Command
{
    protected $tenderRepository;

    protected $signature = 'tender_email';

    protected $description = 'send yesterday tenders to users';

    public function __construct(TenderRepository $tenderRepository)
    {
        parent::__construct();

        $this->tenderRepository = $tenderRepository;
    }

    public function handle()
    {
        $this->tenderRepository->sendYesterdayTendersToUsers();
    }
}