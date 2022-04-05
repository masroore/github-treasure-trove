<?php

namespace App\Http\Controllers;

use App\Models\Busqueda;
use App\Models\Campania;
use App\Models\SocialProfile;

class MDashboardController extends Controller
{
    public function searchById($id)
    {
        $profileimage = $this->getProfileImage();
        if ($id[0] == 'c') {
            //Se trata de una campaña
            $id = substr($id, 1);
            $data = Campania::where('user_id', auth()->id())->where('id', $id)->get();
            //COMO SOLO PUEDEV VER CAMPAÑAS O BUSQUEDAS AUTH, DEBEMOS VALIDAR UNA VISTA PARA CUANDO NO SE CUMPLE ESA CONDICION
            return view('dashboard/tables/menu_dashboard', compact('data', 'profileimage'));
        }//Se trata de una busqueda

        $data = Busqueda::where('user_id', auth()->id())->where('id', $id)->get();

        return view('dashboard/tables/menu_dashboard', compact('data', 'profileimage'));
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

    public function searchById_test($id)
    {
        $profileimage = $this->getProfileImage();
        if ($id[0] == 'c') {
            //Se trata de una campaña
            $id = substr($id, 1);
            $data = Campania::where('user_id', auth()->id())->where('id', $id)->get();
            //COMO SOLO PUEDEV VER CAMPAÑAS O BUSQUEDAS AUTH, DEBEMOS VALIDAR UNA VISTA PARA CUANDO NO SE CUMPLE ESA CONDICION
            return view('dashboard/tables/menu_dashboard_test', compact('data', 'profileimage'));
        }//Se trata de una busqueda

        $data = Busqueda::where('user_id', auth()->id())->where('id', $id)->get();

        return view('dashboard/tables/menu_dashboard_test', compact('data', 'profileimage'));
    }

    public function searchMediosById($id)
    {
        $profileimage = $this->getProfileImage();
        if ($id[0] == 'c') {
            //Se trata de una campaña
            $id = substr($id, 1);
            $data = Campania::where('user_id', auth()->id())->where('id', $id)->get();
            //COMO SOLO PUEDEV VER CAMPAÑAS O BUSQUEDAS AUTH, DEBEMOS VALIDAR UNA VISTA PARA CUANDO NO SE CUMPLE ESA CONDICION
            return view('dashboard/tables/menu_dashboard', compact('data', 'profileimage'));
        }//Se trata de una busqueda

        $data = Busqueda::where('user_id', auth()->id())->where('id', $id)->get();

        return view('dashboard/tables/menu_dashboard_medios', compact('data', 'profileimage'));
    }
}
