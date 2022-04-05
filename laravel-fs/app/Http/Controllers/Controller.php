<?php

namespace App\Http\Controllers;

use App\Mail\FistSwitchMail;
use App\Models\AccessHistory;
use App\Models\Client;
use App\Models\Country;
use App\Models\LoggedUser;
use App\Models\Representative;
use App\Models\State;
use App\Models\User;
use Auth;
use DB;
use File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests;

    use DispatchesJobs;

    use ValidatesRequests;

    private $Avatars = [];

    public $idDptoAdministration = 1;

    public $idCellPhone = 2;

    public $idCellHouse = 1;

    public $idStorageAgency = 2;

    public $timeForLockUsers = 90; // minutes

    public $timeForChangePassw = 90; // minutes

    public $PersonNatural = 1; // status persona natural en tipo de documento

    public $PersonJuridico = 2; // status persona juridico en tipo de documento

    public $statusAvailable = 1; // status registers available

    public function saveDate($date)
    {
        $date = explode('/', $date);

        return $date[2] . '-' . $date[1] . '-' . $date[0];
    }

    public function showDate($date)
    {
        $date = explode('-', $date);

        return $date[2] . '/' . $date[1] . '/' . $date[0];
    }

    public function showFullDate($date)
    {
        if ($date == null || $date == '') {
            return date('d/m/Y H:i:s');
        }
        $date = explode(' ', $date);
        $f = explode('-', $date[0]);

        return $f[2] . '/' . $f[1] . '/' . $f[0] . ' ' . $date[1];
    }

    public function getClientBank($type_document, $document)
    {
        $client = Client::where('type_document_id', $type_document)->where('document', $document)->where('status', 1)->get();
        $list_clients = [];
        foreach ($client as $value) {
            if (in_array($value->getStorage->getBanks->id, Auth::User()->toArray()['list_bank_id'])) {
                $list_clients[] = Client::find($value->id);
            }
        }

        return count($list_clients) > 0 ? $list_clients : null;
    }

    public function getClient($code)
    {
        $Client = Client::find($code);

        if ($Client != null) {
            if (!in_array($Client->getStorage->getBanks->id, Auth::User()->toArray()['list_bank_id']) && ($Client->status == 0)) {
                $Client = null;
            }
        }

        return $Client;
    }

    public function searchREP($nac, $cedula)
    {

        //$esta_representative = rand(0, 1);
        $esta_representative = Representative::where([['type_document_id', '=', $nac], ['document', '=', $cedula]])->first();
        if ($esta_representative != null) {
            $datos = [
                'id' => $esta_representative->id,
                'document' => $cedula,
                'first_name' => $esta_representative->first_name,
                'second_name' => $esta_representative->second_name,
                'first_surname' => $esta_representative->first_surname,
                'second_surname' => $esta_representative->second_surname,
                'date_birth' => $this->showDate($esta_representative->date_birth),
                'expiration_month' => $esta_representative->expiration_month,
                'expiration_year' => $esta_representative->expiration_year,
                'phone' => $esta_representative->phone,
                'email' => $esta_representative->email,
                'type_document_id' => $esta_representative->type_document_id,
                'gender_id' => $esta_representative->gender_id,
                'telephone_operator_id' => $esta_representative->telephone_operator_id,
                'where_is' => 1, ]; // representative
        } else {
            //  $esta_rep = rand(0, 1);
            $esta_rep = 0;
            if ($esta_rep == 1) {
                $datos = [
                    'id' => 1,
                    'document' => $cedula,
                    'first_name' => 'AAAAA',
                    'second_name' => 'AAAAA',
                    'first_surname' => 'BBBBB',
                    'second_surname' => 'BBBBB',
                    'date_birth' => '2019-01-01',
                    'expiration_month' => '',
                    'expiration_year' => '',
                    'phone' => '',
                    'email' => '',
                    'type_document_id' => 1,
                    'gender_id' => 1,
                    'telephone_operator_id' => 1,
                    'where_is' => 2, ]; // representative
            } else {
                $datos = [
                    'id' => '',
                    'document' => $cedula,
                    'first_name' => '',
                    'second_name' => '',
                    'first_surname' => '',
                    'second_surname' => '',
                    'date_birth' => '',
                    'expiration_month' => '',
                    'expiration_year' => '',
                    'phone' => '',
                    'email' => '',
                    'type_document_id' => '',
                    'gender_id' => '',
                    'telephone_operator_id' => '',
                    'where_is' => null, ]; // no found
            }
        }

        return $datos;
    }

    public function getPathTimer()
    {
        return storage_path('app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'time_inactivity');
    }

    public function getNameUser($username = '')
    {
        if ($username != '') {
            $user_search = User::where('username', $username)->first();
            if ($user_search == null) {
                return $username;
            }

            return $this->getNameUser($username . mt_rand(10, 99));
        }
    }

    public function setClearString($cadena = '')
    {
        $cadena = str_replace(
            ['Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'],
            ['A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'],
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            ['É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'],
            ['E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'],
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            ['Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'],
            ['I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'],
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            ['Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'],
            ['O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'],
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            ['Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'],
            ['U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'],
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            ['Ñ', 'ñ', 'Ç', 'ç'],
            ['N', 'n', 'C', 'c'],
            $cadena
        );
        $cadena = preg_replace('([^A-Za-z0-9])', '', $cadena);

        return $cadena;
    }

    public function __construct()
    {
        $defaultCountry = Country::where('default', true)->first()->toArray();
        View::share('defaultCountry', $defaultCountry['id']);

        $defaultCodeOperatorCountries = Country::find($defaultCountry['id']);
        $defaultCodeOperatorCountriesAux = $defaultCodeOperatorCountries->getTelephoneOperators->toArray();

        $defaultCodeOperatorCellPhoneCountries = [];
        $defaultCodeOperatorCellHouseCountries = [];

        $defaultStateFromCountry = State::pluck('name_state', 'id');
        $defaultCodeOperatorCountries = [];
        foreach ($defaultCodeOperatorCountriesAux as $value) {
            $defaultCodeOperatorCountries[$value['id']] = $defaultCountry['code_phone'] . ' ' . $value['code'];

            if ($value['type_operator_id'] == $this->idCellPhone) {
                $defaultCodeOperatorCellPhoneCountries[$value['id']] = $defaultCountry['code_phone'] . ' ' . $value['code'];
            }

            if ($value['type_operator_id'] == $this->idCellHouse) {
                $defaultCodeOperatorCellHouseCountries[$value['id']] = $defaultCountry['code_phone'] . ' ' . $value['code'];
            }
        }

        View::share('defaultCodeOperatorCountries', $defaultCodeOperatorCountries);

        View::share('defaultCodeOperatorCellPhoneCountries', $defaultCodeOperatorCellPhoneCountries);
        View::share('defaultCodeOperatorCellHouseCountries', $defaultCodeOperatorCellHouseCountries);

        View::share('defaultStateFromCountry', $defaultStateFromCountry);

        $pathAvatar = storage_path('app/img/avatar/');
        $files = File::files($pathAvatar);
        foreach ($files as $key => $value) {
            if ($value->getExtension() == 'png') {
                $this->Avatars[] = substr($value->getFileName(), 0, strpos($value->getFileName(), '.'));
            }
        }

        View::share('AVATARS', $this->Avatars);
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                View::share('Special_Permission_user', Auth::user()->special_permission);
            }

            return $next($request);
        });
    }

    public function getSelectListUsers()
    {
        return User::join('type_documents', 'type_documents.id', '=', 'users.type_document_id')
            ->select(DB::raw("CONCAT(type_documents.abbreviation,'-', users.document, ' ' ,users.name_user, ' ',users.surname_user ) as full_name"), 'users.id')
            ->orderBy('full_name')->pluck('full_name', 'id');
    }

    public function endLogin($user_id): void
    {
        LoggedUser::where('user_id', $user_id)->delete();

        $AccessHistory = AccessHistory::where('user_id', $user_id)->whereNull('date_out');
        if ($AccessHistory != null) {
            $AccessHistory->update(['date_out' => date('Y-m-d H:i:s')]);
        }
    }

    public function send_mail($mail_to, $template, $info_mail): void
    {
        $data['info_mail'] = $info_mail;
        $data['template'] = $template;
        Mail::to($mail_to)->send(new FistSwitchMail($data));
    }

    public function get_boxes($box = [])
    {
        return $this->getNumberSequence($box);
        // $allow  = '0123456789-,';
        // for ($i = 0; $i < strlen($box); $i++){
        //   if (strpos($allow, substr($box,$i,1)) === false){
        //   }
        // }
        // $box = explode(',',$box);
        // $full_array = [];
        // $key = 0;
        // for ($i = 0; $i < count($box); $i++){
        //     if(strpos($box[$i], '-') !== false){
        //         $array_range = explode('-', $box[$i]);
        //         if(count($array_range) == 2){
        //             $first       = $array_range[0];
        //             $second      = $array_range[1];
        //             $str_range   = range($first,$second);
        //             for ($j = 0; $j < count($str_range); $j++){
        //                 $full_array[] = $str_range[$j];
        //             }
        //         }
        //     }else{
        //         $full_array[] = (int) $box[$i];
        //     }
        // }
        // return $full_array;
    }

    public function getNumberSequence($box = '')
    {
        $num = '';
        $charactersAllowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', ','];

        for ($i = 0; $i < strlen($box); ++$i) {
            if (in_array($box[$i], $charactersAllowed)) {
                $num .= $box[$i];
            }
        }
        $test = explode(',', $num);

        $test2 = [];

        foreach ($test as $key => $value) {
            if (strpos($value, '-') === false) {
                $test2[] = $value;
            } else {
                $test3 = explode('-', $value);
                if (count($test3) == 2) {
                    if ($test3[1] > $test3[0]) {
                        for ($i = (int) $test3[0]; $i <= (int) $test3[1]; ++$i) {
                            $test2[] = $i;
                        }
                    }
                }
            }
        }

        return $test2;
    }

    public function getUsersByStorage($storage)
    {
        $usr = [];
        $users = User::get()->toArray();
        foreach ($users as $key => $value) {
            if ($value['storage_id'] == $storage) {
                $usr[] = $value;
            }
        }

        return $usr;
    }

    public function FullSerial($serial, $zero = 6)
    {
        return str_pad($serial, $zero, '0', STR_PAD_LEFT);
    }

    public function getUserStorages()
    {
        $list = [];

        foreach (Auth::user()->toArray()['get_storages'] as $value) {
            $list[] = $value['id'];
        }

        return $list;
    }

    public function getAccount($code_bank = '0102')
    {
        $agency = str_pad(mt_rand(10, 1000), 4, '0', STR_PAD_LEFT);
        $account = str_pad(mt_rand(100, 6000), 10, '0', STR_PAD_LEFT);

        $pesos1 = [3, 2, 7, 6, 5, 4, 3, 2];
        $pesos2 = [3, 2, 7, 6, 5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        $d1 = $code_bank . '' . $agency;
        $d2 = $agency . '' . $account;
        $suma1 = 0;
        $suma2 = 0;
        foreach ($pesos1 as $k => $v) {
            $suma1 += $v * $d1[$k];
        }
        foreach ($pesos2 as $k => $v) {
            $suma2 += $v * $d2[$k];
        }
        $digito1 = 11 - ($suma1 % 11);
        $digito2 = 11 - ($suma2 % 11);
        if ($digito1 >= 10 || $digito1 < 1) {
            $digito1 = $digito1 % 10;
        }
        if ($digito2 >= 10 || $digito2 < 1) {
            $digito2 = $digito2 % 10;
        }
        $cuentaValidada = $code_bank . $agency . $digito1 . $digito2 . $account;

        return $cuentaValidada;
    }
}
