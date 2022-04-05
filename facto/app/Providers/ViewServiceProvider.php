<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // $user_menus = [
        //     ['key' => 'kr', 'title' =>'한국야동', 'type'=>'gallery' ,'link'=>'/posts?cat=1'],
        //     ['key' => 'jp', 'title' =>'일본야동', 'type'=>'gallery','link'=>'/posts?cat=2'],
        //     ['key' => 'asia', 'title' =>'동양야동', 'type'=>'gallery','link'=>'/posts?cat=3'],
        //     ['key' => 'western', 'title' =>'서양야동', 'type'=>'gallery','link'=>'/posts?cat=4'],

        //     ['key' => 'bbs', 'title' =>'서양야동', 'type'=>'dropdown','link'=>''],

        //     ['key' => 'torrent', 'title' =>'av토렌트', 'type'=>'outlink','link'=>'/'],
        //     ['key' => 'upso', 'title' =>'업소정보', 'type'=>'outlink','link'=>'/'],
        //     ['key' => 'broadcast', 'title' =>'스포츠중계', 'type'=>'outlink','link'=>'http://betmoa00.com'],
        //     ['key' => 'bet', 'title' =>'놀이터', 'type'=>'outlink', 'link'=>'/' ],
        //     ['key' => 'quest', 'title' =>'1:1문의', 'type'=>'list-password', 'link'=>'/posts?cat=9'],
        //     ['key' => 'banner', 'title' =>'광고문의', 'type'=>'list-password', 'link'=>'/posts?cat=10'],
        //     ];

        // View::composer( '*' , $user_menus );
        // View::share( '*', $user_menus );
    }
}
