<?php

/**
 * Copyright 2018 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

//namespace Google\Ads\GoogleAds\Examples\Planning;

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';
use App\Models\Busqueda;
use App\Models\Campania;
use App\Models\OnboardingBusqueda;
use Illuminate\Http\Request;

class Onboarding extends Controller
{
    public static function mxIllcj4eviICPDss1oc(Request $request): void
    {
        //$words_busquedas = [$request->word1,$request->word2,$request->word3];
        //return dd($words_busquedas);
        //Crear Campaña, se requieren los parámetros
        //$string nombre_campaña
        //$integer user_id

        $nuevaCampaña = new Campania();
        $nuevaCampaña->nombre_campania = $request->nombre_campania;
        $nuevaCampaña->user_id = $request->user_id;
        $nuevaCampaña->save();

        //Crear 3 búsquedas de la campaña
        $controller = resolve('App\Http\Controllers\TwitterWSController');

        $words_busquedas = [$request->word1, $request->word2, $request->word3];
        foreach ($words_busquedas as $b) {
            $onb = new OnboardingBusqueda();
            $onb->estado = 'No ejecutada';
            $onb->nombre_busqueda = $request->nombre_campania . ' - ' . ucfirst($b);
            $onb->palabra_busqueda = ucfirst($b);
            $onb->fecha_inicial = date('Y-m-d', strtotime(date('Y-m-d') . '- 3 days'));
            $onb->fecha_final = date('Y-m-d', strtotime(date('Y-m-d')));
            $onb->campania_id = $nuevaCampaña->id;
            $onb->user_id = $request->user_id;
            $onb->save();
            /*
            $request_new_busqueda = new Request;
            $request_new_busqueda->palabraClave = $b;
            $request_new_busqueda->nombreBusqueda = $request->nombre_campania.' - '.$b;
            $request_new_busqueda->fecha1 = date("Y-m-d", strtotime(date("Y-m-d")."- 1 days"));
            $request_new_busqueda->fecha2 = date("Y-m-d", strtotime(date("Y-m-d")));
            $request_new_busqueda->campañas_select = [$nuevaCampaña->id];
            $request_new_busqueda->user_id_on = $request->user_id;
            try {
                $funcion=$controller->losTweets($request_new_busqueda);
            } catch (\Exception $e) {
                echo $e;
            }
            */
        }
    }

    public function success()
    {
        return view('successonboarding');
    }
}
