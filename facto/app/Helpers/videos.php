<?php

// 유튜브 썸네일 가져오기
if (!function_exists('get_youtube_thumbnail')) {
    function get_youtube_thumbnail($url)
    {
        return get_youtube_thumbnail(get_youtube_id($url));
    }
}

if (!function_exists('get_youtube_id')) {
    // 유튜브 ID 가져오기
    function get_youtube_id($url)
    {
        if (!$url) {
            return false;
        }
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

        return $match[1];
    }
}

if (!function_exists('get_youtube_thumbnail')) {
    // 유튜브 썸네일 링크
    // http://webdir.tistory.com/472($thumb_str에 따른 썸네일 크기 및 설명)
    function get_youtube_thumbnail($youtube_id, $thumb_str = '1')
    {
        if (!$youtube_id) {
            return false;
        }

        return 'https://img.youtube.com/vi/' . $youtube_id . '/' . $thumb_str . '.jpg';
    }
}
