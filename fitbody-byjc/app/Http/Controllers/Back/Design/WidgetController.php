<?php

namespace App\Http\Controllers\Back\Design;

use App\Http\Controllers\Controller;
use App\Models\Back\Category;
use App\Models\Back\Design\Widget;
use App\Models\Back\Design\WidgetGroup;
use App\Models\Back\Marketing\Blog\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = (new Widget())->newQuery();

        if ($request->has('group')) {
            $query->where('group_id', $request->input('group'));
        }

        $widgets = $query->orderBy('sort_order')->with('group')->paginate(config('settings.pagination.items'));

        $groups = WidgetGroup::where('status', 1)->get();

        Log::info($groups);

        return view('back.design.widgets.index', compact('widgets', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = WidgetGroup::where('status', 1)->get();
        $sizes = (new Widget())->sizes();

        return view('back.design.widgets.edit', compact('groups', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $widget = new Widget();
        $stored = $widget->validateRequest($request)->setUrl()->store();

        if ($stored) {
            if (Widget::hasImage($request)) {
                $stored->resolveImage($request);
            }

            return redirect()->route('widgets')->with(['success' => 'Widget je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem widgeta.']);
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
        $query = (new Widget())->newQuery();

        $widget = $query->where('id', $id)->first();
        $sizes = $widget->sizes();

        if (!$widget) {
            abort(401);
        }

        $groups = WidgetGroup::where('status', 1)->get();

        return view('back.design.widgets.edit', compact('widget', 'groups', 'sizes'));
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
        $widget = new Widget();
        $updated = $widget->validateRequest($request)->setUrl()->edit($id);

        if ($updated) {
            if (Widget::hasImage($request)) {
                $updated->resolveImage($request);
            }

            return redirect()->back()->with(['success' => 'Widget je uspješno snimljen!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Desila se greška sa snimanjem widgeta.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['data']['id'])) {
            return response()->json(
                Widget::where('id', $request['data']['id'])->delete()
            );
        }
    }

    /*
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    */
    // API ROUTES

    public function getLinks(Request $request)
    {
        if ($request->has('type')) {
            if ('category' == $request->input('type')) {
                return response()->json(Category::getList());
            }
            if ('page' == $request->input('type')) {
                return response()->json(Blog::published()->pluck('title', 'id'));
            }
        }

        return response()->json([
            'id' => 0,
            'text' => 'Molimo odaberite tip linka..',
        ]);
    }
}
