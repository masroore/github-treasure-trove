<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Passenger\BulkDestroyPassenger;
use App\Http\Requests\Admin\Passenger\DestroyPassenger;
use App\Http\Requests\Admin\Passenger\IndexPassenger;
use App\Http\Requests\Admin\Passenger\StorePassenger;
use App\Http\Requests\Admin\Passenger\UpdatePassenger;
use App\Models\Passenger;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PassengersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexPassenger $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Passenger::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'surname', 'first_name', 'second_name', 'passport_series', 'passport_number', 'phone', 'deleted'],

            // set columns to searchIn
            ['id', 'surname', 'first_name', 'second_name', 'passport_series', 'passport_number', 'phone']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }

            return ['data' => $data];
        }

        return view('admin.passenger.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.passenger.create');

        return view('admin.passenger.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StorePassenger $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Passenger
        $passenger = Passenger::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/passengers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/passengers');
    }

    /**
     * Display the specified resource.
     */
    public function show(Passenger $passenger): void
    {
        $this->authorize('admin.passenger.show', $passenger);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(Passenger $passenger)
    {
        $this->authorize('admin.passenger.edit', $passenger);

        return view('admin.passenger.edit', [
            'passenger' => $passenger,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdatePassenger $request, Passenger $passenger)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Passenger
        $passenger->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/passengers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/passengers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyPassenger $request, Passenger $passenger)
    {
        $passenger->delete();

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
    public function bulkDestroy(BulkDestroyPassenger $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    Passenger::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
