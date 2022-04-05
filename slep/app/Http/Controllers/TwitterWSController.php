<?php

namespace App\Http\Controllers;

use App\Models\AsyncResult;
use App\Models\Busqueda;
use App\Models\BusquedaRegistro;
use App\Models\Campania;
use App\Models\DeletedYoutubeVideo;
use App\Models\GoogleNewsArticle;
use App\Models\Reporte;
use App\Models\Tweet;
use App\Models\YoutubeVideo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use stdClass;

class TwitterWSController extends Controller
{
    /**
     * Create a new controller instance.
     *y.
     */
    public function writeSlacker(Request $request)
    {
        $texto = "\npalabraClave => " . $request->palabraClave .
                    "\nidBusqueda => " . $request->idBusqueda .
                    "\nfecha1 => " . $request->fecha1 .
                    "\nfecha2 => " . $request->fecha2 .
                    "\nuFecha1 => " . $request->uFecha1 .
                    "\nuFecha2 => " . $request->uFecha2 .
                    "\nidCampaña => " . $request->idCampaña;

        return $texto;
    }

    public function losTweetsNoSearch()
    {
        $tweetsNS = Tweet::all();

        return view('dashboard/tables/twittertables', compact('tweetsNS'));
        $tweetsNS = null;
    }

    public function wordsHandle(Request $request)
    {
        $words = Http::post('localhost:3005/wordscloud/', [
            'string' => $request->words_data,
        ]);

        return $words->json();
    }

    public function losTweets(Request $request)
    {
        $kw_ctrl = resolve('App\Http\Controllers\GenerateKeywordIdeas');
        //return ($request->all());
        //Validacion si es un # se borra el simbolo
        $searchWord = '';
        //error_log('sssss');
        if (($request->palabraClave)[0] == '#') {
            $searchWord = substr($request->palabraClave, 1);
        } else {
            $searchWord = $request->palabraClave;
        }
        //Quitar tildes
        $searchWord = $this->eliminar_tildes($searchWord);
        //Llamadas a los servicios web
        //Caso Actualizar Búsqueda
        if (isset($request->idBusqueda)) {
            $nuevaBusqueda = Busqueda::find($request->idBusqueda);
            //error_log($nuevaBusqueda->id);
                $tweets = HTTP::get('localhost:3000/tweets/searchv2Update/' . $searchWord . '&' . $request->fecha1 . '&' . $request->fecha2); //llamada al servicio de Twitter
                $youtubeVideos = HTTP::get('localhost:3001/youtube/searchUpdate/' . $searchWord . '&' . $request->fecha1 . '&' . $request->fecha2); //llamada al servicio de Youtube
                $googleNews = HTTP::get('localhost:3003/news/search/' . $searchWord); //llamada al servicio de Google News

                /*if(!isset($request->system_update)){
                    $r_facebook_search = Http::get('localhost:3015/rfb/buscar/'.$searchWord);
                }*/
                //$r_instagram_search = Http::get('localhost:3016/rig/buscar/'.$searchWord);
            //Caso Nueva Búsqueda
        } else {
            $tweets = HTTP::get('localhost:3000/tweets/searchv2/' . $searchWord . '&' . $request->fecha1 . '&' . $request->fecha2); //llamada al servicio de Twitter
                $youtubeVideos = HTTP::get('localhost:3001/youtube/search/' . $searchWord . '&' . $request->fecha1 . '&' . $request->fecha2); //llamada al servicio de Youtube
                $googleNews = HTTP::get('localhost:3003/news/search/' . $searchWord); //llamada al servicio de Google News
                /*if(!isset($request->user_id_on)){
                    $r_facebook_search = Http::get('localhost:3015/rfb/buscar/'.$searchWord);
                }*/
                //$r_instagram_search = Http::get('localhost:3016/rig/buscar/'.$searchWord);
        }
        //Columnas para la llamadas a servicios web
        //Columnas para la llamada a Twitter
        $dataTwitter = $tweets->json();
        //Codificación del json
        $json = json_decode($tweets);
        //Array con las filas que contienen la info
        if (isset($json->data)) {
            $rows = $json->data;
        }
        if (isset($json->includes->users)) {
            $twitterUsers = $json->includes->users;
        }
        if (isset($json->includes->media)) {
            $twitterMedia = $json->includes->media;
        }
        if (isset($json->includes->tweets)) {
            $twitterRetweets = $json->includes->tweets;
        }
        if (isset($json->includes->places)) {
            $twitterGeo = $json->includes->places;
        }
        //Columnas para la llamada a Youtube
        $dataYoutube = $youtubeVideos->json();
        //Codificación del json
        $jsonYoutube = json_decode($youtubeVideos);
        //Array con las filas que contienen la info
        if (isset($jsonYoutube->items)) {
            $rowsYoutube = $jsonYoutube->items;
        }

        //Columnas para la llamada a Google News
        if (isset($googleNews)) {
            $dataGNews = $googleNews->json();
            //Codificación del json
            $jsonGNews = json_decode($googleNews);
        }
        //Array con las filas que contienen la info
        if (isset($jsonGNews->rss->channel->item)) {
            $rowsGNews = $jsonGNews->rss->channel->item;
        }

        //Handler Resultados Asincronos: RFacebook
        /*if((!isset($request->user_id_on))&&(!isset($request->system_update))){
            $asyncDataRFB = json_decode($r_facebook_search);
        }*/
        //$asyncDataRIG = json_decode($r_instagram_search);
        //Definicion del Registro de la busqueda

        //$registro_busqueda = new BusquedaRegistro;

        //Definicion e Inserción de la busqueda
        if (isset($request->idBusqueda)) {
            error_log('EL ID ES!!: ' . $nuevaBusqueda->id);
            $nuevaBusqueda->fecha_inicial = $request->uFecha1;
            $nuevaBusqueda->fecha_final = $request->uFecha2;
            $nuevaBusqueda->updated_at = Carbon::now();
            $nuevaBusqueda->save(['timestamps' => false]);
            //$nuevaBusqueda->save();
            error_log('LA FECHA SE ACTUALIZO A: ' . $nuevaBusqueda->fecha_inicial . ' y ' . $nuevaBusqueda->fecha_final);
            error_log('updated_at: ' . $nuevaBusqueda->updated_at);

        //$registro_busqueda = RegistroBusqueda::where('busqueda_id',$nuevaBusqueda->id)->first();
                    //$registro_busqueda->twitter = 'Actualizando';
                    //$registro_busqueda->youtube = 'Actualizando';
                    //$registro_busqueda->google = 'Actualizando';
                    //$registro_busqueda->facebook = 'Actualizando';
        } else {
            //Si es una busqueda nueva
            $nuevaBusqueda = new Busqueda();
            $nuevaBusqueda->json_busqueda = $tweets;
            $nuevaBusqueda->json_youtube = $youtubeVideos;
            $nuevaBusqueda->nombre_busqueda = $request->nombreBusqueda;
            $nuevaBusqueda->palabra_busqueda = $searchWord;
            $nuevaBusqueda->fecha_inicial_original = $request->fecha1;
            $nuevaBusqueda->fecha_inicial = $request->fecha1;
            $nuevaBusqueda->fecha_final = $request->fecha2;
            if (isset($request->user_id_on)) {
                $nuevaBusqueda->user_id = $request->user_id_on;
            } else {
                $nuevaBusqueda->user_id = auth()->id();
            }
            $nuevaBusqueda->save();
            $nuevaBusqueda->campañas()->attach($request->campañas_select);
            $nuevaBusqueda->save();

            //Google Ads Keyword Ideas para una nueva busqueda
            $kw_rqst = new Request();
            $kw_rqst->b_id = $nuevaBusqueda->id;
            $kw_rqst->words = $searchWord;
            $kw_ctrl->main($kw_rqst);

            //$registro_busqueda->busqueda_id = $nuevaBusqueda->id;
                    //$registro_busqueda->user_id = auth()->id();

                    //Columnas de registro por defecto en pendiente
        }
        //$registro_busqueda->save();

        //Inserción en el modelo de Resultados Asincronos: RFacebook
        $requestAsyncResultFB = new Request();

        /*if(isset($request->system_update)||isset($request->user_id_on)){
            $requestAsyncResultFB->code = 'Codigo Pendiente';
            $requestAsyncResultFB->status = 'Codigo Pendiente';
        }else{
            $requestAsyncResultFB->code = $asyncDataRFB->code;
            $requestAsyncResultFB->status = 'Pendiente';
        }*/
        $requestAsyncResultFB->code = 'Codigo Pendiente';
        $requestAsyncResultFB->status = 'Codigo Pendiente';

        $requestAsyncResultFB->source = 'Facebook';
        $requestAsyncResultFB->busqueda_id = $nuevaBusqueda->id;
        $requestAsyncResultFB->user_id = $nuevaBusqueda->user_id;
        $this->insertarResultadosAsincronos($requestAsyncResultFB);
        //Inserción en el modelo de Resultados Asincronos: RInstagram
        /*Stand-By por el momento
        $requestAsyncResultIG = new Request;
        $requestAsyncResultIG->code = $asyncDataRIG->code;
        $requestAsyncResultIG->source = 'Instagram';
        $requestAsyncResultIG->status = 'Pendiente';
        $requestAsyncResultIG->busqueda_id = $nuevaBusqueda->id;
        $requestAsyncResultIG->user_id = auth()->id();
        $this->insertarResultadosAsincronos($requestAsyncResultIG);
        */

        //Iteracion y extraccion de info de los resultados de Twitter para posterior inserción en BDD
        if (isset($rows)) {
            //variable que guarda un retweet analizado, puesto que por ahora pregunta muchas veces por el mismo tweet y eso quita bastante tiempo.
            $rt_analizados = [];

            foreach ($rows as $current_tweet) {
                $id_tweet = $current_tweet->id;
                $tweet = $current_tweet->text;
                $rts = $current_tweet->public_metrics->retweet_count;
                $url_imagen = 'Sin imagen';

                foreach ($twitterUsers as $tw_user) {
                    if ($tw_user->id == $current_tweet->author_id) {
                        $usuario = $tw_user->username;
                        $followers = $tw_user->public_metrics->followers_count;

                        break;
                    }
                }

                //error_log('Current Tweet: '.$current_tweet->created_at);
                $date = new DateTime($current_tweet->created_at);
                $date->modify('-4 hours');
                $date->format('d-m-Y HH:mm:ss');
                $creacionTweet = $date;

                $geo_nombre = 'Sin referencia';

                //Si referenced_tweets->type es igual a "retweeted" se deben asignar las interacciones y la imagen del retweeteado, ya se tienen las viralizaciones, solo se extrae imagen y likes; se agrega la geo
                if (isset($current_tweet->referenced_tweets[0]) && $current_tweet->referenced_tweets[0]->type === 'retweeted') {
                    $id_tweet_rt = $current_tweet->referenced_tweets[0]->id;
                    //error_log('EVALUANDO '.$id_tweet_rt);
                    //Preguntar si este id esta en algun retweet que ya fue analizado
                    $id_analizado = false;
                    $objeto_analizado = new stdClass();

                    $found_id_first = array_filter($rt_analizados, function ($field) use ($id_tweet_rt) {
                        if ($field->id === $id_tweet_rt) {
                            return true;
                        }

                        return false;
                    });
                    $found_obj = reset($found_id_first);

                    if ($found_obj) {
                        //error_log('LO ENCONTRE');
                        $id_analizado = true;
                        $objeto_analizado = $found_obj;
                    }

                    //foreach($rt_analizados as $analizado){error_log('COMP '.$id_tweet_rt.' CON '.$analizado->id);if($analizado->id == $id_tweet_rt){error_log('EXISTENTE '.$id_tweet_rt);$id_analizado=true;$objeto_analizado=$analizado;break;}}

                    if (!$id_analizado) {
                        $analizado = new stdClass();
                        $analizado->id = $id_tweet_rt;
                        $analizado->url_imagen = 'Sin imagen';
                        $analizado->geo_nombre = 'Sin referencia';
                        //error_log('NO EXISTENTE '.$id_tweet_rt);
                        //buscar el id en el arreglo de include->tweets
                        foreach ($twitterRetweets as $tw_retweeted) {
                            if ($id_tweet_rt == $tw_retweeted->id) {
                                $favs = $tw_retweeted->public_metrics->like_count;
                                //Si el tweet referenciado tiene lugar se consulta el tweet por id para capturar geo_nombre OR
                                //Si el tweet referenciado tiene imagen se consulta el tweet por id para capturar su imagen y //Datos del usuario de la publicación retweeteada (Esto esta comentado. no se hace)
                                if (isset($tw_retweeted->attachments->media_keys) || isset($tw_retweeted->geo->place_id) || isset($tw_retweeted->entities->urls[0]->images[0]->url)) {
                                    $retweeted = HTTP::get('localhost:3000/tweets/id/' . $id_tweet_rt); //Tweet por ID
                                    $dataRT = $retweeted->json();
                                    $jsonRT = json_decode($retweeted);

                                    if (isset($jsonRT->includes->media)) {
                                        $mediaRT = $jsonRT->includes->media;
                                        foreach ($mediaRT as $media_tw_retweeted) {
                                            if ($tw_retweeted->attachments->media_keys[0] === $media_tw_retweeted->media_key) {
                                                if ($media_tw_retweeted->type === 'photo') {
                                                    $url_imagen = $media_tw_retweeted->url;
                                                    $analizado->url_imagen = $media_tw_retweeted->url;

                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    if (isset($jsonRT->includes->places)) {
                                        $placesRT = $jsonRT->includes->places;
                                        foreach ($placesRT as $place_tw_retweeted) {
                                            if ($tw_retweeted->geo->place_id === $place_tw_retweeted->id) {
                                                $geo_nombre = $place_tw_retweeted->full_name;
                                                $analizado->geo_nombre = $place_tw_retweeted->full_name;

                                                break;
                                            }
                                        }
                                    }
                                    if (isset($jsonRT->data->entities->urls[0]->images[0]->url)) {
                                        $rowsRT = $jsonRT->data;
                                        if ($url_imagen = 'Sin imagen') {
                                            if (isset($rowsRT->entities->urls[0]->images[0]->url)) {
                                                $url_imagen = $rowsRT->entities->urls[0]->images[0]->url;
                                                $analizado->url_imagen = $rowsRT->entities->urls[0]->images[0]->url;

                                                break;
                                            }
                                        }
                                    }
                                }

                                break;
                            }
                        }
                        //error_log('GUARDADO '.$analizado->id);
                        $rt_analizados[] = $analizado;
                    } else {
                        //El id ya fue analizado antes
                        $url_imagen = $objeto_analizado->url_imagen;
                        $geo_nombre = $objeto_analizado->geo_nombre;
                    }
                } else {
                    $favs = $current_tweet->public_metrics->like_count;
                    if (isset($current_tweet->geo->place_id)) {
                        foreach ($twitterGeo as $tw_geo) {
                            if ($current_tweet->geo->place_id === $tw_geo->id) {
                                $geo_nombre = $tw_geo->full_name;

                                break;
                            }
                        }
                    }
                    if (isset($current_tweet->attachments)) {
                        foreach ($twitterMedia as $tw_media) {
                            if ($current_tweet->attachments->media_keys[0] === $tw_media->media_key) {
                                if ($tw_media->type === 'photo') {
                                    $url_imagen = $tw_media->url;

                                    break;
                                }
                            }
                        }
                    }
                    if (isset($current_tweet->entities->urls[0]->images[0]->url)) {
                        if ($url_imagen === 'Sin imagen') {
                            $url_imagen = $current_tweet->entities->urls[0]->images[0]->url;
                            //error_log('URL IMAGEN = '. $url_imagen);
                        }
                    }
                }
                //Consulta
                $request = new Request();
                $request->id_tweet = $id_tweet;
                $request->tweet = $tweet;
                $request->rts = $rts;
                $request->favs = $favs;
                $request->url_imagen = $url_imagen;
                $request->geo = $geo_nombre;
                $request->usuario = $usuario;
                $request->followers = $followers;
                $request->fechaCreacion = $creacionTweet;
                $request->busqueda_id = $nuevaBusqueda->id;
                $request->busqueda = $nuevaBusqueda;

                //Insertamos los datos en la base de datos
                $this->insertarTweets($request);
            }
            //$registro_busqueda->twitter = 'OK';
                //$registro_busqueda->save();
        }
        //Iteracion y extraccion de info de los resultados de Youtube para posterior inserción en BDD
        if (isset($rowsYoutube)) {
            foreach ($rowsYoutube as $current_yt) {
                $id_video = $current_yt->id->videoId;
                $description = $current_yt->snippet->title;
                $description_of_video = $current_yt->snippet->description;
                $id_channel = $current_yt->snippet->channelId;

                //Consulta para obtener los datos de un video por ID
                $consultaVideoByID = HTTP::get('localhost:3001/youtube/searchVideo/' . $id_video);
                //Codificación del json
                $jsonVideoByID = json_decode($consultaVideoByID);
                //Array con las filas que contienen la info del video
                if (isset($jsonVideoByID->items)) {
                    $rowsVideoByID = $jsonVideoByID->items;
                }
                if (isset($rowsVideoByID[0]->statistics->commentCount)) {
                    $views = $rowsVideoByID[0]->statistics->commentCount; //Comentarios sumados a Viralizaciones
                } else {
                    $views = 0;
                }

                if (isset($rowsVideoByID[0]->statistics->likeCount)) {
                    $likes = $rowsVideoByID[0]->statistics->likeCount;
                    $likes += $rowsVideoByID[0]->statistics->dislikeCount; //Sumar Dislikes a Interacciones
                            $likes += $rowsVideoByID[0]->statistics->viewCount; //Sumar Vistas del video a Interacciones
                } else {
                    $likes = 0;
                }

                $url_thumbnail = $current_yt->snippet->thumbnails->high->url;
                $channel_name = $current_yt->snippet->channelTitle;

                //Consulta para obtener los datos de un canal por ID
                $consultaChannelByID = HTTP::get('localhost:3001/youtube/searchChannel/' . $current_yt->snippet->channelId);
                //Codificación del json
                $jsonChannelByID = json_decode($consultaChannelByID);
                //Array con las filas que contienen la info del video
                if (isset($jsonChannelByID->items)) {
                    $rowsChannelByID = $jsonChannelByID->items;
                    if (isset($rowsChannelByID[0]->statistics->subscriberCount)) {
                        $channel_subs = $rowsChannelByID[0]->statistics->subscriberCount;
                    } else {
                        $channel_subs = 0;
                    }
                } else {
                    $channel_subs = 0;
                }

                $date_video = new DateTime($current_yt->snippet->publishTime);
                $date_video->format('d-m-Y HH:mm:ss');
                $upload_date = $date_video;

                //Consulta
                $requestVideo = new Request();
                $requestVideo->id_video = $id_video;
                $requestVideo->id_channel = $id_channel;
                $requestVideo->description = $description;
                $requestVideo->views = $views;
                $requestVideo->likes = $likes;
                $requestVideo->url_imagen = $url_thumbnail;
                $requestVideo->channel_name = $channel_name;
                $requestVideo->channel_subs = $channel_subs;
                $requestVideo->upload_date = $upload_date;
                $requestVideo->busqueda_id = $nuevaBusqueda->id;
                $requestVideo->busqueda = $nuevaBusqueda;

                /*
                $generator_1 = '$rrr=preg_match("/(' . implode(')/i","'.$description.'") && preg_match("/(', $_kw_arr_) . ')/i","'.$description.'"); if($rrr){return true;}else{return false;}';
                $generator_2 = '$rrr2=preg_match("/(' . implode(')/i","'.$description_of_video.'") && preg_match("/(', $_kw_arr_) . ')/i","'.$description_of_video.'"); if($rrr2){return true;}else{return false;}';
                $generator_3 = '$rrr3=preg_match("/(' . implode(')/i","'.$channel_name.'") && preg_match("/(', $_kw_arr_) . ')/i","'.$channel_name.'"); if($rrr3){return true;}else{return false;}';
                if(
                stripos($description, $searchWord) or
                stripos($description_of_video, $searchWord) or
                stripos($channel_name, $searchWord)
                ){
                if(eval($generator_1) or eval($generator_2) or eval($generator_3)){
                */

                //Evaluar si el video cumple las condiciones de las keywords
                $_kw_arr_ = explode(' ', $searchWord);
                //Insertamos los datos en la base de datos
                if (preg_match('/^(?=.*' . implode(')(?=.*', $_kw_arr_) . ')/i', $description . ' ' . $description_of_video . ' ' . $channel_name)) {
                    //Si todas las palabras de la busqueda estan incluidas en alguno de los campos del video (descripcion,autor,titulo) se insertan
                    $this->insertarYoutubeVideos($requestVideo);
                } else {
                    //Si la descripcion no contiene las keywords se va a la tabla de eliminados
                    $this->deletedYoutubeVideo($requestVideo);
                }
            }
            //$registro_busqueda->youtube = 'OK';
                //$registro_busqueda->save();
        }
        //Iteracion y extraccion de info de los resultados de Google News para posterior inserción en BDD
        if (isset($rowsGNews)) {
            if (is_array($rowsGNews)) {
                for ($i = 0; $i < count($rowsGNews); ++$i) {
                    $date = new DateTime($rowsGNews[$i]->pubDate->_text);
                    $date->format('d-m-Y HH:mm:ss');
                    $published_date = $date;

                    $dateSearch = new DateTime($nuevaBusqueda->fecha_inicial_original . 'T00:00:00Z');
                    $dateSearch->format('d-m-Y HH:mm:ss');

                    $testDate = $published_date >= $dateSearch && $published_date <= $nuevaBusqueda->updated_at;
                    $TestEquallity = GoogleNewsArticle::where('link', $rowsGNews[$i]->link->_text)->where('busqueda_id', $nuevaBusqueda->id)->first();
                    //if($TestEquallity){
                    //  error_log($TestEquallity->link);
                    //}
                    if (!$TestEquallity && $testDate) {
                        error_log('Noticia agregada: ' . $rowsGNews[$i]->pubDate->_text);
                        $title = $rowsGNews[$i]->title->_text;
                        $link = $rowsGNews[$i]->link->_text;
                        $description = $rowsGNews[$i]->description->_text;
                        $source = $rowsGNews[$i]->source->_text;

                        $date = new DateTime($rowsGNews[$i]->pubDate->_text);
                        $date->format('d-m-Y HH:mm:ss');
                        $published_date = $date;

                        //Consulta
                        $request = new Request();
                        $request->title = $title;
                        $request->link = $link;
                        $request->description = $description;
                        $request->source = $source;
                        $request->published_date = $published_date;
                        $request->busqueda_id = $nuevaBusqueda->id;
                        $request->busqueda = $nuevaBusqueda;

                        //Insertamos los datos en la base de datos
                        $this->insertarGoogleNewsArticles($request);
                    }
                }
            }
            //$registro_busqueda->google = 'OK';
                //$registro_busqueda->save();
        }

        //Redirección a la vista de consulta resultados
        return redirect('/tables/consulta_resultados');
    }

    public function insertarTweets(Request $request)
    {
        $nuevoTweet = new Tweet();

        $nuevoTweet->id_tweet = $request->id_tweet;
        $nuevoTweet->tweet = $request->tweet;
        $nuevoTweet->rt = $request->rts;
        $nuevoTweet->fav = $request->favs;
        $nuevoTweet->url_imagen = $request->url_imagen;
        $nuevoTweet->geo = $request->geo;
        $nuevoTweet->usuario = $request->usuario;
        $nuevoTweet->followers = $request->followers;
        $nuevoTweet->fecha_creacion = $request->fechaCreacion;
        $nuevoTweet->busqueda_id = $request->busqueda_id;

        $nuevoTweet->save();

        $new_reporte = new Reporte();
        $new_reporte->fuente = 'Twitter';
        $new_reporte->link = 'https://twitter.com/' . $request->usuario . '/status/' . $request->id_tweet;
        $new_reporte->autor = $request->usuario;
        $new_reporte->fecha = $request->fechaCreacion->format('d-m-Y');
        $new_reporte->hora = $request->fechaCreacion->format('H:m:s');
        $new_reporte->seguidores = $request->followers;
        $new_reporte->interacciones = $request->favs;
        $new_reporte->viralizaciones = $request->rts;
        $new_reporte->impacto = 0;
        $new_reporte->etiquetas = '';
        $new_reporte->mensaje = $request->tweet;
        $new_reporte->id_db = $nuevoTweet->id;
        $new_reporte->keywords_busqueda = $request->busqueda->palabra_busqueda;
        $new_reporte->nombre_busqueda = $request->busqueda->nombre_busqueda;

        $c = Campania::where('id', $request->busqueda->campañas[0]->id)->first();
        $b = $c->busquedas;

        $kw_camp = '';
        foreach ($b as &$busqueda) {
            $kw_camp = $kw_camp . ',' . $busqueda->palabra_busqueda;
        }

        $new_reporte->nombre_campania = $c->nombre_campania;
        $new_reporte->busqueda_id = $request->busqueda_id;
        $new_reporte->campania_id = $c->id;
        $new_reporte->keywords_campania = $kw_camp;
        $new_reporte->save();

        return back()->with('mensaje', 'Tweets agregados');
    }

    public function insertarYoutubeVideos(Request $request)
    {
        $nuevoVideo = new YoutubeVideo();

        $nuevoVideo->id_video = $request->id_video;
        $nuevoVideo->id_channel = $request->id_channel;
        $nuevoVideo->description = $request->description;
        $nuevoVideo->views = $request->views;
        $nuevoVideo->likes = $request->likes;
        $nuevoVideo->url_imagen = $request->url_imagen;
        $nuevoVideo->channel_name = $request->channel_name;
        $nuevoVideo->channel_subs = $request->channel_subs;
        $nuevoVideo->upload_date = $request->upload_date;
        $nuevoVideo->busqueda_id = $request->busqueda_id;

        $nuevoVideo->save();

        $new_reporte = new Reporte();
        $new_reporte->fuente = 'Youtube';
        $new_reporte->link = 'https://www.youtube.com/watch?v=' . $request->id_video;
        $new_reporte->autor = $request->channel_name;
        $new_reporte->fecha = $request->upload_date->format('d-m-Y');
        $new_reporte->hora = $request->upload_date->format('H:m:s');
        $new_reporte->seguidores = $request->channel_subs;
        $new_reporte->interacciones = $request->likes;
        $new_reporte->viralizaciones = $request->views;
        $new_reporte->impacto = 0;
        $new_reporte->etiquetas = '';
        $new_reporte->mensaje = $request->description;
        $new_reporte->id_db = $nuevoVideo->id;
        $new_reporte->keywords_busqueda = $request->busqueda->palabra_busqueda;
        $new_reporte->nombre_busqueda = $request->busqueda->nombre_busqueda;

        $c = Campania::where('id', $request->busqueda->campañas[0]->id)->first();
        $b = $c->busquedas;

        $kw_camp = '';
        foreach ($b as &$busqueda) {
            $kw_camp = $kw_camp . ',' . $busqueda->palabra_busqueda;
        }

        $new_reporte->nombre_campania = $c->nombre_campania;
        $new_reporte->busqueda_id = $request->busqueda_id;
        $new_reporte->campania_id = $c->id;
        $new_reporte->keywords_campania = $kw_camp;
        $new_reporte->save();

        return back()->with('mensaje', 'Videos agregados');
    }

    public function insertarGoogleNewsArticles(Request $request)
    {
        $nuevoArticulo = new GoogleNewsArticle();

        $nuevoArticulo->title = $request->title;
        $nuevoArticulo->link = $request->link;
        $nuevoArticulo->published_date = $request->published_date;
        $nuevoArticulo->description = $request->description;
        $nuevoArticulo->source = $request->source;
        $nuevoArticulo->busqueda_id = $request->busqueda_id;

        $nuevoArticulo->save();

        $new_reporte = new Reporte();
        $new_reporte->fuente = 'Google News';
        $new_reporte->link = $request->link;
        $new_reporte->autor = $request->source;
        $new_reporte->fecha = $request->published_date->format('d-m-Y');
        $new_reporte->hora = $request->published_date->format('H:m:s');
        $new_reporte->seguidores = 0;
        $new_reporte->interacciones = 0;
        $new_reporte->viralizaciones = 0;
        $new_reporte->impacto = 0;
        $new_reporte->etiquetas = '';
        $new_reporte->mensaje = $request->description;
        $new_reporte->id_db = $nuevoArticulo->id;
        $new_reporte->keywords_busqueda = $request->busqueda->palabra_busqueda;
        $new_reporte->nombre_busqueda = $request->busqueda->nombre_busqueda;

        $c = Campania::where('id', $request->busqueda->campañas[0]->id)->first();
        $b = $c->busquedas;

        $kw_camp = '';
        foreach ($b as &$busqueda) {
            $kw_camp = $kw_camp . ',' . $busqueda->palabra_busqueda;
        }

        $new_reporte->nombre_campania = $c->nombre_campania;
        $new_reporte->busqueda_id = $request->busqueda_id;
        $new_reporte->campania_id = $c->id;
        $new_reporte->keywords_campania = $kw_camp;
        $new_reporte->save();

        return back()->with('mensaje', 'Articulos agregados');
    }

    public function insertarResultadosAsincronos(Request $request)
    {
        $new_async_result = new AsyncResult();

        $new_async_result->code = $request->code;
        $new_async_result->source = $request->source;
        $new_async_result->status = $request->status;
        $new_async_result->busqueda_id = $request->busqueda_id;
        $new_async_result->user_id = $request->user_id;

        $new_async_result->save();

        return back()->with('mensaje', 'Resultados asincronos agregados con exito');
    }

    public function deletedYoutubeVideo(Request $request): void
    {
        $deleted_youtube_video = new DeletedYoutubeVideo();
        $deleted_youtube_video->id_video = $request->id_video;
        $deleted_youtube_video->id_channel = $request->id_channel;
        $deleted_youtube_video->description = $request->description;
        $deleted_youtube_video->views = $request->views;
        $deleted_youtube_video->likes = $request->likes;
        $deleted_youtube_video->url_imagen = $request->url_imagen;
        $deleted_youtube_video->channel_name = $request->channel_name;
        $deleted_youtube_video->channel_subs = $request->channel_subs;
        $deleted_youtube_video->upload_date = $request->upload_date;
        $deleted_youtube_video->busqueda_id = $request->busqueda_id;
        $deleted_youtube_video->tags = '';
        $deleted_youtube_video->save();
        error_log('Video eliminado: ' . $request->id_video);
    }

    public function eliminar_tildes($str)
    {
        $str = str_replace(
            ['á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú'],
            ['a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U'],
            $str
        );

        return $str;
    }
}
