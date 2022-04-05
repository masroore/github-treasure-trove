<?php

namespace App\Http\Controllers;

use App\Models\DeletedGoogleNewsArticle;
use App\Models\DeletedRFacebookPost;
use App\Models\DeletedRInstagramPost;
use App\Models\DeletedTweet;
use App\Models\DeletedYoutubeVideo;
use App\Models\GoogleNewsArticle;
use App\Models\Reporte;
use App\Models\RFacebookPost;
use App\Models\RInstagramPost;
use App\Models\Tweet;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    public function DeleteById_TW(Request $request): void
    {
        $tweet = Tweet::where('id', $request->id)->first();

        $deleted_tweet = new DeletedTweet();
        $deleted_tweet->id_tweet = $tweet->id_tweet;
        $deleted_tweet->tweet = $tweet->tweet;
        $deleted_tweet->rt = $tweet->rt;
        $deleted_tweet->fav = $tweet->fav;
        $deleted_tweet->url_imagen = $tweet->url_imagen;
        $deleted_tweet->geo = $tweet->geo;
        $deleted_tweet->usuario = $tweet->usuario;
        $deleted_tweet->followers = $tweet->followers;
        $deleted_tweet->fecha_creacion = $tweet->fecha_creacion;
        $deleted_tweet->busqueda_id = $tweet->busqueda_id;
        $deleted_tweet->tags = $tweet->tags;
        $deleted_tweet->save();
        $tweet->delete();
        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Twitter')->first();
        $reporte->delete();
    }

    public function DeleteById_YT(Request $request): void
    {
        $video = YoutubeVideo::where('id', $request->id)->first();

        $deleted_youtube_video = new DeletedYoutubeVideo();
        $deleted_youtube_video->id_video = $video->id_video;
        $deleted_youtube_video->id_channel = $video->id_channel;
        $deleted_youtube_video->description = $video->description;
        $deleted_youtube_video->views = $video->views;
        $deleted_youtube_video->likes = $video->likes;
        $deleted_youtube_video->url_imagen = $video->url_imagen;
        $deleted_youtube_video->channel_name = $video->channel_name;
        $deleted_youtube_video->channel_subs = $video->channel_subs;
        $deleted_youtube_video->upload_date = $video->upload_date;
        $deleted_youtube_video->busqueda_id = $video->busqueda_id;
        $deleted_youtube_video->tags = $video->tags;
        $deleted_youtube_video->save();
        $video->delete();
        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Youtube')->first();
        $reporte->delete();
    }

    public function DeleteById_GN(Request $request): void
    {
        $article = GoogleNewsArticle::where('id', $request->id)->first();

        $deleted_google_news_article = new DeletedGoogleNewsArticle();
        $deleted_google_news_article->title = $article->title;
        $deleted_google_news_article->link = $article->link;
        $deleted_google_news_article->published_date = $article->published_date;
        $deleted_google_news_article->description = $article->description;
        $deleted_google_news_article->source = $article->source;
        $deleted_google_news_article->busqueda_id = $article->busqueda_id;
        $deleted_google_news_article->tags = $article->tags;
        $deleted_google_news_article->save();
        $article->delete();
        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Google News')->first();
        $reporte->delete();
    }

    public function DeleteById_FB(Request $request): void
    {
        $fbpost = RFacebookPost::where('id', $request->id)->first();

        $deleted_fbpost = new DeletedRFacebookPost();
        $deleted_fbpost->url = $fbpost->url;
        $deleted_fbpost->likes = $fbpost->likes;
        $deleted_fbpost->comments = $fbpost->comments;
        $deleted_fbpost->shares = $fbpost->shares;
        $deleted_fbpost->message = $fbpost->message;
        $deleted_fbpost->image_url = $fbpost->image_url;
        $deleted_fbpost->date = $fbpost->date;
        $deleted_fbpost->followers = $fbpost->followers;
        $deleted_fbpost->autor_url = $fbpost->autor_url;
        $deleted_fbpost->autor = $fbpost->autor;
        $deleted_fbpost->busqueda_id = $fbpost->busqueda_id;
        $deleted_fbpost->tags = $fbpost->tags;
        $deleted_fbpost->save();
        $fbpost->delete();
        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Facebook')->first();
        $reporte->delete();
    }

    public function DeleteById_IG(Request $request): void
    {
        $igpost = RInstagramPost::where('id', $request->id)->first();

        $deleted_igpost = new DeletedRInstagramPost();
        $deleted_igpost->url = $igpost->url;
        $deleted_igpost->likes = $igpost->likes;
        $deleted_igpost->comments = $igpost->comments;
        $deleted_igpost->shares = $igpost->shares;
        $deleted_igpost->message = $igpost->message;
        $deleted_igpost->image_url = $igpost->image_url;
        $deleted_igpost->date = $igpost->date;
        $deleted_igpost->followers = $igpost->followers;
        $deleted_igpost->autor_url = $igpost->autor_url;
        $deleted_igpost->autor = $igpost->autor;
        $deleted_igpost->autor_total_posts = $igpost->autor_total_posts;
        $deleted_igpost->busqueda_id = $igpost->busqueda_id;
        $deleted_igpost->tags = $igpost->tags;
        $deleted_igpost->save();
        $igpost->delete();
        $reporte = Reporte::where('id_db', $request->id)->where('fuente', 'Instagram')->first();
        $reporte->delete();
    }

    public function deleteMultipleResults(Request $request): void
    {
        $results = $request->results;
        foreach ($results as &$result) {
            if ($result['source'] == 'Twitter') {
                $request_to_delete = new Request();
                $request_to_delete->id = $result['id_db'];
                $this->DeleteById_TW($request_to_delete);
            }
            if ($result['source'] == 'Youtube') {
                $request_to_delete = new Request();
                $request_to_delete->id = $result['id_db'];
                $this->DeleteById_YT($request_to_delete);
            }
            if ($result['source'] == 'Facebook') {
                $request_to_delete = new Request();
                $request_to_delete->id = $result['id_db'];
                $this->DeleteById_FB($request_to_delete);
            }
            if ($result['source'] == 'Instagram') {
                $request_to_delete = new Request();
                $request_to_delete->id = $result['id_db'];
                $this->DeleteById_IG($request_to_delete);
            }
        }
    }
}
