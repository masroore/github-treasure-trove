<?php

namespace App\Models;

use App\Models\Traits\HasSeoTrait;
use App\Models\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Variable;

class Page extends Model
{
    use HasSeoTrait;
    use HasTranslation;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [

    ];

    public function getPerPage()
    {
        if (request('limit')) {
            return request('limit');
        } elseif (request('per_page')) {
            return request('per_page');
        }

        return $this->perPage;
    }

    /**
     * Relation SEO.
     *
     * @return mixed
     */
    public function seo()
    {
        $var = Variable::getArray('seo_masks');

        return $this->metaTag()->withDefault([
            'title' => $var['pages']['fields']['title'] ?? '',
            'description' => $var['pages']['fields']['description'] ?? '',
            'keywords' => $var['pages']['fields']['keywords'] ?? '',
            'robots' => 'index',
        ]);
    }

    public function metaTag()
    {
        $modelClass = config('meta-tags.model', \Fomvasss\LaravelMetaTags\Models\MetaTag::class);

        return $this->morphOne($modelClass, 'model');
    }

    public function getSeo(): array
    {
        if ($tag = $this->metaTag) {
            return [
                'title' => $tag->title,
                'description' => $tag->description,
                'keywords' => $tag->keywords,
                'robots' => $tag->robots,
            ];
        }

        $var = Variable::getArray('seo_masks', null, $this->lang);

        return [
            'title' => $var['pages']['fields']['title'] ?? '[node:name]',
            'description' => $var['pages']['fields']['description'] ?? '',
            'keywords' => $var['pages']['fields']['keywords'] ?? '',
            'robots' => 'index',
        ];
    }
}
