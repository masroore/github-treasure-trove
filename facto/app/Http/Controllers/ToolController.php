<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ToolController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function download_userfiles($id, Request $request)
    {
        $user_file = UserFile::find($id);
        $data = unserialize($user_file->post->post_cat->value);
        $download_login_need = (int) ($data['download_login_need'] ?? 1);

        if ($download_login_need == 1) { // 다운로드하는데에 로그인 필요하다면
            $user = Auth::user();

            $count = $user_file->downloads()
                ->where('user_id', $user->id)
                ->count();

            if ($count > 0) {
                // downoad
            } else {
                $data = unserialize($user_file->post->post_cat->value);
                $download_points = (int) ($data['download_points'] ?? 0);
                $uploader_points = (int) ($data['uploader_points'] ?? 0);

                if ($user->points < $download_points) {
                    notify()->error('최소 ' . $download_points . ' 포인트가 필요합니다.');

                    return redirect()->back();
                }
                // $user->points = $user->points - $user_file->points_charged ;
                $user->decrement('points', $download_points);
                $user->setLevel();

                if ($uploader_points > 0) {
                    $uploader = $user_file->post->user;
                    $uploader->increment('points', $uploader_points);
                    $uploader->setLevel();
                }

                // $user->save();
                // dd( $torrent_file->points_charted);
                $download = new Download();
                $download->user_id = $user->id;
                $download->points_charged = $download_points;
                $user_file->downloads()->save($download);
            }
        }

        $user_file->increment('download_count');

        $file_server = config('site-common.file-server');
        // $file_server = str_replace('/file-storage', '', $file_server );

        $main_url = $file_server . '/' . $user_file->file_path;
        // header("Content-disposition:attachment; filename=$user_file->org_file_name");
        // readfile($main_url);

        session()->flash('newurl', $main_url);
        session()->flash('org_file_name', $user_file->org_file_name);

        return redirect()->route('download_redirect');
    }

    public function download_torrent(Request $request)
    {
        $id = $request->id;
        $torrent_file = TorrentFile::find($id);

        $data = unserialize($torrent_file->post->post_cat->value);
        $download_login_need = (int) ($data['download_login_need'] ?? 1);

        if ($download_login_need == 1) { // 다운로드하는데에 로그인 필요하다면

            $user = Auth::user();
            // dd($user);

            $count = $torrent_file->downloads()
                ->where('user_id', $user->id)
                ->count();

            if ($count > 0) {
                // downoad
            } else {
                $data = unserialize($torrent_file->post->post_cat->value);
                $download_points = (int) ($data['download_points'] ?? 0);
                $uploader_points = (int) ($data['uploader_points'] ?? 0);

                if ($user->points < $download_points) {
                    notify()->error('최소 ' . $download_points . ' 포인트가 필요합니다.');

                    return redirect()->back();
                }
                $user->decrement('points', $download_points);
                $user->setLevel();

                if ($uploader_points > 0) {
                    $uploader = $torrent_file->post->user;
                    $uploader->increment('points', $uploader_points);
                    $uploader->setLevel();
                }

                $download = new Download();
                $download->user_id = $user->id;
                $download->points_charged = $download_points;

                // $download = [
                //     'user_id'=> $user->id ,
                //     'points_charged'=> $torrent_file->points_charged,
                // ];
                $torrent_file->downloads()->save($download);
            }
        }

        $torrent_file->increment('download_count');

        $file_server = config('site-common.file-server');
        // $file_server = str_replace('/file-storage', '', $file_server );

        // dd($torrent_file->org_file_name);
        $main_url = $file_server . '/' . $torrent_file->file_path;
        // header("Content-disposition:attachment; filename=$torrent_file->org_file_name");
        // readfile($main_url);

        session()->flash('newurl', $main_url);
        session()->flash('org_file_name', $torrent_file->org_file_name);

        return redirect()->route('download_redirect');
    }

    public function upload(Request $request)
    {
        // $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        // dd($CKEditorFuncNum);

        $validator = Validator::make($request->all(), [
            // 'upload' => 'required|mimetypes:image/png,image/bmp,image/apng,image/jpeg,image/gif'
            'upload' => 'required|image|mimes:jpeg,bmp,png,jpg,gif|max:3072',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        if ($request->hasFile('upload')) {

            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            // $filenametostore = $filename.'_'.time().'.'.$extension;
            $milliseconds = (int) (round(microtime(true) * 1000000));
            $filenametostore = $milliseconds . '.' . $extension;

            $ext = $request->file('upload')->extension();

            $path = 'editor'; // . '/' . $milliseconds . '.' . $ext ;
            // $filename = $milliseconds . '.' . $ext;

            // $thumb_path = $request->file('upload')->storeAs($path, $filename, 'public');
            // $url = config('site-common.image-server') . '/' . $thumb_path;

            // //Upload File
            $vvpath = $request->file('upload')->storeAs('public/uploads/editor', $filenametostore);
            // $request->file('upload')->storeAs( $path , $filenametostore);

            // dd($vvpath) ;
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            // // $url = asset('storage/uploads/'.$filenametostore);
            $url = '/storage/uploads/editor/' . $filenametostore;

            $msg = '이미지 파일이 업로드 되었습니다.';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }

        // if (isset($_FILES['upload']['name'])) {
        //     $folder = storage_path('app/upload');
        //     $file = $_FILES['upload']['tmp_name'];
        //     $file_name = $_FILES['upload']['name'];
        //     $file_name_array = explode(".", $file_name);
        //     $extension = end($file_name_array);
        //     $new_image_name = rand() . '.' . $extension;
        //     // chmod('upload', 0755);
        //     $allowed_extension = array("jpg", "gif", "png");
        //     if (in_array($extension, $allowed_extension)) {
        //         move_uploaded_file($file, $folder . '/' . $new_image_name);
        //         $function_number = $_GET['CKEditorFuncNum'];
        //         $url = 'upload/' . $new_image_name;
        //         $message = '';
        //         echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
        //     }
        // }

        // return '{"filename" : "파일명", "uploaded" : 1, "url":"파일이 업로든 된 경로"}';

        // $data = $request->all();

        // return response()->json( $data);
        // dd($request->all());
    }

    public function download_test(Request $request)
    {
        $id = 479;

        $id = $request->id;
        $torrent_file = TorrentFile::find($id);

        $data = unserialize($torrent_file->post->post_cat->value);
        $download_login_need = (int) ($data['download_login_need'] ?? 1);

        if ($download_login_need == 1) { // 다운로드하는데에 로그인 필요하다면

            $user = Auth::user();
            // dd($user);

            $count = $torrent_file->downloads()
                ->where('user_id', $user->id)
                ->count();

            if ($count > 0) {
                // downoad
            } else {
                $data = unserialize($torrent_file->post->post_cat->value);
                $download_points = (int) ($data['download_points'] ?? 0);
                $uploader_points = (int) ($data['uploader_points'] ?? 0);

                if ($user->points < $download_points) {
                    notify()->error('최소 ' . $download_points . ' 포인트가 필요합니다.');

                    return redirect()->back();
                }
                $user->decrement('points', $download_points);
                $user->setLevel();

                if ($uploader_points > 0) {
                    $uploader = $torrent_file->post->user;
                    $uploader->increment('points', $uploader_points);
                    $uploader->setLevel();
                }

                $download = new Download();
                $download->user_id = $user->id;
                $download->points_charged = $download_points;

                // $download = [
                //     'user_id'=> $user->id ,
                //     'points_charged'=> $torrent_file->points_charged,
                // ];
                $torrent_file->downloads()->save($download);
            }
        }

        $torrent_file->increment('download_count');

        $file_server = config('site-common.file-server');
        // $file_server = str_replace('/file-storage', '', $file_server );

        // dd($torrent_file->org_file_name);
        $main_url = $file_server . '/' . $torrent_file->file_path;
        // header("Content-disposition:attachment; filename=$torrent_file->org_file_name");
        // readfile($main_url);

        session()->flash('newurl', $main_url);
        session()->flash('org_file_name', $torrent_file->org_file_name);

        return redirect()->route('download_redirect');

        // header("Cache-Control: public");
        // header("Content-Description: File Transfer");
        // header("Content-Disposition: attachment; filename=$torrent_file->org_file_name");
        // // header("Content-Type: $contentType");
        // header("Content-Transfer-Encoding: binary");
        // readfile($main_url);

        // if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
        //     header("content-type: doesn/matter");
        //     header("content-transfer-encoding: binary");
        // } else {
        //     header("content-type: file/unknown");
        //     header("content-description: php generated data");
        // }
        // header("content-length: " . $torrent_file->file_size ) ;
        // header("Content-disposition: attachment; filename=$torrent_file->org_file_name");
        // // header("content-length: ".filesize("$filepath"));

        // header("pragma: no-cache");
        // header("expires: 0");

        // readfile($main_url);

        // flush();

        // sleep(2);

        // notify()->success('다운로드 되었습니다.');

        return redirect()->back()->refresh();
    }
}
