@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
                <div class="hpanel">
                    <form method="POST" action="{{ route('admin.orders.store') }}" class="form-horizontal" enctype="multipart/form-data" id="createProductForm">
                            @csrf
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5><strong>Create orders</strong> </h5>
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
                            @include ('adminorder::form', ['formMode' => 'create'])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('ext_js')
<script>

$('#openProductModal').on('click',function(e){
    $('.validate-msg').hide();

        $('#add-product-modal').modal('show');
        var productId = $('#product_id').val();
        getProductVariants(productId);
        getProductPackages(productId);
    });

  function getProductVariants(productId){
    var url = '{{ route('admin.orders.product.options') }}';

    $.ajax({
        /* the route pointing to the post function */
        url: url,
        type: 'post',
        /* send the csrf-token and the input to the controller */
        data: {
            "_token": "{{ csrf_token() }}",
            "productId": productId
        },
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function(data) {
           $('.modal-product-otion-panel').empty().append(data.html);
        }
    });
  }

  function getProductPackages(productId){

    var url = '{{ route('admin.orders.product.packages') }}';

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
            "productId": productId
        },
        dataType: 'JSON',
        success: function(data) {
           $('.modal-product-package-panel').empty().append(data.html);
        }
    });
  }

$('.add-product').on('click', function (e)
{
    $('#product_table').removeClass('hidden');
    e.preventDefault();
    var productId = $('#product_id option:selected').val();

    var productName = $('#product_id option:selected').text();
    var totalQuantity = $('#order_product_quantity').val();

    var validate = false;
    var checkInputs =$('input.'+productId+'[type=text]');
    var checkSelects =$('select.'+productId);

    /*checkInputs.each(function() {
        if($(this).val() == "")
        {
            validate = true;
        }
    });
    checkSelects.each(function() {
        if($(this).val() == "")
        {
            validate = true;
        }
    });*/
    if(productId==="" || totalQuantity==="" || validate === true)
    {
        $('.validate-msg').show();
    }
    else
    {
        $('.validate-msg').hide();
        var $inputs =$('input.'+productId+'[type=text]');
        var row = "";
        var inputDisplay = '';
        var inputsHtml ='';

        $inputs.each(function() {
          row += this.name+'['+$(this).val()+']';
          inputsHtml += '<input type="text" data-id='+this.id+' class="hiddenInput" name="" value='+$(this).val()+'>';
          inputDisplay += '<p>'+this.placeholder+' : '+$(this).val()+'</p></br>';
        });


        var selects =$('select.'+productId);

        var selectDisplay = '';
        var selectHtml ='';


        console.log(selects);

        selects.each(function() {
          row += this.name+'['+$(this).find(":selected").val()+']';

          selectHtml += '<input type="text" data-id='+this.id+' class="hiddenInput" name="" value='+$(this).find(":selected").val()+'>' ;

            if($(this).find(":selected").text()){
                selectDisplay += '<p>'+$(this).attr("data-option")+' : '+$(this).find(":selected").text()+'</p></br>';
            }
        });

        if(row == ""){
            row = productId;
        }

        if($('#option-values-table tr').length>0){
            var rowExist = document.getElementById(row);
            if(rowExist){
                $(rowExist).remove();
            }
        }

        $('#option-values-table').append("<tr style='display: table-row;' class='footable-even' id='"+row+"'> <td class='footable-visible footable-first-column'> <input type='hidden' name='product_id[]' value="+productId+">"+productName+"</td><td class='footable-visible'> <input type='text' name='product_quantity[]' value="+totalQuantity+"></td><td>"+inputDisplay + selectDisplay+"</td><td class='footable-visible footable-last-column'> <button type='button' class='btn btn-danger dlt-product'><i class='fa fa-trash'></i></button> </td><td class='hidden'>"+inputsHtml + selectHtml +"</td></tr>");
        
        arrangeOrder();

        $('#add-product-modal').modal('hide');
  }
    
});

// for ordering option index according to productId Index;
function arrangeOrder(){
    var rowCount = $('tr.footable-even').length;
    if(rowCount>0){
        $('tr.footable-even').each(function(index){
            var input = $(this).find('input.hiddenInput');
            $(input).each(function(){
                updatedName = "option["+index+"]"+$(this).data('id');
                $(this).attr('name',updatedName);
            });
        });
    }
    
}

$('#product_id').on('change',function(){

    var productId = $(this).val();
    getProductVariants(productId);

    getProductPackages(productId);
});
$(document).on('click','.dlt-product',function(e)
{
    e.preventDefault();
    $(this).closest("tr").remove();
    arrangeOrder();

});

$(document).ready(function(){
    $("#same_as_customer_details").on('change',function(){
        if($('input[name="same_as_customer_details"]:checked').val()==1){
            $("#payment_first_name").val($("#first_name").val());
            $("#payment_last_name").val($("#last_name").val());
            $("#payment_company").val($("#company").val());
            $("#payment_address_1").val($("#address_1").val());
            $("#payment_address_2").val($("#address_2").val());
            $("#payment_city").val($("#city").val());
            $("#payment_postcode").val($("#postcode").val());
            $("#payment_country_name").val($("#country_name").val());
        }
    });

    $("#same_as_customer_details_shipping").on('change',function(){
        if($('input[name="same_as_customer_details_shipping"]:checked').val()==1){
            $("#shipping_first_name").val($("#first_name").val());
            $("#shipping_last_name").val($("#last_name").val());
            $("#shipping_company").val($("#payment_company").val());
            $("#shipping_address_1").val($("#address_1").val());
            $("#shipping_address_2").val($("#address_2").val());
            $("#shipping_city").val($("#city").val());
            $("#shipping_postcode").val($("#postcode").val());
            $("#shipping_country_name").val($("#country_name").val());
        }
    });
});



</script>
@endsection
