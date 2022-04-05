<?php

namespace App\Http\Controllers;

use App\Models\AsyncResult;
use App\Models\Busqueda;
use App\Models\BusquedaRegistro;
use App\Models\Campania;
use App\Models\Reporte;
use App\Models\RFacebookPost;
use App\Models\RInstagramPost;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AsyncSourcesController extends Controller
{
    public function facebookCheckStatus($code)
    {
        $data = Http::get('localhost:3015/rfb/consulta/' . $code);

        return $data->json();
    }

    public function facebookGetResults($code)
    {
        $data = Http::get('localhost:3015/rfb/obtiene/' . $code);
        $arr = json_decode($data);

        //$asyncResult = AsyncResult::where('code',$code)->where('status','Pendiente')->first();
        $asyncResult = AsyncResult::where('code', $code)->first();
        $busqueda = Busqueda::where('id', $asyncResult->busqueda_id)->first();
        //$registro_busqueda = BusquedaRegistro::where('busqueda_id',$busqueda->id)->first();
        $dateSearch = new DateTime($busqueda->fecha_inicial_original . 'T00:00:00Z');
        $dateSearch->format('d-m-Y HH:mm:ss');

        $cantidad_errores = 0;

        try {
            foreach ($arr as $element) {
                try {
                    $dateCheck = $this->checkDate($element->Post_Date);
                    $timeCheck = $this->checkHours($element->Post_hour);
                    $dateTimeToCheck = new Datetime($dateCheck . 'T' . $timeCheck . 'Z');
                    $testDate = $dateTimeToCheck >= $dateSearch && $dateTimeToCheck <= $asyncResult->updated_at;
                    $TestEquallity = RFacebookPost::where('url', $element->Post_Link)->where('busqueda_id', $asyncResult->busqueda_id)->first();
                    if (!$TestEquallity && $testDate) {
                        //if(!$TestEquallity){
                        error_log('Agregando post...: ' . $element->Post_Link);
                        $request = new Request();
                        $request->post_link = $element->Post_Link;
                        $request->post_likes = $this->checkLikes($element->Post_Likes);
                        $request->post_comments = $this->checkIntValues($element->Post_comments);
                        $request->post_shares = $this->checkIntValues($element->Post_Shares);
                        //viene con b' al inicio y con ' al final, se eliminan estos caracteres
                        $request->post_message = $this->checkMessage($element->Post_Message);
                        $request->post_image_url = $this->checkImage($element->Image_Link);

                        $post_date = $this->checkDate($element->Post_Date);
                        $post_hours = $this->checkHours($element->Post_hour);

                        //$request->post_date     =       '2021-07-12 18:33:55';
                        $request->post_date = $post_date . ' ' . $post_hours;
                        $request->post_followers = $this->checkFollowers($element->Followers);
                        $request->post_autor_url = $this->checkValue($element->Poster_Link);
                        $request->post_autor = $this->getNameByUrl($element->Poster_Link);
                        $request->busqueda_id = $asyncResult->busqueda_id;
                        $request->busqueda = $busqueda;
                        $request->fecha = $post_date;
                        $request->hora = $post_hours;

                        $this->insertarFacebookPosts($request);
                        error_log('Post agregado: ');
                        error_log($request->post_link);
                    }
                } catch (Exception $e) {
                    error_log('Post con elemento erroneo encontrado:');
                    error_log($element->Post_Link);
                    $from = 'sergio.aslacker@gmail.com';
                    $to = 'sergio@andestic.com';
                    $subject = 'Error de Facebook';
                    $message = 'Error en: ' . $element->Post_Link . ' Id del resultado en bdd:' . $asyncResult->id . ' Codigo: ' . $asyncResult->code;
                    $headers = 'From:' . $from;
                    //mail($to,$subject,$message, $headers);

                    ++$cantidad_errores;
                    $cantidad_errores == 1 ? Storage::append($code . ' - ' . date('Y-m-d') . '.txt', 'Busqueda ' . $asyncResult->busqueda_id . "\n") : null;
                    $cantidad_errores > 0 ? Storage::append($code . ' - ' . date('Y-m-d') . '.txt', $element->Post_Link) : null;
                    //return $message;
                    //$url_errores = $url_errores."\n".$element->Post_Link."\n".$e->getMessage()."\n";
                }
            }
            $asyncResult->status = 'OK';
            $asyncResult->save();
            //$registro_busqueda->facebook = 'OK';
            //$registro_busqueda->save();
            if ($cantidad_errores > 0) {
                return 'Resultados Cargados en la Busqueda ' . $asyncResult->busqueda_id . '. Errores en archivo: ' . $code . '.txt';
            }

            return 'Resultados Cargados con Exito en la Busqueda ' . $asyncResult->busqueda_id;

            //return $data->json();
        } catch (Exception $e) {
            error_log('ERROR DE JSON:');
            $from = 'sergio.aslacker@gmail.com';
            $to = 'sergio@andestic.com';
            $subject = 'Error de Facebook';
            $message = 'Error del JSON; Id del resultado en bdd:' . $asyncResult->id . ' Codigo: ' . $asyncResult->code;
            $headers = 'From:' . $from;
            //mail($to,$subject,$message, $headers);
            $asyncResult->status = 'ERROR';
            $asyncResult->save();
            //$registro_busqueda->facebook = 'ERROR';
            //$registro_busqueda->save();

            if ($arr == null) {
                return 'JSON vacío al intentar cargar resultados en la Busqueda ' . $asyncResult->busqueda_id . "\nLinea " . $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile();
            }
            Storage::append($code . ' - ' . date('Y-m-d') . '.json', $arr);

            return 'Error de Json al intentar cargar resultados en la Busqueda ' . $asyncResult->busqueda_id . ', Detalles en ' . $code . ' - ' . date('Y-m-d') . '.json' . "\nLinea " . $e->getLine() . ': ' . $e->getMessage() . "\n" . $e->getFile();
        }
    }

    public function instagramCheckStatus($code)
    {
        $data = Http::get('localhost:3016/rig/consulta/' . $code);

        return $data->json();
    }

    public function instagramGetResults($code)
    {
        $data = Http::get('localhost:3016/rig/obtiene/' . $code);
        $arr = json_decode($data);

        $asyncResult = AsyncResult::where('code', $code)->where('status', 'Pendiente')->first();
        $busqueda = Busqueda::where('id', $asyncResult->busqueda_id)->first();
        //$registro_busqueda = BusquedaRegistro::where('busqueda_id',$busqueda->id)->first();
        $dateSearch = new DateTime($busqueda->fecha_inicial_original . 'T00:00:00Z');
        $dateSearch->format('d-m-Y HH:mm:ss');

        try {
            foreach ($arr as $element) {
                try {
                    $dateCheck = $this->checkDate($element->Date);
                    $timeCheck = $this->checkInstagramHours($element->Time);
                    $dateTimeToCheck = new Datetime($dateCheck . 'T' . $timeCheck . 'Z');
                    $testDate = ($dateTimeToCheck >= $dateSearch) && ($dateTimeToCheck <= $asyncResult->updated_at);
                    error_log('TEST DATE...: ' . $testDate);
                    $TestEquallity = RInstagramPost::where('url', $element->Post_Url)->where('busqueda_id', $asyncResult->busqueda_id)->first();
                    if (!$TestEquallity && $testDate) {
                        //if(!$TestEquallity){
                        error_log('Agregando post de instagram...: ' . $element->Post_Url);
                        $request = new Request();
                        $request->url = $element->Post_Url;
                        $request->likes = $this->checkLikes($element->Post_Likes);
                        $request->comments = $this->checkIntValues($element->Num_of_Comments);
                        $request->followers = $this->checkIntValues($element->Author_Followers);
                        $request->autor_total_posts = $this->checkIntValues($element->Author_total_Posts);

                        $post_date = $this->checkDate($element->Date);
                        $post_hours = $this->checkInstagramHours($element->Time);

                        $request->date = $post_date . ' ' . $post_hours;
                        $request->message = $this->checkInstagramMessage($element->Message_Caption);
                        $request->autor_url = $this->checkValue($element->Author);
                        $request->autor = $this->getNameByUrl($element->Author);
                        $request->image_url = $this->checkNullPhoto($element->Photo);
                        $request->busqueda_id = $asyncResult->busqueda_id;

                        $this->insertarInstagramPosts($request);
                        error_log('Post de instagram agregado: ');
                        error_log($request->url);
                    }
                } catch (Exception $e) {
                    error_log('Post de Instagram con elemento erroneo encontrado:');
                    error_log($element->Post_Url);
                    $from = 'sergio.aslacker@gmail.com';
                    $to = 'sergio@andestic.com';
                    $subject = 'Error de Instagram';
                    $message = 'Error en: ' . $element->Post_Url . ' Id del resultado en bdd:' . $asyncResult->id . ' Codigo: ' . $asyncResult->code;
                    $headers = 'From:' . $from;
                    mail($to, $subject, $message, $headers);
                    $asyncResult->status = 'ERROR';
                    $asyncResult->save();
                }
            }
            $asyncResult->status = 'OK';
            $asyncResult->save();
            //$registro_busqueda->instagram = 'OK';
            //$registro_busqueda->save();
            return $data->json();
        } catch (Exception $e) {
            error_log('ERROR DE JSON de Instagram:');
            $from = 'sergio.aslacker@gmail.com';
            $to = 'sergio@andestic.com';
            $subject = 'Error de Instagram';
            $message = 'Error del JSON; Id del resultado en bdd:' . $asyncResult->id . ' Codigo: ' . $asyncResult->code;
            $headers = 'From:' . $from;
            mail($to, $subject, $message, $headers);
            $asyncResult->status = 'ERROR';
            $asyncResult->save();
            //$registro_busqueda->instagram = 'ERROR';
            //$registro_busqueda->save();
            return $data->json();
        }
    }

    public function checkFollowers($value)
    {
        if ($value == 'None') {
            return 0;
        }

        return str_replace(',', '', $value);
    }

    public function checkLikes($value)
    {
        if ($value == 'None') {
            return 0;
        }

        return (int) (explode(' ', $value)[0]);
    }

    public function checkIntValues($value)
    {
        if ($value == 'None') {
            return 0;
        }

        return (int) $value;
    }

    public function checkValue($value)
    {
        if ($value == 'None') {
            return 0;
        }

        return $value;
    }

    public function checkImage($value)
    {
        if ($value == 'None') {
            return 'Sin imagen';
        }

        return $value;
    }

    public function checkDate($value)
    {
        $today = date('Y-m-d');
        if ($value == 'Yesterday') {
            return date('Y-m-d', strtotime($today . '- 1 days'));
        }
        if (substr($value, -2) == 'hr') {
            $resta = (int) (explode(' ', $value)[0]);

            return date('Y-m-d', strtotime($today . '-' . $resta . 'hours'));
        }
        if (substr($value, -4) == 'mins') {
            $resta = (int) (explode(' ', $value)[0]);

            return date('Y-m-d', strtotime($today . '-' . $resta . 'minute'));
        }
        if ($value == 'None') {
        }

        return date('Y-m-d', strtotime($value));
    }

    public function checkHours($value)
    {
        if (substr($value, -2) == 'AM') {
            return date('H:i:s', strtotime(substr($this->checkNumber(explode(':', explode(' ', $value)[0])[0]) . ':' . explode(':', $value)[1], 0, -2)));
        }
        if (substr($value, -2) == 'PM') {
            if (explode(':', $value)[0] == 12) {
                //return substr($this->checkNumber(0).':'.explode(":", $value)[1],0,-2);
                return date('H:i:s', strtotime(substr($this->checkNumber(0) . ':' . explode(':', $value)[1], 0, -2)));
            }
            //return substr($this->checkNumber(intval(explode(":", $value)[0])+12).':'.explode(":", $value)[1],0,-2);
            return date('H:i:s', strtotime(substr($this->checkNumber((int) (explode(':', explode(' ', $value)[0])[0]) + 12) . ':' . explode(':', $value)[1], 0, -2)));
        }
        if (substr($value, -7) == 'hrs ago') {
            $today = date('H:i:s');
            $resta = (int) (explode(' ', $value)[0]);

            return date('H:i:s', strtotime($today . '-' . $resta . 'hours'));
        }
    }

    public function checkNumber($number)
    {
        if ($number < 10) {
            return '0' . $number;
        }

        return $number;
    }

    public function checkMessage($value)
    {
        if ($value == 'None') {
            return 'Sin contenido';
        }

        return substr($value, 2, -1);
    }

    public function getNameByUrl($url)
    {
        if ($url == 'None') {
            return 'Sin autor';
        }
        $cadena = explode('/', $url)[3];
        if (strpos($cadena, '?__tn__=C-R')) {
            return str_replace('?__tn__=C-R', '', $cadena);
        }

        return $cadena;
    }

    public function checkNullPhoto($urls)
    {
        if ($urls == null) {
            return 'Sin imagen';
        }

        return explode(',', explode(' ', $urls)[0])[0];
    }

    public function checkInstagramHours($value)
    {
        $today = date('H:i:s');
        $resta = (int) (explode(' ', $value)[0]);

        if (str_contains($value, 'minute')) {
            return date('H:i:s', strtotime($today . '-' . $resta . 'minute'));
        } elseif (str_contains($value, 'hour')) {
            return date('H:i:s', strtotime($today . '-' . $resta . 'hours'));
        } elseif (str_contains($value, 'day')) {
            return date('H:i:s', strtotime($today));
        }

        return date('H:i:s', strtotime($today));
    }

    public function checkInstagramMessage($value)
    {
        if ($value == 'None') {
            return 'Sin contenido';
        }

        return $value;
    }

    public function insertarFacebookPosts(Request $request)
    {
        $nuevoFacebookPost = new RFacebookPost();

        $nuevoFacebookPost->url = $request->post_link;
        $nuevoFacebookPost->likes = $request->post_likes;
        $nuevoFacebookPost->comments = $request->post_comments;
        $nuevoFacebookPost->shares = $request->post_shares;
        $nuevoFacebookPost->message = $request->post_message;
        $nuevoFacebookPost->image_url = $request->post_image_url;
        $nuevoFacebookPost->date = $request->post_date;
        $nuevoFacebookPost->followers = $request->post_followers;
        $nuevoFacebookPost->autor_url = $request->post_autor_url;
        $nuevoFacebookPost->autor = $request->post_autor;
        $nuevoFacebookPost->busqueda_id = $request->busqueda_id;

        $nuevoFacebookPost->save();

        $new_reporte = new Reporte();
        $new_reporte->fuente = 'Facebook';
        $new_reporte->link = $request->post_link;
        $new_reporte->autor = $request->post_autor;
        $new_reporte->fecha = $request->fecha;
        $new_reporte->hora = $request->hora;
        $new_reporte->seguidores = $request->post_followers;
        $new_reporte->interacciones = $request->post_likes;
        //Comentarios sumados en viralizaciones en reporte
        $new_reporte->viralizaciones = $request->post_shares + $request->post_comments;
        $new_reporte->impacto = 0;
        $new_reporte->etiquetas = '';
        $new_reporte->mensaje = $request->post_message;
        $new_reporte->id_db = $nuevoFacebookPost->id;
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

        return back()->with('mensaje', 'Posts de Facebook agregados');
    }

    public function insertarInstagramPosts(Request $request)
    {
        $nuevoInstagramPost = new RInstagramPost();

        $nuevoInstagramPost->url = $request->url;
        $nuevoInstagramPost->likes = $request->likes;
        $nuevoInstagramPost->comments = $request->comments;
        $nuevoInstagramPost->followers = $request->followers;
        $nuevoInstagramPost->autor_total_posts = $request->autor_total_posts;
        $nuevoInstagramPost->date = $request->date;
        $nuevoInstagramPost->message = $request->message;
        $nuevoInstagramPost->autor_url = $request->autor_url;
        $nuevoInstagramPost->autor = $request->autor;
        $nuevoInstagramPost->image_url = $request->image_url;
        $nuevoInstagramPost->busqueda_id = $request->busqueda_id;

        $nuevoInstagramPost->save();

        return back()->with('mensaje', 'Posts de Instagram agregados');
    }

    public function getAllAsyncResults()
    {
        return AsyncResult::where('user_id', auth()->id())->where('status', 'Pendiente')->get();
    }

    public function getAllAsyncResultsSys()
    {
        return AsyncResult::where('status', 'Pendiente')->get();
    }
}
