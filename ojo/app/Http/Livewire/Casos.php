<?php

namespace App\Http\Livewire;

use App\Models\Caso;
use App\Models\Fiscalia;
use Auth;
use Browser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;

class Casos extends Component
{
    use WithPagination;

    //propiedades de casos
    public $isBanda;

    public $banda;

    public $isFlagrancia;

    public $search;

    public $carpeta_fiscal;

    public $fiscalia;

    public $entidad_id;

    public $entidad;

    public $documento_id;

    public $documento;

    public $fecha_recepcion;

    public $delito_id;

    public $plazo;

    public $modalidad_id;

    public $banco_id;

    public $moneda_id;

    public $cantidad;

    public $delito_id_active;

    public $hide_entidad = false;

    public $selected_id;

    public $pagina = 'index';

    protected $rules = [
        'carpeta_fiscal' => 'required',
        'isFlagrancia' => 'required|boolean',
        'isBanda' => 'required|boolean',
        'banda' => 'required_if:isBanda,==,1',
        'fiscalia' => 'required',
        'entidad_id' => 'required|numeric',
        'documento_id' => 'required|numeric',
        'documento' => 'required',
        'fecha_recepcion' => 'required',
        'delito_id' => 'required|numeric',
        'plazo' => 'required|numeric',
        'modalidad_id' => 'required|numeric',
        'banco_id' => 'required|numeric',
        'moneda_id' => 'required|numeric',
        'cantidad' => 'required',
    ];

    public function index(): void
    {
        $this->resetPage();

        $this->reset();

        $this->pagina = 'index';
    }

    public function create(): void
    {
        $this->pagina = 'form_caso';
    }

    public function change_modalidades(): void
    {
        $this->delito_id_active = $this->delito_id;
    }

    public function change_entidad(): void
    {
        // Si es fiscalia u denuncia directa
        if ($this->entidad_id == 1 || $this->entidad_id == 2) {
            $this->hide_entidad = true;
        } else {
            $this->hide_entidad = false;
        }
    }

    public function store()
    {
        $this->validate();

        //operacionalizacion de fecha de expiracion

        $fecha_expiracion = Carbon::parse($this->fecha_recepcion)->addDays($this->plazo);

        //creacion de caso y obtencion de ID
        $caso = Caso::create([
            'fiscalia' => $this->fiscalia,
            'carpeta_fiscal' => $this->carpeta_fiscal,
            'isFlagrancia' => $this->isFlagrancia,
            'isBanda' => $this->isBanda,
            'banda' => $this->banda,
            'entidad_id' => $this->entidad_id,
            'entidad' => $this->entidad,
            'documento_id' => $this->documento_id,
            'documento' => $this->documento,
            'fecha_recepcion' => $this->fecha_recepcion,
            'fecha_expiracion' => $fecha_expiracion,
            'plazo' => $this->plazo,
            'delito_id' => $this->delito_id,
            'modalidad_id' => $this->modalidad_id,
            'banco_id' => $this->banco_id,
            'moneda_id' => $this->moneda_id,
            'cantidad' => $this->cantidad,
            'investigador_id' => auth()->user()->id,
        ]);

        //Log

        activity()
            ->causedBy(auth::user()->id)
            ->performedOn(new Caso())
            ->event('Create')
            ->withProperties([
                'IP' => request()->ip(),
                'browser' => Browser::browserName(),
                'Os' => Browser::platformName(),
            ])
            ->log('Caso ID: ' . $caso->id);

        //vinculacion con fiscalia

        Fiscalia::create([
            'fiscalia' => $this->fiscalia,
            'caso_id' => $caso->id,
        ]);

        session()->flash('message', 'Se guardo el caso correctamente!');

        return redirect()->route('personas', ['create' => base64_encode(Crypt::encryptString($caso->id))]);
    }

    public function show($id): void
    {
        $this->selected_id = $id;

        $this->pagina = 'show';
    }

    public function edit($id): void
    {
        $this->selected_id = $id;

        $this->pagina = 'edit';

        session()->flash('message', '¡ALERTA! Debe estar seguro de editar los datos, una vez guardado no se pueden recuperar.');

        $caso = DB::table('casos')
            ->Where('casos.id', '=', Crypt::decryptString($this->selected_id))
            ->join('info_bancos', 'info_bancos.id', '=', 'casos.banco_id')
            ->join('info_monedas', 'info_monedas.id', '=', 'casos.moneda_id')
            ->join('info_entidad', 'info_entidad.id', '=', 'casos.entidad_id')
            ->join('info_documentos', 'info_documentos.id', '=', 'casos.documento_id')
            ->join('info_delitos', 'info_delitos.id', '=', 'casos.delito_id')
            ->join('info_modalidad', 'info_modalidad.id', '=', 'casos.modalidad_id')
            ->select(
                'casos.id as c_id',
                'casos.isFlagrancia as c_isFlagrancia',
                'casos.isBanda as c_isBanda',
                'casos.banda as c_banda',
                'casos.entidad as c_entidad',
                'casos.documento as c_documento',
                'casos.fecha_recepcion as c_fecha_recepcion',
                'casos.plazo as c_plazo',
                'casos.fiscalia as c_fiscalia',
                'casos.carpeta_fiscal as c_carpeta_fiscal',
                'casos.cantidad as c_cantidad',
                'info_monedas.moneda as moneda',
                'info_modalidad.id as modalidad_id',
                'info_delitos.id as delito_id',
                'info_entidad.id as entidad_id',
                'info_documentos.id as documento_id',
                'info_bancos.id as banco_id',
            )
            ->first();

        $this->fiscalia = $caso->c_fiscalia;
        $this->carpeta_fiscal = $caso->c_carpeta_fiscal;
        $this->isFlagrancia = $caso->c_isFlagrancia;
        $this->isBanda = $caso->c_isBanda;
        $this->banda = $caso->c_banda;
        $this->entidad_id = $caso->entidad_id;
        $this->entidad = $caso->c_entidad;
        $this->documento = $caso->c_documento;
        $this->documento_id = $caso->documento_id;
        $this->fecha_recepcion = date('Y-m-d', strtotime($caso->c_fecha_recepcion));
        $this->plazo = $caso->c_plazo;

        $this->delito_id = $caso->delito_id;
        $this->modalidad_id = $caso->modalidad_id;

        $this->banco_id = $caso->banco_id;
        $this->cantidad = $caso->c_cantidad;
        $this->moneda_id = $caso->moneda;
    }

    public function update(): void
    {
        $this->validate();

        //operacionalizacion de fecha de expiracion
        $fecha_expiracion = Carbon::parse($this->fecha_recepcion)->addDays($this->plazo);

        Caso::where('id', Crypt::decryptString($this->selected_id))
            ->update(
                [
                    'fiscalia' => $this->fiscalia,
                    'carpeta_fiscal' => $this->carpeta_fiscal,
                    'isFlagrancia' => $this->isFlagrancia,
                    'isBanda' => $this->isBanda,
                    'banda' => $this->banda,
                    'entidad_id' => $this->entidad_id,
                    'entidad' => $this->entidad,
                    'documento_id' => $this->documento_id,
                    'documento' => $this->documento,
                    'fecha_recepcion' => $this->fecha_recepcion,
                    'fecha_expiracion' => $fecha_expiracion,
                    'plazo' => $this->plazo,
                    'delito_id' => $this->delito_id,
                    'modalidad_id' => $this->modalidad_id,
                    'banco_id' => $this->banco_id,
                    'moneda' => $this->moneda,
                    'cantidad' => $this->cantidad,
                    'investigador_id' => auth()->user()->id,
                ]
            );

        //Log

        activity()
            ->causedBy(auth::user()->id)
            ->performedOn(new Caso())
            ->event('Update')
            ->withProperties([
                'IP' => request()->ip(),
                'browser' => Browser::browserName(),
                'Os' => Browser::platformName(),
            ])
            ->log('Caso ID: ' . $this->selected_id);

        session()->flash('message', 'El caso se actualizo correctamente!');

        $this->show($this->selected_id);
    }

    public function destroy($id): void
    {

            //eliminar caso
        $caso = Caso::findOrFail(Crypt::decryptString($id));
        $caso->delete();

        //eliminar historial de fiscalias
        DB::table('fiscalias')
            ->Where('fiscalias.caso_id', '=', Crypt::decryptString($id))
            ->delete();

        //eliminar personas vinculadas a caso
        DB::table('personas')
            ->join('caso_has_persons', 'caso_has_persons.person_id', '=', 'personas.id')
            ->Where('caso_has_persons.caso_id', '=', Crypt::decryptString($id))
            ->delete();

        //Log

        activity()
            ->causedBy(auth::user()->id)
            ->performedOn(new Caso())
            ->event('Delete')
            ->withProperties([
                'IP' => request()->ip(),
                'browser' => Browser::browserName(),
                'Os' => Browser::platformName(),
            ])
            ->log('Caso ID: ' . $caso->id);
    }

    public function render()
    {
        if ($this->pagina == 'index') {
            if ($this->search >= 3) {
                return view(
                    'livewire.caso.index',
                    [
                        'casos' => DB::table('casos')
                            ->where('deleted_at', null)
                            ->Where('casos.entidad', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('casos.documento', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('carpeta_fiscal', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('fecha_recepcion', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('banco', 'LIKE', '%' . $this->search . '%')
                            ->join('users', 'users.id', '=', 'casos.investigador_id')
                            ->join('info_entidad', 'info_entidad.id', '=', 'casos.entidad_id')
                            ->join('info_documentos', 'info_documentos.id', '=', 'casos.documento_id')
                            ->join('info_delitos', 'info_delitos.id', '=', 'casos.delito_id')
                            ->join('info_modalidad', 'info_modalidad.id', '=', 'casos.modalidad_id')
                            ->join('info_bancos', 'info_bancos.id', '=', 'casos.banco_id')
                            ->join('info_monedas', 'info_monedas.id', '=', 'casos.moneda_id')
                            ->select(
                                'casos.id as c_id',
                                'casos.isFlagrancia as c_isFlagrancia',
                                'casos.isBanda as c_isBanda',
                                'casos.banda as c_banda',
                                'casos.entidad as c_entidad',
                                'casos.documento as c_documento',
                                'casos.fecha_recepcion as c_fecha_recepcion',
                                'casos.fecha_expiracion as c_fecha_expiracion',
                                'casos.plazo as c_plazo',
                                'casos.fiscalia as c_fiscalia',
                                'casos.carpeta_fiscal as c_carpeta_fiscal',
                                'casos.cantidad as c_cantidad',
                                'info_monedas.moneda as moneda',
                                'info_modalidad.modalidad as modalidad',
                                'info_delitos.delito as delito',
                                'info_entidad.entidad as entidad',
                                'info_documentos.documento as documento',
                                'info_bancos.banco as banco',
                                'users.nombres as u_nombres',
                                'users.paterno as u_paterno',
                                'users.materno as u_materno',
                            )
                            ->paginate(10),
                    ]
                )->extends('layouts.Master')->section('container');
            }

            return view(
                'livewire.caso.index',
                [
                    'casos' => DB::table('casos')
                        ->where('deleted_at', null)
                        ->join('users', 'users.id', '=', 'casos.investigador_id')
                        ->join('info_entidad', 'info_entidad.id', '=', 'casos.entidad_id')
                        ->join('info_documentos', 'info_documentos.id', '=', 'casos.documento_id')
                        ->join('info_delitos', 'info_delitos.id', '=', 'casos.delito_id')
                        ->join('info_modalidad', 'info_modalidad.id', '=', 'casos.modalidad_id')
                        ->join('info_bancos', 'info_bancos.id', '=', 'casos.banco_id')
                        ->join('info_monedas', 'info_monedas.id', '=', 'casos.moneda_id')
                        ->select(
                            'casos.id as c_id',
                            'casos.isFlagrancia as c_isFlagrancia',
                            'casos.isBanda as c_isBanda',
                            'casos.banda as c_banda',
                            'casos.entidad as c_entidad',
                            'casos.documento as c_documento',
                            'casos.fecha_recepcion as c_fecha_recepcion',
                            'casos.fecha_expiracion as c_fecha_expiracion',
                            'casos.plazo as c_plazo',
                            'casos.fiscalia as c_fiscalia',
                            'casos.carpeta_fiscal as c_carpeta_fiscal',
                            'casos.cantidad as c_cantidad',
                            'info_monedas.moneda as moneda',
                            'info_modalidad.modalidad as modalidad',
                            'info_delitos.delito as delito',
                            'info_entidad.entidad as entidad',
                            'info_documentos.documento as documento',
                            'info_bancos.banco as banco',
                            'users.nombres as u_nombres',
                            'users.paterno as u_paterno',
                            'users.materno as u_materno',
                        )
                        ->orderBy('casos.id', 'desc')
                        ->paginate(10),
                ]
            )->extends('layouts.Master')->section('container');
        } elseif ($this->pagina == 'form_caso') {
            return view(
                'livewire.caso.index',
                [
                    'bancos' => DB::table('info_bancos')->get(),
                    'monedas' => DB::table('info_monedas')->get(),
                    'delitos' => DB::table('info_delitos')->get(),
                    'entidades' => DB::table('info_entidad')->get(),
                    'documentos' => DB::table('info_documentos')->get(),
                    'modalidades' => DB::table('info_modalidad')->Where('delitos_id', '=', $this->delito_id_active)->get(),
                ]
            )->extends('layouts.Master')->section('container');
        } elseif ($this->pagina == 'show') {
            return view(
                'livewire.caso.index',
                [
                    'caso' => DB::table('casos')
                        ->where('deleted_at', null)
                        ->Where('casos.id', '=', Crypt::decryptString($this->selected_id))
                        ->join('users', 'users.id', '=', 'casos.investigador_id')
                        ->join('info_bancos', 'info_bancos.id', '=', 'casos.banco_id')
                        ->join('info_entidad', 'info_entidad.id', '=', 'casos.entidad_id')
                        ->join('info_documentos', 'info_documentos.id', '=', 'casos.documento_id')
                        ->join('info_delitos', 'info_delitos.id', '=', 'casos.delito_id')
                        ->join('info_modalidad', 'info_modalidad.id', '=', 'casos.modalidad_id')
                        ->join('info_monedas', 'info_monedas.id', '=', 'casos.moneda_id')
                        ->select(
                            'casos.id as c_id',
                            'casos.isFlagrancia as c_isFlagrancia',
                            'casos.isBanda as c_isBanda',
                            'casos.banda as c_banda',
                            'casos.entidad as c_entidad',
                            'casos.documento as c_documento',
                            'casos.fecha_recepcion as c_fecha_recepcion',
                            'casos.fecha_expiracion as c_fecha_expiracion',
                            'casos.plazo as c_plazo',
                            'casos.fiscalia as c_fiscalia',
                            'casos.carpeta_fiscal as c_carpeta_fiscal',
                            'casos.cantidad as c_cantidad',
                            'info_monedas.moneda as moneda',
                            'info_modalidad.modalidad as modalidad',
                            'info_delitos.delito as delito',
                            'info_entidad.entidad as entidad',
                            'info_documentos.documento as documento',
                            'info_bancos.banco as banco',
                            'users.nombres as u_nombres',
                            'users.paterno as u_paterno',
                            'users.materno as u_materno',
                            'users.telefono as u_telefono',
                        )
                        ->first(),

                    'fiscalias' => DB::table('fiscalias')
                        ->where('deleted_at', null)
                        ->Where('fiscalias.caso_id', '=', Crypt::decryptString($this->selected_id))
                        ->orderBy('id', 'desc')
                        ->select(
                            'fiscalias.fiscalia as fiscalia',
                            'fiscalias.created_at as fecha_creacion'
                        )
                        ->get(),

                    'personas' => DB::table('personas')
                        ->join('caso_has_persons', 'caso_has_persons.person_id', '=', 'personas.id')
                        ->join('info_tipo_documento_identidad', 'info_tipo_documento_identidad.id', '=', 'personas.tipo_documento')
                        ->Where('caso_has_persons.caso_id', '=', Crypt::decryptString($this->selected_id))
                        ->where('deleted_at', null)
                        ->orderBy('personas.id', 'desc')
                        ->select(
                            'personas.id as p_person_id',
                            'personas.nombres as p_nombres',
                            'personas.paterno as p_paterno',
                            'personas.materno as p_materno',
                            'info_tipo_documento_identidad.name as p_tipo_documento',
                            'personas.numero_documento as p_documento',
                            'caso_has_persons.situacion_id as situacion',
                        )
                        ->get(),
                ]
            )->extends('layouts.Master')->section('container');
        } elseif ($this->pagina == 'edit') {
            return view(
                'livewire.caso.edit',
                [
                    'entidades' => DB::table('info_entidad')->get(),
                    'bancos' => DB::table('info_bancos')->get(),
                    'delitos' => DB::table('info_delitos')->get(),
                    'documentos' => DB::table('info_documentos')->get(),
                    'modalidades' => DB::table('info_modalidad')->get(),
                    'monedas' => DB::table('info_monedas')->get(),

                ]
            )->extends('layouts.Master')->section('container');
        }
    }
}
