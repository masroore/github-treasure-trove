<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRandomCodeRequest;
use App\Http\Requests\UpdateRandomCodeRequest;
use App\Http\Resources\Admin\RandomCodeResource;
use App\Models\RandomCode;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RandomCodeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('random_code_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RandomCodeResource(RandomCode::with(['location_code', 'company'])->get());
    }

    public function store(StoreRandomCodeRequest $request)
    {
        $randomCode = RandomCode::create($request->all());

        return (new RandomCodeResource($randomCode))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RandomCode $randomCode)
    {
        abort_if(Gate::denies('random_code_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RandomCodeResource($randomCode->load(['location_code', 'company']));
    }

    public function update(UpdateRandomCodeRequest $request, RandomCode $randomCode)
    {
        $randomCode->update($request->all());

        return (new RandomCodeResource($randomCode))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RandomCode $randomCode)
    {
        abort_if(Gate::denies('random_code_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $randomCode->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
