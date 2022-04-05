<?php

namespace Modules\Purchase\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Purchase\Repositories\CNFRepositoryInterface;

class CNFController extends Controller
{
    protected $cnfRepository;

    public function __construct(CNFRepositoryInterface $cnfRepository)
    {
        $this->middleware(['auth']);
        $this->cnfRepository = $cnfRepository;
    }

    public function index()
    {
        $warehouses = $this->cnfRepository->all();

        return view('purchase::cnf.index', [
            'warehouses' => $warehouses,
        ]);
    }

    public function create()
    {
        return view('purchase::create');
    }

    public function store(Request $request)
    {
        try {
            $this->cnfRepository->create($request->except('_token'));
            LogActivity::successLog('New CNF - (' . $request->name . ') has been created.');
            Toastr::success(__('purchase.CNF has been added Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Role creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function show($id)
    {
        return view('purchase::show');
    }

    public function edit(Request $request)
    {
        try {
            $cnf = $this->cnfRepository->find($request->id);

            return view('purchase::cnf.edit', [
                'cnf' => $cnf,
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->cnfRepository->update($request->except('_token'), $id);
            LogActivity::successLog($request->name . '- has been updated.');
            Toastr::success(__('purchase.CNF has been updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for CNF update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->cnfRepository->delete($id);
            Toastr::success(__('purchase.CNF has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
