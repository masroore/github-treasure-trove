<?php

namespace App\Http\Controllers\Admin\Seo;

use App\Http\Controllers\Controller;
use App\Managers\SitemapManager;
use Cache;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    protected $sitemapManager;

    /**
     * SiteMapController constructor.
     *
     * @param $sitemapManager
     */
    public function __construct(SitemapManager $sitemapManager)
    {
        $this->sitemapManager = $sitemapManager;
    }

    protected function edit()
    {
        $this->authorize('site-map.update');

        return view('admin.seo.site-map');
    }

    public function update(Request $request)
    {
        $this->authorize('site-map.update');

        $this->validate($request, [
            'vars.sitemap_schedule_cron' => 'nullable|string',
            'vars.sitemap_priority' => 'required|string',
            'vars.sitemap_changefreq' => 'required|string',
        ]);
        $vars = $request->only(['vars.sitemap_schedule_cron', 'vars.sitemap_priority', 'vars.sitemap_changefreq'])['vars'];

        foreach ($vars as $key => $value) {
            \Fomvasss\Variable\Models\Variable::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('laravel.variables.cache');

        $destination = $request->session()->pull('destination', route('admin.site-map.edit'));

        return redirect()->to($destination)
            ->with('success', trans('notifications.update.success'));
    }

    public function regenerate(Request $request)
    {
        $this->authorize('site-map.create');

        $this->sitemapManager->store();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Карта сайта успешно создана!',
                'status' => 'success',
            ]);
        }

        return redirect()->back()->with('success', 'Карта сайта успешно создана');
    }

    public function destroy(Request $request)
    {
        $this->authorize('site-map.destroy');

        if ($this->sitemapManager->destroy()) {
            $msg = 'Карта сайта успешно удалена!';
        } else {
            $msg = 'Ошибка удаления. Возможно не найден файл карты сайта!';

            if ($request->ajax()) {
                return response()->json([
                    'message' => $msg,
                    'status' => 'error',
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => $msg,
                'status' => 'success',
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }
}
