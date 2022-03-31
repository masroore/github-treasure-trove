<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPropoertyInquiryRequest;
use App\Http\Requests\StorePropoertyInquiryRequest;
use App\Http\Requests\UpdatePropoertyInquiryRequest;
use App\Models\Property;
use App\Models\PropoertyInquiry;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PropoertyInquiriesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('propoerty_inquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propoertyInquiries = PropoertyInquiry::with(['property', 'created_by'])->get();

        return view('admin.propoertyInquiries.index', compact('propoertyInquiries'));
    }

    public function create()
    {
        abort_if(Gate::denies('propoerty_inquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $properties = Property::pluck('property_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.propoertyInquiries.create', compact('properties'));
    }

    public function store(StorePropoertyInquiryRequest $request)
    {
        $propoertyInquiry = PropoertyInquiry::create($request->all());

        return redirect()->route('admin.propoerty-inquiries.index');
    }

    public function edit(PropoertyInquiry $propoertyInquiry)
    {
        abort_if(Gate::denies('propoerty_inquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $properties = Property::pluck('property_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $propoertyInquiry->load('property', 'created_by');

        return view('admin.propoertyInquiries.edit', compact('properties', 'propoertyInquiry'));
    }

    public function update(UpdatePropoertyInquiryRequest $request, PropoertyInquiry $propoertyInquiry)
    {
        $propoertyInquiry->update($request->all());

        return redirect()->route('admin.propoerty-inquiries.index');
    }

    public function show(PropoertyInquiry $propoertyInquiry)
    {
        abort_if(Gate::denies('propoerty_inquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propoertyInquiry->load('property', 'created_by');

        return view('admin.propoertyInquiries.show', compact('propoertyInquiry'));
    }

    public function destroy(PropoertyInquiry $propoertyInquiry)
    {
        abort_if(Gate::denies('propoerty_inquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propoertyInquiry->delete();

        return back();
    }

    public function massDestroy(MassDestroyPropoertyInquiryRequest $request)
    {
        PropoertyInquiry::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
