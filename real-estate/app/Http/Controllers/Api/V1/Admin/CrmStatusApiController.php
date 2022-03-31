<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmStatusRequest;
use App\Http\Requests\UpdateCrmStatusRequest;
use App\Http\Resources\Admin\CrmStatusResource;
use App\Models\CrmStatus;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class CrmStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmStatusResource(CrmStatus::with(['created_by'])->get());
    }

    public function store(StoreCrmStatusRequest $request)
    {
        $crmStatus = CrmStatus::create($request->all());

        return (new CrmStatusResource($crmStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmStatus $crmStatus)
    {
        abort_if(Gate::denies('crm_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmStatusResource($crmStatus->load(['created_by']));
    }

    public function update(UpdateCrmStatusRequest $request, CrmStatus $crmStatus)
    {
        $crmStatus->update($request->all());

        return (new CrmStatusResource($crmStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmStatus $crmStatus)
    {
        abort_if(Gate::denies('crm_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
