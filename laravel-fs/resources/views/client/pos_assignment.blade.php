<div class="content-table">
    <h3>{{ __('POS Asignment') }}</h3>
    <div class="content-space">
        {{ Form::open(['id' => 'frm1_pos_asignment', 'class' => 'validate', 'autocomplete' => 'Off']) }}
        {{ Form::hidden('type', 'code')}}
        {{ Form::hidden('id', '', ["id"=>"id"])}}
        <div class="row ">
            <div class="col-xs-11 col-sm-11 col-md-11 mb-4 te-1">
                <div class="form-group floating-label">
                    {{ Form::text('code', null, ['class' => 'form-control  number', 'id'=> 'code_client', 'maxlength'=>'20','minlength'=>'1','placeholder' => __('Code Client'), 'required'=>'required'])}}
                    {{Form::label('labelcode', __('Code Client'), ['class' => 'title'])}}
                </div>  
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary','data-step-valid'=>'#step-1', 'id' => 'search_code_client']) }}
            </div>
        </div>
        <div class="content-table inside content-space"  >
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('document', null, ['class' => 'form-control ', 'id'=> 'document', 'placeholder' => __('Document'), 'readonly'=>'readonly'])}}
                        {{Form::label('document', __('Document'), ['class' => 'title'])}}
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('name_client', null, ['class' => 'form-control ', 'id'=> 'name_client', 'placeholder' => __('Name'), 'readonly'=>'readonly'])}}
                        {{Form::label('name_client', __('Name'), ['class' => 'title'])}}
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('account', [], '', ['id'=>'account', 'class'=>'form-select required', 'placeholder' => __('Select...'), 'required'=>'required', 'disabled' => true])}}
                        {{Form::label('account', __('Account'), ['class' => 'selec2label'])}}
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                    <div class="form-group floating-label">
                        {{Form::number('serial', '', ['id'=>'serial', 'class'=>'form-control number  required', 'min'=>'1', 'placeholder' => __('POS Serial'), 'required'=>'required', 'disabled' => true])}}
                        {{Form::label('serial', __('POS Serial'), ['class' => 'selec2label'])}}
                    </div>  
                </div>
                <div class="col-md-1 mb-4">
                    {{ Form::button(('<i class="fa fa-search"></i>'), ['class' => 'btn btn-primary style', 'id' => 'price_search', 'disabled' => true]) }}
                </div>
                @if(Auth::User()->sensitive_info == 1)
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('exonerate', [1 => __('Yes'), 0 => __('No')], 0, ['id'=>'exonerate', 'class'=>'form-select required', 'placeholder' => __('Select...'), 'required'=>'required', 'disabled' => true])}}
                        {{Form::label('exonerate', __('Exonerate'), ['class' => 'selec2label'])}}
                    </div>  
                </div>
                @else
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('not_exonerate', 'No', ['class' => 'form-control', 'id'=> 'not_exonerate', 'placeholder' => __('Exonerate'), 'disabled' => true])}}
                        {{Form::label('not_exonerate', __('Exonerate'), ['class' => 'title'])}}
                    </div>
                        {{ Form::hidden('exonerate', 0, ["id"=>"exonerate"])}}
                </div>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('model', null, ['class' => 'form-control ', 'id'=> 'model', 'placeholder' => __('Model'), 'readonly'=>'readonly'])}}
                        {{Form::label('model', __('Model'), ['class' => 'title'])}}
                    </div>  
                </div>
                @if(Auth::User()->sensitive_info == 1)
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('price', null, ['class' => 'form-control maskmoney', 'id'=> 'price', 'placeholder' => __('Price'),'disabled' => true])}}
                        {{Form::label('price', __('Price'), ['class' => 'title'])}}
                    </div>  
                </div>
                @else
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('price', null, ['class' => 'form-control maskmoney', 'id'=> 'price', 'placeholder' => __('Price'),'readonly' => true, 'disabled' => true])}}
                        {{Form::label('price', __('Price'), ['class' => 'title'])}}
                    </div>  
                </div>    
                @endif
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('insurance', [1 => __('Yes'), 0 => __('No')] ,'', ['id'=>'insurance', 'class'=>'form-select  required', 'placeholder' => __('Select...'), 'required'=>'required', 'disabled' => true])}}
                        {{Form::label('insurance', __('Insurance'), ['class' => 'selec2label'])}}
                    </div>  
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('dual_sim', [1 => __('Yes'), 0 => __('No')] ,'', ['id'=>'dual_sim', 'class'=>'form-select  required', 'placeholder' => __('Select...'), 'required'=>'required', 'disabled' => true])}}
                        {{Form::label('dual_sim', __('Dual Sim'), ['class' => 'selec2label'])}}
                    </div>   
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('observations', null, ['class' => 'form-control', 'id'=> 'observations', 'placeholder' => __('Observations'),'maxlength'=> 20, 'disabled' => true])}}
                        {{Form::label('observations', __('Observations'), ['class' => 'title'])}}
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                    <div class="form-group floating-label">
                        {{Form::select('type_transation', $transa , 1, ["multiple"=>"multiple", 'id'=>'type_transation', 'class'=>'form-control select2 required', 'required'=>'required', 'disabled' => true])}}
                        {{Form::label('type_transation', __('Type Transation'), ['class' => 'selec2label'])}}
                    </div>  
                </div>
                <div class="col-5 mx-auto">
                    {{ Form::button('<i class="fa fa-plus-circle"></i>', ['class' => 'btn btn-primary', 'onClick'=>'add_asignment()' ,'id' => 'add_table']) }}
                </div>  
            </div>
        </div>
        {{ Form::close() }}
        {{ Form::open(['id' => 'frm1_pos_asignment_save','class' => 'validate', 'autocomplete' => 'Off']) }}
        <div class="content-table inside content-space"  >
            <div class="col-lg-12">
                <table id="table_pos" data-pDataTable='{"searching": false, "paging": false, "info": false}' class="table dataTable" >
                    <thead>
                        <tr>
                            <th scope='col' >{{__('Model')}}</th>
                            <th scope='col' >{{__('Serial')}}</th>
                            <th scope='col' >{{__('Type Transation')}}</th>
                            <th scope='col' >{{__('Insurance')}}</th>
                            <th scope='col' >{{__('Dual Sim')}}</th>
                            <th scope='col'>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-5 mx-auto"> 
                {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save', 'type' => 'button']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script>
    var cant_asig     = 0;
    var price         = '';
    var asignment     = [];
    var obj_asignment = {};
    $(document).ready(function () {
        $(document).on('click', '#dell', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });
        $("#save").on("click", function (){
            loadingWait();
            $.post('{{route("pos_assignment.save_pos_client")}}', $('#frm1_pos_asignment_save').serialize(), function (response){
                Swal.close();
                Swal.fire(response.title, response.message, response.type_message);
                if(response.status == 1){
                    clean_fields();
                    $("#table_pos").DataTable().clear().draw();
                }
            });  
        });
        $('#search_code_client').on('click', function () {
            if ($("#code_client").valid()) {
                loadingWait();
                $.post('{{route("client.getDataClient")}}', $('#frm1_pos_asignment').serialize(), function (response) {
                    Swal.close();
                    if (response.status == 1) {
                        $('#account, #serial, #price_search').prop('disabled', false);
                        $("#account").empty().append('<option value="">{{__('Select...')}}</option>');
                        $("#document").val(response.data.rif);
                        $("#id").val(response.data.crypt_id);
                        $("#name_client").val(response.data.name_client);
                        for (const acc in response.accounts) {
                          $("#account").append('<option value="'+`${acc}`+'">'+`${response.accounts[acc]}`+'</option>');
                        }
                    }
                },'json').fail(function(){
                    Swal.close();
                    clean_fields();
                    toastr.error('{{ __('Your request could not be processed') }}');
                }); 
            }
        });        
        $('#price_search').on('click', function () {
            if ($("#serial").valid() && AsignmentRegisterValid() == true) {
                loadingWait();
                $.get('{{url("CL004.get_pos")}}/' + $("#serial").val(), function (response) {
                    Swal.close();
                    if (response != '') {
                        price = response.get_boxes.get_models.price;
                        $('#model').val(response.model);
                        $('#price').val(response.get_boxes.get_models.price);
                        $('#exonerate').val(0).trigger('change');
                        $('#exonerate, #price, #insurance, #dual_sim, #observations, #type_transation').prop('disabled', false);

                    } else {
                        clean_fields_price();
                        toastr.info('{{ __('POS not found') }}');
                    }
                },'json').fail(function(){
                    Swal.close();
                    clean_fields_price();
                    toastr.error('{{ __('Your request could not be processed') }}');
                }); 
            }
        });        
        $('#exonerate').on('change', function () {
            if($(this).val() == 1){
                $('#price').val('0,00');
                $('#price').prop('disabled', true);
                $('#insurance').val(0).trigger('change');
                $('#insurance').prop('disabled', true);
            }else{
                $('#price').val(price);
                $('#price').prop('disabled', false);
                $('#insurance').val('').trigger('change');
                $('#insurance').prop('disabled', false);
            }
        });
    });
    function add_asignment() {
        if ($('#frm1_pos_asignment').valid()) {
            loadingWait();
            $.get('{{url("CL004.get_pos")}}/' + $("#serial").val(), function (response){
                Swal.close();
                if (response.length == 0){
                    toastr['error']('{{__("POS not found")}}');
                } else{
                    type_transation_text = "";
                    type_transation_value = "";
                    $('#type_transation :selected').each(function (i, obj){
                        type_transation_text += $(obj).text() + ",";
                        type_transation_value += obj.value + ";";
                    });
                    inputs  = '<input type="hidden" name="assig[' + cant_asig + '][client_id]"       class="pos_asig" value="' + $("#id").val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][pos_id]"          class="pos_asig" value="' + response.crypt_id + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][insurance]"       class="pos_asig" value="' + $('#insurance').val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][dual_sim]"        class="pos_asig" value="' + $('#dual_sim').val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][account_id]"      class="pos_asig" value="' + $('#account').val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][price]"           class="pos_asig" value="' + $('#price').val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][exonerate]"       class="pos_asig" value="' + $('#exonerate').val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][observations]"    class="pos_asig" value="' + $('#observations').val() + '"/>';
                    inputs += '<input type="hidden" name="assig[' + cant_asig + '][type_transation]" class="pos_asig" value="' + type_transation_value + '"/>';
                    row_table = [
                            response.model + inputs,
                            $('#serial').val(),
                            type_transation_text,
                            $('#insurance :selected').text(),
                            $('#dual_sim :selected').text(),
                            '<a onClick="delete_row(this);" href="#" class="btn btn-moderation delete" title="{{ __('Delete')}}" ><i class="fa fa-trash"></i>{{ __('Delete')}}</a>'
                    ];
                    obj_asignment = {
                        'model'           : $('#model').val(),
                        'serial'          : $('#serial').val()
                    };
                    asignment.push(obj_asignment);
                    $('#table_pos').dataTable().fnAddData(row_table);
                    clean_fields_price();
                    cant_asig++;
                }
            }, 'json');
        }
    }
    function delete_row(obj){
        tr = $(obj).parents('tr').get();
        $("#table_pos").DataTable().row(tr).remove().draw();
    }    
    function clean_fields(){
        price = '';
        $("#document, #name_client, #id, #serial, #model, #price, #insurance, #dual_sim, #observations").val('').trigger('change');
        $("#exonerate").val(0).trigger('change');
        $('#type_transation').val(1).trigger('change');
        $('#account, #serial, #price_search, #exonerate, #price, #insurance, #dual_sim, #observations, #type_transation').prop('disabled', true);
        $("#account").empty().append('<option value="">{{__('Select...')}}</option>');
    }    
    function clean_fields_price(){
        price = '';
        $("#serial, #model, #price, #insurance, #dual_sim, #observations").val('').trigger('change');
        $("#exonerate").val(0).trigger('change');
        $('#type_transation').val(1).trigger('change');
        $('#exonerate, #price, #insurance, #dual_sim, #observations, #type_transation').prop('disabled', true);
    }
    function AsignmentRegisterValid(){
        for (var i = 0; i < asignment.length; i++) {
            if(asignment[i].serial == $('#serial').val().toString()){
                toastr['error']('{{ __('The POS serial is already added to the table') }}');
                return false;
            }
        }
        return true;
    }
</script>
