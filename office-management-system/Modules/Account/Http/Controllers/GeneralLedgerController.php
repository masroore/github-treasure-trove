<?php

namespace Modules\Account\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\OpeningBalanceHistory;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Account\Repositories\LedgerReportRepositoryInterface;

class GeneralLedgerController extends Controller
{
    protected $charAccountRepository;

    protected $leadgerRepository;

    public function __construct(ChartAccountRepositoryInterface $charAccountRepository, LedgerReportRepositoryInterface $leadgerRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->leadgerRepository = $leadgerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : '' . date('m/d/Y') . ' - ' . date('m/d/Y') . '';

            if ($request->date_range) {
                $dateFrom = new DateTime(trim($rangeArr[0]), new DateTimeZone('Asia/Dhaka'));
                $dateTo = new DateTime(trim($rangeArr[1]), new DateTimeZone('Asia/Dhaka'));
            }

            $accounts = $this->charAccountRepository->all();

            $openingBalance = 0;
            $beforedateAccount = null;
            $accont_type = null;
            $dateFrom = ($request->date_range != null) ? Carbon::parse($dateFrom)->format('Y-m-d') : null;
            $dateTo = ($request->date_range != null) ? Carbon::parse($dateTo)->format('Y-m-d') : null;
            $account_id = ($request->account_id != null) ? $request->account_id : null;
            if ($request->account_id != null) {
                $beforedateAccount = ChartAccount::findOrFail($request['account_id']);
                $balance = $this->leadgerRepository->balanceBeforeDate($dateFrom, $beforedateAccount);
                $accont_type = $beforedateAccount->type;
                // $balance;

                $openingBalance = OpeningBalanceHistory::where('account_id', $account_id)->first()->amount ?? 0;
            } else {
                $balance = 0;
            }
            // return $dateTo;
            //
            if (!$account_id) {
                $transactions = null;
            } else {
                $transactions = $this->leadgerRepository->search($dateFrom, $dateTo, $account_id);
            }

            // return $transactions;
            return view('account::statement.index', compact('transactions', 'accont_type', 'accounts', 'dateFrom', 'dateTo', 'account_id', 'balance', 'beforedateAccount', 'openingBalance'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }

    public function filterAccountBytype($id)
    {
        $accounts = ChartAccount::where('type', $id)->get();

        return response()->json([
            'accounts' => $accounts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('account::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function show($id)
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function edit($id)
    {
        return view('account::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function destroy($id)
    {

    }
}
