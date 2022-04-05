<?php

namespace App\Http\Controllers\Master;

use App\Agen;
use App\Applicationsetting;
use App\Awb;
use App\Http\Controllers\Controller;
use App\Kota;
use App\Manifest;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ManifestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.master.manifest.index');
    }

    public function datatables()
    {
        $level_user = (int) Auth::user()->level;
        $manifest = Manifest::select(DB::raw("DATE_FORMAT(manifest.created_at,'%d-%M-%Y (%H:%i)') as tanggal_manifest"), 'agen.kode as kodeagen', 'manifest.*', 'kotaasal.kode as kodekotaasal', 'kotatujuan.kode as kodekotatujuan', 'users.nama as namauser')
            ->join('kota as kotaasal', 'kotaasal.id', '=', 'manifest.id_kota_asal')
            ->join('kota as kotatujuan', 'kotatujuan.id', '=', 'manifest.id_kota_tujuan')
            ->join('users', 'users.id', '=', 'manifest.dibuat_oleh')
                // ->leftjoin("users as agenuser", 'users.id_agen',   '=', 'manifest.agen_tujuan')
            ->leftjoin('agen  as agen', 'agen.id', '=', 'manifest.agen_tujuan')
            ->where('manifest.id', '>', '0')
            ->orderBy('manifest.id', 'desc');
        if ($level_user != 1 && $level_user != 5) {
            $manifest = $manifest->where('manifest.agen_tujuan', '=', (int) Auth::user()->id_agen);
        }
        $manifest->get();

        return Datatables::of($manifest)
            ->addColumn('aksi', function ($a) {
            $edit = ($a['status'] == 'arrived' || (int) Auth::user()->level != 1) ? '' : '
            <button
                type            = "button"
                class           = "btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success openstatus"
                idmanifest      = "' . $a['id'] . ' "
                kodemanifest    = "' . $a['kode'] . ' "
                tanggalmanifest = "' . $a['tanggal_manifest'] . ' "
                kodekotaasal    = "' . $a['kodekotaasal'] . ' "
                kodekotatujuan  = "' . $a['kodekotatujuan'] . ' "
                status          = "' . $a['status'] . '"
                data-toggle     = "modal"
                data-target     = ".bd-example-modal-lg">
                    <i class="fa fa-edit" aria-hidden="true"></i>
            </button>
            ';

            return '
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="' . url('printout/manifest/' . Crypt::encrypt($a['id'])) . '" target="blank" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Lihat Detail/Print">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
                ' . $edit . '
            </div>';
        })
            ->addColumn('status_info', function ($a) {
            $status = '<span class="badge badge-success"> <i class="fa fa-check"  style="color:white;"></i>&nbsp;' . $a['status'] . '</span>';
            if ($a['status'] == 'delivering') {
                $status = '<span class="badge badge-info"><i class="fa fa-truck"  style="color:white;"></i>&nbsp;' . $a['status'] . '</span>';
            } elseif ($a['status'] == 'arrived') {
                $status = '<span class="badge badge-primary"><i class="fa fa-university"  style="color:white;"></i>&nbsp;' . $a['status'] . '</span>';
            }

            return $status;
        })
            ->rawColumns(['aksi', 'status_info'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    public function updatestatus(Request $request): void
    {
        // $manifest = Manifest::where('id',$request['idmanifest'])->first();
        // if($manifest->status == 'arrived' && $request['status'] == 'delivering'){
        //     return response()->json(array('success' => 'Manifest sudah ber status arrived! tidak bisa dikembalikan ke delivering'));
        // }
        // $manifest->status = $request['status'];
        // if($request['status'] == 'arrived'){

        //     $manifest->discan_terima_oleh        = (int) Auth::user()->id;
        //     $manifest->discan_diterima_oleh_nama = Auth::user()->nama.' (Update status manual)';
        //     $manifest->tanggal_diterima          = Carbon::now()->addHours(7);
        // }
        // $manifest->save();
        // if($request['status'] == 'delivering' || $request['status'] == 'arrived'){
        //     app('App\Http\Controllers\AwbController')->inserthistoryscan(0,(( $request['status'] == 'delivering') ? 'loaded' : 'at-agen'),   $manifest['id'] );
        // }
        // return response()->json(array('success' => 'success'));
    }

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $manifest = new Manifest();
        } else {
            $manifest = Manifest::where('id', $request['id'])->first();
        }
        $manifest->kode = Manifest::getNoManifest();
        $manifest->status = ($request->status) ?: 'checked';
        $manifest->supir = ($request->supir) ?: '';
        $manifest->keterangan = ($request->keterangan) ?: '';
        $manifest->id_kota_asal = ($request->id_kota_asal) ?: 0;
        $manifest->id_kota_tujuan = ($request->id_kota_tujuan) ?: 0;
        $manifest->dibuat_oleh = ($request->dibuat_oleh) ?: 0;
        $manifest->dicek_oleh = ($request->dicek_oleh) ?: 0;
        $manifest->id_agen_penerima = ($request->id_agen_penerima) ?: 0;
        $manifest->agen_tujuan = ($request->agen_tujuan) ?: 0;
        $manifest->jumlah_kg = ($request->jumlah_kg) ?: 0;
        $manifest->jumlah_koli = ($request->jumlah_koli) ?: 0;
        $manifest->jumlah_doc = ($request->jumlah_doc) ?: 0;
        $manifest->created_at = Carbon::now()->addHours(7);
        $manifest->tanggal_pengiriman = Carbon::now()->addHours(7);
        // dd($manifest);
        $manifest->save();

        // GET AWB BY GROUPING, dan meng update id_manifestnya
        $data['awb'] = Awb::select('awb.*')
            ->where(function ($query): void {
                        $query->where('awb.status_tracking', '=', 'at-manifest')->orWhere('awb.status_tracking', '=', 'booked');
                    })
            ->where('awb.id_manifest', '=', 0)
            ->where('awb.id_kota_tujuan', '=', $manifest['id_kota_tujuan'])
            ->where('awb.id_kota_asal', '=', $manifest['id_kota_asal'])
            ->where('awb.id_agen_penerima', '=', $manifest['agen_tujuan'])//--------------------BARU
            ->where(function ($query): void {
                        $query->where('awb.created_at', '<=', Carbon::now()->hour(ApplicationSetting::getJamMinim())->minute(0)->second(0));
                        // ->where('awb.created_at', '>',  Carbon::yesterday()->hour(ApplicationSetting::getJamMinim())->minute(0)->second(0));
                    })
            ->get();
        foreach ($data['awb'] as $item) {
            $item['id_manifest'] = $manifest['id'];
            $item->save();
        }

        // FOREACH UNTUK MENG HITUNG HARGA OA SHIPMENT
        $data['awb_update'] = Awb::select(DB::raw('customer.id as idcust,ROUND((customer.harga_oa / count(awb.id)),2) as dividedoa,count(awb.id) as total'))
            ->join('customer as customer', 'customer.id', '=', 'awb.id_customer')
            ->where(function ($query): void {
                        $query->where('awb.status_tracking', '=', 'at-manifest')->orWhere('awb.status_tracking', '=', 'booked');
                    })
            ->where('awb.id_manifest', '=', $manifest['id'])
            ->where('customer.jenis_out_area', '=', 'shipment')
            ->where('awb.id_kota_tujuan', '=', $manifest['id_kota_tujuan'])
            ->where('awb.id_kota_asal', '=', $manifest['id_kota_asal'])
            ->where('awb.id_agen_penerima', '=', $manifest['agen_tujuan'])//--------------------BARU
            ->where('awb.charge_oa', '=', 1)
            ->orderBy('id_customer', 'desc')
            ->groupBY('customer.id', 'customer.harga_oa')
            ->get();

        // FOREACH UNTUK MENG UPDATE HARGA OA SHIPMENT
        foreach ($data['awb_update'] as $item) {
            DB::table('awb')
                ->where('id_manifest', $manifest['id'])
                ->where('id_customer', $item['idcust'])
                ->where('charge_oa', 1)
                ->update(
                    ['idr_oa' => $item['dividedoa'],
                        'total_harga' => DB::raw('awb.total_harga+' . $item['dividedoa']),
                    ]
                );
        }

        return redirect('master/manifest')->with('message', 'created');
    }

    public function edit($kotaasal, $kotatujuan, $agentujuan)
    {
        if ((int) Auth::user()->level == 1) {
            $data['manifest'] = Manifest::find(0);
            $data['nopol'] = DB::SELECT('select distinct(keterangan) from manifest order by keterangan asc');
            $data['kotaasal'] = Kota::where('id', '=', $kotaasal)->get();
            $data['kotatujuan'] = Kota::where('id', '=', $kotatujuan)->get();
            $data['agentujuan'] = Agen::where('id', '=', $agentujuan)->get();

            $data['awb'] = Awb::select(
                'awb.*',
                'customer.nama as namacust',
                'kotatujuan.nama as kotatujuan',
                DB::raw('(awb.qty_kecil + awb.qty_sedang + awb.qty_besar + awb.qty_besarbanget) as qtykoli')
            )
                ->join('customer', 'customer.id', '=', 'awb.id_customer')
                ->join('kota as kotatujuan', 'kotatujuan.id', '=', 'awb.id_kota_tujuan')
                ->where(function ($query): void {
                                $query->where('awb.status_tracking', '=', 'at-manifest')->orWhere('awb.status_tracking', '=', 'booked');
                            })
                ->where('awb.id_manifest', '=', 0)
                ->where('awb.id_kota_asal', '=', $kotaasal)
                ->where('awb.id_kota_tujuan', '=', $kotatujuan)
                ->where('awb.id_agen_penerima', '=', $agentujuan)//--------------------BARU
                ->where(function ($query): void {
                                $query->where('awb.created_at', '<=', Carbon::now()->hour(ApplicationSetting::getJamMinim())->minute(0)->second(0));
                                // ->where('awb.created_at', '>',  Carbon::yesterday()->hour(ApplicationSetting::getJamMinim())->minute(0)->second(0));
                            })
                ->orderBy('awb.id_customer', 'desc')
                ->get();

            return view('pages.master.manifest.edit', $data);
        }
        echo 'Create Manifest only for admin!';

    }

    public function grouping()
    {
        if ((int) Auth::user()->level == 1) {
            $data['awb'] = Awb::select(DB::raw('
                                kotaasal.id as idkotaasal,
                                kotatujuan.id as idkotatujuan,
                                kotaasal.kode as kotaasal,
                                kotatujuan.kode as kotatujuan,
                                agentujuan.kode as agentujuan,
                                agentujuan.id as idagentujuan,
                                count(awb.id) as total'))
                ->join('kota as kotaasal', 'kotaasal.id', '=', 'awb.id_kota_asal')
                ->join('kota as kotatujuan', 'kotatujuan.id', '=', 'awb.id_kota_tujuan')
                ->join('agen as agentujuan', 'agentujuan.id', '=', 'awb.id_agen_penerima')//-------BARU
                ->where(function ($query): void {
                                $query->where('awb.status_tracking', '=', 'at-manifest')->orWhere('awb.status_tracking', '=', 'booked');
                            })
                ->where('awb.id_manifest', '=', 0)
                ->where(function ($query): void {
                                $query->where('awb.created_at', '<=', Carbon::now()->hour(ApplicationSetting::getJamMinim())->minute(0)->second(0));
                                // ->where('awb.created_at', '>',  Carbon::yesterday()->hour(ApplicationSetting::getJamMinim())->minute(0)->second(0));
                            })
                ->groupBy('kotaasal.kode', 'kotatujuan.kode', 'kotaasal.id', 'kotatujuan.id', 'agentujuan.kode', 'agentujuan.id')
                ->get();

            return view('pages.master.manifest.grouping', $data);
        }
        echo 'Grouping only for admin!';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
