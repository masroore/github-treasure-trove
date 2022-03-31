@extends('layouts.main')

@section('ext_css')
    <style>
        ol
        {
            padding-left: 10px;
        }
        li
        {
            padding-bottom: 10px;
        }
    </style>

    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
                <form method="POST" action="{{ route('admin.pages.components.update') }}" class="form-horizontal"
                enctype="multipart/form-data">
                @csrf
                    <div class="panel-heading">
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
                            <input type="hidden" name="id" value="{{ $pageComponent->id }}">
                        <div class="row">
                            <label class="col-md-2 control-label">Choose Page</label>
                            <div class="col-md-8">
                                <input type="radio" id="homePage" name="page_id" value="1"  {{ old('page_id', isset($pageComponent)&&$pageComponent->page_id=='1' ? 'checked' : '') }} >
                                <label for="homePage">Home</label><br>
                                <input type="radio" id="productDetails" name="page_id" value="2" {{ old('page_id', isset($pageComponent)&&$pageComponent->page_id=='2' ? 'checked' : '') }} >
                                <label for="productDetails">Product Details</label><br>
                            </div>
                        </div>


                        {{-- ck editor --}}
                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Content</label>
                            <div class="col-md-8">
                                <textarea name="content" id="content">{!! $pageComponent->content !!}</textarea>
                            </div>
                        </div>


                        <div class="hr-line-dashed"></div>

                        <div class="row">
                            <label class="col-md-2 control-label">Status</label>
                            <div class="col-md-8">
                                <input type="radio" id="active" name="status" value="1" {{ old('status', isset($pageComponent)&&$pageComponent->status=='1' ? 'checked' : '') }} >
                                <label for="active">Active</label><br>
                                <input type="radio" id="inactive" name="status" value="0" {{ old('status', isset($pageComponent)&&$pageComponent->status=='0' ? 'checked' : '') }} >
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

@section('ext_js')
<script>
var content = CKEDITOR.replace( 'content',{
    removeButtons: 'Image',
});
</script>
@endsection
