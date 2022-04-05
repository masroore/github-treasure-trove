<?php

namespace Modules\Backup\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use DateTime;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LogActivity;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission']);
        $this->middleware('prohibited.demo.mode')->only(['import']);
    }

    public function index()
    {
        try {
            $dir = is_dir(public_path('/database-backup'));
            $getDirData = [];
            if ($dir) {
                $getDirData = scandir(public_path('/database-backup'));
            }

            $allBackup = [];

            foreach ($getDirData as $key => $value) {
                $this->checkValidDate($value) ? array_push($allBackup, $value) : '';
            }

            $data = [
                'allBackup' => $allBackup,
            ];

            return view('backup::backup.index', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function checkValidDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        try {
            Artisan::call('backup:database');
            Toastr::success('New database backup has been created', 'Backup Done!!');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return back();
        }
    }

    public function delete($dir)
    {
        try {
            $dir = public_path('/database-backup/' . $dir);
            if (is_dir($dir)) {
                array_map('unlink', glob("$dir/*.*"));
                rmdir($dir);
                Toastr::success('Database backup has been deleted', 'Delete Done!!');

                return redirect()->back();
            }

            Toastr::error('Something Wrong', 'Error!!');

            return redirect()->back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function import(Request $request)
    {
        try {
            if (pathinfo($request->db_file->getClientOriginalName(), PATHINFO_EXTENSION) !== 'sql') {
                Toastr::error('Invalid File, file should be sql', 'Invalid File!!');

                return redirect()->back();
            }
            set_time_limit(2700);

            DB::statement('SET foreign_key_checks=0');
            $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
            foreach ($tableNames as $name) {
                //if you don't want to truncate migrations
                if ($name == 'migrations') {
                    continue;
                }
                DB::table($name)->truncate();
            }

            DB::statement('SET foreign_key_checks=1');
            $file = $request->file('db_file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path() . '/tmpfile/', $filename);
            $sql = public_path() . '/tmpfile/' . $filename;
            DB::unprepared(file_get_contents($sql));

            if (file_exists($sql)) {
                unlink($sql);
            }

            Toastr::success('Database import sunccessfullu', 'import Done!!');

            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }
}
