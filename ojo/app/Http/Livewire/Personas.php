<?php

namespace App\Http\Livewire;

use App\Models\Caso;
use App\Models\Correo;
use App\Models\CuentaBancaria;
use App\Models\Imagen;
use App\Models\PaginaWeb;

use App\Models\Persona;
use App\Models\RedSocial;
use App\Models\Tarjeta;

use App\Models\Telefono;
use Auth;

use Browser;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Personas extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $pagina = 'index';

    //variables por get
    protected $queryString = ['show', 'create'];

    public $show;

    public $create;

    public $form_addElemento = false;

    public $tipo_elemento;

    public $telefono;

    public $operador_id;

    public $sistema_id;

    public $cuenta_bancaria;

    public $banco_id;

    public $moneda;

    public $numero_tarjeta;

    public $correo;

    public $red_social;

    public $pagina_web;

    public $imagen = [];

    public $form_vincular = false;

    public $showElemento;

    public $search;

    public $caso_id;

    public $delito_id_active;

    //propiedades de paises, regiones y distritos
    public $hide_peru = false;

    public $paises;

    public $regiones;

    public $provincias;

    public $distritos;

    public $selectedPais = 143;

    public $selectedRegion = 150000;

    public $selectedProvincia = 150100;

    public $selectedDistrito = 150101;

    //propiedades de persona
    public $direccion;

    public $nombres;

    public $paterno;

    public $materno;

    public $edad;

    public $sexo;

    public $numero_documento;

    public $tipo_documento;

    public $situacion_id;

    //persona
    public $selected_id;

    public $noExistPerson;

    public function mount()
    {

        //recibe caso id y redirecciona para creacion
        if (request()->create) {
            try {
                $caso_id = Crypt::decryptString(base64_decode(request()->create));

                if (Caso::where('id', '=', $caso_id)->exists()) {
                    $this->create($caso_id);
                }
            } catch (DecryptException $e) {

                //No mostrar error solo 403
                session()->flash('message', 'Error 403: Acceso denegado o prohibido, se reporto la IP y cuenta de usuario.');

                return redirect()->back();
            }
        }

        if (request()->show) {
            try {
                $person_id = Crypt::decryptString(base64_decode(request()->show));

                if (Persona::where('id', '=', $person_id)->exists()) {
                    $this->show($person_id);
                }
            } catch (DecryptException $e) {

                //No mostrar error solo 403
                session()->flash('message', 'Error 403: Acceso denegado o prohibido, se reporto la IP y cuenta de usuario.');

                return redirect()->back();
            }
        }

        $this->paises = DB::table('info_paises')->get();
        $this->regiones = DB::table('info_regiones')->get();
        $this->provincias = DB::table('info_provincias')->Where('info_provincias.region_id', '=', 150000)->get();
        $this->distritos = DB::table('info_distritos')->Where('info_distritos.region_id', '=', 150100)->get();
    }

    public function updatePais(): void
    {
        if ($this->selectedPais != 143) {
            $this->hide_peru = true;
            $this->selectedRegion = null;
            $this->selectedProvincia = null;
            $this->selectedDistrito = null;
        } else {
            $this->hide_peru = false;
            $this->selectedRegion = 150000;
            $this->selectedProvincia = 150100;
            $this->selectedDistrito = 150101;
        }
    }

    //verificar si es representante legal

    protected $rules = [
        'nombres' => 'required',
        'paterno' => 'required',
        'materno' => 'required',
        'tipo_documento' => 'required|numeric',
        'numero_documento' => 'required',
        'edad' => 'required|numeric',
        'sexo' => 'required',
        'situacion_id' => 'required|numeric',
        'selectedPais' => 'required|numeric',
        'direccion' => 'required',
        //VALIDACION DE UBICACION
        'selectedRegion' => 'required_if:selectedPais,==,143',
        'selectedProvincia' => 'required_if:selectedPais,==,143',
        'selectedDistrito' => 'required_if:selectedPais,==,143',
    ];

    public function updateRegion(): void
    {
        $this->provincias = DB::table('info_provincias')->Where('info_provincias.region_id', '=', $this->selectedRegion)->get();

        $this->reset(['distritos', 'selectedDistrito']);
    }

    public function updateProvincia(): void
    {
        $this->reset(['distritos', 'selectedDistrito']);

        $this->distritos = DB::table('info_distritos')->Where('info_distritos.region_id', '=', $this->selectedProvincia)->get();
    }

    public function index(): void
    {
        $this->pagina = 'index';
    }

    public function create($caso_id = null): void
    {
        if (empty($caso_id) || $caso_id == null) {
            session()->flash('message', 'Seleccione un caso para luego agregar un denunciante!');

            redirect()->route('casos');
        } else {
            $this->caso_id = $caso_id;

            $this->pagina = 'form_persona';
        }
    }

    public function checkPersona(): void
    {
        if (Persona::where('numero_documento', $this->numero_documento)->exists()) {
            $this->form_vincular = true;

            $persona = Persona::where('numero_documento', $this->numero_documento)->first();

            $this->selected_id = $persona->id;
            $this->nombres = $persona->nombres;
            $this->paterno = $persona->paterno;
            $this->materno = $persona->materno;
            $this->numero_documento = $persona->numero_documento;
        } else {
            $this->form_vincular = false;

            $this->noExistPerson = true;
        }
    }

    public function storeVinculacion(): void
    {

            // registro de vinculacion de casos y personas
        DB::table('caso_has_persons')->insert([
            'caso_id' => $this->caso_id,
            'person_id' => $this->selected_id,
            'situacion_id' => $this->situacion_id, // SITUACION 1 DENUNCIANTE, 2 INVESTIGADO, 3 TESTIGO.
        ]);

        //Log

        activity()
            ->causedBy(auth::user()->id)
            ->performedOn(new Persona())
            ->event('Linking')
            ->withProperties([
                'IP' => request()->ip(),
                'browser' => Browser::browserName(),
                'Os' => Browser::platformName(),
            ])
            ->log('Add Person ID: ' . $this->selected_id . ' to Case ID: ' . $this->caso_id);

        session()->flash('message', 'La persona ya existe en el sistema por lo que no fue necesario registrarla de nuevo, unicamente se vinculo con el caso.');

        redirect()->route('personas');
    }

    public function store(): void
    {
        $this->validate();

        //Proceso verifica si existe en DB, si existe vincula a caso y redirige comunicando evento.

        if (DB::table('personas')->where('numero_documento', $this->numero_documento)->exists()) {
            $persona = DB::table('personas')->where('numero_documento', $this->numero_documento)->first();

            // registro de vinculacion de casos y personas
            DB::table('caso_has_persons')->insert([
                'caso_id' => $this->caso_id,
                'person_id' => $persona->id,
                'situacion_id' => $this->situacion_id, // SITUACION 1 DENUNCIANTE, 2 INVESTIGADO, 3 TESTIGO.
            ]);

            session()->flash('message', 'La persona ya existe en el sistema por lo que no fue necesario registrarla de nuevo, unicamente se vinculo con el caso.');

            redirect()->route('personas');
        }

        try {
            DB::beginTransaction();

            $person = Persona::create([
                'nombres' => $this->nombres,
                'paterno' => $this->paterno,
                'materno' => $this->materno,
                'tipo_documento' => $this->tipo_documento,
                'numero_documento' => $this->numero_documento,
                'edad' => $this->edad,
                'sexo' => $this->sexo,
                'pais_id' => $this->selectedPais,
                'region_id' => $this->selectedRegion,
                'provincia_id' => $this->selectedProvincia,
                'distrito_id' => $this->selectedDistrito,
                'direccion' => $this->direccion,
            ]);

            // registro de vinculacion de casos y personas
            DB::table('caso_has_persons')->insert([
                'caso_id' => $this->caso_id,
                'person_id' => $person->id,
                'situacion_id' => $this->situacion_id, // SITUACION 1 DENUNCIANTE, 2 INVESTIGADO, 3 TESTIGO.
            ]);

            DB::commit();

            activity()
                ->causedBy(auth::user()->id)
                ->performedOn(new Persona())
                ->event('Create')
                ->withProperties([
                    'IP' => request()->ip(),
                    'browser' => Browser::browserName(),
                    'Os' => Browser::platformName(),
                ])
                ->log('Add Person ID: ' . $person_id . ' to Case ID: ' . $this->caso_id);
        } catch (Exception $e) {
            DB::rollback();

            session()->flash('message', 'Ocurrio un error comunicarse con Administrador.');
        }

        session()->flash('message', 'Se guardo informacion del denunciante correctamente!');

        $this->show($person_id);
    }

    public function show($id): void
    {
        $this->selected_id = $id;

        $this->pagina = 'show';
    }

    //ELEMENTOS
    public function addElemento($tipo_elemento): void
    {
        $this->form_addElemento = true;
        $this->tipo_elemento = $tipo_elemento;
    }

    public function storeElemento($id): void
    {
        if ($id == 1) {
            $telefono = Telefono::create([
                'operador_id' => $this->operador_id,
                'sistema_id' => $this->sistema_id,
                'telefono' => $this->telefono,
                'person_id' => $this->selected_id,
            ]);

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('telefono', 'operador_id', 'sistema_id');
        } elseif ($id == 2) {
            $cuenta_bancaria = CuentaBancaria::create([
                'banco_id' => $this->banco_id,
                'cuenta_bancaria' => $this->cuenta_bancaria,
                'moneda' => $this->moneda,
                'person_id' => $this->selected_id,
            ]);

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('banco_id', 'cuenta_bancaria', 'moneda');
        } elseif ($id == 3) {
            $this->validate([
                'numero_tarjeta' => 'required|numeric',
                'banco_id' => 'required|numeric',
            ]);

            $tarjeta = Tarjeta::create([
                'banco_id' => $this->banco_id,
                'numero_tarjeta' => $this->numero_tarjeta,
                'person_id' => $this->selected_id,
            ]);

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('banco_id', 'numero_tarjeta');
        } elseif ($id == 4) {
            $this->validate([
                'correo' => 'required|email',
            ]);

            $correo = Correo::create([
                'correo' => $this->correo,
                'person_id' => $this->selected_id,
            ]);

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('correo');
        } elseif ($id == 5) {
            $this->validate([
                'pagina_web' => 'required|url',
            ]);

            $pagina_web = PaginaWeb::create([
                'pagina_web' => $this->pagina_web,
                'person_id' => $this->selected_id,
            ]);

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('pagina_web');
        } elseif ($id == 6) {
            $this->validate([
                'red_social' => 'required|url',
            ]);

            $red_social = RedSocial::create([
                'red_social' => $this->red_social,
                'person_id' => $this->selected_id,
            ]);

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('red_social');
        } elseif ($id == 7) {
            $this->validate([

                'imagen.*' => 'required|mimes:jpg,jpeg,png|max:1024',

            ]);

            foreach ($this->imagen as $img) {
                $image_url = $img->store('images');

                Imagen::create([
                    'image_url' => $image_url,
                    'person_id' => $this->selected_id,
                ]);
            }

            session()->flash('message', 'Se guardo informacion correctamente!');

            $this->reset('imagen');
        }
    }

    public function destroyImage($id): void
    {
        Imagen::destroy($id);

        session()->flash('message', 'Imagen eliminada.');
    }

    public function changeProfile($id): void
    {
        $img = Imagen::find($id);

        $profile_img = $img->image_url;

        $person_id = $img->person_id;

        $persona = Persona::find($person_id);

        $persona->profile_img = $profile_img;

        $persona->save();

        session()->flash('message', 'Imagen de perfil actualizado.');
    }

    public function showElemento($id): void
    {
        $this->showElemento = $id;
    }

    public function render()
    {
        if ($this->pagina == 'index') {
            if ($this->search) {
                return view(
                    'livewire.persona.index',
                    [
                        'personas' => DB::table('personas')
                            ->where('deleted_at', null)
                            ->Where('personas.nombres', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('personas.paterno', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('personas.materno', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('personas.numero_documento', 'LIKE', '%' . $this->search . '%')
                            ->join('caso_has_persons', 'caso_has_persons.person_id', '=', 'personas.id')
                            ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                            ->join('info_paises', 'info_paises.id', '=', 'personas.pais_id')
                            ->leftjoin('info_regiones', 'info_regiones.id', '=', 'personas.region_id')
                            ->leftjoin('info_provincias', 'info_provincias.id', '=', 'personas.provincia_id')
                            ->leftjoin('info_distritos', 'info_distritos.id', '=', 'personas.distrito_id')
                            ->select(
                                'personas.id as p_id',
                                'personas.nombres as p_nombres',
                                'personas.paterno as p_paterno',
                                'personas.materno as p_materno',
                                'personas.numero_documento as p_numero_documento',
                                'info_tipo_documento_identidad.name as tipo_documento',
                                'personas.edad as p_edad',
                                'personas.sexo as p_sexo',
                                'info_paises.pais as pais',
                                'info_regiones.name as region',
                                'info_provincias.name as provincia',
                                'info_distritos.name as distrito',
                                'personas.direccion as p_direccion',
                            )
                            ->paginate(5),
                    ]
                )->extends('layouts.Master')->section('container');
            }

            return view(
                'livewire.persona.index',
                [

                    'personas' => DB::table('personas')
                        ->where('deleted_at', null)
                        ->join('caso_has_persons', 'caso_has_persons.person_id', '=', 'personas.id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->join('info_paises', 'info_paises.id', '=', 'personas.pais_id')
                        ->leftjoin('info_regiones', 'info_regiones.id', '=', 'personas.region_id')
                        ->leftjoin('info_provincias', 'info_provincias.id', '=', 'personas.provincia_id')
                        ->leftjoin('info_distritos', 'info_distritos.id', '=', 'personas.distrito_id')
                        ->select(
                            'personas.id as p_id',
                            'personas.nombres as p_nombres',
                            'personas.paterno as p_paterno',
                            'personas.materno as p_materno',
                            'personas.numero_documento as p_numero_documento',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'personas.edad as p_edad',
                            'personas.sexo as p_sexo',
                            'info_paises.pais as pais',
                            'info_regiones.name as region',
                            'info_provincias.name as provincia',
                            'info_distritos.name as distrito',
                            'personas.direccion as p_direccion',
                        )
                        ->distinct()
                        ->paginate(5),

                ]
            )->extends('layouts.Master')->section('container');
        } elseif ($this->pagina == 'form_persona') {
            return view(
                'livewire.persona.index',
                [
                    //'caso_id' => $this->caso_id,
                    'delitos' => DB::table('info_delitos')->get(),
                    'entidades' => DB::table('info_entidad')->get(),
                    'operadoras' => DB::table('info_operadoras')->get(),
                    'documentos' => DB::table('info_documentos')->get(),
                    'tipo_documento_identidad' => DB::table('info_tipo_documento_identidad')->get(),
                    'modalidades' => DB::table('info_modalidad')->Where('delitos_id', '=', $this->delito_id_active)->get(),
                ]
            )->extends('layouts.Master')->section('container');
        } elseif ($this->pagina == 'show') {
            return view(
                'livewire.persona.index',
                [
                    'denunciante' => DB::table('personas')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->join('info_paises', 'info_paises.id', '=', 'personas.pais_id')
                        ->leftjoin('info_regiones', 'info_regiones.id', '=', 'personas.region_id')
                        ->leftjoin('info_provincias', 'info_provincias.id', '=', 'personas.provincia_id')
                        ->leftjoin('info_distritos', 'info_distritos.id', '=', 'personas.distrito_id')
                        ->join('caso_has_persons', 'caso_has_persons.person_id', '=', 'personas.id')
                        ->join('casos', 'casos.id', '=', 'caso_has_persons.caso_id')
                        ->Where('personas.id', $this->selected_id)
                        ->select(
                            'personas.id as p_id',
                            'personas.nombres as p_nombres',
                            'personas.paterno as p_paterno',
                            'personas.materno as p_materno',
                            'personas.numero_documento as p_numero_documento',
                            'personas.edad as p_edad',
                            'personas.sexo as p_sexo',
                            'personas.profile_img as p_img',
                            'personas.direccion as p_direccion',
                            'info_tipo_documento_identidad.name as tipo_documento',
                            'info_paises.pais as p_pais',
                            'info_regiones.name as p_region',
                            'info_provincias.name as p_provincia',
                            'info_distritos.name as p_distrito',
                            'casos.id as c_id',
                            'casos.fiscalia as c_fiscalia',
                            'casos.carpeta_fiscal as c_carpeta_fiscal',
                            'casos.isFlagrancia as c_isFlagrancia',
                            'casos.isBanda as c_isBanda',
                            'casos.banda as c_banda',
                            'caso_has_persons.situacion_id as c_situacion'
                        )
                        ->first(),
                    'operadoras' => DB::table('info_operadoras')->get(),
                    'sistemas' => DB::table('info_sistemas')->get(),
                    'bancos' => DB::table('info_bancos')->get(),
                    'telefonos' => DB::table('data_telefonos')
                        ->join('info_operadoras', 'info_operadoras.id', '=', 'data_telefonos.operador_id')
                        ->join('info_sistemas', 'info_sistemas.id', '=', 'data_telefonos.sistema_id')
                        ->select('data_telefonos.telefono as telefono', 'info_operadoras.name as operador', 'info_sistemas.name as sistema')
                        ->where('person_id', '=', $this->selected_id)
                        ->orderBy('data_telefonos.id', 'desc')
                        ->get(),
                    'cuenta_bancarias' => DB::table('data_cuenta_bancarias')
                        ->join('info_bancos', 'info_bancos.id', '=', 'data_cuenta_bancarias.banco_id')
                        ->join('info_monedas', 'info_monedas.id', '=', 'data_cuenta_bancarias.moneda_id')
                        ->select('data_cuenta_bancarias.cuenta_bancaria as cuenta', 'info_monedas.moneda as moneda', 'info_bancos.banco as banco')
                        ->where('person_id', '=', $this->selected_id)
                        ->orderBy('data_cuenta_bancarias.id', 'desc')
                        ->get(),
                    'imagenes' => DB::table('data_imagenes')
                        ->where('person_id', '=', $this->selected_id)
                        ->where('deleted_at', null)
                        ->select('data_imagenes.image_url as image_url', 'data_imagenes.id as image_id')
                        ->orderBy('data_imagenes.id', 'desc')
                        ->get(),
                    'tarjetas' => DB::table('data_tarjetas')
                        ->where('person_id', '=', $this->selected_id)
                        ->where('deleted_at', null)
                        ->join('info_bancos', 'info_bancos.id', '=', 'data_tarjetas.banco_id')
                        ->select('data_tarjetas.numero_tarjeta as numero_tarjeta', 'info_bancos.banco as banco')
                        ->orderBy('data_tarjetas.id', 'desc')
                        ->get(),
                    'correos' => DB::table('data_correos')
                        ->where('person_id', '=', $this->selected_id)
                        ->where('deleted_at', null)
                        ->select('data_correos.correo as correo')
                        ->orderBy('data_correos.id', 'desc')
                        ->get(),
                    'paginasWeb' => DB::table('data_paginas_web')
                        ->where('person_id', '=', $this->selected_id)
                        ->where('deleted_at', null)
                        ->select('data_paginas_web.pagina_web as pagina_web')
                        ->orderBy('data_paginas_web.id', 'desc')
                        ->get(),
                    'redesSociales' => DB::table('data_redes_sociales')
                        ->where('person_id', '=', $this->selected_id)
                        ->where('deleted_at', null)
                        ->select('data_redes_sociales.red_social as red_social')
                        ->orderBy('data_redes_sociales.id', 'desc')
                        ->get(),
                ]
            )->extends('layouts.Master')->section('container');
        }
    }
}
