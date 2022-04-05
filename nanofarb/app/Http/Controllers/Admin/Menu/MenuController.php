<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu\Menu;
use Fomvasss\LaravelEUS\Facades\EUS;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('menu.read');

        $menus = Menu::withCount('items')->get();

        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $this->authorize('menu.create');

        $system_name = EUS::setEntity(new Menu())
            ->setRawStr($request->system_name ?? $request->name)
            ->setFieldName('system_name')
            ->setSlugSeparator('_')
            ->get();

        Menu::create([
            'name' => $request->name,
            'system_name' => $system_name,
            'publish' => $request->get('publish', 1),
        ]);

        $destination = $request->session()->pull('destination', route('admin.menu.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        $this->authorize('menu.update');

        $menu = Menu::findOrFail($id);
        $menu->update([
            'name' => $request->name,
            'publish' => $request->get('publish', 1),
        ]);

        $destination = $request->session()->pull('destination', route('admin.menu.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('menu.delete');

        $menu = Menu::findOrFail($id);

        $destination = $request->session()->pull('destination', route('admin.menu.index'));
        if ($menu->items->count()) {
            return redirect()->to($destination)
                ->with('error', trans('notifications.destroy.error_children'));
        }

        $menu->delete();

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }
}
