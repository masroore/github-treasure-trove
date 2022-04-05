<?php

namespace Modules\Setup\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Setup\Http\Requests\TaxFormRequest;
use Modules\Setup\Repositories\TaxRepositoryInterface;

class TaxController extends Controller
{
    protected $taxRepository;

    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->middleware(['auth']);
        $this->taxRepository = $taxRepository;
    }

    public function index(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $taxes = $this->taxRepository->serachBased($search_keyword);
            } else {
                $taxes = $this->taxRepository->all();
            }

            return view('setup::taxes.index', [
                'taxes' => $taxes,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for District creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function Store(TaxFormRequest $request)
    {
        try {
            $this->taxRepository->create($request->except('_token'));
            LogActivity::successLog('New Tax - (' . $request->name . ') has been created.');

            return response()->json(['message' => 'Tax has been Updated Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Tax creation');

            return response()->json(['message' => 'Something Went Wrong', 'error' => $e->getMessage()], 503);
        }
    }

    public function edit($id)
    {
        try {
            return $this->taxRepository->find($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(TaxFormRequest $request, $id)
    {
        try {
            $this->taxRepository->update($request->except('_token'), $id);

            return response()->json(['message' => 'Tax has been Updated Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong', 'error' => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $tax = $this->taxRepository->delete($id);
            LogActivity::successLog('A Tax has been destroyed.');
            Toastr::success(__('setup.Tax has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Tax Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function update_active_status(Request $request)
    {
        try {
            $tax = $this->taxRepository->update_status($request->except('_token'));

            return 1;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return 0;
        }
    }
}
