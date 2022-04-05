<?php

namespace Modules\Account\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Repositories\CashbookRepositoryInterface;

class CashbookController extends Controller
{
    protected $cashbookRepository;

    public function __construct(CashbookRepositoryInterface $cashbookRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->cashbookRepository = $cashbookRepository;
    }

    public function index(Request $request)
    {
        if ($request->date != null) {
            $data['date'] = ($request->date != null) ? Carbon::parse($request->date)->format('Y-m-d') : null;
            $data['credit_transactions'] = $this->cashbookRepository->search_credit($data['date']);
            $data['debit_transactions'] = $this->cashbookRepository->search_debit($data['date']);
            $data['total_transactions'] = $this->cashbookRepository->search(date('Y-m-d', strtotime('-1 day', strtotime($request->date))));

            return view('account::cashbook.index', $data);
        }
        $data['credit_transactions'] = $this->cashbookRepository->search_credit(Carbon::now()->format('Y-m-d'));
        $data['debit_transactions'] = $this->cashbookRepository->search_debit(Carbon::now()->format('Y-m-d'));
        $data['total_transactions'] = $this->cashbookRepository->search(Carbon::now()->subDays(1)->format('Y-m-d'));

        return view('account::cashbook.index', $data);
    }
}
