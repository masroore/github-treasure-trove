@extends('layouts.main')

@section('ext_css')
    <style type="text/css">
        
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 3px;
        }
        span.select2-selection.select2-selection--single {
            min-height: 35px;
        }
        span.select2-selection__rendered {
            margin-top: 2px !important;
        }
    </style>
@endsection

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="hpanel">
            <div class="panel-heading">
                <H4>Edit Product Attribute</H4>
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

            <form method="POST" action="{{ route('admin.product.attributes.update',[$attribute->id]) }}" accept-charset="UTF-8" class="form-horizontal col-md-12" enctype="multipart/form-data" id="updateProductAttributesFrm">
                    @csrf
                    <br>
                    <div class="hr-line-dashed"></div>
                    @include ('adminproductattribute::form', ['formMode' => 'edit'])

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ext_js')

@php
    $counter = $attribute->attributeValues()->count();
@endphp

<script>

        var counter = {{$counter}};
        $('#add-attribute-value').on('click',function(){
            $("#attribute-values-table tbody").append("<tr id style='display: table-row;' class='footable-even'><td class='footable-visible footable-first-column'><input type='input' class='form-control' name='attribute_value[name]["+counter+"]' placeholder='name' id='attribute_value[name]["+counter+"]' required/></td><td class='footable-visible'><input class='form-control' type='file' name='attribute_value[file]["+counter+"]' placeholder='sort order' id='attribute_value[file]["+counter+"]'></td><td class='footable-visible'><input class='form-control' type='number' class='' name='attribute_value[sort_order]["+counter+"]' placeholder='name' id='attribute_value[sort_order]["+counter+"]' required></td><td class='footable-visible footable-last-column'><button type='button' class='btn btn-danger delete-attribute-value'><i class='fa fa-trash'></i></button></td></tr>");
            counter++;
        });

        $('#attribute-values-table').on('click', '.delete-attribute-value', function() {
            $(this).parents('tr').remove();
        });
</script>
@endsection
