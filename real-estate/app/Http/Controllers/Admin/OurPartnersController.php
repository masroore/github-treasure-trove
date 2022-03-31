<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOurPartnerRequest;
use App\Http\Requests\StoreOurPartnerRequest;
use App\Http\Requests\UpdateOurPartnerRequest;
use App\Models\OurPartner;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OurPartnersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('our_partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ourPartners = OurPartner::with(['media'])->get();

        return view('admin.ourPartners.index', compact('ourPartners'));
    }

    public function create()
    {
        abort_if(Gate::denies('our_partner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ourPartners.create');
    }

    public function store(StoreOurPartnerRequest $request)
    {
        $ourPartner = OurPartner::create($request->all());

        if ($request->input('logo', false)) {
            $ourPartner->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $ourPartner->id]);
        }

        return redirect()->route('admin.our-partners.index');
    }

    public function edit(OurPartner $ourPartner)
    {
        abort_if(Gate::denies('our_partner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ourPartners.edit', compact('ourPartner'));
    }

    public function update(UpdateOurPartnerRequest $request, OurPartner $ourPartner)
    {
        $ourPartner->update($request->all());

        if ($request->input('logo', false)) {
            if (!$ourPartner->logo || $request->input('logo') !== $ourPartner->logo->file_name) {
                if ($ourPartner->logo) {
                    $ourPartner->logo->delete();
                }
                $ourPartner->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($ourPartner->logo) {
            $ourPartner->logo->delete();
        }

        return redirect()->route('admin.our-partners.index');
    }

    public function show(OurPartner $ourPartner)
    {
        abort_if(Gate::denies('our_partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ourPartners.show', compact('ourPartner'));
    }

    public function destroy(OurPartner $ourPartner)
    {
        abort_if(Gate::denies('our_partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ourPartner->delete();

        return back();
    }

    public function massDestroy(MassDestroyOurPartnerRequest $request)
    {
        OurPartner::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('our_partner_create') && Gate::denies('our_partner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new OurPartner();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
