<div class="content-table">

    <h3>{{ __('Payment POS') }}</h3>

    <div class="content-space">

        {{ Form::open(['id' => 'frmUpdateClient', 'class' => 'validate', 'onsubmit' => 'return false', 'autocomplete' => 'Off']) }}

        <div class="row ocult">
             <div class="col-xs-1 col-sm-1 col-md-1 lo">
                <div class="form-check">
                    {{ Form::radio('check', 1, true, ['class' => 'form-check-input', 'checked'=> 'checked','id'=> 'check1'])}}

                </div>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-4 te-b mb-4">
                <div class="form-group floating-label">
                    {{ Form::number('code', 1, ['class' => 'form-control numeric number', 'id'=> 'code', 'placeholder' => __('Code Client')])}}
                    {{Form::label('labelcode', __('Code Client'), ['class' => 'title'])}}
                </div>  
                    {{Form::hidden('type','code')}}
            </div>

            <div class="col-xs-1 col-sm-1 col-md-1 lo">
                <div class="form-check">
                    {{ Form::radio('check', 2, false, ['class' => 'form-check-input checkSearch','id'=> 'check2'])}}

                </div>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 te-b te-1">
                <div class="form-group floating-label">
                    {{Form::label('type_documenttlabel', __('Type Document'), ['class' => 'selec2label'])}}
                    {{Form::select('type_document', $type_document ,'', ['id'=>'type_document', 'class'=>'form-control select2', 'placeholder' => __('Select...'), 'disabled' => 'disabled' ])}}
                </div>
            </div>
            <div class="col-xs-7 col-sm-7 col-md-3 te-b">
                <div class="form-group floating-label">
                    {{ Form::number('document','', ['class' => 'form-control number numeric', 'id'=> 'document', 'maxlength'=>'9', 'minlength'=>'8','placeholder' => __('RIF'), 'readonly' => true]) }}
                    {{Form::label('documentlabel', __('RIF'), ['class' => 'title'])}}
                </div> 
            </div>


            <div class="col-xs-1 col-sm-1 col-md-1">  
                {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary', 'id' => 'search']) }}
            </div>                                       

        </div>

        {{ Form::close() }}
    <div style="display:none" id="ocult" class=" content-table inside content-space">
            <div class="row mb-4">
                <div class="col-xs-6 col-sm-6 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('rif_client','', ['readonly'=>'true','class' => 'form-control', 'id'=> 'rif_client','placeholder' => __('Rif'),'readonly'=>'readonly']) }}
                        {{Form::label('rif_client', __('Rif'), ['class' => 'title'])}}
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('name_client','', ['readonly'=>'true','class' => 'form-control', 'id'=> 'name_client','placeholder' => __('Client'),'readonly'=>'readonly']) }}
                        {{Form::label('name_client', __('Client'), ['class' => 'title'])}}
                    </div> 
                </div>
                <table class="dataTable table" cellspacing="0" width="100%" id="table">
                    <thead>
                        <tr>
                            <th scope='col'>{{__('Model')}}</th>
                            <th scope='col'>{{__('Exonerated')}}</th>
                            <th scope='col'>{{__('Price')}}</th>
                            <th scope='col'>{{__('Abonate')}}</th>
                            <th scope='col'>{{__('Debt')}}</th>
                            <th scope='col'>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    <div id="client_bank">
    </div>
    </div>
</div>
@include('pay_pos.pay_pos_details')
<script>
    var cont_boxs = 0;
    $(document).ready(function () {
        $('#check1').on('click', function () {
            $('#code_client').prop('readonly', false);
            $('#type_document').prop("disabled", true);
            $('#document').prop('readonly', true);             
            $("#type_document").val('').trigger('change');
            $("#document").val('');
        });
        $('#check2').on('click', function () {
            $('#code_client').prop('readonly', true);
            $('#document').prop('readonly', true);                
            $('#type_document').prop("disabled", false);
            $("#document").removeAttr("readonly");
            $("#code_client").val('');        
        });
        $('#search').on('click', function () {
				loadingWait()
                $.post("{{route('charge_pos.search_client')}}", $('#frmUpdateClient').serialize(), function (data) {
					Swal.close();
                    $('#rif_client').val('');
                    $('#name_client').val('');
                    $('#table').dataTable().fnClearTable();
                    $('#table_2').dataTable().fnClearTable();
                    if (data['status'] == 0) {
                        toastr['error'](data['message']);
                        $('#ocult').slideUp('fast');
                    } else {
                        toastr.success(data.message);
                        $('#rif_client').val(data.rif);
                        $('#name_client').val(data.name_client);
                        var response = data.client_pos;
                        var client_pos_model = data.client_pos_model;
                        var client_pos_exonerate = data.client_pos_exonerate;
                        var client_pos_price = data.client_pos_price;
                        var client_pos_amount = data.pos_pay;
                        for (var i = 0; i < response.length; i++) {
                            let row_table = [    
                                client_pos_model[i],
                                client_pos_exonerate[i],
                                client_pos_price[i],
                                client_pos_amount[i].pagado,
                                client_pos_amount[i].deu,
                                '<a title="{{__('Charge')}}" onClick="show_pay(\''+response[i].crypt_id+'\')" data-bs-toggle="modal" data-bs-target="#detail_pay" href="#" class="btn btn-moderation edit"  ><i class="fa fa-search"></i>{{__("Charge")}} </a>'
                            ];
                        $('#table').dataTable().fnAddData(row_table);   
                        cont_boxs++;
                        }
                        $('#ocult').slideDown('fast');
                    }
                }, 'json').fail(function (){ 
                    toastr['error']('{{ __('Your request could not be processed') }}');
                });
        });
        $('#document').on('keypress', function (e) {
            if (e.which == 13) {
                $('#search').click();
            }
        });
    });
    function show_pay(id) {
    $.get("{{url('CL005.search_pay')}}/" + id, function(response) {
        $('#models').text('');
        $('#serials').text('');
        $('#departments').text('');
        $('#table_2').dataTable().fnClearTable();
        $('#pay_methods').empty().append('<option value="null">{{ __('Select...') }}</option>');   
        if (response.status == 1) {
            for (var i =Object.keys(response.pay_method)[0]; i < Object.keys(response.pay_method).length+1; i++) {
                $('#pay_methods').append('<option value="'+[i]+'">'+response.pay_method[i]+'</option>');
            }
            for (var i = Object.keys(response.pays)[0]; i < Object.keys(response.pays).length; i++) {
                let row_table = [    
                    response.pays[i].pay_method_id,
                    response.pays[i].pay_date,
                    response.pays[i].reference,
                    response.pays[i].amount,
                ];
            $('#table_2').dataTable().fnAddData(row_table);   
            }
        }
    }, 'json');
}
</script>
