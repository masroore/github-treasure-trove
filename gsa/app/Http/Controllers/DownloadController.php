<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download_lidar(Request $request)
    {
        $token_db = Token::first();
        if ($token_db->token == md5($request->token)) {
            return response()->download(storage_path('app/public/SURABAYA_JPEG.tif'));
        }
    }

    public function lidar_form()
    {
        return view('pages.popup.download.lidar');
    }
}
