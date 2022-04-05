<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostUser\BulkDestroyPostUser;
use App\Http\Requests\Admin\PostUser\DestroyPostUser;
use App\Http\Requests\Admin\PostUser\IndexPostUser;
use App\Http\Requests\Admin\PostUser\StorePostUser;
use App\Http\Requests\Admin\PostUser\UpdatePostUser;
use App\Models\PostUser;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|Factory|View
     */
    public function index(IndexPostUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PostUser::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'post_id', 'deleted'],

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

        return view('admin.post-user.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.post-user.create');

        return view('admin.post-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function store(StorePostUser $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PostUser
        $postUser = PostUser::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/post-users'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/post-users');
    }

    /**
     * Display the specified resource.
     */
    public function show(PostUser $postUser): void
    {
        $this->authorize('admin.post-user.show', $postUser);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View
     */
    public function edit(PostUser $postUser)
    {
        $this->authorize('admin.post-user.edit', $postUser);

        return view('admin.post-user.edit', [
            'postUser' => $postUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array|Redirector|RedirectResponse
     */
    public function update(UpdatePostUser $request, PostUser $postUser)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PostUser
        $postUser->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/post-users'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/post-users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function destroy(DestroyPostUser $request, PostUser $postUser)
    {
        $postUser->delete();

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
    public function bulkDestroy(BulkDestroyPostUser $request): Response
    {
        DB::transaction(static function () use ($request): void {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk): void {
                    PostUser::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
