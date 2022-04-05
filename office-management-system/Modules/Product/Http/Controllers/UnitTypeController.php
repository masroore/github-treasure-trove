<?php

namespace Modules\Product\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Product\Http\Requests\UnitTypeFormRequest;
use Modules\Product\Repositories\UnitTypeRepositoryInterface;

class UnitTypeController extends Controller
{
    protected $unitTypeRepository;

    public function __construct(UnitTypeRepositoryInterface $unitTypeRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->unitTypeRepository = $unitTypeRepository;
    }

    public function index()
    {
        $unit_types = $this->unitTypeRepository->all();

        return view('product::unit_type.unit_type', compact('unit_types'));
    }

    public function getALl()
    {
        return $this->unitTypeRepository->all();
    }

    public function create(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $unit_types = $this->unitTypeRepository->serachBased($search_keyword);
            } else {
                $unit_types = $this->unitTypeRepository->all();
            }

            return view('product::unit_type.unit_type_list', [
                'unit_types' => $unit_types,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function store(UnitTypeFormRequest $request)
    {
        try {
            $this->unitTypeRepository->create($request->except('_token'));

            return response()->json(['message' => 'Unit Type Added Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong'], 404);
        }
    }

    public function edit($id)
    {
        try {
            return $this->unitTypeRepository->find($id);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    public function update(UnitTypeFormRequest $request, $id)
    {
        try {
            $this->unitTypeRepository->update($request->except('_token'), $id);

            return response()->json(['message' => 'Unit Type Updated Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->unitTypeRepository->delete($id);
            Toastr::success('Unit Type Deleted Successfully');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Something Went Wrong');

            return back();
        }
    }

    public function csv_upload()
    {
        return view('product::unit_type.upload_via_csv.create');
    }

    public function csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();

        try {
            $this->unitTypeRepository->csv_upload_unit($request->except('_token'));
            DB::commit();
            Toastr::success('Successfully Uploaded !!!');

            return back();
        } catch (Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error('Duplicate entry is exist in your file !!!');
            } else {
                Toastr::error('Something went wrong. Upload again !!!');
            }

            return back();
        }
    }

    public function csv_download()
    {
        try {
            return $this->unitTypeRepository->csv_download();
        } catch (Exception $e) {
            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }
}
