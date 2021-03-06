<?php
/**
 * Filter Controller.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Filter;
use Illuminate\Http\Request;

/**
 * Filter Controller.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class FilterController extends Controller
{
    /**
     * Make sure the filter pages can only be seen if the user is authenticated
     * and verified.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['show', 'getImage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->_indexView('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        if (auth()->user()->isAdmin()) {
            return $this->_indexView('admin');
        }
        abort(401);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string            $user      user for a normal user, admin for an admin
     *
     * @return \Illuminate\Http\Response
     */
    private function _indexView($user)
    {
        return view('layout.filter.view', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Filter $filter The filter to fill out in the fields
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Filter $filter)
    {
        return view(
            'layout.filter.create',
            ['filter' => $filter, 'update' => false]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The request with all information
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FilterRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $filter = Filter::create($validated);

        if ($request->picture != null) {
            // Add the picture
            Filter::find($filter->id)
                ->addMedia($request->picture->path())
                ->usingFileName($filter->id . '.png')
                ->toMediaCollection('filter');
        }

        laraflash(_i('Filter %s created', $request->name))->success();

        // View the page with all filters for the user
        return redirect(route('filter.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Filter $filter The filter to show
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Filter $filter)
    {
        $media = $this->getImage($filter);

        return view(
            'layout.filter.show',
            ['filter' => $filter, 'media' => $media]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Filter $filter The filter to edit
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Filter $filter)
    {
        $this->authorize('update', $filter);

        return view('layout.filter.create', ['filter' => $filter, 'update' => true]);
    }

    /**
     * Returns the image of the filter.
     *
     * @param Filter $filter The filter
     *
     * @return MediaObject the image of the filter
     */
    public function getImage(Filter $filter)
    {
        if (!$filter->hasMedia('filter')) {
            $filter->addMediaFromUrl(asset('images/filter.jpg'))
                ->usingFileName($filter->id . '.png')
                ->toMediaCollection('filter');
        }

        return $filter->getFirstMedia('filter');
    }

    /**
     * Remove the image of the filter.
     *
     * @param int $id The id of the filter
     *
     * @return None
     */
    public function deleteImage($id)
    {
        $this->authorize('update', Filter::find($id));

        Filter::find($id)
            ->getFirstMedia('filter')
            ->delete();

        return '{}';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Filter $filter The filter to remove
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filter $filter)
    {
        $this->authorize('update', $filter);

        if ($filter->observations > 0) {
            laraflash(
                _i('Filter %s has observations. Impossible to delete.', $filter->name)
            )->info();
        } else {
            if (Filter::find($filter->id)->hasMedia('filter')) {
                Filter::find($filter->id)
                    ->getFirstMedia('filter')
                    ->delete();
            }

            $filter->delete();

            laraflash(_i('Filter %s deleted', $filter->name))->info();
        }

        return redirect()->back();
    }
}
