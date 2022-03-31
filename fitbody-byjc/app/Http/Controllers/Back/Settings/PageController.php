<?php

namespace App\Http\Controllers\Back\Settings;

use App\Http\Controllers\Controller;
use App\Models\Back\Category;
use App\Models\Back\Settings\Page;
use App\Models\Back\Settings\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Page())->newQuery();

        if ($request->has('group')) {
            $cat = Category::where('id', $request->input('group'))->first();

            if (!$cat->parent_id) {
                $ids = Category::where('parent_id', $request->input('group'))->pluck('id');
                $ids->push($request->input('group'));

                $query->whereIn('category_id', $ids);
            } else {
                $query->where('category_id', $request->input('group'));
            }
        }

        if ($request->has('from')) {
            $query->whereDate('created_at', '>=', Carbon::createFromFormat('d.m.Y.', $request->input('from')));
        }

        if ($request->has('to')) {
            $query->where('created_at', '<=', Carbon::createFromFormat('d.m.Y.', $request->input('to')));
        }

        $pages = $query->orderBy('created_at', 'desc')->paginate(40);

        $page_groups = Category::getList();

        return view('back.settings.pages.index', compact('pages', 'page_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_groups = Category::getList();

        //dd($page_groups);

        return view('back.settings.pages.edit', compact('page_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page();
        $stored = $page->validateRequest($request)->storePage();

        Cache::forget('latest');

        if ($stored) {
            if ($request->has('main_image') && $request->input('main_image')) {
                $page->resolveMainImage($stored->id);
            }

            if ($request->has('gallery_images') || $request->has('new_gallery_images')) {
                $page->resolveGallery($stored->id);
            }

            if ($request->has('blocks_docs')) {
                $page->resolveDocuments(
                    $stored->id,
                    $request->block_doc_files ?: null
                );
            }

            return redirect()->route('pages')->with(['success' => 'Page was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error creating the page.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd(isset($page->block));

        $query = (new Page())->newQuery();

        $page = $query->where('id', $id)->first();

        //dd($page->blocks->groupBy('type')['pdf']);

        if (!$page) {
            abort(401);
        }

        $page_groups = Category::getList();

        return view('back.settings.pages.edit', compact('page', 'page_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);

        //$ic = new \Imagick();

        $page = new Page();
        $updated = $page->validateRequest($request)->updatePage($id);

        Cache::forget('latest');

        if ($updated) {
            if ($request->has('main_image') && $request->input('main_image')) {
                $page->resolveMainImage($id);
            }

            if ($request->has('gallery_images') || $request->has('new_gallery_images')) {
                $page->resolveGallery($id);
            }

            if ($request->has('blocks_docs')) {
                $page->resolveDocuments(
                    $id,
                    $request->block_doc_files ?: null
                );
            }

            return redirect()->route('pages')->with(['success' => 'Page was succesfully updated!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error updating the page.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            Cache::forget('latest');

            return response()->json(
                Page::where('id', $request['data']['id'])->delete()
            );
        }
    }

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    public function blockDestroy(Request $request)
    {
        $block = PageBlock::where('id', $request['data'])->first();
        Storage::disk('page')->delete(str_replace(config('filesystems.disks.page.url'), '', $block->path));

        return response()->json($block->delete());
    }
}
