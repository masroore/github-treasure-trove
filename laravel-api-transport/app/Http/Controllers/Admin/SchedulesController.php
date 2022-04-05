<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Schedule\BulkDestroySchedule;
use App\Http\Requests\Admin\Schedule\DestroySchedule;
use App\Http\Requests\Admin\Schedule\IndexSchedule;
use App\Http\Requests\Admin\Schedule\StoreSchedule;
use App\Http\Requests\Admin\Schedule\UpdateSchedule;
use App\Models\Schedule;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexSchedule $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Schedule::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'date', 'time', 'cost', 'confirmed', 'transport_id', 'route_id', 'deleted'],

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

        return view('admin.schedule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.schedule.create');

        return view('admin.schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StoreSchedule $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Schedule
        $schedule = Schedule::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/schedules'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/schedules');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule): void
    {
        $this->authorize('admin.schedule.show', $schedule);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(Schedule $schedule)
    {
        $this->authorize('admin.schedule.edit', $schedule);

        return view('admin.schedule.edit', [
            'schedule' => $schedule,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdateSchedule $request, Schedule $schedule)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Schedule
        $schedule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/schedules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/schedules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroySchedule $request, Schedule $schedule)
    {
        $schedule->delete();

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
    public function bulkDestroy(BulkDestroySchedule $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    Schedule::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
