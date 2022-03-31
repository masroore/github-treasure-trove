<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropoertyInquiryRequest;
use App\Http\Requests\UpdatePropoertyInquiryRequest;
use App\Http\Resources\Admin\PropoertyInquiryResource;
use App\Models\PropoertyInquiry;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PropoertyInquiriesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('propoerty_inquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PropoertyInquiryResource(PropoertyInquiry::with(['property', 'created_by'])->get());
    }

    public function store(StorePropoertyInquiryRequest $request)
    {
        $propoertyInquiry = PropoertyInquiry::create($request->all());

        return (new PropoertyInquiryResource($propoertyInquiry))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PropoertyInquiry $propoertyInquiry)
    {
        abort_if(Gate::denies('propoerty_inquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PropoertyInquiryResource($propoertyInquiry->load(['property', 'created_by']));
    }

    public function update(UpdatePropoertyInquiryRequest $request, PropoertyInquiry $propoertyInquiry)
    {
        $propoertyInquiry->update($request->all());

        return (new PropoertyInquiryResource($propoertyInquiry))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PropoertyInquiry $propoertyInquiry)
    {
        abort_if(Gate::denies('propoerty_inquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $propoertyInquiry->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
