<?php

namespace Modules\Product\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use LogActivity;
use Modules\Product\Http\Requests\BrandFormRequest;
use Modules\Product\Repositories\BrandRepositoryInterface;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->all();

        return view('product::brand.brand', compact('brands'));
    }

    public function getALl()
    {
        return $this->brandRepository->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $brands = $this->brandRepository->serachBased($search_keyword);
            } else {
                $brands = $this->brandRepository->all();
            }

            return view('product::brand.brand_list', [
                'brands' => $brands,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandFormRequest $request)
    {
        try {
            $this->brandRepository->create($request->except('_token'));

            return response()->json(['message' => 'Brand Added Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return string
     */
    public function edit($id)
    {
        try {
            return $this->brandRepository->find($id);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BrandFormRequest $request, $id)
    {
        try {
            $this->brandRepository->update($request->except('_token'), $id);

            return response()->json(['message' => 'Brand Updated Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->brandRepository->delete($id);
            Toastr::success('Brand Deleted Successfully');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Something Went Wrong');

            return back();
        }
    }

    public function csv_download()
    {
        try {
            return $this->brandRepository->csv_download();
        } catch (Exception $e) {
            return response()->json(['message' => 'Something Went Wrong'], 503);
        }
    }

    public function csv_upload()
    {
        return view('product::brand.upload_via_csv.create');
    }

    public function csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();

        try {
            $this->brandRepository->csv_upload_brand($request->except('_token'));
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

    public function csv_upload_brand($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->take(1)->first();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                Brand::create([
                    $column_name[0] => $row[0],
                    $column_name[1] => $row[1],
                    'status' => '1',
                ]);
            }
        }
    }
}
