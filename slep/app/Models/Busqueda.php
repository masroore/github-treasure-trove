<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busqueda extends Model
{
    use HasFactory;

    //n to n relationship
    public function campañas()
    {
        return $this->belongsToMany('App\Models\Campania');
    }

    public function n_resultados()
    {
        $posts = count(Tweet::where('busqueda_id', $this->id)->get());
        $videos = count(YoutubeVideo::where('busqueda_id', $this->id)->get());
        //$news=GoogleNewsArticle::where('busqueda_id',$id)->get();
        $fbposts = count(RFacebookPost::where('busqueda_id', $this->id)->get());
        $igposts = count(RInstagramPost::where('busqueda_id', $this->id)->get());

        return $posts + $videos + $fbposts + $igposts;
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->with('roles')->with('empresas');
    }

    public function async()
    {
        return $this->hasMany('App\Models\AsyncResult', 'busqueda_id', 'id');
    }

    public function googlenews()
    {
        return $this->hasMany('App\Models\GoogleNewsArticle', 'busqueda_id', 'id');
    }
}
