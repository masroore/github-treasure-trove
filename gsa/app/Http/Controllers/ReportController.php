<?php

namespace App\Http\Controllers;

use App\Agen;
use App\Applicationsetting;
use App\Customer;
use App\Kota;
use App\ViewReportAwb;
use App\ViewReportInvoice;
use App\ViewReportManifest;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;

class ReportController extends Controller
{
    public function awb()
    {
        $customer = Customer::orderBy('nama', 'asc')->get();
        $agen = Agen::orderBy('nama', 'asc')->get();
        if ((int) Auth::user()->level == 2) {
            $customer = customer::find(Auth::user()->id_customer);
        }

        return view('pages.report.awb', compact('customer', 'agen'));
    }

    public function awb_grid(Request $request)
    {
        $period = explode(' - ', $request->tanggal);
        $periode = [Carbon::createFromFormat('d/m/Y', $period[0])->toDateString(), Carbon::createFromFormat('d/m/Y', $period[1])->toDateString()];
        $query = ViewReportAwb::query();
        $query->when(request('id_customer') !== '-', function ($q) {
            return $q->where('id_customer', '=', request('id_customer'));
        })
            ->when(request('id_agen_penerima') !== '-', function ($q) {
            return $q->where('id_agen_penerima', '=', request('id_agen_penerima'));
        })
            ->when(request('id_agen_asal') !== '-', function ($q) {
            return $q->where('id_agen_asal', '=', request('id_agen_asal'));
        })
            ->when(request('status_tracking') !== '-', function ($q) {
            return $q->where('status_tracking', '=', request('status_tracking'));
        })
            ->when((int) Auth::user()->level == 3, function ($q) {
            return //$q->where('id_agen_penerima', '=',request('id_agen_penerima'));
                $q->where(function ($query): void {
                    $query->where('id_agen_penerima', '=', (int) Auth::user()->id_agen)
                        ->orWhere('id_agen_asal', '=', (int) Auth::user()->id_agen);
                });
        })
            ->when(request('noawb') !== null, function ($q) {
            return $q->where('noawb', 'like', '%' . strtoupper(request('noawb')) . '%');
        });
        $awbs = $query->whereDate('created_at', '>=', $periode[0])->whereDate('created_at', '<=', $periode[1])->orderBy('id', 'DESC')->get();
        $collect_awb = new Collection();
        foreach ($awbs as $a) {
            $collect_awb->push([
                'id' => $a->id,
                'noawb' => $a->noawb,
                'faktur_string' => $a->faktur_string,
                'pengirim' => $a->pengirim,
                'created_at' => date('Y-m-d H:i:s', strtotime(date($a->created_at))),
                'kota_asal' => $a->kota_asal,
                'kota_transit' => $a->kota_transit,
                'kota_tujuan' => $a->kota_tujuan,
                'agen_asal' => $a->agen_asal,
                'agen_tujuan' => $a->agen_tujuan,
                'nama_penerima' => $a->nama_penerima,
                'labelalamat' => $a->labelalamat,
                'kodepos_penerima' => $a->kodepos_penerima,
                'alamat_tujuan' => $a->alamat_tujuan,
                'kecamatan' => $a->kecamatan,
                'notelp_penerima' => $a->notelp_penerima,
                'tanggal_diterima' => $a->tanggal_diterima,
                'diterima_oleh' => $a->diterima_oleh,
                'oa_string' => $a->oa_string,
                'qty' => $a->qty,
                'qty_kecil' => $a->qty_kecil,
                'qty_sedang' => $a->qty_sedang,
                'qty_besar' => $a->qty_besar,
                'qty_besarbanget' => $a->qty_besarbanget,
                'qty_kg' => $a->qty_kg,
                'qty_doc' => $a->qty_doc,
                'oa_desc' => $a->oa_desc,
                'idr_oa' => $a->idr_oa,
                'total_harga' => $a->total_harga,
                'kode_manifest' => $a->kode_manifest,
                'kode_invoice' => $a->kode_invoice,
                'status_pembayaran' => $a->status_pembayaran,
                'status_tracking' => $a->status_tracking,
                'harga_charge' => $a->harga_charge,
                'harga_gsa' => $a->harga_gsa,
            ]);
        }
        $data['data'] = $collect_awb;

        return response()->json($data);
    }

    public function manifest()
    {
        $kota = Kota::where('id', '>', 0)->orderBy('nama', 'asc')->get();

        return view('pages.report.manifest', compact('kota'));
    }

    public function manifest_grid(Request $request)
    {
        $period = explode(' - ', $request->tanggal);
        $periode = [Carbon::createFromFormat('d/m/Y', $period[0])->toDateString(), Carbon::createFromFormat('d/m/Y', $period[1])->toDateString()];
        $query = ViewReportManifest::query();
        $query->when(request('id_kota_asal') !== '-', function ($q) {
            return $q->where('id_kota_asal', '=', request('id_kota_asal'));
        })
            ->when(request('id_kota_tujuan') !== '-', function ($q) {
            return $q->where('id_kota_tujuan', '=', request('id_kota_tujuan'));
        })
            ->when(request('status') !== '-', function ($q) {
            return $q->where('status', '=', request('status'));
        })
            ->when((int) Auth::user()->level == 3, function ($q) {
            return //$q->where('id_agen_penerima', '=',request('id_agen_penerima'));
                $q->where(function ($query): void {
                    $query->where('id_agen_penerima', '=', (int) Auth::user()->id_agen)
                        ->orWhere('id_agen_tujuan', '=', (int) Auth::user()->id_agen);
                });
        })
            ->when(request('kode_manifest') !== null, function ($q) {
            return $q->where('kode', 'like', '%' . strtoupper(request('kode_manifest')) . '%');
        });
        $awbs = $query->whereDate('created_at', '>=', $periode[0])->whereDate('created_at', '<=', $periode[1])->orderBy('id', 'DESC')->get();
        $collect_manifest = new Collection();
        foreach ($awbs as $a) {
            $collect_manifest->push([
                'id' => Crypt::encrypt($a->id),
                'kode' => $a->kode,
                'status' => $a->status,
                'kota_asal' => $a->kota_asal,
                'kota_tujuan' => $a->kota_tujuan,
                'created_at' => date('Y-m-d H:i:s', strtotime(date($a->created_at))),
                'dibuat_oleh_user' => $a->dibuat_oleh_user,
                'supir' => $a->supir,
                'keterangan' => $a->keterangan,
                'jumlah_koli' => $a->jumlah_koli,
                'jumlah_doc' => $a->jumlah_doc,
                'jumlah_kg' => $a->jumlah_kg,
                'tanggal_diterima' => $a->tanggal_diterima,
                'discan_diterima_oleh_nama' => $a->discan_diterima_oleh_nama,
            ]);
        }
        $data['data'] = $collect_manifest;

        return response()->json($data);
    }

    public function invoice()
    {
        $customer = Customer::orderBy('nama', 'asc')->get();
        if ((int) Auth::user()->level !== 1) {
            $customer = customer::find(Auth::user()->id_customer);
        }

        return view('pages.report.invoice', compact('customer'));
    }

    public function invoice_grid(Request $request)
    {
        $period = explode(' - ', $request->tanggal);
        $periode = [Carbon::createFromFormat('d/m/Y', $period[0])->toDateString(), Carbon::createFromFormat('d/m/Y', $period[1])->toDateString()];
        $query = ViewReportInvoice::query();
        $query->when(request('id_customer') !== '-', function ($q) {
            return $q->where('id_customer', '=', request('id_customer'));
        })
            ->when(request('metodepembayaran') !== '-', function ($q) {
            return $q->where('metodepembayaran', '=', request('metodepembayaran'));
        })
            ->when(request('status') !== '-', function ($q) {
            return $q->where('status', '=', request('status'));
        })
            ->when(request('kode_invoice') !== null, function ($q) {
            return $q->where('kode', 'like', '%' . strtoupper(request('kode_invoice')) . '%');
        });
        $awbs = $query->whereDate('created_at', '>=', $periode[0])->whereDate('created_at', '<=', $periode[1])->orderBy('id', 'DESC')->get();
        $data['data'] = $awbs;

        return response()->json($data);
    }

    public function bonus()
    {
        $agen = Agen::orderBy('nama', 'asc')->get();
        $customer = Customer::where('is_agen', 1)->get();
        $kota = Kota::where('id', '>', 0)->orderBy('nama', 'asc')->get();

        return view('pages.report.bonus', compact('agen', 'kota'));
    }

    public function bonus_grid(Request $request)
    {
        $period = explode(' - ', $request->tanggal);
        $periode = [Carbon::createFromFormat('d/m/Y', $period[0])->toDateString(), Carbon::createFromFormat('d/m/Y', $period[1])->toDateString()];
        $query = ViewReportAwb::query();
        $query->when(request('id_agen_asal') !== '-', function ($q) {
            return $q->where('id_agen_asal', '=', request('id_agen_asal'))->orWhere('id_customer', '=', request('id_agen_asal'));
        })
            ->when(request('id_agen_tujuan') !== '-', function ($q) {
            return $q->where('id_agen_penerima', '=', request('id_agen_tujuan'));
        })
            ->when(request('id_kota_tujuan') !== '-', function ($q) {
            return $q->where('id_kota_tujuan', '=', request('id_kota_tujuan'));
        })
            ->when((int) Auth::user()->level == 3, function ($q) {
            return //$q->where('id_agen_penerima', '=',request('id_agen_penerima'));
                $q->where(function ($query): void {
                    $query->where('id_agen_penerima', '=', (int) Auth::user()->id_agen)
                        ->orWhere('id_agen_asal', '=', (int) Auth::user()->id_agen);
                });
        });
        $awbs = $query->whereDate('created_at', '>=', $periode[0])->whereDate('created_at', '<=', $periode[1])->where('status_tracking', 'complete')->orderBy('id', 'desc')->get();
        $bonus = [];
        $collection = new Collection();
        foreach ($awbs as $a) {
            $is_transit = 'NO';
            $agen_asal = 'GLOBAL SERVICE ASIA';
            $bonus = $this->hitungBonus($a);
            if (strtoupper($a->kota_transit) == 'SURABAYA') {
                $is_transit = 'YES';
            }
            if ($a->is_agen == 1) {
                $agen_asal = $a->pengirim;
            }
            $collection->push([
                'bonus_gsa' => $bonus['bonus_gsa'],
                'bonus_agen_asal' => $bonus['bonus_agen_asal'],
                'bonus_agen_tujuan' => $bonus['bonus_agen_tujuan'],
                'total_harga' => $a->total_harga,
                'idr_oa' => $a->idr_oa,
                'pengirim' => $agen_asal,
                'kota_asal' => $a->kota_asal,
                'kota_tujuan' => $a->kota_tujuan,
                'noawb' => $a->noawb,
                'status_tracking' => $a->status_tracking,
                'agen_tujuan' => $a->agen_tujuan,
                'kota_transit' => $is_transit,
                'created_at' => $a->created_at,
                'is_agen' => $a->is_agen,
            ]);
        }
        $data['data'] = $collection;

        return response()->json($data);
    }

    private function hitungBonus($awb)
    {
        $array = [];

        $komisi_agen_asal = (int) ApplicationSetting::checkappsetting('komisi_agen_asal');
        $komisi_gsa = (int) ApplicationSetting::checkappsetting('komisi_gsa');
        $komisi_agen_tujuan = (int) ApplicationSetting::checkappsetting('komisi_agen_tujuan');

        $agentosub_komisi_agen = ((int) ApplicationSetting::checkappsetting('agentosub_komisi_agen')) / 100;
        $agentosub_komisi_gsa = ((int) ApplicationSetting::checkappsetting('agentosub_komisi_gsa')) / 100;

        $bonus_gsa = 0;
        $bonus_agen_asal = 0;
        $bonus_agen_tujuan = 0;
        $agen = Agen::find($awb->id_agen_penerima);
        if ($awb->is_agen == 0) {
            // SURABAYA KE AGEN---------------------------------
            $bonus_agen_tujuan = $agen->presentase / 100 * $awb->total_harga;
            $bonus_gsa = (100 - $agen->presentase) / 100 * $awb->total_harga;
        } else {
            if (strtolower($awb->kota_asal) !== 'surabaya' && strtolower($awb->kota_tujuan) !== 'surabaya') {
                // AGEN KE AGEN---------------------------------
                // TRANSIT---------------------------------
                $bonus_agen_asal = ($komisi_agen_asal / 100) * $awb->total_harga;
                $bonus_gsa = ($komisi_gsa / 100) * $awb->total_harga;
                $bonus_agen_tujuan = ($komisi_agen_tujuan / 100) * $awb->total_harga;
            } else {
                // AGEN KE SURABAYA---------------------------------
                $bonus_gsa = $agentosub_komisi_gsa * $awb->total_harga;
                $bonus_agen_asal = $agentosub_komisi_agen * $awb->total_harga;
            }
        }
        $array['bonus_gsa'] = $bonus_gsa;
        $array['bonus_agen_asal'] = $bonus_agen_asal;
        $array['bonus_agen_tujuan'] = $bonus_agen_tujuan;

        return $array;
    }
}
