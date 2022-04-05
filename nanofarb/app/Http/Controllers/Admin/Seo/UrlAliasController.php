<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Seo\UrlAliasRequest;
use Fomvasss\UrlAliases\Models\UrlAlias;
use Illuminate\Http\Request;

class UrlAliasController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $aliases = UrlAlias::whereNotNull('type')->orderByDesc('id')->paginate();

        return view('admin.seo.redirects', compact('aliases'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UrlAliasRequest $request)
    {
        UrlAlias::create($request->validated());

        $destination = $request->session()->pull('destination', route('admin.url-aliases.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    public function destroy(Request $request, $id)
    {
        UrlAlias::whereNotNull('type')->findOrFail($id)->delete();

        $destination = $request->session()->pull('destination', route('admin.url-aliases.index'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.destroy.success'));
    }

    /**
     * Data search for select autocomplete.
     *
     * @return array
     */
    public function autocomplete(Request $request)
    {
        if ($request->has('q') && strlen($request->get('q'))) {
            $q = mb_strtolower($request->q);

            $result = UrlAlias::with('aliasable')->get()
                ->mapWithKeys(function ($a) use ($q) {
                    $haystack = [mb_strtolower($a->aliasable->name ?? ''), mb_strtolower($a->aliasable->title ?? ''), $a->alias];

                    foreach ($haystack as $haystackItem) {
                        if ($haystackItem && strpos($haystackItem, $q) !== false) {
                            return [$a->id => [
                                'text' => ($a->aliasable->name ?? $a->aliasable->title) . ' [' . url($a->alias) . ']',
                                'id' => $a->id,
                            ]];
                        }
                    }

                    return [];
                });

            return ['results' => array_values($result->toArray())];
        }

        return ['results' => []];
    }
}
