{{ Form::open(['id'=>'pos_register','autocomplete'=>'Off', "enctype"=>"multipart/form-data", 'class' => 'validate']) }}
<div class="content-table">
    <h3>{{ __('POS Register') }}</h3>
    <div class="content-space"> 
        <div class="content-table inside content-space">      
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('provider', $provider, null, ['class' => 'form-select required', 'id'=> 'provider','placeholder'=>__('Select...'), 'required' => 'required']) }} 
                        {{Form::label('provider', __('Provider'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('invoice_number', null, ['class' => 'form-control number required', 'id'=> 'invoice_number', 'placeholder'=>__('Invoice number'), 'required' => 'required','maxlength'=>'20']) }}
                        {{ Form::label('invoice_number', __('Invoice number'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group floating-label">
                        {{ Form::select('model', $models, null, ['class' => 'form-select', 'id'=> 'model', 'placeholder'=>__('Select...')], $models_quantity) }} 
                         {{ Form::label('model', __('Model'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group floating-label">
                        {{ Form::number('num_box', null, ['class' => 'form-control number', 'id'=> 'num_box', 'min'=>'1','maxlength'=>'10','placeholder'=>__('N° number')]) }}
                         {{ Form::label('num_box', __('N° Box'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="form-group floating-label">
                        {{ Form::number('amo_box', null, ['class' => 'form-control number', 'id'=> 'amo_box', 'min'=>'1', 'placeholder'=>__('Amount of box'), 'maxlength'=>'3']) }}
                        {{ Form::label('amo_box', __('Amount of box'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group floating-label">
                        {{ Form::number('ini_serial', null, ['class' => 'form-control onlyText', 'id'=> 'ini_serial', 'min'=>'1','maxlength'=>'6', 'placeholder'=>__('Initial serial')]) }}
                        {{ Form::label('ini_serial', __('Initial serial'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-11 col-sm-11 col-md-2">
                    <div class="form-group floating-label">
                        {{ Form::number('num_lot', null, ['class' => 'form-control number', 'id'=> 'num_lot', 'min'=>'1', 'placeholder'=>__('N° Lot'), 'maxlength'=>'8']) }}
                         {{ Form::label('num_lot', __('N° Lot'), ['class' => 'title'])}}
                    </div>
                </div>
                 <div class="col-xs-1 col-sm-1 col-md-1 ">
                    {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-primary', 'id' => 'add_pos']) }}
                </div>
            </div>
        </div>
    </div>  
   <table class="dataTable table" cellspacing="0" width="100%" id="table_pos">
        <thead>
            <tr>
                <th scope='col'>{{__('Model')}}</th>
                <th scope='col'>{{__('N° Box')}}</th>
                <th scope='col'>{{__('Serial')}}</th>
                <th scope='col'>{{__('Amount of POS')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="col-3 mx-auto content-space">
        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id'=>'save']) }}
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">
var boxes = [];
var obj_boxes ={};
$(document).ready(function () {
    $('#add_excel').on('click',function(){  
    });
    $('#add_pos').on('click',function(){   
        if($('#pos_register').valid() && posRegisterValid() == true){  
            loadingWait();
            if(parseInt($('#amo_box').val(),10) <= 500){
                setTimeout(function(){add_pos()},5000);
            }else{
                swal.close();
                toastr.error('{{ __('You can add max of 500 boxes at the same time') }}');
            }
        }
    });
    $("#save").on('click', function (){
        if(boxes != ''){
            loadingWait();
            $.post("{{route('pos_register.store')}}","_token="+$('[name=_token]').val()+"&provider="+$('#provider').val()+"&invoice_number="+$('#invoice_number').val()+"&boxes="+JSON.stringify(boxes),function(result){
                boxes = [];
                $('#table_pos').dataTable().fnClearTable();
                swal.close();
                toastr[result.type_message](result.message, result.tittle,
                { "progressBar"  : true,
                  "onclick": null,
                  "positionClass": "toast-bottom-center"
                }); 
            },'json').fail(function(){
                swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });
        }else{
            toastr.info('{{ __('You must add at least one box') }}');
        }
    });    
    $("#excel_save").on('click', function (){
        var formData = new FormData(document.getElementById("pos_register"));
        $.ajax({
            url: "{{route('pos_register.excel')}}",
            type: "post",
            data: formData,
            processData: false,  
            contentType: false,   
            success: function(response) {          
                for(i in response.statistics) {
                    model = i;
                    boxs = [];
                    cant_pos = [];
                    for(j in response.statistics[i]){
                        boxs.push(j);
                        cant_pos.push(response.statistics[i][j]);
                    }
                    for(k in boxs ){
                        if (k==0){
                            good = $.inArray( model, response.models_good )==-1 ? 'X::':'';     
                            rowSpan= ' <td rowspan="'+boxs.length+'" >'+ good +model+'</td> '; 
                        }else{
                            rowSpan= '';     
                        }
                        tr = '<tr class="prueba"> '+rowSpan+' <td>'+boxs[k]+'</td> <td>'+cant_pos[k]+'</td> </tr>';
                        $('#table_excel tbody').append(tr);
                    }
                }  
            } 
        })
    });
});
function delete_pos_r(obj){
    tr    =  $(obj).parents('tr').get();
    index = $('#table_pos').DataTable().row( tr ).index();
    $("#table_pos").DataTable().row(tr).remove().draw();
    boxes.splice(index, 1);
}
function add_pos(){
    for(i=0; i<$('#amo_box').val(); i++){
        var s_begin = parseInt($('#ini_serial').val(), 10) + parseInt(( $('#model option:selected').attr('data-quantity') * i), 10);
        var s_end   = ( s_begin +  parseInt($('#model option:selected').attr('data-quantity'), 10) -1   );
        var number_box = parseInt($('#num_box').val(), 10) + i; 
        row_table = [    
            $('#model option:selected').text(),
            number_box,
            $('#model option:selected').attr('data-serial') + FullSerial(s_begin, 6) + '/'+ $('#model option:selected').attr('data-serial') + FullSerial(s_end) ,
            $('#model option:selected').attr('data-quantity'),
            '<a onClick="delete_pos_r(this);" href="#" class="btn btn-moderation delete" title="{{ __('Delete')}}" ><i class="fa fa-trash"></i>{{ __('Delete')}}</a>'
        ];
        obj_boxes = {
            'initial_serial' : s_begin,
            'number_box'     : number_box,
            'model_id'       : $('#model').val(),
            'number_lot'     : $("#num_lot").val()   
        };
        boxes.push(obj_boxes);
       $('#table_pos').dataTable().fnAddData(row_table);  
    }   
    swal.close();
    toastr['info']('{{ __('Adding the POS model to the table') }}');
    clean_fields();   
}
function clean_fields(){
    $("#model").val('').trigger('change');
    $("#num_box").val('');
    $("#amo_box").val('');
    $("#ini_serial").val('');
    $("#num_lot").val('');
}
function posRegisterValid(){
    if ( $('#model').val() == '' ){
         toastr['error']('{{ __('You must enter a model') }}');
        return false;
    }
    for (var i = 0; i < boxes.length; i++) {
        if(boxes[i].model_id == $('#model').val()){
            toastr['error']('{{ __('The POS model is already added to the table') }}');
            return false;
        }
    }
    if ( $('#num_box').val() == '' || $('#num_box').val() < 0 ){
         toastr['error']('{{ __('You must enter a box number') }}');
        return false;
    }
    if ( $('#amo_box').val() == '' || $('#amo_box').val() < 0 ){
         toastr['error']('{{ __('You must enter a number of boxes') }}');
        return false;
    }  
    if ( $('#ini_serial').val() == '' || $('#ini_serial').val() < 0 ){
         toastr['error']('{{ __('You must enter the initial serial') }}');
        return false;
    } 
    if ( $('#num_lot').val() == '' || $('#num_lot').val() < 0 ){
         toastr['error']('{{ __('You must enter the lot number') }}');
        return false;
    }
    return true;
}
</script>
