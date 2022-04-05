<div class="content-table"> 
    <h3>{{ __('POS Configuration') }}</h3>
    <div class="content-space"> 
        {{ Form::open(['route'=>'pos_configuration.configured_store','id'=>'frmSearch','autocomplete'=>'Off','class' => 'validate' ]) }}
           <div class="row mb-4">
                <div class="col-xs-11 col-sm-11 col-md-11 te-1">
                    <div class="form-group floating-label">
                        {{ Form::text('boxes', null, ['class' => 'form-control','min'=>'1', 'id'=> 'boxes','placeholder'=>__('N° Boxes')]) }}
                        {!!Form::label('boxes', __('N° Boxes'), ['class' => 'title'])!!}
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1">
                    {{ Form::button(('<i class="fa fa-search"></i>'), ['class' => 'btn btn-primary style', 'id' => 'masive_searh']) }}
                </div>
            </div>
            <table class="dataTable table" cellspacing="0" width="100%" id="table1">
                <thead>
                    <tr>
                        <th scope='col'>{{__('Model')}}</th>
                        <th scope='col'>{{__('Box Number')}}</th>
                        <th scope='col'>{{__('Serial')}}</th>
                        <th scope='col'>{{__('POS Amount')}}</th>
                        <th scope='col'>{{__('Configured')}}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="col-5 mx-auto mt-4">  
                {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save_masive', 'type' => 'submit']) }}
            </div>
        {{ Form::close() }}
    </div>
</div>
<script type="text/javascript">
var cont_boxs = 0;
$(document).ready(function () {
    $('#masive_searh').on('click',function(){   
        if($('#frmSearch').valid()){        
            $('#table1').dataTable().fnClearTable();
            loadingWait();
            $.get("{{route('pos_configuration.SearchForConfig')}}/"+$('#boxes').val(),function(data){
                swal.close();
                if(data != ''){
                    for (var i = 0; i < data.length; i++) {

                        let id_box = '<input type="hidden" name="boxes['+cont_boxs+'][id]" value="'+data[i].id+'" />';

                        let row_table = [    
                            data[i].model+id_box,
                            data[i].number_box,
                            data[i].serial_end,
                            data[i].quantity_pos,
                            '<select name="boxes['+cont_boxs+'][configured]" class ="form-control required"><option value="1" selected>'+ "{{__('Configured')}}" +'</option><option value="0">'+ "{{__('Non-Configured')}}" +'</option></select>'
                            ];
                        $('#table1').dataTable().fnAddData(row_table);     
                        cont_boxs++;
                    }
                }else{
                    toastr.info('{{ __('No data Found') }}');
                }
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });   
        }
     });  
});
</script>
