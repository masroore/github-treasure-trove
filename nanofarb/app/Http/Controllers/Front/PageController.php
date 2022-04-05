<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Page;
use App\Models\Taxonomy\Term;
use Fomvasss\UrlAliases\Models\UrlAlias;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        if (\UrlAlias::current(false) === '/' || \UrlAlias::current(false) === config('app.locale')) {
            $alias = UrlAlias::whereIn('alias', ['/', config('app.locale')])
                ->where('locale', config('app.locale'))
                ->firstOrFail();
            $params = $this->getParamsHomePage();
            $params['page'] = $alias->aliasable;

            return view('front.pages.home', $params);
        }

        abort(404);
    }

    public function show($id)
    {
        $params['page'] = $page = Page::isPublish()->findOrFail($id);

        if (in_array($page->blade, ['front.pages.home'])) {
            $params = array_merge($params, $this->getParamsHomePage());
        }

        return view()->first([$page->blade, 'front.pages.default'], $params);
    }

    protected function getParamsHomePage()
    {
        return [
            'categories' => Term::byVocabulary('product_categories')
                ->with('urlAlias', 'media')
                ->byLocale()
                ->whereNull('parent_id')->get(),
            'news' => News::orderBy('created_at', 'desc')
                ->byLocale()
                ->limit(48)->get(),
        ];
    }
}
