<?php

namespace App\Http\Controllers;

use App\Awb;
use App\Invoice;
use App\Manifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PrintoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $data['invoice'] = Invoice::select(
            DB::raw("DATE_FORMAT(invoice.created_at,'%d-%M-%Y') as tanggal_invoice"),
            'invoice.*',
            'customer.nama      as namacustomer',
            'customer.kode      as kodecustomer',
            'customer.alamat    as alamatcustomer',
            'customer.notelp    as notelpcustomer',
            'customer.is_agen   as is_agen',
            'users.nama as namauser'
        )
            ->join('users', 'users.id', '=', 'invoice.mengetahui_oleh')
            ->join('customer', 'customer.id', '=', 'invoice.id_customer')
            ->where('invoice.id', $id)
            ->first();

        $data['awb'] = Awb::select(
            'awb.*',
            'customer.nama      as namacust',
            'manifest.kode      as kodemanifest',
            'kotatujuan.nama    as kotatujuan',
            'kotaasal.nama      as kotaasal',
            'kotatransit.nama   as kotatransit',
            DB::raw('(awb.qty_kecil + awb.qty_sedang + awb.qty_besar + awb.qty_besarbanget) as qtykoli')
        )
            ->join('customer', 'customer.id', '=', 'awb.id_customer')
            ->join('manifest', 'manifest.id', '=', 'awb.id_manifest')
            ->leftjoin('kota as kotatujuan', 'kotatujuan.id', '=', 'awb.id_kota_tujuan')
            ->leftjoin('kota as kotaasal', 'kotaasal.id', '=', 'awb.id_kota_asal')
            ->leftjoin('kota as kotatransit', 'kotatransit.id', '=', 'awb.id_kota_transit')
            ->where('awb.id_invoice', '=', $id)
            ->orderBy('id_manifest', 'desc')
            ->orderBy('charge_oa', 'desc')
            ->get();

        return view('pages.printout.invoice', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manifest($id)
    {
        $id = Crypt::decrypt($id);
        $data['manifest'] = Manifest::select(
            DB::raw("DATE_FORMAT(manifest.created_at,'%d-%M-%Y') as tanggal_manifest"),
            'manifest.*',
            'kotaasal.kode as kodekotaasal',
            'kotatujuan.kode as kodekotatujuan',
            'kotaasal.nama as namakotaasal',
            'kotatujuan.nama as namakotatujuan',
            'users.nama as namauser',
            'agen.nama as namaagen'
        )
            ->join('kota as kotaasal', 'kotaasal.id', '=', 'manifest.id_kota_asal')
            ->join('kota as kotatujuan', 'kotatujuan.id', '=', 'manifest.id_kota_tujuan')
            ->join('users', 'users.id', '=', 'manifest.dibuat_oleh')
            ->join('users as agen', 'agen.id', '=', 'manifest.dicek_oleh')
            ->where('manifest.id', $id)
            ->first();

        $data['awb'] = Awb::select(
            'awb.*',
            'customer.nama as namacust',
            'kotatujuan.nama as kotatujuan',
            DB::raw('(awb.qty_kecil + awb.qty_sedang + awb.qty_besar + awb.qty_besarbanget) as qtykoli'),
            DB::raw('(select count(*) from detail_qty_scanned where idawb=awb.id and status="loaded") as qtyloaded')
        )
            ->join('customer', 'customer.id', '=', 'awb.id_customer')
            ->join('kota as kotatujuan', 'kotatujuan.id', '=', 'awb.id_kota_tujuan')
            ->where('awb.id_manifest', '=', $id)
            ->get();

        return view('pages.printout.manifest', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function awb($id)
    {
        $id = Crypt::decrypt($id);
        $awb = DB::SELECT('SELECT
                            a.*,
                            k1.kode AS kota_tujuan_kode,
                            k2.kode AS kota_asal_kode
                            FROM
                                awb a
                            LEFT JOIN kota k1 ON a.id_kota_tujuan = k1.id
                            LEFT JOIN kota k2 ON a.id_kota_asal = k2.id
                            WHERE a.id = ' . $id . ' ');
        // dd(strlen($awb[0]->noawb));
        // $noawb = "";
        // for($i = 0; $i < 10 - strlen($awb[0]->noawb) ; $i++ ){
        //     $noawb .= "0";
        // }
        // $noawb .= $awb[0]->noawb;
        return view('pages.printout.awb', compact('awb'));
    }

    public function awbtri($id)
    {
        $id = Crypt::decrypt($id);
        $awb = DB::SELECT('SELECT
                            a.*,
                            k1.kode AS kota_tujuan_kode,
                            k2.kode AS kota_asal_kode
                            FROM
                                awb a
                            LEFT JOIN kota k1 ON a.id_kota_tujuan = k1.id
                            LEFT JOIN kota k2 ON a.id_kota_asal = k2.id
                            WHERE a.id = ' . $id . ' ');
        // dd(strlen($awb[0]->noawb));
        $noawb = '';
        for ($i = 0; $i < 10 - strlen($awb[0]->noawb); ++$i) {
            $noawb .= '0';
        }
        $noawb .= $awb[0]->noawb;
        // dd($total_penagihan);
        return view('pages.printout.awbtri', compact('awb', 'noawb'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
