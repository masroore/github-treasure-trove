<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Model\BulkDestroyModel;
use App\Http\Requests\Admin\Model\DestroyModel;
use App\Http\Requests\Admin\Model\IndexModel;
use App\Http\Requests\Admin\Model\StoreModel;
use App\Http\Requests\Admin\Model\UpdateModel;
use App\Models\Model;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexModel $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Model::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'model_name', 'deleted'],

            // set columns to searchIn
            ['id', 'model_name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }

            return ['data' => $data];
        }

        return view('admin.model.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.model.create');

        return view('admin.model.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StoreModel $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Model
        $model = Model::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/models'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/models');
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $model): void
    {
        $this->authorize('admin.model.show', $model);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(Model $model)
    {
        $this->authorize('admin.model.edit', $model);

        return view('admin.model.edit', [
            'model' => $model,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdateModel $request, Model $model)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Model
        $model->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/models'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/models');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyModel $request, Model $model)
    {
        $model->delete();

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
    public function bulkDestroy(BulkDestroyModel $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    Model::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
