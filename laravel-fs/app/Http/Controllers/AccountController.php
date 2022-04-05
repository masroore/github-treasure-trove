<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
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
     * @param  \App\Models\Acount  $acount
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Acount $acount)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acount  $acount
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Acount $acount)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Acount  $acount
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acount $acount)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acount  $acount
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acount $acount)
    {

    }

    public function getAccount($code_bank = '0102')
    {
        $agency = str_pad(mt_rand(10, 1000), 4, '0', STR_PAD_LEFT);
        $account = str_pad(mt_rand(100, 6000), 10, '0', STR_PAD_LEFT);

        $pesos1 = [3, 2, 7, 6, 5, 4, 3, 2];
        $pesos2 = [3, 2, 7, 6, 5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        $d1 = $code_bank . '' . $agency;
        $d2 = $agency . '' . $account;
        $suma1 = 0;
        $suma2 = 0;
        foreach ($pesos1 as $k => $v) {
            $suma1 += $v * $d1[$k];
        }
        foreach ($pesos2 as $k => $v) {
            $suma2 += $v * $d2[$k];
        }
        $digito1 = 11 - ($suma1 % 11);
        $digito2 = 11 - ($suma2 % 11);
        if ($digito1 >= 10 || $digito1 < 1) {
            $digito1 = $digito1 % 10;
        }
        if ($digito2 >= 10 || $digito2 < 1) {
            $digito2 = $digito2 % 10;
        }
        $cuentaValidada = $code_bank . $agency . $digito1 . $digito2 . $account;

        return $cuentaValidada;
    }
}
