<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use App\Models\Campania;
use App\Models\GoogleNewsArticle;
use App\Models\Reporte;
use App\Models\RFacebookPost;
use App\Models\RInstagramPost;
use App\Models\Tweet;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $campanias_data = Campania::all();

        return view('dashboard/tables/exportalldata', compact('campanias_data'));
    }

    public function databaseCampañas()
    {
        $campañas = Campania::all();
        $wBusquedas = [];
        foreach ($campañas as &$c) {
            $resultados = [];

            foreach ($c->busquedas as $b) {
                $posts = Tweet::where('busqueda_id', $b->id)->get();
                $videos = YoutubeVideo::where('busqueda_id', $b->id)->get();
                $news = GoogleNewsArticle::where('busqueda_id', $b->id)->get();
                $fbposts = RFacebookPost::where('busqueda_id', $b->id)->get();

                $all = [$b, $posts, $videos, $news, $fbposts];
                $resultados[] = $all;
            }
            $obj = [$c, $resultados];

            $wBusquedas[] = $obj;
        }

        return $wBusquedas;
        //return Campania::all();
    }

    public function databaseBusquedas()
    {
        return Busqueda::all();
    }

    public function databaseTweets($idSearch)
    {
        return Tweet::where('busqueda_id', $idSearch)->get();
    }

    public function databaseVideos($idSearch)
    {
        return YoutubeVideo::where('busqueda_id', $idSearch)->get();
    }

    public function databaseNews($idSearch)
    {
        return GoogleNewsArticle::where('busqueda_id', $idSearch)->get();
    }

    public function databaseFacebookPosts($idSearch)
    {
        return RFacebookPost::where('busqueda_id', $idSearch)->get();
    }

    public function databaseInstagramPosts($idSearch)
    {
        return RInstagramPost::where('busqueda_id', $idSearch)->get();
    }

    public function toReportesTable(Request $request): void
    {
        $results = json_decode($request->posts);
        foreach ($results as &$result) {
            $TestEquallity = Reporte::where('link', $result->linkPost)->where('busqueda_id', $result->id_search)->first();
            if (!$TestEquallity) {
                if ($result->id_campaign != 'Sin campaña asociada') {
                    $new_reporte = new Reporte();
                    $new_reporte->fuente = $result->tipoPagina;
                    $new_reporte->link = $result->linkPost;
                    $new_reporte->autor = $result->autor;
                    $new_reporte->fecha = $result->fecha;
                    $new_reporte->hora = $result->hora;
                    $new_reporte->seguidores = $result->seguidores;
                    $new_reporte->interacciones = $result->likes;
                    $new_reporte->viralizaciones = $result->viralizacion;
                    $new_reporte->impacto = $result->impacto;
                    $new_reporte->etiquetas = $result->tags;
                    $new_reporte->mensaje = $result->mensaje;
                    $new_reporte->id_db = $result->id_db;
                    $new_reporte->keywords_busqueda = $result->keywords;
                    $new_reporte->nombre_busqueda = $result->nameSearch;
                    $new_reporte->nombre_campania = $result->nameCampaign;
                    $new_reporte->busqueda_id = $result->id_search;
                    $new_reporte->campania_id = $result->id_campaign;
                    $new_reporte->keywords_campania = $result->campaign_keywords;
                    $new_reporte->save();
                }
            }
        }
    }

    public function testing()
    {
        $c = Campania::where('id', 26)->first();
        $b = $c->busquedas;

        $kw = '';
        foreach ($b as &$busqueda) {
            $kw = $kw . ',' . $busqueda->palabra_busqueda;
        }

        $bb = Busqueda::where('id', 57)->first();

        return $bb->campañas[0]->id;
    }

    public function ReporteById($id)
    {
        return Reporte::where('campania_id', $id)->get();
    }

    public function ReporteAll()
    {
        return Reporte::all();
    }

    public function wctest()
    {
        return view('dashboard/tables/nube');
    }
}
