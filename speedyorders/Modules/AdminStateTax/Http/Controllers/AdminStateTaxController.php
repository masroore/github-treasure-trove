<?php

namespace Modules\AdminStateTax\Http\Controllers;

use App\Models\StateTaxManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminStateTax\Http\Requests\CreateStateTaxManagerRequest;
use Modules\AdminStateTax\Http\Requests\UpdateStateTaxManagerRequest;
use Modules\AdminStateTax\Services\CreateStateTaxService;
use Modules\AdminStateTax\Services\UpdateStateTaxService;

class AdminStateTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'tax',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $categories = StateTaxManager::where('state_code', 'LIKE', "%$keyword%")
                ->orWhere('tax_percentage', 'LIKE', "%$keyword%")
                ->orderByDesc('id')
                ->latest()->paginate($perPage);
        } else {
            $tax = StateTaxManager::latest()->paginate($perPage);
        }

        return view('adminstatetax::index', compact('tax'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'menu' => 'tax',
        ];
        $tax = StateTaxManager::latest()->get();

        return view('adminstatetax::create', compact('tax'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateStateTaxManagerRequest $request, CreateStateTaxService $service)
    {
        $validatedDatas = $request->validated();

        if ($service->handle($validatedDatas)) {
            session()->flash('success_message', 'State Tax stored successfully.');
        } else {
            session()->flash('error_message', 'State Tax could not be stored.');
        }

        return redirect()->route('admin.reports.tax.index');
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'menu' => 'tax',
        ];

        $tax = StateTaxManager::findOrFail($id);

        return view('adminstatetax::show', compact('tax'), $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'tax',
        ];

        $tax = StateTaxManager::findOrFail($id);

        return view('adminstatetax::edit', ['tax'=>$tax], $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateStateTaxManagerRequest $request, $id, UpdateStateTaxService $service)
    {
        $tax = StateTaxManager::findOrFail($id);

        $validatedDatas = $request->validated();

        if ($service->handle($validatedDatas, $id)) {
            session()->flash('success_message', 'State Tax updated successfully.');
        } else {
            session()->flash('error_message', 'State Tax could not be updated.');
        }

        return redirect()->route('admin.reports.tax.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            StateTaxManager::destroy($id);
            session()->flash('success_message', 'State Tax deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'State Tax could not be deleted.');
        }

        return redirect()->route('admin.reports.tax.index');
    }

    public function updateStateTaxManagerStatus($id)
    {
        try {
            $tax = StateTaxManager::find($id);
            if ('1' == $tax->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            StateTaxManager::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'State Tax updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'State Tax could not be updated.');
        }

        return redirect()->route('admin.reports.tax.index');
    }
}
