<?php

namespace Modules\Setup\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Setup\Http\Requests\CountryFormRequest;
use Modules\Setup\Repositories\CountryRepositoryInterface;

class CountryController extends Controller
{
    protected $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->middleware(['auth']);
        $this->countryRepository = $countryRepository;
    }

    public function index(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $countries = $this->countryRepository->serachBased($search_keyword);
            } else {
                $countries = $this->countryRepository->all();
            }

            return view('setup::country.index', [
                'countries' => $countries,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Country creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function Store(CountryFormRequest $request)
    {
        try {
            $this->countryRepository->create($request->except('_token'));
            LogActivity::successLog('New Country - (' . $request->name . ') has been created.');
            Toastr::success(__('setup.Country has been added Successfully'));

            return redirect()->route('country.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Country creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $country = $this->countryRepository->find($request->id);

            return view('setup::country.edit', [
                'country' => $country,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    public function update(CountryFormRequest $request, $id)
    {
        try {
            $country = $this->countryRepository->update($request->except('_token'), $id);
            LogActivity::successLog($request->name . '- has been updated.');
            Toastr::success(__('setup.Country has been updated Successfully'));

            return redirect()->route('country.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Country update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $country = $this->countryRepository->delete($id);
            LogActivity::successLog('A Country has been destroyed.');
            Toastr::success(__('setup.Country has been deleted Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Country Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
