<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Route\BulkDestroyRoute;
use App\Http\Requests\Admin\Route\DestroyRoute;
use App\Http\Requests\Admin\Route\IndexRoute;
use App\Http\Requests\Admin\Route\StoreRoute;
use App\Http\Requests\Admin\Route\UpdateRoute;
use App\Models\Route;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexRoute $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Route::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'departure_city_id', 'arrival_city_id', 'distance', 'user_id', 'deleted'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }

            return ['data' => $data];
        }

        return view('admin.route.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.route.create');

        return view('admin.route.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StoreRoute $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Route
        $route = Route::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/routes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/routes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route): void
    {
        $this->authorize('admin.route.show', $route);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(Route $route)
    {
        $this->authorize('admin.route.edit', $route);

        return view('admin.route.edit', [
            'route' => $route,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdateRoute $request, Route $route)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Route
        $route->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/routes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/routes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyRoute $request, Route $route)
    {
        $route->delete();

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
    public function bulkDestroy(BulkDestroyRoute $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    Route::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
