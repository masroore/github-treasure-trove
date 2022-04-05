<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 11.04.19
 * Time: 15:58.
 */

namespace App\Models\Traits;

trait Metatagable
{
    use \Fomvasss\LaravelMetaTags\Traits\Metatagable;

    protected $defaultMetaTags = [
        'changefreq' => 'daily',
        'priority' => '0.5',
    ];

    public function generateMetaTags(): array
    {
        return array_merge($this->defaultMetaTags, [
            'title' => str_limit($this->name, 55, '') . ' - ' . config('app.name'),
            'description' => str_limit(strip_tags($this->body ?? $this->description ?? ''), 300, ''),
            'h1' => $this->name,
            //'og_title' => str_limit($this->name, 60, ''),
            //'og_description' => str_limit(strip_tags($this->body ?? $this->description ?? ''), 300, ''),
        ]);
    }

    public function generateMetaTagOgImgData(): array
    {
        return [
            'title' => $this->metaTag ? $this->metaTag->title : $this->name,
            'subtitle' => $this->txCategory ? $this->txCategory->name : config('app.name'),
            'img' => '',
        ];
    }
}
