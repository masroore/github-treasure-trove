<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page['agen'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/agen') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-user-circle-o" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/agen') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Master Agen</a>
                                        </div>
                                    </div>
                                </div>';

        $page['customer'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/customer') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-users" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/customer') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Master Customer</a>
                                        </div>
                                    </div>
                                </div>';

        $page['awb'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('awb') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-truck" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('awb') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">AWB</a>
                                        </div>
                                    </div>
                                </div>';

        $page['users'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/users') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa  fa-id-card-o" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/users') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Users</a>
                                        </div>
                                    </div>
                                </div>';

        $page['manifest'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/manifest') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-file-text-o" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/manifest') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Manifest</a>
                                        </div>
                                    </div>
                                </div>';

        $page['invoice'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/invoice') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-usd" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/invoice') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Invoice</a>
                                        </div>
                                    </div>
                                </div>';

        $page['kota'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/kota') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-industry" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/kota') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Kota</a>
                                        </div>
                                    </div>
                                </div>';

        $page['alamat'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <a href="' . url('master/alamat') . '">
                                                <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                    <i class="icon-6x text-info mb-10 mt-10 fa fa-home" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                            <br>
                                            <a href="' . url('master/alamat') . '"
                                                class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Alamat</a>
                                        </div>
                                    </div>
                                </div>';

        $page['awbscan'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5" data-toggle="modal" data-target="#modalscanner" style="cursor: pointer;">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                <i class="icon-6x text-info mb-10 mt-10 fa fa-qrcode" aria-hidden="true"></i>
                                            </span>
                                            <br>
                                            <div class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Scanner AWB</div>
                                        </div>
                                    </div>
                                </div>';

        $page['manifestscan'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5" data-toggle="modal" data-target="#modalscannermanifest" style="cursor: pointer;">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                <i class="icon-6x text-info mb-10 mt-10 fa fa-qrcode" aria-hidden="true"></i>
                                            </span>
                                            <br>
                                            <div class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Scanner Manifest</div>
                                        </div>
                                    </div>
                                </div>';

        $page['report'] = '<div class="col-6 col-lg-6 col-xl-6 mb-5" data-toggle="modal" data-target="#modalreport" style="cursor: pointer;">
                                    <div class="card card-custom wave wave-animate-fast wave-primary">
                                        <div class="card-body text-center">
                                            <span class="svg-icon svg-icon-primary svg-icon-6x">
                                                <i class="icon-6x text-info mb-10 mt-10 fas fa-book" aria-hidden="true"></i>
                                            </span>
                                            <br>
                                            <div class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Report</div>
                                        </div>
                                    </div>
                                </div>';
        // }

        // else if((int) Auth::user()->level == 2){

        $modalawb['loaded'] = '<a href="' . url('scannerawb/' . Crypt::encrypt('loaded') . '') . '"
                                        class="btn btn-primary btn-lg btn-block"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;
                                        Scan Loading ke truck
                                    </a>';
        $modalawb['delivkurir'] = '<a href="' . url('scannerawb/' . Crypt::encrypt('delivery-by-courier') . '') . '"
                                        class="btn btn-primary btn-lg btn-block"><i class="fa fa-motorcycle" aria-hidden="true"></i>
                                        &nbsp;Scan pengantaran ke tujuan
                                    </a>';
        $modalawb['complete'] = '<a href="' . url('scannerawb/' . Crypt::encrypt('complete') . '') . '"
                                        class="btn btn-primary btn-lg btn-block"><i class="fa fa-check-square"aria-hidden="true"></i>
                                        &nbsp;Scan sudah tiba di tujuan
                                    </a>';

        $modalmanifest['delivering'] = '<a href="' . url('scannermanifest/' . Crypt::encrypt('delivering') . '') . '"
                                            class="btn btn-primary btn-lg btn-block"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;Scan
                                            Loading ke truck
                                        </a>';
        $modalmanifest['arrived'] = '<a href="' . url('scannermanifest/' . Crypt::encrypt('arrived') . '') . '"
                                            class="btn btn-primary btn-lg btn-block"><i class="fa fa-check-square" aria-hidden="true"></i>
                                            &nbsp;Scan tiba di agen
                                        </a>';

        $report['awb'] = '<a href="' . url('report/awb') . '" class="btn btn-primary btn-lg btn-block"><i
                                    class="fa fa-truck" aria-hidden="true"></i>
                                    &nbsp;Halaman Report AWB
                                </a>';
        $report['manifest'] = '<a href="' . url('report/manifest') . '" class="btn btn-primary btn-lg btn-block"><i
                                    class="fa fa-file-text-o" aria-hidden="true"></i>
                                    &nbsp;Halaman Report Manifest
                                </a>';
        $report['invoice'] = '<a href="' . url('report/invoice') . '" class="btn btn-primary btn-lg btn-block"><i
                                    class="fa fa-usd" aria-hidden="true"></i>
                                    &nbsp;Halaman Report Invoice
                                </a>';
        $report['komisi'] = '<a href="' . url('report/bonus') . '" class="btn btn-primary btn-lg btn-block"><i
                                    class="fas fa-gifts" aria-hidden="true"></i>
                                    &nbsp;Halaman Report Komisi
                                </a>';

        $data['page'] = [];
        $data['modalawb'] = [];
        $data['modalmanifest'] = [];
        $data['modalreport'] = [];
        if ((int) Auth::user()->level == 1) {
            array_push(
                $data['page'],
                $page['awb'],
                $page['manifest'],
                $page['awbscan'],
                $page['manifestscan'],
                $page['invoice'],
                $page['report'],
                $page['kota'],
                $page['alamat'],
                $page['agen'],
                $page['customer'],
                $page['users']
            );
            array_push(
                $data['modalawb'],
                $modalawb['loaded'],
                $modalawb['delivkurir'],
                $modalawb['complete']
            );
            array_push(
                $data['modalmanifest'],
                $modalmanifest['delivering'],
                $modalmanifest['arrived']
            );
            array_push(
                $data['modalreport'],
                $report['awb'],
                $report['manifest'],
                $report['invoice'],
                $report['komisi']
            );
        } elseif ((int) Auth::user()->level == 2) {
            array_push(
                $data['page'],
                $page['awb'],
                $page['alamat'],
                $page['report']
            );

                $data['modalreport'][] =
                $report['awb'];
        } elseif ((int) Auth::user()->level == 3) {
            array_push(
                $data['page'],
                $page['awbscan'],
                $page['manifestscan'],
                $page['report']
            );
            array_push(
                $data['modalawb'],
                $modalawb['delivkurir'],
                $modalawb['complete']
            );

                $data['modalmanifest'][] =
                $modalmanifest['arrived'];
            array_push(
                $data['modalreport'],
                $report['awb'],
                $report['manifest']
            );
        } elseif ((int) Auth::user()->level == 4) {

                $data['page'][] =
                $page['awbscan'];
            array_push(
                $data['modalawb'],
                $modalawb['delivkurir'],
                $modalawb['complete']
            );
        } elseif ((int) Auth::user()->level == 5) {
            array_push(
                $data['page'],
                $page['manifest'],
                $page['awbscan'],
                $page['manifestscan']
            );

                $data['modalawb'][] =
                $modalawb['loaded'];

                $data['modalmanifest'][] =
                $modalmanifest['delivering'];
        }

        return view('home', $data);
    }
}
