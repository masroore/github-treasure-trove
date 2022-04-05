<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\UpsoType;
// use Illuminate\Support\Facades\Input;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class BannersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->division) {
            $division = $request->division;
        } else {
            $division = 1;
        }

        $upso_types = UpsoType::all();

        $divisions = [
            1 => [
                'title' => '메인 배너관리',
                'size' => '400 X 100',
                'count' => 16,
                'range' => '1~12, ...',
            ],
            2 => [
                'title' => '뷰 페이지 중간 배너관리',
                'size' => '1000 X 100',
                'count' => 3,
                'range' => '13~15',
            ],
            3 => [
                'title' => '뷰 페이지 하단 배너관리',
                'size' => '260 X 260',
                'count' => 8,
                'range' => '16~23',
            ],

            4 => [
                'title' => '팝업 배너관리',
                'size' => '320 X 220',
                'count' => 4,
                'range' => '26~30',
            ],

            5 => [
                'title' => '프리미엄업소 배너관리',
                'size' => '280 X 196',
                'count' => 4,
                'range' => '39~42',
            ],

            5 => [
                'title' => '프리미엄업소 배너관리',
                'size' => '280 X 196',
                'count' => 4,
                'range' => '39~42',
            ],

        ];

        $sub_premia = [];

        foreach ($upso_types as $upso_type) {
            $tmp = [
                'title' => '프리미엄업소 [' . $upso_type->title . ']',
                'size' => '280 X 196',
                'count' => 4,
                'range' => '39~42',
            ];
            $divisions[] = $tmp;
        }

        $banners_admin = Banner::where('division', $division)->get();

        // dd($banners->count());

        return view('admin.banners.index', compact('banners_admin', 'divisions', 'division'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $id = $request->id;

        $type = $request->type;
        // $division= $request->division;
        if ($request->status) {
            $status = $request->status;
        } else {
            $status = 'D';
        }
        // dd($requestData);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = File::extension($file->getClientOriginalName());

            $image = Image::make($file);
            $ff = $id . '.' . $ext;
            $ff = time() . '.' . $ext;

            $file_name = 'storage/upload/banners/' . $ff;

            if ($file->getClientOriginalExtension() == 'gif') {
                // echo $file->getRealPath() ;
                $cc = copy($file->getRealPath(), $file_name);

                if (!$cc) {
                    return redirect()->back()->with('error', '유저단 저장에 실패했습니다. ');
                }
            } else {
                $cc = $image->save($file_name);
                if (!$cc) {
                    return redirect()->back()->with('error', '유저단 저장에 실패했습니다. ');
                }
            }

            $banner = Banner::find($request->id);

            $division = $banner->division;

            $banner->type = $request->type;
            $banner->link = $request->link;
            // $banner->division = $division ;
            $banner->title = $request->title;
            $banner->status = $status;
            $banner->file_name = $file_name;

            $banner->save();
            $this->saveBannerToFile();

            $cache_key = 'banners-' . $division;
            Cache::forget($cache_key);

        // return redirect()->back()->with('error', '에러가 발생했습니다.') ;
        } else {
            return redirect()->back()->with('error', '파일이 없습니다.');
        }

        return redirect('/admin/banners?division=' . $division)->with('success', '입력 되었습니다.');
    }

    public function saveBannerToFile()
    {
        $banners = Banner::where('status', 'A')->get();
        $fb = 'banners.json';

        return Storage::put($fb, $banners->toJson());
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
        dd('asd');
    }

    public function status(Request $request, $id)
    {
        $banner = Banner::find($id);
        $banner->status = $request->status;
        $url = $request->url;

        if ($banner->save() && $this->saveBannerToFile()) {
            $cache_key = 'banners-' . $banner->division;
            Cache::forget($cache_key);

            return redirect($url)->with('success', '배너 상태가 수정되었습니다.');
        }

        return redirect()->back()->with('error', '수정에 실패하였습니다.');
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
