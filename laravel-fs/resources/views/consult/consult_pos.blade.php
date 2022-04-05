<div class="content-table">
    {{ Form::open(array('id'=>'pos_request','autocomplete'=>'Off', "enctype"=>"multipart/form-data",'onsubmit'=>'displayAll()')) }}
    <h3>{{ __('Consult POS') }}</h3>
    <div class="content-space ">
        <div class="content-table inside content-space">
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-3">
                    <div class="form-group floating-label">
                        {{ Form::select('model', $tradeMark, null, ['class' => 'form-select required', 'id'=> 'model','placeholder'=>__('Select...'), 'required' => 'required']) }}
                        {{ Form::label('model', __('Model'), ['class' => 'title']) }}
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group floating-label">
                        {{ Form::number('serial','', ['class' => 'form-control numeric number required', 'id'=> 'serial', 'placeholder'=>__('Serial')]) }}
                        {{ Form::label('serial', __('Serial'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group floating-label">
                        {{ Form::number('box_number','', ['class' => 'form-control numeric number required', 'id'=> 'box_number', 'placeholder'=>__('Box number')]) }}
                        {{ Form::label('box_number', __('Box number'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-1 col-sm-2 col-md-4">
                    <div class="form-group floating-label">
                        {{ Form::select('storage', $storage, null, ['class' => 'form-select required', 'id'=> 'storage','placeholder'=>__('Select...'), 'required' => 'required']) }}
                        {{ Form::label('storage', __('Department'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1">
                    {{ Form::button('<i class="fa fa-search "></i>', ['class' => 'btn btn-primary', 'id' => 'add_pos_request']) }}
                </div>
                <div class="row">
                    <div class="col-5 mx-auto">
                        {{ Form::button('<i class="fa fa-chart-bar "></i>', ['class' => 'btn btn-primary mt-2', 'id' => 'view_graphic', 'onClick'=>"consult_available()"]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <table class="dataTable table" cellspacing="0" width="100%" id="table_pos_request">
        <thead>
            <tr>
                <th scope='col'>{{__('Model')}}</th>
                <th scope='col'>{{__('Serial')}}</th>
                <th scope='col'>{{__('Box')}}</th>
                <th scope='col'>{{__('Department')}}</th>
                <th scope='col'>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($search_box as $value)
            <tr>
                <td>{{$value['model']}}</td>
                <td>{{$value['serial']}}</td>
                <td>{{$value['number_box']}}</td>
                <td>{{$value['name_storage']}}</td>
                <td>
                    <a onClick="show_detail('{{$value['id']}}');" data-bs-toggle="modal" data-bs-target="#detail_request_pos" href="#" class="btn btn-moderation edit" title="{{ __('Detail')}}"><i class="fa fa-search"></i>{{ __(' Detail')}}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @include('consult.consult_pos_detail')
    @include('consult.consult_available_storage')
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#add_pos_request').on('click', function() {
        loadingWait();
        $.post("{{route('consult.consult_pos_searh')}}", $('#pos_request').serialize(), function(response) {
            $('#table_pos_request').dataTable().fnClearTable();
            if (response.status == 1) {
                for (var i = 0; i < response.data.length; i++) {
                    let row_table = [
                        response.data[i].model,
                        response.data[i].serial,
                        response.data[i].number_box,
                        response.data[i].name_storage.toUpperCase(),
                        '<a title="{{__('Detail')}}" onClick="show_detail(\'' + response.data[i].h + '\')" data-bs-toggle="modal" data-bs-target="#detail_request_pos" href="#" class="btn btn-moderation edit"  ><i class="fa fa-search"></i>{{__("Detail")}} </a>'
                    ];
                    $('#table_pos_request').dataTable().fnAddData(row_table);
                }
                toastr['success'](response.message);
            } else {
                toastr.warning(response.message);
            }
            swal.close();
        }, 'json');
    });
});

function displayAll() {
    $("#table_pos_request").DataTable().rows().nodes().page.len(-1).draw(false);
    return true;
}

function show_detail(id) {
    $.get("{{url('RQ0001.detail_pos')}}/" + id, function(response) {
        $('#models').text('');
        $('#serials').text('');
        $('#departments').text('');
        if (response.status == 1) {
            $('#models').text(response.model);
            $('#serials').text(response.model_serial);
            $('#departments').text(response.storage);
            $('#number_boxs').text(response.box_number);
        }
    }, 'json');
}

function consult_available()
{
    if($('#storage').val() != ''){
        $("#consultStorages").empty();
            loadingWait();
            $.get("{{url('RQ0001.view_graphic')}}/" + $('#storage').val(), function(response) {
                Swal.close();
                $('#detailConsultStorage').modal('show')
                $("#consultStorages").html(response);
            }).fail(function(){
                Swal.close();
                toastr.error('{{ __('Your request could not be processed') }}');
            });
    }else{
        toastr.info('{{ __('Please select a storage') }}');
    }
}
</script>