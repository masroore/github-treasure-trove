<?php

namespace Modules\Setup\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Setup\Http\Requests\ApplyLoanFormRequest;
use Modules\Setup\Repositories\ApplyLoanRepositoryInterface;

class ApplyLoanController extends Controller
{
    protected $applyLoanRepository;

    public function __construct(ApplyLoanRepositoryInterface $applyLoanRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->applyLoanRepository = $applyLoanRepository;
    }

    public function index(UserRepositoryInterface $userRepository)
    {
        try {
            $loans = $this->applyLoanRepository->all();
            $users = $userRepository->normalUser();

            return view('setup::staff_loans.index', [
                'loans' => $loans,
                'users' => $users,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function create()
    {
        return view('setup::staff_loans.create');
    }

    public function store(ApplyLoanFormRequest $request)
    {
        try {
            $this->applyLoanRepository->create($request->except('_token'));
            LogActivity::successLog('New Division - (' . $request->name . ') has been created.');
            Toastr::success(__('common.Loan has been applied Successfully'));

            return redirect()->route('apply_loans.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Loan Apply');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $loan = $this->applyLoanRepository->find($request->id);

            return view('setup::staff_loans.edit', [
                'loan' => $loan,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Loan Apply');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function show(Request $request)
    {
        try {
            $loan = $this->applyLoanRepository->find($request->id);

            return view('setup::staff_loans.view', [
                'loan' => $loan,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Loan Apply');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function update(ApplyLoanFormRequest $request, $id)
    {
        try {
            $this->applyLoanRepository->update($request->except('_token'), $id);
            LogActivity::successLog('Division - (' . $request->name . ') has been updated.');
            Toastr::success(__('common.Loan has been updated Successfully'));

            return redirect()->route('apply_loans.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Loan Apply update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->applyLoanRepository->delete($id);
            LogActivity::successLog('Applyied Loan has been destroyed.');
            Toastr::success(__('common.Applyied Loan has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Division Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function loan_approval_index()
    {
        try {
            $loans = $this->applyLoanRepository->appliedAll();

            return view('setup::approval_loans.index', [
                'loans' => $loans,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Loan Apply');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function applied_show(Request $request)
    {
        try {
            $loan = $this->applyLoanRepository->find($request->id);

            return view('setup::approval_loans.view', [
                'loan' => $loan,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Loan Apply');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function change_approval(Request $request)
    {
        try {
            $this->applyLoanRepository->change_approval($request->except('_token'));

            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function history(UserRepositoryInterface $userRepository)
    {
        $users = $this->applyLoanRepository->loanUser();

        return view('setup::approval_loans.history', compact('users'));
    }

    public function loanDetails(Request $request, UserRepositoryInterface $userRepository)
    {
        $user = $userRepository->findUser($request->id);

        return view('setup::approval_loans.get_details', compact('user'));
    }
}
