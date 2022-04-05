<div class="content-table">
    <h3>{{ __('Consult Request Pos') }}</h3>
    <div class="content-space ">
       
        <div class="row">
            <div class="col-xs-11 col-sm-11 col-md-11">
                <div class="form-group floating-label">
                    {{ Form::number('request_number','', ['class' => 'form-control numeric number','maxlength'=>'8', 'id'=> 'request_number', 'placeholder'=>__('Request Number')]) }}
                     {{ Form::label('serial', __('Request Number'), ['class' => 'title'])}}
                </div>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                {{ Form::button('<i class="fa fa-search "></i>', ['class' => 'btn btn-primary', 'id' => 'search_pos_request']) }}
            </div>
        </div>
         
        <div id="aaa"></div>

    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('#search_pos_request').on('click',function(){  
    loadingWait();
        if($('#request_number').val()!==''){
            $.get("{{url('RQ0002.consult_request_pos_search')}}/"+$('#request_number').val(),function(response){
                    $('#storage_request').val('');
                    $('#responsable').val('');
                    $('#date_request').val('');
                    $('#date_request').val('');
                    $('#date_send').val('');
                    $('#number_send').val('');
                    $('#responsable').val('');
                    $("#models > tbody").empty();
                    $("#model2 > tbody").empty();
                    $("#aaa").hide();
                    if(response===''){
                        toastr.warning('{{__('Data no found')}}');
                    }else{
                        $("#aaa").show();
                        $('#aaa').html(response);
                    }
            },'html');
        }else{
            toastr.warning('{{__('Please enter the Request Number')}}');
        }
    swal.close();
    });
});
</script>




