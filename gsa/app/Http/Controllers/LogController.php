<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.log.index');
    }

    public function datatables(Request $request)
    {
        $period = explode(' - ', $request->tanggal);
        $periode = [Carbon::createFromFormat('d/m/Y', $period[0])->toDateString(), Carbon::createFromFormat('d/m/Y', $period[1])->toDateString()];
        $custom = new Collection();
        $activity = Activity::orderBy('created_at', 'desc')->whereDate('created_at', '>=', $periode[0])->whereDate('created_at', '<=', $periode[1])->get();
        foreach ($activity as $a) {
            $user = 'Tidak ada';
            $users = User::where('id', $a->causer_id)->first();
            $desc = '';
            $kets = '';
            $aksi = '-';
            $properties = json_decode($a->properties);
            if (!empty($users)) {
                $user = $users->nama;
            }
            $desc = $a->description;
            $before = explode('App', $a->subject_type);
            $str = trim(end($before));
            if ($str == '\Detailqtyscanned') {
                $str = 'Scan AWB';
            } elseif ($str == '\Detailqtyscanned') {
                $str = 'Scan Per Koli/Per Barang yang dikirim';
            } elseif ($str == '\Detailqtyscanned') {
                $str = 'Scan Per Koli/Per Barang yang dikirim';
            }
            $kets = $str;
            if ($a->description == 'created') {
                $aksi = '<button class="btn btn-primary" data-toggle="modal" data-target="#modal-new" onClick="modalNew(' . $a->id . ')"><i class="fa fa-eye"></i></button>';
            } elseif ($a->description == 'updated') {
                $aksi = '<button class="btn btn-primary" data-toggle="modal" data-target="#modal-update" onClick="modalUpdate(' . $a->id . ')"><i class="fa fa-eye"></i></button>';
            }
            $tanggal = date('d F Y, H.i', strtotime($a->created_at->addHours(7)));
            $custom->push([
                'user' => $user,
                'description' => $desc,
                'tanggal' => $tanggal,
                'keterangan' => $kets,
                'dates' => $a->created_at,
                'aksi' => $aksi,
            ]);
        }

        return Datatables::of($custom)->rawColumns(['description', 'keterangan', 'aksi'])->make(true);
    }

    public function modalNew(Request $request)
    {
        $log = Activity::find($request->id);
        $properties = json_decode($log->properties);
        $view = (string) view('pages.log.ajax.show', compact('properties'));

        return response()->json(['view' => $view]);
    }

    public function modalUpdate(Request $request)
    {
        $log = Activity::find($request->id);
        $log = json_decode($log->properties);
        $data_new = $log->attributes;
        $data_old = $log->old;
        $view = (string) view('pages.log.ajax.show_update', compact('data_new', 'data_old'));

        return response()->json(['view' => $view]);
    }
}
