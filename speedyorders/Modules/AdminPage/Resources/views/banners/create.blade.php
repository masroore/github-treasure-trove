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
                <form method="POST" action="{{ route('admin.pages.banners.store') }}" class="form-horizontal"
                enctype="multipart/form-data">
                @csrf
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Create Banner</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
                                <button class="btn btn-success" type="submit">Create</button>
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
                                <input type="file" name="f_image" value="{{ old('f_image') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Title</label>
                            <div class="col-md-8">
                                <input type="text" name="f_title" value="{{ old('f_title') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Description</label>
                            <div class="col-md-8">
                                <input type="text" name="f_description" value="{{ old('f_description') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Button Text</label>
                            <div class="col-md-8">
                                <input type="text" name="f_button_text" value="{{ old('f_button_text') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">First Button Link</label>
                            <div class="col-md-8">
                                <input type="text" name="f_link" value="{{ old('f_link') }}"
                                    class="form-control">
                            </div>
                        </div>

                        {{-- second --}}


                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class=" col-md-2 control-label">Second Image</label>
                            <div class="col-md-8">
                                <input type="file" name="s_image" value="{{ old('s_image') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Title</label>
                            <div class="col-md-8">
                                <input type="text" name="s_title" value="{{ old('s_title') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Description</label>
                            <div class="col-md-8">
                                <input type="text" name="s_description" value="{{ old('s_description') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Button Text</label>
                            <div class="col-md-8">
                                <input type="text" name="s_button_text" value="{{ old('s_button_text') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Second Button Link</label>
                            <div class="col-md-8">
                                <input type="text" name="s_link" value="{{ old('s_link') }}"
                                    class="form-control">
                            </div>
                        </div>



                        {{-- third --}}

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class=" col-md-2 control-label">Third Image</label>
                            <div class="col-md-8">
                                <input type="file" name="t_image" value="{{ old('t_image') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Title</label>
                            <div class="col-md-8">
                                <input type="text" name="t_title" value="{{ old('t_title') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Description</label>
                            <div class="col-md-8">
                                <input type="text" name="t_description" value="{{ old('t_description') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Button Text</label>
                            <div class="col-md-8">
                                <input type="text" name="t_button_text" value="{{ old('t_button_text') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Third Button Link</label>
                            <div class="col-md-8">
                                <input type="text" name="t_link" value="{{ old('t_link') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Sort Order</label>
                            <div class="col-md-8">
                                <input type="text" name="sort_order" value="{{ old('sort_order') }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Status</label>
                            <div class="col-md-8">
                                <input type="radio" id="first" name="status" value="1" {{ old('status' =='1' ? 'checked' : '') }} >
                                <label for="first">Active</label><br>
                                <input type="radio" id="second" name="status" value="2" {{ old('status' =='0' ? 'checked' : '') }} >
                                <label for="second">Inactive</label><br>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

