<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use App\Models\Campania;
use App\Models\GoogleNewsArticle;
use App\Models\RFacebookPost;
use App\Models\RInstagramPost;
use App\Models\SocialProfile;
use App\Models\Tweet;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class CampaniaController extends Controller
{
    public function GetAll()
    {
        $data = Campania::where('user_id', auth()->id())->get();
        $isSearch = false;
        $busquedas = Busqueda::where('user_id', auth()->id())->get();
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/campañas', compact('data', 'isSearch', 'busquedas', 'profileimage'));
    }

    public function GetAllCampaniasRaw()
    {
        return Campania::where('user_id', auth()->id())->get();
    }

    public function GetCampaña($id)
    {
        return Campania::where('id', $id)->get();
    }

    public function GetResultadosTwitter($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;

        $ids = [];

        foreach ($busquedas as &$busqueda) {
            $ids[] = $busqueda->id;
        }

        return Tweet::whereIn('busqueda_id', $ids)->get();
    }

    public function GetResultadosYoutube($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;

        $ids = [];

        foreach ($busquedas as &$busqueda) {
            $ids[] = $busqueda->id;
        }

        return YoutubeVideo::whereIn('busqueda_id', $ids)->get();
    }

    public function GetResultadosGNews($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;

        $ids = [];

        foreach ($busquedas as &$busqueda) {
            $ids[] = $busqueda->id;
        }

        return GoogleNewsArticle::whereIn('busqueda_id', $ids)->get();
    }

    public function GetResultadosFacebook($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;

        $ids = [];

        foreach ($busquedas as &$busqueda) {
            $ids[] = $busqueda->id;
        }

        return RFacebookPost::whereIn('busqueda_id', $ids)->get();
    }

    public function GetResultadosInstagram($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;

        $ids = [];

        foreach ($busquedas as &$busqueda) {
            $ids[] = $busqueda->id;
        }

        return RInstagramPost::whereIn('busqueda_id', $ids)->get();
    }

    public function GetAllResultados($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;
        $ids = [];
        foreach ($busquedas as &$busqueda) {
            $ids[] = $busqueda->id;
        }
        $posts = Tweet::whereIn('busqueda_id', $ids)->get();
        $videos = YoutubeVideo::whereIn('busqueda_id', $ids)->get();
        $news = GoogleNewsArticle::whereIn('busqueda_id', $ids)->get();
        $fbposts = RFacebookPost::whereIn('busqueda_id', $ids)->get();
        $igposts = RInstagramPost::whereIn('busqueda_id', $ids)->get();

        $all = [$posts, $videos, $news, $fbposts, $igposts];

        return $all;
    }

    public function crearNuevaCampaña(Request $request)
    {
        $nuevaCampaña = new Campania();
        $nuevaCampaña->nombre_campania = $request->nombreCampaña;
        $nuevaCampaña->user_id = auth()->id();
        $nuevaCampaña->save();

        $data = Campania::where('user_id', auth()->id())->get();
        $isSearch = false;
        $busquedas = Busqueda::where('user_id', auth()->id())->get();

        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/campañas', compact('data', 'isSearch', 'busquedas', 'profileimage'));
    }

    public function GetCampañaById($id)
    {
        return Campania::where('id', $id)->get();
    }

    public function GetBusquedas($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas = $c->busquedas;
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/campaña', compact('busquedas', 'id', 'profileimage'));
    }

    public function GetBusquedasRaw($id)
    {
        $c = Campania::where('id', $id)->first();
        $busquedas_de_campaña = $c->busquedas;

        return $busquedas_de_campaña;
    }

    public function addBusquedas(Request $request)
    {
        $c = Campania::where('id', $request->c_id)->first();
        $c->busquedas()->attach($request->b_id);

        $data = Campania::where('user_id', auth()->id())->get();
        $busquedas = Busqueda::where('user_id', auth()->id())->get();
        $isSearch = false;
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/campañas', compact('data', 'isSearch', 'busquedas', 'profileimage'));
    }

    public function deleteBusquedas(Request $request)
    {
        $c = Campania::where('id', $request->c_id)->first();
        $c->busquedas()->detach($request->b_id);

        $data = Campania::where('user_id', auth()->id())->get();
        $busquedas = Busqueda::where('user_id', auth()->id())->get();
        $isSearch = false;
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/campañas', compact('data', 'busquedas', 'profileimage'));
    }

    public function addTags(Request $request)
    {
        $c = Campania::where('id', $request->c_id)->first();
        if ($request->tags == '' || $request->tags == ' ') {
            $c->tags = ' ';
        } else {
            $c->tags = $request->tags;
        }

        $c->save();

        $data = Campania::where('user_id', auth()->id())->get();
        $busquedas = Busqueda::where('user_id', auth()->id())->get();
        $isSearch = false;
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/campañas', compact('data', 'busquedas', 'profileimage'));
    }

    public function getProfileImage()
    {
        $socialprofile = SocialProfile::where('user_id', auth()->id())->first();
        $profileimage = '/assets/img/avatars/birs_profile.png';
        if (isset($socialprofile)) {
            $profileimage = $socialprofile->social_avatar;
        }

        return $profileimage;
    }
}
