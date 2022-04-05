<div class="content-table">
    <h3>{{ __('Pre Opening Account') }}</h3>
    <div class="content-space">
        {{ Form::open(['route'=>'client.storeAccount', 'id' => 'frm1_pre_opening', 'class' => 'validate', 'autocomplete' => 'Off']) }}
            <div class="row">
                <div class="col-xs-11 col-sm-11 col-md-11 mb-4 te-1">
                    <div class="form-group floating-label">
                        {{ Form::text('code', null, ['class' => 'form-control  number', 'id'=> 'code','placeholder' => __('Code Client')])}}
                        {{Form::label('code', __('Code Client'), ['class' => 'title'])}}
                        {{ Form::hidden('id', '', ['id'=> 'id'])}}
                        {{ Form::hidden('type', 'code', ['id'=> 'type'])}}
                    </div>  
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary','data-step-valid'=>'#step-1', 'id' => 'search_code_client']) }}
                </div>
            </div>
            <div class="content-table inside content-space"  id="ocult">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                        <div class="form-group floating-label">
                            {{ Form::text('document', null, ['class' => 'form-control ', 'id'=> 'document','placeholder' => __('Document'), 'disabled'=> true ])}}
                            {{Form::label('document', __('Document'), ['class' => 'title'])}}
                        </div>  
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                        <div class="form-group floating-label">
                            {{ Form::text('name_client', null, ['class' => 'form-control ', 'id'=> 'name_client','placeholder' => __(''), 'disabled'=> true, 'placeholder' => __('Name')])}}
                            {{Form::label('name_client', __('Name'), ['class' => 'title'])}}
                        </div>  
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                        <div class="form-group floating-label">
                            {{Form::select('type_account', $type_account, '', ['id'=>'type_account', 'class'=>'form-control select2 required', 'placeholder' => __('Select...'), 'disabled' => true])}}
                            {{Form::label('type_account', __('Type Account'), ['class' => 'selec2label'])}}
                        </div>  
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                        <div class="form-group floating-label">
                            {{ Form::text('account', null, ['class' => 'form-control numeric number required', 'id'=> 'account','placeholder' => __(''), 'readonly'=> true, 'placeholder' => __('Account')])}}
                            {{Form::label('account', __('Account'), ['class' => 'title'])}}
                        </div>  
                    </div> 
                    <div class="col-xs-1 col-sm-1 col-md-1 mb-4">
                        {{ Form::button('<i class="fas fa-money-check"></i>', ['class' => 'btn btn-primary','data-step-valid'=>'#step-1', 'id' => 'search_account']) }}
                    </div>   
                </div>
                <div class="col-5 mx-auto"> 
                    {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save1', 'type' => 'submit']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
<script>
$(document).ready(function () {
    $('#search_code_client').on('click', function () {
        if ($("#code").val() != '') {
            loadingWait();
            $.post('{{route("client.getDataClient")}}', $('#frm1_pre_opening').serialize(), function (response) {
                Swal.close();
                if (response.status == 1) {
                    $("#type_account").prop('disabled', false);
                    $("#document").val(response.data.rif);
                    $("#id").val(response.data.crypt_id);
                    $("#name_client").val(response.data.name_client);
                } else {
                    $("#type_account").prop('disabled', true);
                    $("#document, #name_client, #id").val("");
                    toastr[response.type_message](response.message);
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            }); 
        }else{
            toastr.info('{{ __('The client code is empty') }}');
        }
    });    
    $('#search_account').on('click', function () {
        if ($("#type_account").val() != '') {
            loadingWait();
            $.get("{{url('CL001.generateAccount')}}", function(response) {
                Swal.close();
                if (response.status == 1) {
                    toastr[response.type_message](response.message);
                    $("#account").val(response.data);
                } else {
                    $("#account").val("");
                    toastr[response.type_message](response.message);
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            }); 
        }else{
            toastr.info('{{ __('Please select a coin type for account generation') }}');
        }
    });
});
</script>