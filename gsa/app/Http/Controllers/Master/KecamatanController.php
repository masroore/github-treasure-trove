<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
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
        $data['kecamatan'] = Kecamatan::find($id);

        return view('pages.master.kota.edit', $data);
    }

    public function datatables(Request $request)
    {
        $kecamatan = Kecamatan::where('idkota', $request->id)->orderBy('id', 'desc')->get();

        return response()->json(['data' => $kecamatan]);
    }

    public function save(Request $request)
    {
        if ($request->idkec && $request->idkec > 0) {
            $kota = Kecamatan::where('id', $request['idkec'])->first();
        } else {
            $kota = new Kecamatan();
        }
        $kota->nama = ($request->nama) ?: '';
        $kota->idkota = ($request->idkota) ?: '';
        $kota->oa = ($request->oa) ?: 0;
        $kota->save();

        return response()->json(['success' => 'success']);
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

    public function delete(Request $request)
    {
        $kecamatan = Kecamatan::find($request->id);
        Kecamatan::find($request->id)->delete();

        return response()->json(['customer' => $kecamatan]);
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
