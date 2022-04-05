<?php

namespace App\Http\Controllers;

use App\Models\GoogleNewsArticle;
use App\Models\Reporte;
use App\Models\RFacebookPost;
use App\Models\RInstagramPost;
use App\Models\Tweet;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function setTags_TW(Request $request): void
    {
        if ($request->tags == '') {
            $request->tags = ' ';
        }
        $tweet = Tweet::where('id', $request->id)->first();
        $tweet->tags = $request->tags;
        $tweet->save();

        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Twitter')->first();
        $reporte->etiquetas = $request->tags;
        $reporte->save();
    }

    public function setTags_YT(Request $request): void
    {
        if ($request->tags == '') {
            $request->tags = ' ';
        }
        $video = YoutubeVideo::where('id', $request->id)->first();
        $video->tags = $request->tags;
        $video->save();

        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Youtube')->first();
        $reporte->etiquetas = $request->tags;
        $reporte->save();
    }

    public function setTags_GN(Request $request): void
    {
        if ($request->tags == '') {
            $request->tags = ' ';
        }
        $article = GoogleNewsArticle::where('id', $request->id)->first();
        $article->tags = $request->tags;
        $article->save();

        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Google News')->first();
        $reporte->etiquetas = $request->tags;
        $reporte->save();
    }

    public function setTags_FB(Request $request): void
    {
        if ($request->tags == '') {
            $request->tags = ' ';
        }
        $fbpost = RFacebookPost::where('id', $request->id)->first();
        $fbpost->tags = $request->tags;
        $fbpost->save();

        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Facebook')->first();
        $reporte->etiquetas = $request->tags;
        $reporte->save();
    }

    public function setTags_IG(Request $request): void
    {
        if ($request->tags == '') {
            $request->tags = ' ';
        }
        $igpost = RInstagramPost::where('id', $request->id)->first();
        $igpost->tags = $request->tags;
        $igpost->save();

        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Instagram')->first();
        $reporte->etiquetas = $request->tags;
        $reporte->save();
    }

    public function setMultipleTags(Request $request): void
    {
        $results = $request->results;
        foreach ($results as &$result) {
            if ($result['source'] == 'Twitter') {
                $tweet = Tweet::where('id', $result['id_db'])->first();
                $reporte = Reporte::where('id_db', $result['id_db'])->where('fuente', 'Twitter')->first();
                if (str_contains($tweet->tags, $request->tag)) {
                    //no hace nada
                } else {
                    if ($tweet->tags == '' || $tweet->tags == ' ') {
                        $tweet->tags = $request->tag;
                        $reporte->etiquetas = $request->tag;
                    } else {
                        $tweet->tags = $tweet->tags . ',' . $request->tag;
                        $reporte->etiquetas = $reporte->etiquetas . ',' . $request->tag;
                    }
                    $tweet->save();
                    $reporte->save();
                }
            }
            if ($result['source'] == 'Youtube') {
                $yt_video = YoutubeVideo::where('id', $result['id_db'])->first();
                $reporte = Reporte::where('id_db', $result['id_db'])->where('fuente', 'Youtube')->first();
                if (str_contains($yt_video->tags, $request->tag)) {
                    //no hace nada
                } else {
                    if ($yt_video->tags == '' || $yt_video->tags == ' ') {
                        $yt_video->tags = $request->tag;
                        $reporte->etiquetas = $request->tag;
                    } else {
                        $yt_video->tags = $yt_video->tags . ',' . $request->tag;
                        $reporte->etiquetas = $reporte->etiquetas . ',' . $request->tag;
                    }
                    $yt_video->save();
                    $reporte->save();
                }
            }
            if ($result['source'] == 'Facebook') {
                $fb_post = RFacebookPost::where('id', $result['id_db'])->first();
                $reporte = Reporte::where('id_db', $result['id_db'])->where('fuente', 'Facebook')->first();
                if (str_contains($fb_post->tags, $request->tag)) {
                    //no hace nada
                } else {
                    if ($fb_post->tags == '' || $fb_post->tags == ' ') {
                        $fb_post->tags = $request->tag;
                        $reporte->etiquetas = $request->tag;
                    } else {
                        $fb_post->tags = $fb_post->tags . ',' . $request->tag;
                        $reporte->etiquetas = $reporte->etiquetas . ',' . $request->tag;
                    }
                    $fb_post->save();
                    $reporte->save();
                }
            }
            if ($result['source'] == 'Instagram') {
                $ig_post = RInstagramPost::where('id', $result['id_db'])->first();
                $reporte = Reporte::where('id_db', $result['id_db'])->where('fuente', 'Instagram')->first();
                if (str_contains($ig_post->tags, $request->tag)) {
                    //no hace nada
                } else {
                    if ($ig_post->tags == '' || $ig_post->tags == ' ') {
                        $ig_post->tags = $request->tag;
                        $reporte->etiquetas = $request->tag;
                    } else {
                        $ig_post->tags = $ig_post->tags . ',' . $request->tag;
                        $reporte->etiquetas = $reporte->etiquetas . ',' . $request->tag;
                    }
                    $ig_post->save();
                    $reporte->save();
                }
            }
        }
    }
}
