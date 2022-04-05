<?php

namespace App\Http\Controllers;

class SlepCtrl extends Controller
{
    public function getMantenedores()
    {
        return view('dashboard.slep.mantenedores');
    }

    public function getReportes()
    {
        return view('dashboard.slep.reportes');
    }
}
