<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Transport\BulkDestroyTransport;
use App\Http\Requests\Admin\Transport\DestroyTransport;
use App\Http\Requests\Admin\Transport\IndexTransport;
use App\Http\Requests\Admin\Transport\StoreTransport;
use App\Http\Requests\Admin\Transport\UpdateTransport;
use App\Models\Transport;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexTransport $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Transport::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'car_number', 'total_seats', 'model_id', 'deleted'],

            // set columns to searchIn
            ['id', 'car_number']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }

            return ['data' => $data];
        }

        return view('admin.transport.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.transport.create');

        return view('admin.transport.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StoreTransport $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Transport
        $transport = Transport::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/transports'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/transports');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transport $transport): void
    {
        $this->authorize('admin.transport.show', $transport);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(Transport $transport)
    {
        $this->authorize('admin.transport.edit', $transport);

        return view('admin.transport.edit', [
            'transport' => $transport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdateTransport $request, Transport $transport)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Transport
        $transport->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/transports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/transports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyTransport $request, Transport $transport)
    {
        $transport->delete();

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
    public function bulkDestroy(BulkDestroyTransport $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    Transport::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
