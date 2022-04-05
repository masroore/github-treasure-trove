<?php

namespace App\Http\Controllers\Orgmanage;

use App\Http\Controllers\Controller;
use App\Models\BreadCrumb;

use App\Models\Operations\BackupDB;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        return view('orgmanage.backup', [
            'title' => '',
            'breadCrumb' => $breadCrumb,
        ]);
    }

    public function getList(Request $request)
    {
        $backupTbl = new BackupDB();
        $result = $backupTbl->getForDatatable($request->all());

        return response()->json($result);
    }

    public function add(Request $request)
    {
        $backupTbl = new BackupDB();
        $result = $backupTbl->addTransaction($request->all());

        return response()->json($result);
    }

    public function backup(Request $request)
    {
        $backupTbl = new BackupDB();
        $result = $backupTbl->runBackup($request->all());

        return response()->json($result);
    }

    public function restore(Request $request)
    {
        $backupTbl = new BackupDB();
        $result = $backupTbl->runRestore($request->all());

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $backupTbl = new BackupDB();
        $result = $backupTbl->deleteTransaction($request->all());

        return response()->json($result);
    }
}
