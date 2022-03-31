@extends('layouts.main')

@section('ext_css')
    <style>
        ol {
            padding-left: 10px;
        }

        li {
            padding-bottom: 10px;
        }

    </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
                <form method="POST" action="{{ route('admin.pages.banners.update') }}" class="form-horizontal"
                enctype="multipart/form-data">
                @csrf
        <div class="panel-heading">
            <input type="hidden" name="id" @if(isset($banner)) value="{{ $banner->id }}" @endif>
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Update Banner</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class=" col-md-2 control-label">First Image</label>
                            <div class="col-md-8">
                                <input type="file" name="f_image" value="{{ old('f_image', isset($banner) ? $banner->f_image : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Title</label>
                            <div class="col-md-8">
                                <input type="text" name="f_title" value="{{ old('f_title', isset($banner) ? $banner->f_title : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Description</label>
                            <div class="col-md-8">
                                <input type="text" name="f_description" value="{{ old('f_description', isset($banner) ? $banner->f_description : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Button Text</label>
                            <div class="col-md-8">
                                <input type="text" name="f_button_text" value="{{ old('f_button_text', isset($banner) ? $banner->f_button_text : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Button Link</label>
                            <div class="col-md-8">
                                <input type="text" name="f_link" value="{{ old('f_link', isset($banner) ? $banner->f_link : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        {{-- second --}}


                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class=" col-md-2 control-label">Second Image</label>
                            <div class="col-md-8">
                                <input type="file" name="s_image" value="{{ old('s_image', isset($banner) ? $banner->s_image : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Title</label>
                            <div class="col-md-8">
                                <input type="text" name="s_title" value="{{ old('s_title', isset($banner) ? $banner->s_title : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Description</label>
                            <div class="col-md-8">
                                <input type="text" name="s_description" value="{{ old('s_description', isset($banner) ? $banner->s_description : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Button Text</label>
                            <div class="col-md-8">
                                <input type="text" name="s_button_text" value="{{ old('s_button_text', isset($banner) ? $banner->s_button_text : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Button Link</label>
                            <div class="col-md-8">
                                <input type="text" name="s_link" value="{{ old('s_link', isset($banner) ? $banner->s_link : null) }}"
                                    class="form-control">
                            </div>
                        </div>



                        {{-- third --}}

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class=" col-md-2 control-label">Third Image</label>
                            <div class="col-md-8">
                                <input type="file" name="t_image" value="{{ old('t_image', isset($banner) ? $banner->t_image : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Title</label>
                            <div class="col-md-8">
                                <input type="text" name="t_title" value="{{ old('t_title', isset($banner) ? $banner->t_title : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Description</label>
                            <div class="col-md-8">
                                <input type="text" name="t_description" value="{{ old('t_description', isset($banner) ? $banner->t_description : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Button Text</label>
                            <div class="col-md-8">
                                <input type="text" name="t_button_text" value="{{ old('t_button_text', isset($banner) ? $banner->t_button_text : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Button Link</label>
                            <div class="col-md-8">
                                <input type="text" name="t_link" value="{{ old('t_link', isset($banner) ? $banner->t_link : null) }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Sort Order</label>
                            <div class="col-md-8">
                                <input type="text" name="sort_order" value="{{ old('sort_order',isset($banner) ? $banner->sort_order:'') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Status</label>
                            <div class="col-md-8">
                                <input type="radio" id="active" name="status" value="1" {{ old('status', isset($banner)&&$banner->status=='1' ? 'checked' : '') }} >
                                <label for="active">Active</label><br>
                                <input type="radio" id="inactive" name="status" value="2" {{ old('status', isset($banner)&&$banner->status=='0' ? 'checked' : '') }} >
                                <label for="inactive">Inactive</label><br>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

