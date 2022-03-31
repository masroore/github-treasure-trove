<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRandomCodeRequest;
use App\Http\Requests\StoreRandomCodeRequest;
use App\Http\Requests\UpdateRandomCodeRequest;
use App\Models\Company;
use App\Models\Location;
use App\Models\RandomCode;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RandomCodeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('random_code_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $randomCodes = RandomCode::with(['location_code', 'company'])->get();

        return view('frontend.randomCodes.index', compact('randomCodes'));
    }

    public function create()
    {
        abort_if(Gate::denies('random_code_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $location_codes = Location::all()->pluck('location_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.randomCodes.create', compact('location_codes', 'companies'));
    }

    public function store(StoreRandomCodeRequest $request)
    {
        $randomCode = RandomCode::create($request->all());

        return redirect()->route('frontend.random-codes.index');
    }

    public function edit(RandomCode $randomCode)
    {
        abort_if(Gate::denies('random_code_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $location_codes = Location::all()->pluck('location_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $randomCode->load('location_code', 'company');

        return view('frontend.randomCodes.edit', compact('location_codes', 'companies', 'randomCode'));
    }

    public function update(UpdateRandomCodeRequest $request, RandomCode $randomCode)
    {
        $randomCode->update($request->all());

        return redirect()->route('frontend.random-codes.index');
    }

    public function show(RandomCode $randomCode)
    {
        abort_if(Gate::denies('random_code_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $randomCode->load('location_code', 'company');

        return view('frontend.randomCodes.show', compact('randomCode'));
    }

    public function destroy(RandomCode $randomCode)
    {
        abort_if(Gate::denies('random_code_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $randomCode->delete();

        return back();
    }

    public function massDestroy(MassDestroyRandomCodeRequest $request)
    {
        RandomCode::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
