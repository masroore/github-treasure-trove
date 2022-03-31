<?php

namespace App\Models\Back;

use App\Models\Back\Settings\Page;
use App\User;

class Dashboard
{
    public function stats()
    {
        return [
            [
                'title'      => 'Ukupno Stranica',
                'value'      => Page::all()->count(),
                'icon'       => 'cloud-upload',
                'icon_color' => 'earth-light',
                'url'        => route('pages'),
            ],
            [
                'title'      => 'Novosti',
                'value'      => \App\Models\Front\Page::news(\App\Models\Front\Category\Category::find(config('settings.category.news')))->get()->count(),
                'icon'       => 'book-open',
                'icon_color' => 'info',
                'url'        => route('pages', ['group' => 10]),
            ],
            [
                'title'      => 'Pregleda Stranica',
                'value'      => Page::all()->sum('viewed'),
                'icon'       => 'globe-alt',
                'icon_color' => 'pulse-light',
                'url'        => route('pages'),
            ],
            [
                'title'      => 'Korisnici',
                'value'      => User::all()->count(),
                'icon'       => 'users',
                'icon_color' => 'elegance-light',
                'url'        => route('users'),
            ],
        ];
    }

    public function news($category_id)
    {
        return \App\Models\Front\Page::news(\App\Models\Front\Category\Category::find($category_id))->latest()->limit(10)->get();
    }

    public function mostClicks()
    {
        return Page::orderBy('viewed', 'desc')->limit(5)->get();
    }
}
