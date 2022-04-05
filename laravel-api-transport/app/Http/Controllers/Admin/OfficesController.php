<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Office\BulkDestroyOffice;
use App\Http\Requests\Admin\Office\DestroyOffice;
use App\Http\Requests\Admin\Office\IndexOffice;
use App\Http\Requests\Admin\Office\StoreOffice;
use App\Http\Requests\Admin\Office\UpdateOffice;
use App\Models\Office;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexOffice $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Office::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'phone', 'address', 'city_id', 'deleted'],

            // set columns to searchIn
            ['id', 'phone', 'address']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }

            return ['data' => $data];
        }

        return view('admin.office.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.office.create');

        return view('admin.office.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StoreOffice $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Office
        $office = Office::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/offices'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/offices');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office): void
    {
        $this->authorize('admin.office.show', $office);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(Office $office)
    {
        $this->authorize('admin.office.edit', $office);

        return view('admin.office.edit', [
            'office' => $office,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdateOffice $request, Office $office)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Office
        $office->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/offices'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/offices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyOffice $request, Office $office)
    {
        $office->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @return bool|Response
     */
    public function bulkDestroy(BulkDestroyOffice $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    Office::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
