<div class="content-table"> 
    <h3>{{__('POS Shipment')}} </h3>
    <div class="content-space"> 
        {{ Form::open(['route'=>'pos_send_request.registerShipmentPos','id'=>'frmSendPos','autocomplete'=>'Off', 'class' => 'validate', 'onSubmit'=>'displayAll()']) }}
            <div class="content-table inside mb-4">
                <h3 class="pos mb-2">{{__('Request')}} </h3>
                <div class="content-space">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="row">
                               <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                    {{ Form::select('nro_petition',$pos_request,null, ['class' => 'form-select required', 'id'=> 'nro_petition','placeholder'=>__('Select...')]) }} 
                                    {{ Form::label('nro_petition_label', __('Number Request'), ['class' => 'title'])}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::date('date_send', date('Y-m-d'), ['class' => 'form-control tooltips', 'id'=> 'date_send','placeholder'=>__('Date Send'),'readonly'=>'readonly']) }}
                                        {{ Form::label('date_send_label', __('Date Send'), ['class' => 'title'])}}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::text('nro_send', FullSerial($nro_send), ['class' => 'form-control tooltips number', 'id'=> 'nro_send','placeholder'=>__('Number Send'),'readonly'=>'readonly']) }}
                                        {{ Form::label('nro_send_label', __('Number Send'), ['class' => 'title'])}} 
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::text('respond_send', $respond, ['class' => 'form-control tooltips', 'id'=> 'respond_send','placeholder'=>__('Responsible Send'),'readonly'=>'readonly']) }}
                                        {{ Form::label('respond_send_label', __('Responsible Shipping'), ['class' => 'title'])}} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="col-xs-12 col-sm-12 col-md-12 ma-1">
                                <table class="dataTable table" data-pDataTable='{"searching": false, "paging": false, "info": false}' cellspacing="0" width="100%"  id ="table_request">
                                    <thead>
                                        <tr>
                                            <th>{{__('Model Request')}}</th>
                                            <th>{{__('Amount Request')}}</th>               
                                            <th>{{__('Amount Send')}}</th>
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
            <div class="content-table inside">
                <h3 class="pos mb-2">{{ __('Amount Box') }}</h3>
                <div class="content-space">
                {{ Form::button(__('Consult Available'), ['class' => 'btn btn-primary search title mb-3 ms-auto', 'id'=>'history_', 'data-bs-toggle'=>'modal', 'data-bs-target'=>'#detailConsultModels','onClick'=>"show_consult_available()"]) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                    <div class="form-group floating-label">
                                    {{ Form::select('model', [], null, ['class' => 'form-select tooltips required', 'id'=> 'model','placeholder'=>__('Select...'), 'disabled'=>true]) }} 
                                    {!!Form::label('model', __('Model'), ['class' => 'title'])!!}
                                    </div>
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-10 mb-4 te-1">
                                    <div class="form-group floating-label">
                                    
                                    {{ Form::text('nro_box', '', ['class' => 'form-control tooltips required', 'id'=> 'nro_box','minlength'=>'1','placeholder'=>__('Number Box'),'disabled'=>true])}}   
                                    {{ Form::label('nro_box_label', __('Number Box'), ['class' => 'required title'])}}

                                    </div> 
                                </div>

                                <div class="col-xs-1 col-sm-1 col-md-1 te-0">

                                    {{ Form::button(('<i class="fa fa-plus"></i>'), ['class' => 'btn btn-primary style', 'id' => 'add_box']) }}

                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 ma-1">
                            <table class="dataTable table" data-pDataTable='{"searching": false, "paging": false, "info": false}' cellspacing="0" width="100%"  id ="table_amount">
                                    <thead>
                                        <tr>
                                            <th>{{__('Model for shipping')}}</th>               
                                            <th>{{__('Boxes quantity to send')}}</th>
                                            <th>{{__('POS quantity to send')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>                         
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="content-table pa-0"> 
                        <table class="dataTable table" cellspacing="0" width="100%" id="table_petition">
                            <thead>
                                <tr>
                                    <th>{{__('Model')}}</th>
                                    <th>{{__('Boxs')}}</th>               
                                    <th>{{__('Serial')}}</th>
                                    <th>{{__('Amount POS')}}</th>
                                    <th>{{__('Actions')}}</th>
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
        {{ Form::close() }} 
    </div>
</div>
@include('pos_shipments.consult_available')
<script  type="text/javascript">
    var cont_boxs    = 0;
    var boxes        = [];
    var obj_boxes    = {};
    var array_count  = [];
    $(document).ready(function () {
        $('#nro_petition').on('change',function(){
            if($('#nro_petition').val() != ''){
                loadingWait();
                $('#table_request').dataTable().fnClearTable();
                $('#table_petition').dataTable().fnClearTable();
                $('#nro_box').val(''); 
                $('#model').empty().append('<option value="null">{{ __('Select...') }}</option>');                  
                $.get("{{route('pos_send_request.list_data_search')}}/"+$('#nro_petition option:selected').text(),function(data){
                    Swal.close();
                    var response = data.data;
                        if(data.status != 0){
                            for (var i = 0; i < response.length; i++) {
                                a = '<input type="hidden" class="check_model" name="model_many[]" value="'+response[i].model_id+'" />';
                                var row_table = [    
                                        a+response[i].model_request,
                                        response[i].quantity_request,
                                        response[i].quantity_send,
                                    ];
                                $('#table_request').dataTable().fnAddData(row_table);   
                                $('#nro_box').prop('disabled', false);
                                $('#model').append('<option value="'+response[i].model_id+'">'+response[i].model_request+'</option>');
                            }
                            $('#model').prop('disabled', false);
                        }else{
                            toastr[data.type_message](data.message, data.tittle,
                            { "progressBar"  : true,
                              "onclick": null,
                              "positionClass": "toast-top-right"
                            });
                        }
                },'json').fail(function(){
                    Swal.close();
                    toastr.error('{{ __('Your request could not be processed') }}');
                });
            }else{
                toastr.info('{{ __('You must select a request number') }}','{{ __('POS Shipment') }}');
                $('#model').prop('disabled', true);
            }
        });
        $('#add_box').on('click',function(){   
            if($('#frmSendPos, #model').valid() && boxesValid() == true){        
                loadingWait();
               $.post("{{route('pos_send_request.search')}}",$('#nro_box, #model,[name=_token]').serialize(),function(data){
                    Swal.close();
                    var response = data.data;
                    if(data.status != 0){
                        if(response != ''){
                            for (var i = 0; i < response.length; i++) {

                                let id_box = '<input type="hidden" name="nro_box['+cont_boxs+'][id]" value="'+response[i].id+'" />';

                                let row_table = [    
                                    response[i].model,
                                    response[i].number_box,
                                    response[i].serial_end+id_box,
                                    response[i].quantity_pos,
                                    '<a onClick="delete_boxs(this);" href="#" class="btn btn-moderation delete" title="{{ __('Delete')}}" ><i class="fa fa-trash"></i>{{ __('Delete')}}</a>'
                                    ];
                                    obj_boxes = {
                                        'id'         : response[i].id,
                                        'number_box' : response[i].number_box   
                                    };
                                $('#table_petition').dataTable().fnAddData(row_table);     
                                boxes.push(obj_boxes);
                                cont_boxs++;
                            }
                            goCount();
                        }else{
                            if(data.status=2){
                                toastr.info(data.message);
                            }
                            toastr.info('{{ __('No data found') }}');
                        }
                    }else{
                        toastr[data.type_message](data.message, data.tittle,
                        { "progressBar"  : true,
                          "onclick": null,
                          "positionClass": "toast-top-right"
                        });
                    }
                },'json').fail(function(){
                    Swal.close();
                    toastr.error('{{ __('Your request could not be processed') }}');
                }); 

            }
         });
    });
    function delete_boxs(obj)
    {
        row =  $(obj).parents('tr').get();
        index = $('#table_petition').DataTable().row( row ).index();
        $("#table_petition").DataTable().row(row).remove().draw();
        boxes.splice(index, 1);
        goCount();
    }
    function show_consult_available()
    {
        $("#consultModels").empty();
            loadingWait();
            $('.hide').hide();
        $.get("PO004.consult_available", function (response){
            Swal.close();
            $("#consultModels").html(response);
            $('.hide').show();
        }).fail(function(){
            Swal.close();
            toastr.error('{{ __('Your request could not be processed') }}');
        });
    }
    function boxesValid(){
        var row = $('#table_petition').DataTable().rows().count();
        for (var i = 0; i < row; i++) {
            if($('#table_petition').DataTable().row(i).data()[0] == $( "#model option:selected" ).text() && $('#table_petition').DataTable().row(i).data()[1]== $('#nro_box').val()){
                toastr['error']('{{ __('The box number is already added to the table') }}');
                return false;
            }
        }
        return true;
    }
    function goCount() 
    {
        var counts = {};
        array_count  = [];
        $('#table_amount').dataTable().fnClearTable();

        var row = $('#table_petition').DataTable().rows().count();
        for (var i = 0; i < row; i++) {
            array_count.push($('#table_petition').DataTable().row(i).data()[0]);
        }

        array_count.forEach((x) => {
          counts[x] = (counts[x] || 0) + 1;
        });
        var keys = Object.entries(counts);
        for (var i = 0; i < keys.length; i++) {
            keys[i].push(50);
            $('#table_amount').dataTable().fnAddData(keys[i]);     
        }
    }
    function displayAll(){
        $("#table_petition").DataTable().rows().nodes().page.len(-1).draw(false);
        return true;
    }
</script>