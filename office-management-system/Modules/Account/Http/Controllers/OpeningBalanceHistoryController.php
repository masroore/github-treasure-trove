<?php

namespace Modules\Account\Http\Controllers;

use App\Traits\Accounts;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\OpeningBalanceHistory;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Http\Requests\OpeningBalanceFormRequest;
use Modules\Account\Repositories\ChartAccountRepositoryInterface;
use Modules\Account\Repositories\OpeningBalanceHistoryRepositoryInterface;
use Modules\Inventory\Repositories\ShowRoomRepositoryInterface;
use Modules\Report\Repositories\IncomeStatementReportRepository;

class OpeningBalanceHistoryController extends Controller
{
    use Accounts;

    protected $openingBalanceHistoryRepository;

    protected $charAccountRepository;

    public function __construct(OpeningBalanceHistoryRepositoryInterface $openingBalanceHistoryRepository, ChartAccountRepositoryInterface $charAccountRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->charAccountRepository = $charAccountRepository;
        $this->openingBalanceHistoryRepository = $openingBalanceHistoryRepository;
    }

    public function index()
    {
        $timeIntervals = $this->openingBalanceHistoryRepository->all();

        return view('account::opening_balances.index', [
            'timeIntervals' => $timeIntervals,
        ]);
    }

    public function create()
    {
        $assetAccounts = $this->charAccountRepository->all();

        return view('account::opening_balances.create', [
            'assetAccounts' => $assetAccounts,
        ]);
    }

    public function store(OpeningBalanceFormRequest $request)
    {
        DB::beginTransaction();

        try {
            $opening_balances = OpeningBalanceHistory::where('account_id', $request->account_id)->first();

            if ($opening_balances) {
                DB::rollBack();
                Toastr::error('Openning balance already add for this account');

                return redirect()->back();
            }

            $this->openingBalanceHistoryRepository->create($request->except('_token'));
            DB::commit();
            LogActivity::successLog('Openning Balance Added.');
            Toastr::success(__('account.Openning Balance Added Successfully'));

            return redirect()->back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit($id)
    {
        $timeInterval = $this->openingBalanceHistoryRepository->find($id);
        $assetAccounts = $this->openingBalanceHistoryRepository->assetAccountsAll();
        $liabilityAccounts = $this->openingBalanceHistoryRepository->liabilityAccountsAll();

        return view('account::opening_balances.edit', [
            'assetAccounts' => $assetAccounts,
            'liabilityAccounts' => $liabilityAccounts,
            'timeInterval' => $timeInterval,
        ]);
    }

    public function update(OpeningBalanceFormRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->openingBalanceHistoryRepository->update($request->except('_token'), $id);
            DB::commit();
            LogActivity::successLog('Openning Balance Updated.');
            Toastr::success(__('account.Openning Balance Updated Successfully'));

            return redirect()->route('openning_balance.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function closeStatement(IncomeStatementReportRepository $incomeStatementRepositories, Request $request)
    {
        $timeInterval = $this->openingBalanceHistoryRepository->find($request->timeInterval_id);
        $saleTransactionBalance = $incomeStatementRepositories->saleTransactionBalance($request->timeInterval_id);
        $start_date = $timeInterval->start_date;
        $closing_date = (new Carbon($request->date));
        $closing_date_value = $closing_date->format('Y-m-d');
        $charAccounts = $this->charAccountRepository->all($start_date, $closing_date_value);

        $cost_of_goods_sold = $charAccounts->where('code', '03-19')->first()->BalanceAmount;

        $income_account_list = $charAccounts->where('type', 4)->whereNotIn('code', ['04-24', '04-15']);
        $expense_account_list = $charAccounts->where('type', 3)->whereNotIn('code', ['03-23', '03-19']);
        $total_sale = $saleTransactionBalance;

        $total_expense_amount = 0;
        foreach ($expense_account_list as $key => $expense_account) {
            $total_expense_amount += $expense_account->BalanceAmount;
        }

        $total_income_amount = 0;
        foreach ($income_account_list as $key => $income_account) {
            $total_income_amount += $income_account->BalanceAmount;
        }

        $total_profit = $saleTransactionBalance - $cost_of_goods_sold;
        $net_profit = $total_profit - $total_expense_amount + $total_income_amount;

        $OpeningBalanceAccountList = [];
        $OpeningBalanceCreditAccountList = [];
        $AccountList = $this->charAccountRepository->all($start_date, $closing_date_value);

        $timeInterval->update(['end_date' => $closing_date->format('Y-m-d')]);
        $timePeriod = TimePeriodAccount::create(['start_date' => $closing_date->addDays(1)]);

        foreach ($AccountList->whereIn('type', ['1', '2']) as $accountDetail) {
            if ($accountDetail->BalanceAmount > 0) {
                if ($accountDetail->type == '1') {
                    $data['asset_account_id'] = $accountDetail->id;
                    $data['asset_amount'] = $accountDetail->balanceAmount;
                    $data['date'] = $timeInterval->end_date;
                    $data['is_default'] = true;
                    $data['acc_type'] = 'asset';
                    $OpeningBalanceAccountList[] = $data;
                } else {
                    $dataF['liability_account_id'] = $accountDetail->id;
                    $dataF['liability_amount'] = $accountDetail->balanceAmount;
                    $dataF['date'] = $timeInterval->end_date;
                    $dataF['is_default'] = true;
                    $dataF['acc_type'] = 'liability';
                    $OpeningBalanceCreditAccountList[] = $dataF;
                }
            }
        }
        $dataF['liability_account_id'] = $this->defaultRetailEarningProfitAccount();
        $dataF['liability_amount'] = $net_profit;
        $dataF['date'] = $timeInterval->end_date;
        $dataF['is_default'] = true;
        $dataF['acc_type'] = 'liability';

        $OpeningBalanceCreditAccountList[] = $dataF;

        $this->openingBalanceHistoryRepository->individualUpdate($OpeningBalanceAccountList, $timePeriod->id);
        $this->openingBalanceHistoryRepository->individualUpdate($OpeningBalanceCreditAccountList, $timePeriod->id);

        try {
            $this->openingBalanceHistoryRepository->closeStatement($request->timeInterval_id);
            LogActivity::successLog($timeInterval->start_date . ' Accounting Period Closed.');
            Toastr::success(__('account.Accounting Period has been closed Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function showroom_openning_balance_store(Request $request, ShowRoomRepositoryInterface $showRoomRepository)
    {
        DB::beginTransaction();
        $showroom = $showRoomRepository->find($request->showroom_id);
        $chart_account_id = ChartAccount::where('contactable_id', $request->showroom_id)->where('contactable_type', 'Modules\Inventory\Entities\ShowRoom')->first()->id;

        try {
            $this->openingBalanceHistoryRepository->createForUser([
                'asset_account_id' => $chart_account_id,
                'asset_amount' => $request->opening_balance,
                'date' => Carbon::now()->format('Y-m-d'),
                'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                'liability_account_id' => ChartAccount::where('code', '02-09-11')->first()->id,
                'liability_amount' => $request->opening_balance,
            ]);
            $this->openingBalanceHistoryRepository->createForHistory([
                'account_id' => $chart_account_id,
                'type' => $request->type,
                'amount' => $request->opening_balance,
            ]);
            DB::commit();
            LogActivity::successLog('Openning Balance Added for showroom - ' . $showroom->name);

            return response()->json(['message' => 'Openning Balance Added Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();

            return response()->json(['message' => 'Something Went Wrong', 'error' => $e->getMessage()], 503);
        }
    }
}
