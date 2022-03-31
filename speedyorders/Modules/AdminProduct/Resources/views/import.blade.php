@extends('layouts.main')

@section('ext_css')

    <style>
        label {
            display: block;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="boxed">
                <div class="boxed-wrapper">
            <div class="hpanel">
                <form method="POST" action="{{route('admin.products.import_data')}}" class="form-horizontal" enctype="multipart/form-data" id="createproductForm" novalidate="novalidate">

                    @csrf     
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Import Products</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
                                <a class="btn btn-danger" href="{{ route('admin.products.index') }}">Cancel</a>
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">                                                
                        <div class="hr-line-dashed"></div>
                        <div id="file_upload_div" class="section_div" style="">                           
                            <div class="form-group">
                                <label class="col-md-2 control-label">Upload File Download</label>

                                <div class="col-md-4">
                                    <input type="file" name="file_name" class="form-control">
                                </div>
                            
                                <label class="col-md-2 control-label">
                                <a href="/products_import.csv">Sample File Download</a></label>
                                
                            </div>

                        </div>
                        <style type="text/css">
                         
                        div.section_div {
                            border: 1px solid gray;
                            padding: 18px;
                            border-radius: 5px;
                        }
                        </style>
                    </div>
                </form>
            </div>
        </div>
            </div>
        </div>
    </div>
    </div>
    <br>

@endsection

@section('ext_js')


    
@endsection
