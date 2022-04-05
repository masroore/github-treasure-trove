<?php

namespace Modules\Setup\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Setup\Http\Requests\IntroPrefixFormRequest;
use Modules\Setup\Repositories\IntroPrefixRepositoryInterface;

class IntroPrefixController extends Controller
{
    protected $introPrefixRepository;

    public function __construct(IntroPrefixRepositoryInterface $introPrefixRepository)
    {
        $this->middleware(['auth']);
        $this->introPrefixRepository = $introPrefixRepository;
    }

    public function index(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $introPrefixes = $this->introPrefixRepository->serachBased($search_keyword);
            } else {
                $introPrefixes = $this->introPrefixRepository->all();
            }

            return view('setup::introPrefixes.index', [
                'introPrefixes' => $introPrefixes,
                'search_keyword' => $search_keyword,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for District creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function Store(IntroPrefixFormRequest $request)
    {
        try {
            $this->introPrefixRepository->create($request->except('_token'));
            LogActivity::successLog('New Intro Prefix - (' . $request->title . ') has been created.');
            Toastr::success(__('setup.Intro Prefix has been added Successfully'));

            return redirect()->route('introPrefixes.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Intro Prefix creation');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $introPrefix = $this->introPrefixRepository->find($request->id);

            return view('setup::introPrefixes.edit', [
                'introPrefix' => $introPrefix,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    public function update(IntroPrefixFormRequest $request, $id)
    {
        try {
            $introPrefix = $this->introPrefixRepository->update($request->except('_token'), $id);

            LogActivity::successLog($request->name . '- has been updated.');
            Toastr::success(__('setup.Intro Prefix has been updated Successfully'));

            return redirect()->back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Division update');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $introPrefix = $this->introPrefixRepository->delete($id);
            LogActivity::successLog('A Intro Prefix has been destroyed.');
            Toastr::success(__('setup.A Intro Prefix has been destroyed Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage() . ' - Error has been detected for Intro Prefix Destroy');
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }
}
