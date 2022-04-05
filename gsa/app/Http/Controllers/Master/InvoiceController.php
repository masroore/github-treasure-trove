<?php

namespace App\Http\Controllers\Master;

use App\Awb;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.master.invoice.index');
    }

    public function updatestatus(Request $request)
    {
        $manifest = Invoice::where('id', $request['idinvoice'])->first();
        $manifest->status = $request['status'];
        $manifest->metodepembayaran = $request['metodepembayaran'];
        $manifest->save();

        return response()->json(['success' => 'success']);
    }

    public function datatables()
    {
        $manifest = Invoice::select(DB::raw("DATE_FORMAT(invoice.created_at,'%d-%M-%Y') as tanggal_invoice"), 'invoice.*', 'users.nama as namauser', 'customer.nama as namacustomer', 'customer.kode as kodecustomer')
            ->join('users', 'users.id', '=', 'invoice.mengetahui_oleh')
            ->join('customer', 'customer.id', '=', 'invoice.id_customer')
            ->where('invoice.id', '>', '0')
            ->orderBy('invoice.id', 'desc')
            ->get();

        return Datatables::of($manifest)
            ->addColumn('aksi', function ($a) {
            $edit = ($a['status'] == 'paid' && $a['metodepembayaran'] != '') ? '' : '
            <button
                type                = "button"
                class               = "btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success openstatus"
                idinvoice           = "' . $a['id'] . ' "
                kodeinvoice         = "' . $a['kode'] . ' "
                tanggalinvoice      = "' . $a['tanggal_invoice'] . ' "
                metodepembayaran    = "' . $a['metodepembayaran'] . '"
                namacustomer        = "' . $a['namacustomer'] . '"
                kodecustomer        = "' . $a['kodecustomer'] . '"
                status              = "' . $a['status'] . '"
                data-toggle         = "modal"
                data-target         = ".bd-example-modal-lg">
                    <i class="fa fa-edit" aria-hidden="true"></i>
            </button>
            ';

            return '
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="' . url('printout/invoice/' . $a['id']) . '" target="blank" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol print">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
               ' . $edit . '
            </div>';
        })
            ->addColumn('nama_pengirim_link', function ($a) {
            return '<a target="blank" href="' . url('master/customer/edit/' . $a['id_customer']) . '">' . $a['namacustomer'] . '</a>';
        })
            ->addColumn('status_info', function ($a) {
            $status = '<span class="badge badge-danger"> <i class="fa fa-remove"  style="color:white;"></i>&nbsp;' . $a['status'] . '</span>';
            if ($a['status'] == 'paid') {
                $status = '<span class="badge badge-primary"><i class="fa fa-usd"  style="color:white;"></i>&nbsp;' . $a['status'] . '</span>';
            }

            return $status;
        })
            ->rawColumns(['aksi', 'status_info', 'nama_pengirim_link'])
            ->make(true);
    }

    public function grouping()
    {
        $data['awb'] = Awb::select(DB::raw('
                            customer.id         as idcustomer,
                            customer.nama       as namacustomer,
                            customer.kode       as kodecustomer,
                            customer.is_agen    as is_agen,
                            count(awb.id) as total'))
            ->join('customer', 'customer.id', '=', 'awb.id_customer')
            ->where('awb.status_tracking', '=', 'complete')
            ->where('awb.id_invoice', '=', 0)
            ->where('awb.id_customer', '<>', 26)//---------------26 ini adalah customer biasa, dan tidak perlu ditagihkan. karena sudah cash
            ->groupBy('customer.kode', 'customer.nama', 'customer.id', 'customer.is_agen')
            ->get();
        // echo Carbon::now()->hour(15)->minute(0)->second(0);
        // echo Carbon::now()->addHours(7);
        // echo Carbon::now()->hour(15)->minute(0)->second(0).'<br>';
        // echo Carbon::yesterday()->hour(15)->minute(0)->second(0);
        return view('pages.master.invoice.grouping', $data);
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

    public function save(Request $request)
    {
        if ($request->id == 0) {
            $invoice = new Invoice();
        } else {
            $invoice = Invoice::where('id', $request['id'])->first();
        }
        $invoice->kode = Invoice::getNoInvoice();
        $invoice->id_customer = ($request->id_customer) ?: 0;
        $invoice->mengetahui_oleh = ($request->mengetahui_oleh) ?: 0;
        $invoice->total_koli = ($request->total_koli) ?: 0;
        $invoice->total_kg = ($request->total_kg) ?: 0;
        $invoice->total_doc = ($request->total_doc) ?: 0;
        $invoice->total_harga = ($request->total_harga) ?: 0;
        $invoice->total_oa = ($request->total_oa) ?: 0;
        $invoice->keterangan = ($request->keterangan) ?: '';
        $invoice->metodepembayaran = ($request->metodepembayaran) ?: '';
        $invoice->tanggal_invoice = Carbon::now()->addHours(7);
        $invoice->created_at = Carbon::now()->addHours(7);
        $invoice->status = 'unpaid';
        $invoice->save();
        DB::table('awb')
            ->where('awb.status_tracking', '=', 'complete')
            ->where('awb.id_customer', '=', $invoice['id_customer'])
            ->where('awb.id_invoice', '=', 0)
            ->update(
                ['id_invoice' => $invoice['id'],
                ]
            );

        return redirect('master/invoice')->with('message', 'created');
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
        $data['customer'] = Customer::find($id);
        $data['invoice'] = Invoice::find(0);
        $data['awb'] = Awb::select(
            'awb.*',
            'customer.nama      as namacust',
            'kotatujuan.nama    as kotatujuan',
            'kotaasal.nama      as kotaasal',
            'kotatransit.nama   as kotatransit',
            'manifest.kode      as kodemanifest',
            DB::raw("DATE_FORMAT(awb.created_at,'%d-%M-%Y') as tanggal_awb"),
            DB::raw('(awb.qty_kecil + awb.qty_sedang + awb.qty_besar + awb.qty_besarbanget) as qtykoli')
        )
            ->join('customer', 'customer.id', '=', 'awb.id_customer')
            ->leftjoin('kota as kotaasal', 'kotaasal.id', '=', 'awb.id_kota_asal')
            ->leftjoin('kota as kotatujuan', 'kotatujuan.id', '=', 'awb.id_kota_tujuan')
            ->leftjoin('kota as kotatransit', 'kotatransit.id', '=', 'awb.id_kota_transit')
            ->leftJoin('manifest', 'manifest.id', '=', 'awb.id_manifest')
            ->where('awb.status_tracking', '=', 'complete')
            ->where('awb.id_invoice', '=', 0)
            ->where('awb.id_customer', '=', $id)
            ->orderBy('id_manifest', 'desc')
            ->orderBy('charge_oa', 'desc')
            ->get();
        // echo $data['awb'];
        return view('pages.master.invoice.edit', $data);
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
