<?php

namespace Modules\AdminPage\Http\Controllers;

use App\Models\Banner;
use Illuminate\Routing\Controller;
use Modules\AdminPage\Http\Requests\CreateBannerRequest;
use Modules\AdminPage\Http\Requests\UpdateBannerRequest;
use Modules\AdminPage\Services\CreateBannerService;
use Modules\AdminPage\Services\UpdateBannerService;

class AdminBannerController extends Controller
{
    public function index()
    {
        $data = [
            'menu' => 'banners',
        ];
        $banners = Banner::orderByDesc('id')->get();

        return view('adminpage::banners.index', compact('banners'), $data);
    }

    public function create()
    {
        $data = [
            'menu' => 'banners',
        ];

        return view('adminpage::banners.create', $data);
    }

    public function store(CreateBannerRequest $request, CreateBannerService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Banner stored successfully.');
        } else {
            session()->flash('error_message', 'Banner could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.pages.banners.index');
    }

    public function edit($id)
    {
        $data = [
            'menu' => 'banners',
        ];

        $banner = Banner::findorfail($id);

        return view('adminpage::banners.edit', compact('banner'), $data);
    }

    public function update(UpdateBannerRequest $request, UpdateBannerService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Banner updated successfully.');
        } else {
            session()->flash('error_message', 'Banner could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.pages.banners.index');
    }

    public function destroy($id)
    {
        Banner::destroy($id);

        return redirect()->route('admin.pages.banners.index')->with('flash_message', 'Banner deleted!');
    }

    public function updateBannerStatus($id)
    {
        try {
            $banner = Banner::find($id);
            if ('1' == $banner->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Banner::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Banner updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Banner could not be updated.');
        }

        return redirect()->route('admin.pages.banners.index');
    }
}
