<?php

namespace App\Http\Controllers\Master;

use App\Agen;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Kota;
use Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CustomerController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        if ((int) Auth::user()->page_customer == 1) {
            return view('pages.master.customer.index');
        }
        abort(403);
    }

    public function create()
    {
        $kota = Kota::where('id', '>', 0)->get();
        $agen = Agen::orderBy('nama', 'ASC')->get();

        return view('pages.master.customer.create', compact('kota', 'agen'));
    }

    public function edit($id)
    {
        if ((int) Auth::user()->page_customer == 1) {
            $kota = Kota::where('id', '>', 0)->get();
            $customer = Customer::find($id);
            $agen = Agen::orderBy('nama', 'ASC')->get();

            return view('pages.master.customer.edit', compact('customer', 'kota', 'agen'));
        }
        abort(403);
    }

    public function delete(Request $request)
    {
        $customer = Customer::find($request->id);
        Customer::find($request->id)->delete();

        return response()->json(['customer' => $customer]);
    }

    public function save(Request $request)
    {
        $access = false;
        $id_agen = 0;
        if ($request->access == 'on') {
            $access = true;
        }
        $is_agen = false;
        if ($request->is_agen == 'on') {
            $is_agen = true;
            $id_agen = $request->id_agen;
        }

        $customer = Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'notelp' => $request->notelp,
            // 'rekening'                  => $request->rekening,
            // 'bank'                      => $request->bank,
            // 'rekeningatasnama'          => $request->rekeningatasnama,
            'harga_oa' => preg_replace('/\D/', '', $request->harga_oa),
            'harga_koli_k' => preg_replace('/\D/', '', $request->harga_koli_k),
            'harga_koli_s' => preg_replace('/\D/', '', $request->harga_koli_s),
            'harga_koli_b' => preg_replace('/\D/', '', $request->harga_koli_b),
            'harga_koli_bb' => preg_replace('/\D/', '', $request->harga_koli_bb),
            'harga_kg' => preg_replace('/\D/', '', $request->harga_kg),
            'harga_doc' => preg_replace('/\D/', '', $request->harga_doc),
            'harga_kg_selanjutnya' => preg_replace('/\D/', '', $request->harga_kg_selanjutnya),
            'can_access_satuan' => $access,
            'kode' => $request->kode,
            'idkota' => $request->idkota,
            'jenis_out_area' => $request->jenis_out_area,
            'kodepos' => $request->kodepos,
            'is_agen' => $is_agen,
            'id_agen' => $id_agen,
        ]);

        return redirect('master/customer')->with('message', 'created');
    }

    public function update(Request $request)
    {
        $access = false;
        $id_agen = 0;
        if ($request->access == 'on') {
            $access = true;
        }
        $is_agen = false;
        if ($request->is_agen == 'on') {
            $is_agen = true;
            $id_agen = $request->id_agen;
            $agen_check = Customer::where('id_agen', $id_agen)->first();
            if ($agen_check !== null) {
                return redirect('master/customer')->with('failed', $agen_check->nama);
            }
        }
        $customer = Customer::find($request->id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'notelp' => $request->notelp,
            // 'rekening'                  => $request->rekening,
            // 'bank'                      => $request->bank,
            // 'rekeningatasnama'          => $request->rekeningatasnama,
            'harga_oa' => preg_replace('/\D/', '', $request->harga_oa),
            'harga_koli_k' => preg_replace('/\D/', '', $request->harga_koli_k),
            'harga_koli_s' => preg_replace('/\D/', '', $request->harga_koli_s),
            'harga_koli_b' => preg_replace('/\D/', '', $request->harga_koli_b),
            'harga_koli_bb' => preg_replace('/\D/', '', $request->harga_koli_bb),
            'harga_kg' => preg_replace('/\D/', '', $request->harga_kg),
            'harga_doc' => preg_replace('/\D/', '', $request->harga_doc),
            'harga_kg_selanjutnya' => preg_replace('/\D/', '', $request->harga_kg_selanjutnya),
            'can_access_satuan' => $access,
            'kode' => $request->kode,
            'idkota' => $request->idkota,
            'jenis_out_area' => $request->jenis_out_area,
            'kodepos' => $request->kodepos,
            'is_agen' => $is_agen,
            'id_agen' => $id_agen,
        ]);

        return redirect('master/customer')->with('message', 'updated');
    }

    public function datatables()
    {
        $customer = Customer::all();

        return Datatables::of($customer)
            ->addColumn('akses_satuan', function ($a) {
                if ($a->can_access_satuan) {
                    return '<span class="label label-lg label-success label-inline mr-2">Diberikan Hak Akses</span>';
                }

                return '<span class="label label-lg label-danger label-inline mr-2">Tidak Diberikan</span>';
            })
            ->addColumn('aksi', function ($a) {
                if ($a->id == 26) {
                    return '<div class="btn-group" role="group" aria-label="Basic example">
                <a href="' . url('master/customer/edit/' . $a['id']) . '" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Edit Customer">
                    <i class="flaticon-edit-1"></i>
                </a>
                </div>';
                }

                return '<div class="btn-group" role="group" aria-label="Basic example">
                    <a href="' . url('master/customer/edit/' . $a['id']) . '" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Edit Customer">
                        <i class="flaticon-edit-1"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Hapus Customer" onClick="deleteCustomer(' . $a['id'] . ')"> <i class="flaticon-delete"></i> </button>
                    </div>';
            })
            ->addColumn('details_url', function ($a) {
                return url('master/customer/data-harga/' . $a->id);
            })
            ->rawColumns(['aksi', 'akses_satuan'])
            ->make(true);
    }
}
