<?php

namespace App\Http\Controllers\Master;

use App\Agen;
use App\Http\Controllers\Controller;
use App\Kota;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AgenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if ((int) Auth::user()->page_agen == 1) {
            $kota = Kota::orderBy('nama', 'asc')->get();

            return view('pages.master.agen.index', compact('kota'));
        }
        abort(403);
    }

    public function save(Request $request)
    {
        $agen = Agen::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'presentase' => $request->presentase,
            'idkota1' => $request->idkota1,
            'idkota2' => $request->idkota2,
            'idkota3' => $request->idkota3,
            'idkota4' => $request->idkota4,
            'idkota5' => $request->idkota5,
            'idkota6' => $request->idkota6,
            'idkota7' => $request->idkota7,
            'idkota8' => $request->idkota8,
            'idkota9' => $request->idkota9,
            'idkota10' => $request->idkota10,
            'has_harga_khusus' => $request->has_harga_khusus,
            'harga_doc' => $request->harga_doc,
            'harga_kg' => $request->harga_kg,
            'harga_kg_selanjutnya' => $request->harga_kg_selanjutnya,
            'harga_koli_b' => $request->harga_koli_b,
            'harga_koli_bb' => $request->harga_koli_bb,
            'harga_koli_k' => $request->harga_koli_k,
            'harga_koli_s' => $request->harga_koli_s,
        ]);

        return redirect('master/agen')->with('message', 'created');
    }

    public function update(Request $request)
    {
        // dd($request);
        $agen = Agen::find($request->id)->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'presentase' => $request->presentase,
            'idkota1' => $request->idkota1,
            'idkota2' => $request->idkota2,
            'idkota3' => $request->idkota3,
            'idkota4' => $request->idkota4,
            'idkota5' => $request->idkota5,
            'idkota6' => $request->idkota6,
            'idkota7' => $request->idkota7,
            'idkota8' => $request->idkota8,
            'idkota9' => $request->idkota9,
            'idkota10' => $request->idkota10,
            'has_harga_khusus' => $request->has_harga_khusus,
            'harga_doc' => $request->harga_doc,
            'harga_kg' => $request->harga_kg,
            'harga_kg_selanjutnya' => $request->harga_kg_selanjutnya,
            'harga_koli_b' => $request->harga_koli_b,
            'harga_koli_bb' => $request->harga_koli_bb,
            'harga_koli_k' => $request->harga_koli_k,
            'harga_koli_s' => $request->harga_koli_s,
        ]);

        return redirect('master/agen')->with('message', 'updated');
    }

    public function edit(Request $request)
    {
        $agen = Agen::find($request->id);

        return response()->json(['agen' => $agen]);
    }

    public function delete(Request $request)
    {
        $agen = Agen::find($request->id);
        $user = User::where('id', $agen->user_id)->first();
        Agen::find($request->id)->delete();

        return response()->json(['agen' => $agen]);
    }

    public function datatables()
    {
        $agen = DB::SELECT('SELECT a.* FROM agen a WHERE a.deleted_at IS NULL  ');
        $agens = new Collection();
        $strings = '';
        foreach ($agen as $a) {
            $kota = DB::SELECT('SELECT * FROM view_agen_kota WHERE agen_id = ' . $a->id);
            foreach ($kota as $k) {
                $strings .= '<span class="label label-lg label-dark label-inline mr-2">' . $k->nama . '</span>';
            }
            $agens->push([
                'id' => $a->id,
                'kode' => $a->kode,
                'nama_agen' => $a->nama,
                'alamat_agen' => $a->alamat,
                'no_telp' => $a->no_telp,
                'presentase' => $a->presentase,
                'coverage' => $strings,
                'has_harga_khusus' => $a->has_harga_khusus,
            ]);
            $strings = '';
        }

        return Datatables::of($agens)
            ->editColumn('presentase', function ($a) {
                return $a['presentase'] . ' % ';
            })
            ->addColumn('aksi', function ($a) {
                $btnhapus = '<button type="button" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Hapus " onClick="deleteAgen(' . $a['id'] . ')"> <i class="flaticon-delete"></i> </button>';

                return '<div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Edit Agen">
                    <i class="flaticon-edit-1"  data-toggle="modal" data-target="#modal-edit-agen" onClick="editAgen(' . $a['id'] . ')"></i>
                </button>
                ' . (($a['id'] > 1) ? $btnhapus : '') . '
                </div>';
            })
            ->addColumn('hargakhusus', function ($a) {
                if ((int) $a['has_harga_khusus'] == 1) {
                    return '<span class="label label-lg label-success label-inline mr-2">ya</span>';
                }

                return '<span class="label label-lg label-danger label-inline mr-2">Tidak</span>';
            })
            ->rawColumns(['coverage', 'aksi', 'presentase', 'hargakhusus'])
            ->make(true);
    }
}
