@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
                <form method="POST" action="{{ route('admin.customers.update', [$customer->id]) }}" accept-charset="UTF-8"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Edit Customer</strong> </h5>
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
                        @include ('admincustomer::form', ['action' => 'edit'])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ext_js')

<script>

$( document ).ready(function() {
        $("#tab-2 div input").find("input[type = 'text']").each(function() {
        if(this.value != null) {
            $('#resetEditAddress').show();
            return false;
        }
    });
});

$('.edit-address-btn').on('click',function(e){

    var actionUrl = $(this).attr('data-edit-url');

    $.ajax({
        url: actionUrl,
        type: "GET",
        dataType: 'JSON',

        success:function(res){
            $.each(res, function(key,value) {
                if(key == 'id')
                {
                    $('#address_id').empty().val(value);
                }
                $('#'+key).empty().val(value);
            });
            $('#resetEditAddress').show();
        },

        error:function(xhr){

        }
    });
});


$('.delete-address-btn').on('click',function(e){

    if(confirm('Are you sure to delete selected address?')){
        var actionUrl = $(this).attr('data-delete-url');
        var address_id = $(this).attr('data-address-id');

        $.ajax({
            url: actionUrl,
            type: "GET",
            dataType: 'JSON',
            success:function(res){
               // alert(res.message);
                $("#address_"+address_id).remove();
            },

            error:function(xhr){

            }
        });
    }
});


$('#resetEditAddress').on('click',function(e){
    e.preventDefault()
    $('#tab-2 div input').val('');
    $(this).hide();
});

$( document ).ready(function() {
        $("#tab-3 div input").find("input[type = 'text']").each(function() {
        if(this.value != null) {
            $('#resetEditTransaction').show();
            return false;
        }
    });
});

$('.edit-transaction-btn').on('click',function(e){

var actionUrl = $(this).attr('data-edit-url');

$.ajax({
    url: actionUrl,
    type: "GET",
    dataType: 'JSON',

    success:function(res){

        $.each(res, function(key,value) {
            if(key == 'id')
            {
                $('#transaction_id').empty().val(value);
            }
            $('#'+key).empty().val(value);
        });
        $('#resetEditTransaction').show();
    },

    error:function(xhr){

    }
});
});

$('#resetEditTransaction').on('click',function(e){
    e.preventDefault()
    $('#tab-3 div input').val('');
    $(this).hide();
});

$( document ).ready(function() {
        $("#tab-4 div input").find("input[type = 'text']").each(function() {
        if(this.value != null) {
            $('#resetEditIp').show();
            return false;
        }
    });
});

$('.edit-ip-btn').on('click',function(e){

var actionUrl = $(this).attr('data-edit-url');

$.ajax({
    url: actionUrl,
    type: "GET",
    dataType: 'JSON',

    success:function(res){

        $.each(res, function(key,value) {
            if(key == 'id')
            {
                $('#ip_id').empty().val(value);
            }
            $('#'+key).empty().val(value);
        });
        $('#resetEditIp').show();
    },

    error:function(xhr){

    }
});
});

$('#resetEditIp').on('click',function(e){
    e.preventDefault()
    $('#tab-4 div input').val('');
    $(this).hide();
});

</script>
@endsection
