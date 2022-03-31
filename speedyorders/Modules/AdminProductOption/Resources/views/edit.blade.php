@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="hpanel">
            <div class="panel-heading">
                <H4>Edit Product Option</H4>
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

            <form method="POST" action="{{ route('admin.product.options.update',[$option->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <br>
                    <div class="hr-line-dashed"></div>
                    @include ('adminproductoption::form', ['formMode' => 'edit'])

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ext_js')

@php
    $counter = $option->optionValues()->count();
@endphp

<script>

        var counter = {{$counter}};
        $('#add-option-value').on('click',function(){
            $("#option-values-table tbody").append("<tr id style='display: table-row;' class='footable-even'><td class='footable-visible footable-first-column'><input type='input' class='form-control' name='option_value[name]["+counter+"]' placeholder='name' id='option_value[name]["+counter+"]' required/></td><td class='footable-visible'><input class='form-control' type='file' name='option_value[file]["+counter+"]' placeholder='sort order' id='option_value[file]["+counter+"]'></td><td class='footable-visible'><input class='form-control' type='number' class='' name='option_value[sort_order]["+counter+"]' placeholder='name' id='option_value[sort_order]["+counter+"]' required></td><td class='footable-visible footable-last-column'><button type='button' class='btn btn-danger delete-option-value'><i class='fa fa-trash'></i></button></td></tr>");
            counter++;
        });

        $('#option-values-table').on('click', '.delete-option-value', function() {
            $(this).parents('tr').remove();
        });

        $("#option_selection").change(function(){
            var val_option = $(this).val();
           
            if(val_option=="input" || val_option=="date" || val_option=="date_time" ){
                $("#option_values_div").hide();    
            } else {
                $("#option_values_div").show();
            }
            

        });
</script>
@endsection
