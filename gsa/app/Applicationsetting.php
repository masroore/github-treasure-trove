<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationsetting extends Model
{
    protected $table = 'applicationsetting';

    public static function getJamMinim()
    {
        // $res = DB::table('manifest')->count();
        $jamminim = (int) (self::where('kode', 'jam-manifest')->first())->value;

        return $jamminim;
    }

    public static function checkappsetting($kode)
    {
        // $res = DB::table('manifest')->count();
        $value = (int) (self::where('kode', $kode)->first())->value;

        return $value;
    }
}
