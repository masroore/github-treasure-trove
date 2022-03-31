<?php

namespace Modules\AdminPage\Http\Controllers;

use App\Models\PageComponent;
use Illuminate\Routing\Controller;
use Modules\AdminPage\Http\Requests\CreatePageComponentRequest;
use Modules\AdminPage\Http\Requests\UpdatePageComponentRequest;
use Modules\AdminPage\Services\CreatePageComponentService;
use Modules\AdminPage\Services\UpdatePageComponentService;

class AdminPageComponentController extends Controller
{
    public function index()
    {
        $data = [
            'menu' => 'pageComponents',
        ];

        $pageComponents = PageComponent::orderByDesc('id')->get();

        return view('adminpage::page-components.index', compact('pageComponents'), $data);
    }

    public function create()
    {
        $data = [
            'menu' => 'pageComponents',
        ];

        return view('adminpage::page-components.create', $data);
    }

    public function store(CreatePageComponentRequest $request, CreatePageComponentService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Page component stored successfully.');
        } else {
            session()->flash('error_message', 'Page component could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.pages.components.index');
    }

    public function edit($id)
    {
        $data = [
            'menu' => 'pageComponents',
        ];

        $pageComponent = PageComponent::findorfail($id);

        return view('adminpage::page-components.edit', compact('pageComponent'), $data);
    }

    public function update(UpdatePageComponentRequest $request, UpdatePageComponentService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Page components updated successfully.');
        } else {
            session()->flash('error_message', 'Page components could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.pages.components.index');
    }

    public function destroy($id)
    {
        PageComponent::destroy($id);

        return redirect()->route('admin.pages.components.index')->with('flash_message', 'Page component deleted!');
    }

    public function updatePageComponentStatus($id)
    {
        try {
            $pageComponent = PageComponent::find($id);
            if ('1' == $pageComponent->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            PageComponent::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Page Component updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Page component could not be updated.');
        }

        return redirect()->route('admin.pages.components.index');
    }
}
