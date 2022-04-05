<?php

use App\Models\PostCat;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('site_settings')) {
    function site_settings()
    {
        $seconds = 120;
        $settings = Cache::remember('site_settings', $seconds, function () {
            return Setting::where('key', 'general')->first()->value;
        });
        // dd( unserialize( $settings) );
        return (object) unserialize($settings);
    }
}

if (!function_exists('post_cat_value')) {
    function post_cat_value($post_cat_id)
    {
        $seconds = 120;
        $value = Cache::remember('cache-post_cat_value-' . $post_cat_id, $seconds, function () use ($post_cat_id) {
            return PostCat::find($post_cat_id)->value;
        });

        return (object) unserialize($value);
    }
}
