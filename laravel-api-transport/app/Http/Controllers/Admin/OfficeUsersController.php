<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OfficeUser\BulkDestroyOfficeUser;
use App\Http\Requests\Admin\OfficeUser\DestroyOfficeUser;
use App\Http\Requests\Admin\OfficeUser\IndexOfficeUser;
use App\Http\Requests\Admin\OfficeUser\StoreOfficeUser;
use App\Http\Requests\Admin\OfficeUser\UpdateOfficeUser;
use App\Models\OfficeUser;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OfficeUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexOfficeUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(OfficeUser::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'office_id', 'deleted'],

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

        return view('admin.office-user.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.office-user.create');

        return view('admin.office-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StoreOfficeUser $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the OfficeUser
        $officeUser = OfficeUser::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/office-users'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/office-users');
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeUser $officeUser): void
    {
        $this->authorize('admin.office-user.show', $officeUser);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(OfficeUser $officeUser)
    {
        $this->authorize('admin.office-user.edit', $officeUser);

        return view('admin.office-user.edit', [
            'officeUser' => $officeUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdateOfficeUser $request, OfficeUser $officeUser)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values OfficeUser
        $officeUser->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/office-users'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/office-users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyOfficeUser $request, OfficeUser $officeUser)
    {
        $officeUser->delete();

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
    public function bulkDestroy(BulkDestroyOfficeUser $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    OfficeUser::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
