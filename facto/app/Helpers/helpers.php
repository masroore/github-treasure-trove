<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

// if (! function_exists('ShortInteger')) {
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
// }

function make_phone($str)
{
    $a1 = substr($str, 0, 3);
    $a3 = substr($str, -4);
    $str = substr_replace($str, '', 0, 3);
    $a2 = substr_replace($str, '', -4);

    return implode('.', [$a1, $a2, $a3]);
}

function show_content($content)
{
    $data = nl2br(strip_tags($content, '<br>'));
    $data = str_replace('<script>', '', $data);
    $data = str_replace('</script>', '', $data);
    $data = str_replace('&lt;script&gt;', '', $data);
    $data = str_replace('&lt;/script&gt;', '', $data);

    return $data;
}

function changeImageServer($content)
{

    // nl2br
    $oldDomains = config('site-common.oldDomains');
    $newDomain = config('site-common.newDomain');
    $data = str_replace($oldDomains, $newDomain, $content);
    $data = str_replace('<script>', '', $data);
    $data = str_replace('</script>', '', $data);
    $data = str_replace('&lt;script&gt;', '', $data);
    $data = str_replace('&lt;/script&gt;', '', $data);

    return $data;
    // return str_replace( '<script>', '', str_replace($oldDomains, $newDomain, $content ) );
}

function changeDomain($content)
{
    $oldDomains = config('site-common.oldDomains');
    $newDomain = config('site-common.newDomain');
    $data = str_replace($oldDomains, $newDomain, $content);

    return $data;
    // return str_replace( '<script>', '', str_replace($oldDomains, $newDomain, $content ) );
}

function makeClickable($str)
{
    return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $str);
}

function checkRecentPosts($post_cat_ids)
{
    $count = 0;
    foreach ($post_cat_ids as $post_cat_id) {
        $key = 'new-post_cat-' . $post_cat_id;
        if (Cache::get($key, 'off') == 'on') {
            ++$count;
        }
    }

    return $count > 0 ? true : false;
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function level_gif($level_id)
{
    return '/assets/img/level/grade/' . $level_id . '.gif';
    // public/assets/img/level/grade
}

if (!function_exists('getwindow')) {
    function getwindow()
    {
        $window = Cookie::get('size');
        if (in_array($window, ['mobile', 'wide'])) {
            return $window;
        }
        redirect('/');
    }
}

if (!function_exists('sub')) {
    function sub()
    {
        $url = URL::current();
        $domains = explode('.', parse_url($url)['host']);

        return $domains[0] == 'm' ? 'front' : 'wide';
    }
}

if (!function_exists('showtime')) {
    function showtime($time)
    {
        $diff = \Carbon\Carbon::parse($time)->diffForHumans();

        if (abs(Carbon::parse($time)->diffInHours()) < 24) {
            return '<span class="text-red-500">' . $diff . '</span>';
        }
        $diff = \Carbon\Carbon::parse($time)->format('m-d');

        return '<span class="text-gray-700">' . $diff . '</span>';
    }
}

if (!function_exists('showtime_wo_tag')) {
    function showtime_wo_tag($time)
    {
        $diff = \Carbon\Carbon::parse($time)->diffForHumans();

        if (abs(Carbon::parse($time)->diffInHours()) < 24) {
            return $diff;
        }
        $diff = \Carbon\Carbon::parse($time)->format('m-d');

        return $diff;
    }
}

if (!function_exists('showTimeDiff')) {
    function showTimeDiff($created_at)
    {
        $diff = \Carbon\Carbon::parse($created_at)->diffForHumans();

        if (\Carbon\Carbon::parse($created_at)->diffInHours() < 24) {
            return '<div class="text-red-500 font-medium">' . $diff . '</div>';
        }

        return '<div class="text-gray-700 font-medium">' . $diff . '</div>';
    }
}

if (!function_exists('get_recent_posts')) {
    function get_recent_posts($menu)
    {
        $all = 0;
        foreach ($menu->children as $child) {
            if ($child->post_cat) {
                $all += $child->post_cat->recent_posts->count();
            }
        }

        return $all;
    }
}

if (!function_exists('isTest')) {
    function isTest()
    {
        $host = parse_url(URL::current())['host'];
        $host = explode('.', $host);
        $enddomain = end($host);

        return $enddomain == 'test' ? true : false;
    }
}

if (!function_exists('ShortInteger')) {
    function ShortInteger($numbers)
    {
        $readable = ['', 'K+', 'M+', 'B+'];
        $index = 0;
        while ($numbers > 1000) {
            $numbers /= 1000;
            ++$index;
        }

        return '' . round($numbers, 0, PHP_ROUND_HALF_DOWN) . $readable[$index];
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('bytesToSize')) {
    function bytesToSize($bytes)
    {
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if ($bytes == 0) {
            return 'n/a';
        }

        $i = (int) (floor(log($bytes) / log(1024)));
        if ($i == 0) {
            return $bytes . ' ' . $sizes[$i];
        }

        return round(($bytes / 1024 ** $i), 1, PHP_ROUND_HALF_UP) . ' ' . $sizes[$i];
    }
}
