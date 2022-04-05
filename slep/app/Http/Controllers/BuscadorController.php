<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use App\Models\BusquedaRegistro;
use App\Models\Campania;
use App\Models\GoogleNewsArticle;
use App\Models\Medio;
use App\Models\RFacebookPost;
use App\Models\RInstagramPost;
use App\Models\SocialProfile;
use App\Models\Tweet;
use App\Models\YoutubeVideo;

class BuscadorController extends Controller
{
    /**
     * Create a new controller instance.
     *y.
     */
    public function index()
    {
        if (auth()->user()->getRoleNames()->first() == 'guest') {
            auth()->logout();

            return redirect('login');
        }
        $campañas = Campania::where('user_id', auth()->id())->get();
        $profileimage = $this->getProfileImage();
        //$toast_pendiente = 'toastr["success"]("Etiqueta agregada al resultado")';$eese= '<script type="text/javascript">'.$toast_pendiente.'</script>';echo $eese;flush();
        return view('dashboard/tables/buscador', compact('campañas', 'profileimage'));
    }

    public function ConsultaResultadosNoSearch()
    {
        $data = Busqueda::where('user_id', auth()->id())->get();
        $isSearch = false;

        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/consulta_resultados', compact('data', 'isSearch', 'profileimage'));
    }

    public function ConsultaResultados()
    {
        $data = Busqueda::where('user_id', auth()->id())->get();
        $isSearch = true;
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/consulta_resultados', compact('data', 'isSearch', 'profileimage'));
    }

    public function ConsultaResultadosById($idSearch)
    {
        return Busqueda::where('id', $idSearch)->get();
    }

    public function all($id)
    {
        $posts = Tweet::where('busqueda_id', $id)->get();
        $videos = YoutubeVideo::where('busqueda_id', $id)->get();
        $news = GoogleNewsArticle::where('busqueda_id', $id)->get();
        $fbposts = RFacebookPost::where('busqueda_id', $id)->get();
        $igposts = RInstagramPost::where('busqueda_id', $id)->get();

        $b = Busqueda::where('id', $id)->first();
        $campañas_de_busqueda = $b->campañas;

        $all = [$posts, $videos, $news, $fbposts, $igposts, $campañas_de_busqueda];

        return $all;
    }

    public function ConsultaPostsById($idSearch)
    {
        return Tweet::where('busqueda_id', $idSearch)->get();
    }

    public function ConsultaVideosById($idSearch)
    {
        return YoutubeVideo::where('busqueda_id', $idSearch)->get();
    }

    public function ConsultaNewsById($idSearch)
    {
        return GoogleNewsArticle::where('busqueda_id', $idSearch)->get();
    }

    public function ConsultaFacebookPostsById($idSearch)
    {
        return RFacebookPost::where('busqueda_id', $idSearch)->get();
    }

    public function ConsultaInstagramPostsById($idSearch)
    {
        return RInstagramPost::where('busqueda_id', $idSearch)->get();
    }

    public function BusquedaById($id)
    {
        $b = Busqueda::where('id', $id)->first();
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/resultado', compact('b', 'profileimage'));
    }

    public function ConsultaMediosNoSearch()
    {
        $data = Busqueda::where('user_id', auth()->id())->get();
        $medios = Medio::all();
        $profileimage = $this->getProfileImage();

        return view('dashboard/tables/consulta_medios', compact('data', 'medios', 'profileimage'));
    }

    public function getCampañasByBusqueda($id)
    {
        $b = Busqueda::where('id', $id)->first();
        $campañas_de_busqueda = $b->campañas;

        return $campañas_de_busqueda;
    }

    public function getStateTable()
    {
        return view('dashboard/tables/registros');
    }

    public function getStateTableData()
    {
        return BusquedaRegistro::where('user_id', auth()->id())->get();
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
