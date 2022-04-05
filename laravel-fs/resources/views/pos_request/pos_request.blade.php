{{ Form::open(['id'=>'pos_request','autocomplete'=>'Off', "onSubmit"=>"displayAll()", "enctype"=>"multipart/form-data", "class"=>"validate"]) }}
<div class="content-table">
    <h3>{{ __('POS Request') }}</h3>   
    <div class="content-space "> 
        {{ Form::button(__('Consult Available'), ['class' => 'btn btn-primary search title mb-3 ms-auto','onClick'=>"show_consult_available()"]) }}
        <div class="content-table inside content-space"> 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::number('request_num', FullSerial($num_send, 8), ['class' => 'form-control number required', 'id'=> 'request_num', 'readonly' => true, 'placeholder'=>__('Request number')]) }}
                         {{ Form::label('request_num', __('Request number'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{  Form::date('date', date('Y-m-d'), ['id'=>'date','class'=>'form-control required', 'readonly' => true, 'placeholder'=>__('Date')]) }}
                        {{  Form::label('date', __('Date'), ['class' => 'title'])}}          
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('store_request', $store_request, null, ['class' => 'form-select required', 'id'=> 'store_request','placeholder'=>__('Select...')]) }} 
                        {!!Form::label('store_request', __('Store Request'), ['class' => 'title'])!!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('responsable', $responsible, ['class' => 'form-control onlyText required', 'id'=> 'responsable', 'readonly' => true, 'placeholder'=>__('Responsable')]) }}
                         {{ Form::label('responsable', __('Responsable'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('model', $models, null, ['class' => 'form-select', 'id'=> 'model','placeholder'=>__('Select...')]) }} 
                        {!!Form::label('model', __('Model'), ['class' => 'title'])!!}
                    </div>
                </div>
                <div class="col-xs-11 col-sm-11 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('amount', $increments, 100, ['class' => 'form-select', 'id'=> 'amount', 'placeholder'=>__('Select...')]) }}
                        {{ Form::label('amount', __('Amount'), ['class' => 'title '])}}
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1">
                    {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-primary', 'id' => 'add_pos_request']) }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
{{ Form::open(['id'=>'pos_request_table_form','autocomplete'=>'Off',"route"=>"pos_request.store", 'class' => 'validate', "enctype"=>"multipart/form-data"]) }}
{{ Form::hidden('model_hidden', null, ['id'=> 'model_hidden'])}}
{{ Form::hidden('amount_hidden', null, ['id'=> 'amount_hidden'])}}          
{{ Form::hidden('store_hidden', null, ['id'=> 'store_hidden'])}}          
    
     <table class="dataTable table" cellspacing="0" width="100%" id="table_pos_request">
        <thead>
            <tr>
                <th scope='col'>{{__('Model')}}</th>
                <th scope='col'>{{__('Amount')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
     <div class="col-5 mx-auto content-space">   
        {{ Form::button('<i class="fa fa-save"></i> '.__('Save'), ['class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'save_request']) }}
         
    </div>
</div>
{{ Form::close() }}
@include('pos_request.consult_available')
<script type="text/javascript">
var cont_req = 0;
$(document).ready(function () {
    $('#seePDF').hide();
    $('#add_pos_request').on('click',function(){   
        if($('#pos_request').valid()){
              $('#model_hidden').val($('#model').val());
              $('#amount_hidden').val($('#amount').val());
              $('#store_hidden').val($('#store_request').val());

            if($('.mdl[value='+$('#model').val()+']').length == 0){
                let input_model_id = '<input type="hidden" class="mdl" name="models['+cont_req+'][model_id]" value="'+$('#model').val()+'" />';
                let input_amount = '<input type="hidden" name="models['+cont_req+'][amount]" value="'+$("#amount").val()+'" />';
             
                let input_model_name = '<input type="hidden" name="models['+cont_req+'][model_name]" value="'+$('#model option:selected').text()+'" />';

                let input_store_request = '<input type="hidden" name="models['+cont_req+'][store_request]" value="'+$("#store_request").val()+'" />';
                
                let input_store_request_name = '<input type="hidden" name="models['+cont_req+'][store_request_name]" value="'+$('#store_request option:selected').text()+'" />';
                
                let fields = input_model_id + input_amount + input_model_name+ input_store_request+ input_store_request_name; 

                cont_req ++;

                row_table = [    
                    fields+$('#model option:selected').text(),
                    $('#amount').val(),
                    '<a onClick="delete_pos_r(this);" href="#" class="btn btn-moderation delete" title="{{ __('Delete')}}" ><i class="fa fa-trash"></i>{{ __('Delete')}}</a>'
                ]
                $('#table_pos_request').dataTable().fnAddData(row_table); 
                toastr['info']('{{ __('Adding the POS model to the table') }}');
                clean_fields()
            } else {
                 toastr.warning('{{ __('The POS model is already added to the table') }}') 
            }
        }
     });

});
function delete_pos_r(obj){
    tr =  $(obj).parents('tr').get()  ;
    $("#table_pos_request").DataTable().row(tr).remove().draw();
}
function displayAll(){
    $("#table_pos_request").DataTable().rows().nodes().page.len(-1).draw(false);
    return true;
}
function clean_fields(){
$("#model").val('').trigger('change');
$("#amount").val('').trigger('change');
}
function show_consult_available()
{
    if($('#store_request').val() != ''){
        $("#consultModels").empty();
            loadingWait();
            $.get("PO003.consult_available/"+$('#store_request').val(), function (response){
                Swal.close();
                $('#detailConsultModels').modal('show')
                $("#consultModels").html(response);
            }).fail(function(){
                Swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });
    }else{
        toastr.info('{{ __('Please select a storage') }}');
    }
}
</script>