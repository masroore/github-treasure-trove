<div class="content-table">
    <h3>{{ __('Reception POS') }}</h3>
    <div class="content-space">
        {{ Form::open(['route'=>'pos_reception.store',"onSubmit"=>"displayAll()",'id'=>'frmReception','autocomplete'=>'Off','class' => 'validate' ]) }}
            <div class="content-table inside mb-4">
                <h3 class="pos mb-2">{{__('Request')}}</h3>
                <div class="content-space"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 mb-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::select('num_petition', $num_request2, null, ['class' => 'form-select required', 'id'=> 'num_petition','placeholder'=>__('Select...')]) }}
                                    {{ Form::label('num_petition_label', __('Number Request'), ['class' => 'title'])}} 
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                <div class="form-group floating-label">
                                    {{ Form::text('responsible', $responsible, ['class' => 'form-control tooltips required', 'id'=> 'responsible','placeholder'=>__('Responsible'),'readonly' => true]) }}
                                    {{ Form::label('responsible_label', __('Responsible'), ['class' => 'title'])}} 
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <div class="col-xs-12 col-sm-12 col-md-12 ma-1">
                                <table class="dataTable table" data-pDataTable='{"searching": false, "paging": false, "info": false}' cellspacing="0" width="100%" id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{__('Model')}}</th>
                                            <th scope="col">{{__('Amount Requested')}}</th>               
                                        </tr>
                                    </thead>
                                    <tbody>                                              
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-table inside mb-4">
                <h3 class="pos">{{ __('Shipping') }}</h3>
                <div class="content-space"> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::select('num_send', [], null, ['class' => 'form-select required', 'id'=> 'num_send','placeholder'=>__('Select...'),'disabled' => true]) }} 
                                {{ Form::label('num_send_label', __('Number Send'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('responsible_send', $responsible, ['class' => 'form-control tooltips required', 'id'=> 'responsible_send','placeholder'=>__('Responsible'),'maxlength'=>'50','minlength'=>'3', 'readonly' => true]) }}
                                {{ Form::label('responsible_sendlabel', __('Responsible'), ['class' => 'title'])}} 
                            </div>
                        </div>
                        <div class="content-table pa-0 mb-4"> 
                            <table class="dataTable table" cellspacing="0" width="100%" id="table2">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('Model')}}</th>
                                        <th scope="col">{{__('Boxs')}}</th>               
                                        <th scope="col">{{__('Serials')}}</th>
                                        <th scope="col">{{__('Amount POS')}}</th>
                                        <th scope="col">{{__('Status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>                                              
                                </tbody>
                            </table>
                        </div> 
                        <div class="col-3 mx-auto mt-4">
                            {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save', 'type' => 'submit']) }} 
                        </div> 
                    </div>
                </div>
            </div>
        {{ Form::close() }} 
    </div>
</div>
<script type="text/javascript">
var cont_boxs = 0;
$(document).ready(function () {
    $('#num_petition').on('change',function(){  
        if($('#num_petition').val() != ''){
            loadingWait();
            $('#table1').dataTable().fnClearTable();
            $('#table2').dataTable().fnClearTable();
            $('#model').val();  
            $('#num_send').empty().append('<option value="null">{{ __('Select...') }}</option>');
            $.get("PO005.search/"+$('#num_petition option:selected').val(),function(data){
                swal.close();
                if(data.status != 0){
                    var response  = data.data;
                    var response2 = data.number_send;
                    for (var i = 0; i < response.length; i++) {
                        $('#id2').val(response[i].id);
                        var row_table = [    
                                response[i].model,
                                response[i].quantity,
                            ];
                        $('#table1').dataTable().fnAddData(row_table);   
                    }
                    if(response2 != ''){
                        for (var i = Object.keys(response2)[0]; i<= Object.keys(response2).pop(); i++) {
                            $('#num_send').append('<option value="'+[i]+'">'+response2[i]+'</option>');
                        }
                        $('#num_send').prop('disabled', false);        
                    }else{
                        $('#num_send').prop('disabled', true);        
                        toastr.info('{{ __('No Shipping Found') }}');
                    }        
                }else{
                    toastr[data.type_message](data.message, data.tittle,
                    { "progressBar"  : true,
                      "onclick": null,
                      "positionClass": "toast-bottom-center"
                    });
                    $('#num_send').prop('disabled', true);        
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });
        }else{
            toastr.info('{{ __('You must select a request number') }}','{{ __('POS Reception') }}');
        }
    });
    $('#num_send').on('change',function(){  
        if($('#num_send').val() != ''){
            loadingWait();
            $('#table2').dataTable().fnClearTable();
                $.get("PO005.shipment_search/"+$('#num_send').val(),function(request){
                swal.close();
                if(request.status != 0){
                    for(i in request.data.detail_shipment){
                        let id_box = '<input type="hidden" name="boxes['+cont_boxs+'][id]" value="'+request.data.detail_shipment[i].pos_boxes_id+'" />';
                        let id_box_model = '<input type="hidden" name="boxes['+cont_boxs+'][model]" value="'+request.data.detail_shipment[i].get_boxes.model_id+'" />';
                        let row_table = [    
                                request.data.detail_shipment[i].boxes.model+id_box,
                                request.data.detail_shipment[i].boxes.number_box+id_box_model,
                                request.data.detail_shipment[i].boxes.serial_end,
                                request.data.detail_shipment[i].boxes.quantity_pos,
                                '<select name="boxes['+cont_boxs+'][recived]" class ="form-select required recived"><option value="1" selected>'+ "{{__('Recived')}}" +'</option><option value="0">'+ "{{__('Non-Recived')}}" +'</option></select>'
                            ];
                        $('#table2').dataTable().fnAddData(row_table);   
                        cont_boxs++;
                    }              
                }else{
                    toastr[data.type_message](data.message, data.tittle,
                    { "progressBar"  : true,
                      "onclick": null,
                      "positionClass": "toast-bottom-center"
                    });
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });
        }else{
            toastr.info('{{ __('You must select a send number') }}','{{ __('POS Reception') }}');
        }
    });
});
function displayAll(){
    $("#table2").DataTable().rows().nodes().page.len(-1).draw(false);
    return true;
}
</script>