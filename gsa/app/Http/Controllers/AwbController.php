<?php

namespace App\Http\Controllers;

use App\Agen;
use App\Alamat;
use App\Applicationsetting;
use App\Awb;
use App\Customer;
use App\Detailqtyscanned;
use App\Historyscanawb;
use App\Kecamatan;
use App\Kota;
use App\Manifest;
use App\ViewAgenKota;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AwbController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $is_akses_qty = 'false';
        $hide_qty = 'false';
        $customer = Customer::find(Auth::user()->id_customer);
        if (!empty($customer)) {
            if ($customer->can_access_satuan == 1) {
                $is_akses_qty = 'true';
            }
            if ($customer->is_agen == 1) {
                $hide_qty = 'true';
            }
        } else {
            if ((int) Auth::user()->level == 1) {
                $is_akses_qty = 'true';
            }
        }
        $master_customer = Customer::all();
        $kota = Kota::where('id', '>', 0)->where('status', 'aktif')->get();
        $data['awbbelumditerima'] = Awb::cek_penerima_kosong();

        return view('pages.awb.index', compact('is_akses_qty', 'hide_qty', 'master_customer', 'kota'), $data);
    }

    public function edit($id, $hilang)
    {
        $customer = '';
        $agen_tujuan = '';
        $kota = Kota::where('id', '>', 0)->where('status', 'aktif')->get();
        if ((int) Auth::user()->level == 2) {
            $customer = Customer::where('id', Auth::user()->id_customer)->first();
        } elseif ((int) Auth::user()->level == 1) {
            $customer = Customer::all();
        }
        $awb = Awb::find($id);

        $alamat_pengirim = Alamat::where('alamat', $awb->alamat_pengirim)->first();
        $alamat_pengirim_array = '';
        if (!isset($alamat_pengirim)) {
            $alamat_pengirim = 'manual';
        } else {
            $alamat_pengirim_array = Alamat::where('pelanggan_id', $alamat_pengirim->pelanggan_id)->get();
        }

        $alamat_tujuan = Alamat::where('alamat', $awb->alamat_tujuan)->first();
        $alamat_tujuan_array = '';
        if (!isset($alamat_tujuan)) {
            $alamat_tujuan = 'manual';
        } else {
            $alamat_tujuan_array = Alamat::where('pelanggan_id', $alamat_tujuan->pelanggan_id)->get();
        }
        $master_alamat = [];
        if ($id !== 0) {
            $master_alamat = Alamat::where('pelanggan_id', $awb->id_customer)->get();
        }
        $id = $id;
        $kecamatan_tujuan = Kecamatan::where('idkota', $awb->id_kota_tujuan)->get();
        $agen_master = ViewAgenKota::where('id', $awb->id_kota_tujuan)->where('status', 'aktif')->get();
        $agen_tujuan = Agen::find($awb->id_agen_penerima);
        if (empty($agen_tujuan)) {
            $agen_tujuan = ViewAgenKota::where('id', $awb->id_kota_tujuan)->where('status', 'aktif')->get();
        }
        $hilang = $hilang;

        return view('pages.awb.create', compact('kota', 'hilang', 'customer', 'awb', 'agen_tujuan', 'agen_master', 'id', 'alamat_pengirim_array', 'kecamatan_tujuan', 'alamat_pengirim', 'alamat_tujuan_array', 'alamat_tujuan', 'master_alamat'));
    }

    public function save(Request $request)
    {
        if ((int) Carbon::now()->addHours(7)->format('H') >= 16 && (int) Auth::user()->level == 2) {
            return redirect('awb')->with('outoftime', 'booking sudah melebihi jam input');
        }
        $ada_faktur = 0;
        if ($request->ada_faktur == 'on') {
            $ada_faktur = 1;
        }
        $id_sby = (int) ApplicationSetting::checkappsetting('id-surabaya');
        $noawb = Awb::getNoAwb();
        $noawb .= $this->randomChar();
        $kecamatan = Kecamatan::find($request->id_kecamatan_tujuan);
        $charge_oa = $kecamatan->oa;
        $created_at = date('Y-m-d H:i:s', strtotime(date('Y-M-d H:i:s')) + 7 * 3600);
        $customer = Customer::find($request->id_customer);
        $total_harga = ['total' => null, 'oa' => null];
        $harga_oa = 0;
        $qty = ($request->qty == null) ? 0 : $request->qty;
        if ($request->jenis_koli == 'koli') {
            $request->qty_doc = 0;
            $request->qty_kg = 0;
        } elseif ($request->jenis_koli == 'dokumen') {
            $request->qty_kecil = 0;
            $request->qty_sedang = 0;
            $request->qty_besar = 0;
            $request->qty_besar_banget = 0;
            $request->qty_kg = 0;
        } elseif ($request->jenis_koli == 'kg') {
            $request->qty_kecil = 0;
            $request->qty_sedang = 0;
            $request->qty_besar = 0;
            $request->qty_besar_banget = 0;
            $request->qty_doc = 0;
        } else {
            $request->qty_kecil = 0;
            $request->qty_sedang = 0;
            $request->qty_besar = 0;
            $request->qty_besar_banget = 0;
            $request->qty_doc = 0;
            $request->qty_kg = 0;
        }
        $id_agen_asal = 0;
        $harga_charge = ($request->harga_charge == null) ? 0 : str_replace(',', '', $request->harga_charge);
        if ($customer->is_agen == 0) {
            if ((int) Auth::user()->level == 1 || ((int) Auth::user()->level == 2 && $customer->can_access_satuan == 1)) {
                $agen_tujuan = Agen::where('id', $request->id_agen_penerima)->first();

                $harga_agen_or_customer = ($agen_tujuan->has_harga_khusus == 1) ? $agen_tujuan : $customer;
                $total_harga = $this->hitungHargaTotal($request->qty_kecil, $request->qty_sedang, $request->qty_besar, $request->qty_besar_banget, $request->qty_kg, $request->qty_doc, $harga_agen_or_customer, $charge_oa, $harga_charge);
                $qty = $request->qty_kecil + $request->qty_sedang + $request->qty_besar + $request->qty_besar_banget + $request->qty_kg + $request->qty_doc;
            }
            // if ((int) Auth::user()->level == 2 && $customer->can_access_satuan == 1):
            //     $total_harga = $this->hitungHargaTotal($request->qty_kecil, $request->qty_sedang, $request->qty_besar, $request->qty_besar_banget, $request->qty_kg, $request->qty_doc, $customer, $charge_oa);
            //     $qty         = $request->qty_kecil + $request->qty_sedang + $request->qty_besar + $request->qty_besar_banget + $request->qty_kg + $request->qty_doc;
            // endif;
        } else {
            if ((int) Auth::user()->level == 1) {
                $total_harga['total'] = str_replace(',', '', $request->harga_total);
            }
            $id_agen_asal = $customer->id_agen;
            if ($id_agen_asal == 0) {
                return redirect('awb')->with('failed_customer', $customer->nama);
            }
        }
        // dd($total_harga);
        $labelalamat = '';
        if ($request->labelalamat !== 'manual') {
            $masteralamat = Alamat::where('alamat', $request->labelalamat)->first();
            $labelalamat = $masteralamat->labelalamat;
        }
        $harga_kg_pertama = ($request->harga_kg_pertama == null) ? 0 : str_replace(',', '', $request->harga_kg_pertama);
        $harga_kg_selanjutnya = ($request->harga_kg_selanjutnya == null) ? 0 : str_replace(',', '', $request->harga_kg_selanjutnya);
        if ($customer->id == 26) {
            $total_harga['total'] = $this->hitungHargaKg($request->qty_kg, $harga_kg_pertama, $harga_kg_selanjutnya, $charge_oa, $customer, $request->hilang, $harga_charge);
        }
        if ($request->id_kota_asal == $id_sby) {
            $id_agen_asal = 1;
        }
        if ($request->hilang == 'hilang') {
            $total_harga['oa'] = 0;
            $total_harga['total'] = -1 * $total_harga['total'];
        }
        $harga_gsa = str_replace(',', '', $request->harga_gsa);
        if ($request->idawb == 0 || ($request->referensi !== '' && $request->referensi !== null)) {
            $awb = Awb::create([
                'noawb' => $noawb,
                'id_customer' => $request->id_customer,
                'id_kota_tujuan' => $request->id_kota_tujuan,
                'id_kota_asal' => $request->id_kota_asal,
                'id_kota_transit' => $request->id_kota_transit,
                'id_agen_asal' => $id_agen_asal,
                'id_agen_penerima' => ($request->id_agen_penerima == null) ? 0 : $request->id_agen_penerima,
                'charge_oa' => $charge_oa,
                'nama_penerima' => $request->nama_penerima,
                'alamat_tujuan' => $request->alamat_tujuan,
                'notelp_penerima' => $request->notelp_penerima,
                'kodepos_penerima' => $request->kodepos_penerima,
                'nama_pengirim' => $request->nama_pengirim,
                'alamat_pengirim' => $request->alamat_pengirim,
                'kodepos_pengirim' => $request->kodepos_pengirim,
                'notelp_pengirim' => $request->notelp_pengirim,
                'keterangan' => $request->keterangan,
                'total_harga' => ($total_harga['total'] == null) ? 0 : $total_harga['total'],
                'tanggal_awb' => date('Y-m-d', strtotime($request->tanggal_awb)),
                'created_by' => Auth::user()->id,
                'status_invoice' => 0,
                'status_tracking' => ($request->referensi == null) ? 'booked' : 'complete',
                'status_manifest' => 0,
                'status_paid_agen' => 0,
                'qty_kecil' => ($request->qty_kecil == null) ? 0 : $request->qty_kecil,
                'qty_sedang' => ($request->qty_sedang == null) ? 0 : $request->qty_sedang,
                'qty_besar' => ($request->qty_besar == null) ? 0 : $request->qty_besar,
                'qty_besarbanget' => ($request->qty_besar_banget == null) ? 0 : $request->qty_besar_banget,
                'qty_kg' => ($request->qty_kg == null) ? 0 : $request->qty_kg,
                'qty_doc' => ($request->qty_doc == null) ? 0 : $request->qty_doc,
                'qty' => ($qty == null) ? 0 : $qty,
                'id_kecamatan_tujuan' => $request->id_kecamatan_tujuan,
                'created_at' => $created_at,
                'idr_oa' => ($total_harga['oa'] == null) ? 0 : $total_harga['oa'],
                'id_manifest' => 0,
                'id_invoice' => 0,
                'is_agen' => $customer->is_agen,
                'ada_faktur' => $ada_faktur,
                'referensi' => $request->referensi,
                'jenis_koli' => $request->jenis_koli,
                'labelalamat' => $labelalamat,
                'harga_kg_pertama' => $harga_kg_pertama,
                'harga_kg_selanjutnya' => $harga_kg_selanjutnya,
                'jenis_oa' => $customer->jenis_out_area,
                'harga_charge' => $harga_charge,
                'harga_gsa' => $harga_gsa,
                'jumlah_koli' => $request->jumlah_koli,
            ]);
            $this->inserthistoryscan($awb->id, (($request->referensi == null) ? 'booked' : 'complete'), 0);

            return redirect('awb')->with('message', 'created');
        }
        $before_update = Awb::find($request->idawb);
        $awb = Awb::find($request->idawb)->update([
            'id_customer' => $request->id_customer,
            'id_kota_tujuan' => $request->id_kota_tujuan,
            'id_kota_asal' => $request->id_kota_asal,
            'id_kota_transit' => $request->id_kota_transit,
            'id_agen_asal' => $id_agen_asal,
            'id_agen_penerima' => ($request->id_agen_penerima == null) ? 0 : $request->id_agen_penerima,
            'charge_oa' => $charge_oa,
            'nama_penerima' => $request->nama_penerima,
            'alamat_tujuan' => $request->alamat_tujuan,
            'notelp_penerima' => $request->notelp_penerima,
            'kodepos_penerima' => $request->kodepos_penerima,
            'nama_pengirim' => $request->nama_pengirim,
            'alamat_pengirim' => $request->alamat_pengirim,
            'kodepos_pengirim' => $request->kodepos_pengirim,
            'notelp_pengirim' => $request->notelp_pengirim,
            'keterangan' => $request->keterangan,
            'total_harga' => ($total_harga['total'] == null) ? 0 : $total_harga['total'],
            'tanggal_awb' => $before_update->tanggal_awb,
            'status_invoice' => 0,
            'status_tracking' => 'booked',
            'status_manifest' => 0,
            'status_paid_agen' => 0,
            'qty_kecil' => ($request->qty_kecil == null) ? 0 : $request->qty_kecil,
            'qty_sedang' => ($request->qty_sedang == null) ? 0 : $request->qty_sedang,
            'qty_besar' => ($request->qty_besar == null) ? 0 : $request->qty_besar,
            'qty_besarbanget' => ($request->qty_besar_banget == null) ? 0 : $request->qty_besar_banget,
            'qty_kg' => ($request->qty_kg == null) ? 0 : $request->qty_kg,
            'qty_doc' => ($request->qty_doc == null) ? 0 : $request->qty_doc,
            'qty' => ($qty == null) ? 0 : $qty,
            'id_kecamatan_tujuan' => $request->id_kecamatan_tujuan,
            'created_at' => $created_at,
            'idr_oa' => ($total_harga['oa'] == null) ? 0 : $total_harga['oa'],
            'id_manifest' => 0,
            'id_invoice' => 0,
            'tanggal_diterima' => $before_update->tanggal_diterima,
            'is_agen' => $customer->is_agen,
            'ada_faktur' => $ada_faktur,
            'jenis_koli' => $request->jenis_koli,
            'labelalamat' => $labelalamat,
            'harga_kg_pertama' => $harga_kg_pertama,
            'harga_kg_selanjutnya' => $harga_kg_selanjutnya,
            'jenis_oa' => $customer->jenis_out_area,
            'harga_charge' => $harga_charge,
            'harga_gsa' => $harga_gsa,
            'jumlah_koli' => $request->jumlah_koli,
        ]);

        return redirect('awb')->with('message', 'updated');
    }

    public function delete(Request $request)
    {
        $awb = DB::table('awb')->where('id', $request->id)->first();
        if ((int) $awb->id_manifest == 0 && ($awb->status_tracking == 'booked' || $awb->status_tracking == 'at-manifest')) {
            DB::table('awb')
                ->where('id', $request->id)
                ->update(['status_tracking' => 'cancel']);

            return response()->json(['awb' => $awb, 'status' => 'success']);
        }

        return response()->json(['awb' => $awb, 'status' => 'failed', 'message' => 'AWB gagal di cancel (AWB sudah dibuatkan manifest)']);
    }

    public function updatemanifestqr(Request $request)
    {
        $kode = $request->kode;
        $status = ($request->status_nonencrypt) ?: Crypt::decrypt($request->status);
        $returnmessage = '';
        $typereturn = ' ';
        $openmodal = ($status == 'complete') ? 'open' : 'close';
        $manifest = Manifest::where('kode', $request->kode)->first();
        $awb = Awb::where('id_manifest', ($manifest != null) ? $manifest->id : 0)->get();
        $continue = true;

        // ----------------------------------------VALIDATE-------------------------------------
        // ----------------------------------------VALIDATE-------------------------------------
        if ($continue == true && $manifest == null) {
            $continue = false;
            $returnmessage = 'Kode Manifest ' . $kode . ' tidak ditemukan!';
            $typereturn = 'statuserror';

            return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
        }
        if ($continue == true && $manifest->status == 'checked' && $status == 'arrived') {
            $continue = false;
            $returnmessage = 'Kode MANIFEST ' . $kode . ', Masih berstatus ' . $manifest->status . '!<br><br> tidak bisa di rubah langsung ke arrived! ';
            $typereturn = 'statuswarning';

            return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
        }
        if ($continue == true && $manifest->status == 'arrived') {
            $continue = false;
            $returnmessage = 'Kode MANIFEST ' . $kode . ', Sudah berstatus ' . $manifest->status . ', tidak bisa di scan lagi!';
            $typereturn = 'statuswarning';

            return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
        }
        // ----------------------------------------END OF VALIDATE-------------------------------------
        // ----------------------------------------END OF VALIDATE-------------------------------------

        if (!$manifest && $continue == true) {
            $returnmessage = 'Kode MANIFEST ' . $kode . ' tidak ditemukan!';
            $typereturn = 'statuserror';
        } elseif ($manifest->id && $continue == true) {
            if ($manifest->status == $status) {
                $returnmessage = 'Kode AWB ' . $kode . ' Sudah berstatus ' . $status . '!';
                $typereturn = 'statuswarning';
            } else {
                $manifest->status = $status;
                if ($status == 'arrived') {
                    $manifest->discan_terima_oleh = (int) Auth::user()->id;
                    $manifest->discan_diterima_oleh_nama = Auth::user()->nama;
                    $manifest->tanggal_diterima = Carbon::now()->addHours(7);
                }

                $manifest->save();
                if ($status == 'delivering' || $status == 'arrived') {
                    $this->inserthistoryscan(0, (($status == 'delivering') ? 'loaded' : 'at-agen'), $manifest['id']);
                    //---------------UPDATE STATUS_TRACKING DI TABLE AWB---------------------------------------------
                    DB::table('awb')->where('id_manifest', $manifest['id'])->update(['status_tracking' => (($status == 'delivering') ? 'loaded' : 'at-agen')]);
                }

                $data['success'] = $manifest->wasChanged('status');
                $returnmessage = 'Update Kode MANIFEST ' . $kode . ' ke ' . $status . ', sukses di update!';
                // echo($manifest['id']);
                $typereturn = 'statussuccess';
            }
        }

        return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'manifest' => $manifest, 'awb' => $awb]);
    }

    public function updateawb(Request $request)
    {
        $kode = $request->kode;
        $qty = $request->qty;
        $status = ($request->status_nonencrypt) ?: Crypt::decrypt($request->status);
        $returnmessage = '';
        $typereturn = ' ';
        $openmodal = 'close';
        $awb = Awb::where('noawb', $request->kode)->first();
        $continue = true;
        if ($awb == null) {
            $returnmessage = 'Kode AWB ' . $kode . ' tidak ditemukan!';
            $typereturn = 'statuserror';

            return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
        }

        // ----------------------------------------VALIDATE-------------------------------------
        // ----------------------------------------VALIDATE-------------------------------------

        // CEK jika AWB belum diterima agen, maka tidak bisa diganti status+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if (($status == 'delivery-by-courier' || $status == 'complete') && ($awb->status_tracking == 'loaded' || $awb->status_tracking == 'at-manifest' || $awb->status_tracking == 'booked') && $continue == true) {
            $continue = false;
            $returnmessage = 'Gagal ganti status, Kode AWB <b>' . $kode . '</b>, Belum diterima agen! <br><br> AWB wajib di teirma agen terlebih dahulu';
            $typereturn = 'statuswarning';
        }

        // CEK jika AWB belum masuk /ditarik ke manifest, maka tidak bisa diganti status+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if (($status == 'loaded' || $status == 'at-agen' || $status == 'delivery-by-courier' || $status == 'complete') && $awb->id_manifest == 0 && $continue == true) {
            $continue = false;
            $returnmessage = 'Gagal ganti status, Kode AWB <b>' . $kode . '</b>, Belum masuk di daftar manifest! ';
            $typereturn = 'statuswarning';
        }

        // CEK jika awb sudah berstatus complete/cancel, sudah tidak bisa dirubah status lagi!
        if (($awb->status_tracking == 'complete' || $awb->status_tracking == 'cancel') && $continue == true && $status != 'complete') {
            $continue = false;
            $returnmessage = 'Kode AWB <b>' . $kode . '</b>, Sudah berstatus ' . $awb->status_tracking . ', tidak bisa di rubah lagi!';
            $typereturn = 'statuswarning';
        }
        // ----------------------------------------END OF VALIDATE-------------------------------------
        // ----------------------------------------END OF VALIDATE-------------------------------------

        if (!$awb && $continue == true) {
            //JIKA KODE TIDAK DITEMUKAN----------------------------------------
            $returnmessage = 'Kode AWB ' . $kode . ' tidak ditemukan!';
            $typereturn = 'statuserror';
        } elseif ($awb->id && $continue == true) {

            //------------HITUNG UNTUK MENDAPATKAN TOTAL QTY ORI--------------------------------
            //------------HITUNG UNTUK MENDAPATKAN TOTAL QTY ORI--------------------------------
            $qty_umum = $awb->qty;
            if ($awb->qty_kecil > 0 || $awb->qty_sedang > 0 || $awb->qty_besar > 0 || $awb->qty_besarbanget > 0) {
                $qty_umum = $awb->qty_kecil + $awb->qty_sedang + $awb->qty_besar + $awb->qty_besarbanget;
            }
            if ($awb->qty_kg > 0) {
                $qty_umum = ($awb->jumlah_koli == 0) ? 1 : $awb->jumlah_koli;
            }
            if ($awb->qty_doc > 0) {
                $qty_umum = $awb->qty_doc;
            }
            //--JIKA KODE AWB , dengan URUTAN ke sekian, sudah discan atau belum
            // $get_detail        = Detailqtyscanned::where('idawb',    '=', $awb->id)->where('status',   '=', $status);
            $qty_count_scanned = Detailqtyscanned::where('idawb', '=', $awb->id)->where('status', '=', $status)->where('qty_ke', '=', $qty)->count();
            $total_scanned = Detailqtyscanned::where('idawb', '=', $awb->id)->where('status', '=', $status)->count();

            if ($qty_count_scanned >= 1 && $qty != 'all') {
                $typereturn = 'statuswarning';
                $returnmessage = 'Kode AWB ' . $kode . ', dengan urutan <b>ke-' . $qty . '</b>, Sudah discan ' . $status . '!';

                return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
            } elseif ($total_scanned == $qty_umum && $qty == 'all') {
                $typereturn = 'statuswarning';
                $returnmessage = 'Kode AWB ' . $kode . ', dengan urutan <b>ke-' . $qty . '</b>, Sudah discan ' . $status . '!';

                return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
            }

            // if ($awb->status_tracking == $status) {
            //     //JIKA KODE TIDAK DITEMUKAN----------------------------------------
            //     $returnmessage = 'Kode AWB ' . $kode . ' Sudah berstatus ' . $status . '!';
            //     $typereturn    = 'statuswarning';
            // }

            // dd($total_scanned);
            $awb->status_tracking = $status;

            if ($total_scanned == 0) {
                $this->inserthistoryscan($awb->id, $status, 0);
            }
            for ($i = 1; $i <= ($qty == 'all' ? $qty_umum : 1); ++$i) {
                $this->insertqty($status, $awb->id, $qty_umum, ($qty == 'all' ? $i : $qty));
            }
            $total_scanned = Detailqtyscanned::where('idawb', '=', $awb->id)->where('status', '=', $status)->count();
            $data['success'] = $awb->wasChanged('status_tracking');
            $returnmessage = 'Update Kode AWB ' . $kode . ', ke ' . $status . ', dengan urutan ke-' . $qty . ' sukses di update!';
            $typereturn = 'statussuccess';

            if ($status == 'complete' && ((int) $total_scanned == (int) $qty_umum)) {
                $awb->tanggal_diterima = Carbon::now()->addHours(7);
                $openmodal = 'open';
            }
            $awb->save();
        }

        return response()->json([$typereturn => $returnmessage, 'openmodal' => $openmodal, 'awb' => $awb]);
    }

    public function insertqty($status, $idawb, $qty_ori, $qty_ke): void
    {
        $Detailqtyscanned = new Detailqtyscanned();
        $Detailqtyscanned->idawb = $idawb;
        $Detailqtyscanned->qty_ke = $qty_ke;
        $Detailqtyscanned->qty_ori = $qty_ori;
        $Detailqtyscanned->status = $status;
        $Detailqtyscanned->save();
    }

    public function inserthistoryscan($idawb, $tipe, $idmanifest): void
    {
        if ($idmanifest == 0) {
            $Historyscanawb = new Historyscanawb();
            $Historyscanawb->tipe = $tipe;
            $Historyscanawb->iduser = Auth::user()->id;
            $Historyscanawb->namauser = Auth::user()->nama;
            $Historyscanawb->idawb = $idawb;
            $Historyscanawb->created_at = Carbon::now()->addHours(7);
            $Historyscanawb->save();
        } else {
            $awb_get_for_history['awb'] = Awb::select('awb.*')
                ->where('awb.id_manifest', '=', $idmanifest)
                ->get();
            foreach ($awb_get_for_history['awb'] as $item) {
                // dd($Historyscanawb);
                $history_count_scanned = Historyscanawb::where('idawb', '=', $item->id)->where('tipe', '=', $tipe)->count();
                if ($history_count_scanned == 0) {
                    $Historyscanawb = new Historyscanawb();
                    $Historyscanawb->tipe = $tipe;
                    $Historyscanawb->iduser = Auth::user()->id;
                    $Historyscanawb->namauser = Auth::user()->nama;
                    $Historyscanawb->idawb = $item->id;
                    $Historyscanawb->created_at = Carbon::now()->addHours(7);
                    $Historyscanawb->save();
                }
                //------------HITUNG UNTUK MENDAPATKAN TOTAL QTY ORI--------------------------------
                //------------HITUNG UNTUK MENDAPATKAN TOTAL QTY ORI--------------------------------
                $qty_umum = $item->qty;
                if ($item->qty_kecil > 0 || $item->qty_sedang > 0 || $item->qty_besar > 0 || $item->qty_besarbanget > 0) {
                    $qty_umum = $item->qty_kecil + $item->qty_sedang + $item->qty_besar + $item->qty_besarbanget;
                }
                if ($item->qty_kg > 0) {
                    $qty_umum = 1;
                }
                if ($item->qty_doc > 0) {
                    $qty_umum = $item->qty_doc;
                }
                Detailqtyscanned::where('idawb', $item->id)->where('status', $tipe)->forceDelete();
                for ($i = 1; $i <= $qty_umum; ++$i) {
                    $this->insertqty($tipe, $item->id, $qty_umum, $i);
                }
            }
        }
    }

    public function updatediterima(Request $request)
    {
        $returnmessage = 'Data penerima berhasil disimpan';
        $typereturn = 'statussuccess';
        $kode = $request->kode;
        $awb = Awb::where('noawb', $request->kode)->first();
        $awb->diterima_oleh = $request->diterima_oleh;
        $awb->keterangan_kendala = ($request->keterangan_kendala) ?: '';
        // dd($awb);
        $awb->save();

        return response()->json([$typereturn => $returnmessage]);
    }

    public function updatetomanifest(Request $request)
    {
        $returnmessage = '';
        $typereturn = 'status';
        $kode = $request->id;
        $awb = Awb::where('id', $request->id)->first();
        if ($awb->status_tracking == 'booked') {
            $awb->status_tracking = 'at-manifest';
            $awb->save();
            $this->inserthistoryscan($awb->id, 'at-manifest', 0);
            $returnmessage = 'Status AWB berhasil dirubah ke "at-manifest"';
        }
        // else if($awb->status_tracking == 'at-manifest'){
        //     $returnmessage      = 'Status AWB sudah '.$awb->status_tracking;
        // }

        return response()->json([$typereturn => $returnmessage]);
    }

    public function manifest(Request $request)
    {
        Awb::find($request->id)->update([
            'status_tracking' => 'at-manifest',
            'status_manifest' => 1,
        ]);
        $awb = Awb::find($request->id);

        return response()->json(['awb' => $awb]);
    }

    public function filter_data_penerima(Request $request)
    {
        $customer = Alamat::where('alamat', $request->alamat)->first();

        return response()->json(['customer' => $customer]);
    }

    public function datatables(Request $request)
    {
        $completecondition = ($request->status_complete == '-') ? 'status_tracking <> \'complete\' and status_tracking <> \'cancel\' and' : '';
        $tanggalcondition = ($request->tanggal == '-') ? '' : " AND tanggal_awb ='" . date('Y-m-d', strtotime($request->tanggal)) . "'";
        $customercondition = ($request->customer == '-') ? '' : " AND id_customer ='" . $request->customer . "'";
        $kotacondition = ($request->kota == '-') ? '' : " AND id_kota_tujuan ='" . $request->kota . "'";
        $showbtnhilang = (int) ApplicationSetting::checkappsetting('show-btnhilang');
        $awb = DB::SELECT('SELECT a.*, ka.nama AS kota_asal,kt.nama AS kota_tujuan,ktt.nama AS kota_transit FROM awb a INNER JOIN kota ka ON (a.id_kota_asal = ka.id ) INNER JOIN kota kt ON (a.id_kota_tujuan = kt.id) LEFT JOIN kota ktt ON (a.id_kota_transit = ktt.id) WHERE ' . $completecondition . ' a.id > 0 AND a.deleted_at IS NULL AND EXTRACT(MONTH FROM tanggal_awb) BETWEEN (EXTRACT(MONTH FROM CURRENT_DATE)-1) AND  EXTRACT(MONTH FROM CURRENT_DATE) ' . $tanggalcondition . $customercondition . $kotacondition . ' ORDER BY a.id DESC');
        if ((int) Auth::user()->level !== 1) {
            //dd(Auth::user()->level);
            $awb = DB::SELECT('SELECT a.*, ka.nama AS kota_asal,kt.nama AS kota_tujuan,ktt.nama AS kota_transit FROM awb a INNER JOIN kota ka ON (a.id_kota_asal = ka.id ) INNER JOIN kota kt ON (a.id_kota_tujuan = kt.id) LEFT JOIN kota ktt ON (a.id_kota_transit = ktt.id) WHERE ' . $completecondition . ' a.id_customer = ' . Auth::user()->id_customer . ' AND a.deleted_at IS NULL AND EXTRACT(MONTH FROM tanggal_awb) BETWEEN (EXTRACT(MONTH FROM CURRENT_DATE)-1) AND  EXTRACT(MONTH FROM CURRENT_DATE) ORDER BY a.id DESC');
        }
        $awbs = new Collection();
        // dd($awb);
        foreach ($awb as $a) {
            $print_awb_biasa = '<a href=' . url('printout/awb/' . Crypt::encrypt($a->id)) . ' target="_blank" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Print AWB">
                                <i class="flaticon2-print" ></i>
                            </a>';
            $print_awb_tri = '<a href=' . url('printout/awbtri/' . Crypt::encrypt($a->id)) . ' target="_blank" class="btn btn-sm btn-icon btn-bg-light btn-icon-primary btn-hover-primary" data-toggle="tooltip" data-placement="bottom" title="Tombol Print AWBTRI">
                                <i class="fas fa-print" ></i>
                            </a>';

            $btn_hilang = '';
            if ($a->qty > 0 && $showbtnhilang == 1) {
                $btn_hilang = '
            <a href=' . url('awb/edit/' . $a->id . '/hilang') . ' class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Input Barang Hilang">
            <i class="flaticon-exclamation" ></i>
            </a>';
            }
            if (
                ((int) $a->qty_kecil <= 0 && (int) $a->qty_sedang <= 0 && (int) $a->qty_besar <= 0 && (int) $a->qty_besarbanget <= 0 && (int) $a->qty_doc <= 0 && $a->qty_kg <= 0 && $a->is_agen == 0)
                || ((int) $a->qty <= 0)
            ) {
                $print_awb_biasa = '';
                $print_awb_tri = '';
            }
            $label_customerbiasa = ($a->id_customer == 26) ? '(Customer biasa)' : '';
            $awbs->push([
                'id' => $a->id,
                'noawb' => $a->noawb,
                'nama_pengirim' => $a->nama_pengirim . '<BR><b style="color:orange;">' . $label_customerbiasa . '</b>',
                'id_customer' => $a->id_customer,
                'id_manifest' => $a->id_manifest,
                'id_agen_tujuan' => $a->id_agen_penerima,
                'kota_asal' => $a->kota_asal,
                'kota_tujuan' => $a->kota_tujuan,
                'kota_transit' => $a->kota_transit,
                'alamat_tujuan' => $a->alamat_tujuan,
                'tanggal_awb' => date('d F Y (H:i)', strtotime($a->created_at)),
                'status_tracking' => $a->status_tracking,
                'qty' => $a->qty,
                'kecil' => $a->qty_kecil,
                'sedang' => $a->qty_sedang,
                'besar' => $a->qty_besar,
                'besarbanget' => $a->qty_besarbanget,
                'doc' => $a->qty_doc,
                'kg' => $a->qty_kg,
                'is_agen' => $a->is_agen,
                'print_awb_biasa' => $print_awb_biasa,
                'print_awb_tri' => $print_awb_tri,
                'btn_hilang' => $btn_hilang,
            ]);
        }

        return Datatables::of($awbs)
            ->addColumn('aksi', function ($a) {
                $tombolhapus = '';
                if (($a['status_tracking'] == 'booked' || $a['status_tracking'] == 'at-manifest') && (int) $a['id_manifest'] == 0) {
                    $tombolhapus = '<button type="button" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Hapus AWB" onClick="deleteAwb(' . $a['id'] . ',`' . $a['noawb'] . '`)">
                                    <i class="flaticon-delete"></i>
                                </button>';
                }

                if ($a['status_tracking'] !== 'booked' && (int) Auth::user()->level !== 1) {
                    return '<div class="btn-group" role="group" aria-label="Basic example">
                        <button  type="button" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="modal" data-target="#modal-show" onClick="detail(' . $a['id'] . ',`' . $a['noawb'] . '`)" data-placement="bottom" title="Lihat Data"><i class="flaticon-eye"> </i></button>
                        <a href=' . url('t/' . $a['noawb'] . '/t/1') . ' target="_blank" class="btn btn-sm btn-icon btn-bg-light btn-icon-primary btn-hover-primary" data-toggle="tooltip" data-placement="bottom" title="TRACKING">
                        <i class="fas fa-map-marked-alt" ></i>
                        </a>
                        </div>';
                } elseif ($a['status_tracking'] == 'booked' && (int) Auth::user()->level == 1) {
                    return '<div class="btn-group" role="group" aria-label="Basic example">
                        <a href=' . url('awb/edit/' . $a['id'] . '/edit') . ' class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Edit AWB">
                            <i class="flaticon-edit-1" ></i>
                        </a>
                        ' . $a['print_awb_biasa'] . '
                        ' . $a['print_awb_tri'] . '
                        ' . $tombolhapus . '

                        </div>';
                } elseif ($a['status_tracking'] == 'booked' && (int) Auth::user()->level == 2) {
                    return '<div class="btn-group" role="group" aria-label="Basic example">
                        <a href=' . url('awb/edit/' . $a['id'] . '/edit') . ' class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Edit AWB">
                            <i class="flaticon-edit-1" ></i>
                        </a>

                        ' . $tombolhapus . '</div>';
                } elseif ($a['status_tracking'] !== 'booked' && (int) Auth::user()->level == 1) {
                    return '<div class="btn-group" role="group" aria-label="Basic example">
                        ' . $a['print_awb_biasa'] . '
                        ' . $a['print_awb_tri'] . '
                        ' . $tombolhapus . '
                        <a href=' . url('t/' . $a['noawb'] . '/t/1') . ' target="_blank" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="TRACKING">
                        <i class="fas fa-map-marked-alt" ></i>
                        </a>
                        ' . (($a['status_tracking'] == 'complete') ? $a['btn_hilang'] : '') . '
                        </div>';
                }
            })
            ->addColumn('qty_stat', function ($a) {
                if ((int) $a['kecil'] !== 0 || (int) $a['sedang'] !== 0 || (int) $a['besar'] !== 0 || (int) $a['besarbanget'] !== 0 || (int) $a['doc'] !== 0 || (int) $a['kg'] !== 0) {
                    return '<span style="cursor:pointer;" data-toggle="modal" data-target="#modal-koli" onClick="modalKoli(' . $a['id'] . ')" class="label label-lg label-success label-inline mr-2"> Terisi &nbsp; <i style="color:white !important;" class="fa fa-search" aria-hidden="true"></i></span>';
                }
                if ($a['is_agen'] == 0) {
                    return '<span class="label label-lg label-danger label-inline mr-2" style="height:auto; font-size:10px;padding:2px;"> Belum Terisi<br>(admin only) </span>';
                }

                return '<span style="cursor:pointer;" data-toggle="modal" data-target="#modal-koli" onClick="modalKoli(' . $a['id'] . ')" class="label label-lg label-success label-inline mr-2"> Terisi &nbsp; <i style="color:white !important;" class="fa fa-search" aria-hidden="true"></i></span>';
            })
            ->addColumn('agen_stat', function ($a) {
                if ($a['id_agen_tujuan'] == 0) {
                    return '<span class="label label-lg label-danger label-inline mr-2" style="height:auto; font-size:10px;padding:2px;"> Belum Terpilih<br>(admin only) </span>';
                }

                return '<span class="label label-lg label-success label-inline mr-2">Terpilih </span>';
            })
            ->editColumn('kota_tujuan', function ($a) {
                $string = $a['kota_tujuan'];
                if ($a['kota_transit'] !== null) {
                    $string .= '<br><span class="label label-info label-inline mr-2" style="height:auto;">Transit ' . $a['kota_transit'] . '</span>';
                }

                return $string;
            })
            ->addColumn('nama_pengirim_link', function ($a) {
                return '<a target="blank" href="' . url('master/customer/edit/' . $a['id_customer']) . '"> ' . $a['nama_pengirim'] . '</a>';
            })
            ->editColumn('status_tracking', function ($a) {
                if ($a['status_tracking'] == 'booked') {
                    return '<span class="badge badge-info"><i class="fas fa-clipboard-list"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                } elseif ($a['status_tracking'] == 'at-manifest') {
                    return '<span class="badge badge-dark"><i class="fa fa-truck"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                } elseif ($a['status_tracking'] == 'loaded') {
                    return '<span class="badge badge-primary"><i class="fas fa-truck-loading"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                } elseif ($a['status_tracking'] == 'at-agen') {
                    return '<span class="badge badge-dark"><i class="fas fa-user-friends"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                } elseif ($a['status_tracking'] == 'delivery-by-courier') {
                    return '<span class="badge badge-warning"><i class="fa fa-motorcycle"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                } elseif ($a['status_tracking'] == 'complete') {
                    return '<span class="badge badge-success"><i class="fa fa-check-circle"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                } elseif ($a['status_tracking'] == 'cancel') {
                    return '<span class="badge badge-danger"><i class="fa fa-times-circle"  style="color:white;"></i>&nbsp;' . $a['status_tracking'] . '</span>';
                }
            })
            ->addColumn('gantistatus', function ($a) {
                $status_ = ((int) Auth::user()->level != 1 || $a['status_tracking'] == 'booked' || $a['status_tracking'] == 'cancel' || $a['status_tracking'] == 'complete') ? '' : '
                <button
                    type            = "button"
                    class           = "btn  btn-info openstatus"
                    idawb           = "' . $a['id'] . ' "
                    kodeawb         = "' . $a['noawb'] . ' "
                    tanggalawb      = "' . $a['tanggal_awb'] . ' "
                    kodekotaasal    = "' . $a['kota_asal'] . ' "
                    kodekotatujuan  = "' . $a['kota_tujuan'] . ' "
                    status          = "' . $a['status_tracking'] . '"
                    data-toggle     = "modal"
                    data-target     = ".bd-example-modal-lg_">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                ';

                return '
                <div class="btn-group" role="group" aria-label="Basic example">
                    ' . $status_ . '
                </div>';
            })
            ->rawColumns(['kota_tujuan', 'aksi', 'agen_stat', 'qty_stat', 'status_tracking', 'gantistatus', 'nama_pengirim_link'])
            ->make(true);
    }

    public function koli(Request $request)
    {
        $awb = Awb::find($request->id);

        return response()->json(['awb' => $awb]);
    }

    public function show(Request $request)
    {
        $awb = Awb::find($request->id);
        $kota_tujuan = Kota::find($awb->id_kota_tujuan);
        $kota_asal = Kota::find($awb->id_kota_asal);
        $kota_transit = Kota::find($awb->id_kota_transit);
        $agen_tujuan = Agen::find($awb->id_agen_penerima);
        $view = (string) view('pages.awb.ajax.show', compact('kota_asal', 'kota_transit', 'kota_tujuan', 'awb', 'agen_tujuan'));

        return response()->json(['view' => $view]);
    }

    public function filter_kota_agen(Request $request)
    {
        $kota = ViewAgenKota::where('id', $request->kota_id)->where('status', 'aktif')->get();
        $kecamatan = Kecamatan::where('idkota', $request->kota_id)->get();
        $view = (string) view('pages.awb.ajax.filter_kota_agen', compact('kota'));
        $view_kecamatan = (string) view('pages.awb.ajax.filter_kecamatan', compact('kecamatan'));

        return response()->json(['view' => $view, 'view_kecamatan' => $view_kecamatan]);
    }

    public function filter_customer(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $alamat = Alamat::where('pelanggan_id', $request->customer_id)->orderBy('id', 'asc')->get();
        if ($customer->is_agen == 0) {
            $kota = Kota::orderBy('nama', 'asc')
                                ->where(function ($query): void {
                                $id_sby = (int) ApplicationSetting::checkappsetting('id-surabaya');
                                $query->where('id', $id_sby);
                            })
                                ->get();
        } else {
            $kota = ViewAgenKota::where('agen_id', $customer->id_agen)->where('status', 'aktif')->get();
        }
        $cbo_alamat = (string) view('pages.awb.ajax.cbo_alamat', compact('alamat'));
        $cbo_asal = (string) view('pages.awb.ajax.cbo_kota_asal', compact('kota', 'customer'));

        return response()->json(['data' => $customer, 'alamat' => $cbo_alamat, 'kota_asal' => $cbo_asal, 'count_alamat' => count($alamat)]);
    }

    public function filter_alamat(Request $request)
    {
        $alamat = Alamat::find($request->alamat_id);

        return response()->json(['data' => $alamat]);
    }

    private function hitungHargaTotal($qty_kecil, $qty_sedang, $qty_besar, $qty_besar_banget, $qty_kg, $qty_dokumen, $customer, $charge_oa, $harga_charge)
    {
        $harga_kg = 0;
        $harga_oa = 0;
        if ($qty_kg > 0) {
            $harga_kg = $customer->harga_kg * 5 + ($customer->harga_kg_selanjutnya * ((($qty_kg > 5) ? $qty_kg : 5) - 5));
        }
        if ($qty_kg < 0) {
            $harga_kg = $customer->harga_kg * 5 - ($customer->harga_kg_selanjutnya * ((($qty_kg < -5) ? $qty_kg : -5) + 5));
        }
        $harga_total = ($qty_kecil * $customer->harga_koli_k) + ($qty_sedang * $customer->harga_koli_s) + ($qty_besar * $customer->harga_koli_b) + ($qty_besar_banget * $customer->harga_koli_bb) + ($qty_dokumen * $customer->harga_doc) + $harga_kg;
        if ($charge_oa == 1) {
            if ($customer->jenis_out_area == 'shipment') {
                $harga_oa = 0;
            } elseif ($customer->jenis_out_area == 'resi') {
                $harga_oa = $customer->harga_oa;
            } elseif ($customer->jenis_out_area == 'koli') {
                $oa_kg = ($qty_kg == 0) ? 0 : 1;
                $harga_oa = ($qty_kecil + $qty_sedang + $qty_besar + $qty_besar_banget + $qty_dokumen + $oa_kg) * $customer->harga_oa;
            }
        }
        $harga_total = $harga_total + $harga_oa + $harga_charge;
        $tots = ['total' => $harga_total, 'oa' => $harga_oa];

        return $tots;
    }

    private function hitungHargaKg($qty_kg, $harga_pertama, $harga_selanjutnya, $charge_oa, $customer, $hilang, $harga_charge)
    {
        $harga_kg = 0;
        $harga_oa = 0;
        if ($hilang == 'hilang') {
            $harga_kg = $harga_pertama * 5 - ($harga_selanjutnya * ((($qty_kg < -5) ? $qty_kg : -5) + 5));
            // else:
            // $harga_kg = $customer->harga_kg * 5;
            if ($charge_oa == 1) {
                $harga_oa = $customer->harga_oa;
            }

            return $harga_kg + $harga_oa;
        }
        $harga_kg = 0;
        $harga_oa = 0;
        if ($qty_kg > 0) {
            $harga_kg = $harga_pertama * 5 + ($harga_selanjutnya * ((($qty_kg > 5) ? $qty_kg : 5) - 5));
            // else:
                // $harga_kg = $customer->harga_kg * 5;
        }
        if ($charge_oa == 1) {
            $harga_oa = $customer->harga_oa;
        }

        return $harga_kg + $harga_oa + $harga_charge;
    }

    private function randomChar()
    {
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 3) as $k) {
            $rand .= $seed[$k];
        }

        return $rand;
    }
}
