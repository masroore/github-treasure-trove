<div class="content-table">

    <div class="row">

        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-university"></i>{{ __('Products') }}</h3> 
        </div>

        <div class="col-md-9">

            <div class="content-space te-0">


    <div class="container-form">
        <div class="container-fluid">
            <div class="row justify-content-center">
                {{ Form::open(['route'=>'banks.storeBinProcess','id'=>'msform','autocomplete'=>'Off','class'=>'validate','data-dataType'=> 'json']) }}
                <!-- progressbar -->
                <ul id="progressbar" class="twostep">
                    <li class="active" id="account"><i class="fas fa-university"></i><strong>{{__('CREDIT')}}</strong></li>
                    <li id="personal"><i class="fab fa-cc-mastercard"></i><strong>{{__('DEBIT')}}</strong></li>
                </ul>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div> <br> 
                <!-- fieldsets -->
                <fieldset>
                <legend></legend>
                    <div class="form-card">
                        <div class="form-container">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">{{ __('BIN') }}</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">{{ __('Step 1 - 2') }}</h2>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group floating-label">
                                            {{Form::label('labelica', __('Ica'), ['class' => 'selec2label'])}}
                                            {{Form::select('code_ica_bin', $ica ,null, ['id'=>'code_ica_bin', 'class'=>'form-select required','placeholder' => __('Select...')])}}
                                        </div>
                                    </div>
                                    {{ Form::hidden('update_bin','', ['id'=>'update_bin']) }}

                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group floating-label">
                                            {{ Form::text('code_bin', '', ['class' => 'form-control numeric number', 'id'=> 'code_bin', 'maxlength'=>'6','minlength'=>'6', 'placeholder'=>__('Code')])}}  
                                            {{Form::label('labelcode', __('Code'), ['class' => 'title'])}}
                                        </div>  
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group floating-label">
                                            {{ Form::text('Description_bin', '', ['class' => 'form-control required', 'id'=> 'Description_bin', 'maxlength'=>'50','minlength'=>'3', 'placeholder'=> __('Description')])}}   
                                            {{Form::label('labelcode', __('Description'), ['class' => 'title'])}} 
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-primary', 'id' => 'adds_bin', 'onClick'=>'bin_update()']) }}
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-formstep">
                                        <table class="table table-bordered" id="table_bin">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope='col'>{{__('Code Ica')}}</th>
                                                    <th scope='col'>{{__('Code Bin')}}</th>
                                                    <th scope='col'>{{__('Description Bin')}}</th>
                                                    <th scope='col'>{{__('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ica_bin_process as $key=>$value)
                                                @foreach($value['get_bin'] as $key2=>$value2)
                                                <tr id="bin_{{$value2['crypt_id']}}" class="text-center">
                                                    <td>{{$value['code']}}</td>
                                                    <td>{{$value2['code']}}</td>
                                                    <td>{{$value2['description_bin']}}</td>
                                                    <td>
                                                        @if($value2['status']==1)
                                                        {{ Form::button('<i class="fa fa-pen"></i>'.__('Edit'), ['class' => 'btn btn-moderation edit','onClick'=>"edit_bin('".$value2['crypt_id']."','".$value['crypt_id']."','".$value2['code']."','".$value2['description_bin']."')"]) }}

                                                        <a class="btn btn-moderation delete link_ajax" href="{{route('banks.deleteBin',$value2['crypt_id'])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                                                        @else
                                                        <a href="{{route('banks.reactivateBin', $value2['crypt_id'] )}}" class="btn btn-moderation edit link_ajax" data-dataType="json"><i class="fa fa-pen"></i>{{__('Activate')}}</a>
                                                        @endif
                                                    </td>               
                                                </tr>
                                                @endforeach    
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <table type="hidden" id="table_bin2">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next']) }}
                    <a class="btn btn-secondary back link_ajax" href="{{route('banks')}}" data-dataType="html"> {{ __('Back') }} </a>
                </fieldset>
                <fieldset>
                <legend></legend>
                    <div class="form-card">
                        <div class="form-container">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">{{ __('ID PROCESS') }}</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">{{ __('Step 2 - 2') }}</h2>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group floating-label">
                                            {{Form::label('labelica', __('Ica'), ['class' => 'selec2label'])}}
                                            {{Form::select('code_ica_process', $ica ,null, ['id'=>'code_ica_process', 'class'=>'form-select required','placeholder' => __('Select...')])}}
                                        </div>
                                    </div>
                                    {{ Form::hidden('update_process','', ['id'=>'update_process']) }}
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group floating-label">
                                            {{ Form::number('code_process', '', ['required'=>'required', 'class' => 'form-control number required', 'id'=> 'code_process', "pattern"=>"\d*",  "maxlength"=>"5", 'min'=>'10000','max'=>'99999', 'placeholder' => __('Code')])}}
                                            {{Form::label('labelcode', __('Code'), ['class' => 'title'])}}
                                        </div>    
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group floating-label">
                                            {{ Form::text('Description_process', '', ['class' => 'form-control required', 'id'=> 'Description_process', 'maxlength'=>'50','minlength'=>'3', 'placeholder' => __('Description')])}}  
                                            {{Form::label('labelcode', __('Description'), ['class' => 'title'])}}
                                        </div>  
                                    </div>

                                    <div class="col-md-1">
                                        {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-primary', 'id' => 'adds_processs','onClick'=>'process_update()']) }}
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-formstep">
                                        <table id="table_process">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope='col'>{{__('ica')}}</th>
                                                    <th scope='col'>{{__('Code Process')}}</th>
                                                    <th scope='col'>{{__('Description Process')}}</th>
                                                    <th scope='col'>{{__('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ica_bin_process as $key=>$value)
                                                @foreach($value['get_process'] as $key2=>$value2)
                                                <tr id="process_{{$value2['crypt_id']}}" class="text-center">
                                                    <td>{{$value['code']}}</td>
                                                    <td>{{$value2['code']}}</td>
                                                    <td>{{$value2['description_process']}}</td>
                                                    <td>
                                                        @if($value2['status']==1)
                                                        {{ Form::button('<i class="fa fa-pen"></i>'.__('Edit'), ['class' => 'btn btn-moderation edit','onClick'=>"edit_process('".$value2['crypt_id']."','".$value['crypt_id']."','".$value2['code']."','".$value2['description_process']."')"]) }}
                                                        <a class="btn btn-moderation delete link_ajax" href="{{route('banks.deleteProcess',$value2['crypt_id'])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                                                        @else
                                                        <a href="{{route('banks.reactivateProcess', $value2['crypt_id'] )}}" class="btn btn-moderation edit link_ajax" data-dataType="json"><i class="fa fa-pen"></i>{{__('Activate')}}</a>
                                                        @endif
                                                    </td>               
                                                </tr>
                                                @endforeach    
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <table type="hidden" id="table_process2">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'submit','onClick'=>'save()']) }}
                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back'])}}
                </fieldset>
                {{ Form::close() }} 
            </div>
        </div>
    </div>
</div></div></div>

</div>
<script type="text/javascript">
    var cont_detail=0;
    $(document).ready(function() {
        
        $(document).on('click', '#dell1, #dell2', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });
	
    });
    function add_bin(){
        $.post("{{route('banks.searchIcabin')}}", $('#code_bin, #code_ica_bin').serialize()+"&_token="+token,function(data){
            if(data.status==1){
                var code_ica_bin=$('#code_ica_bin').val();
                var code_ica_bin_description=$('#code_ica_bin > :selected').text();
                var code_bin=$('#code_bin').val();
                var description_bin=$('#Description_bin').val();
                var fila='<tr>'+'<td><input class="form-control" type="text" name="detail_bin['+cont_detail+'][code_ica_bin_description]" value="'+code_ica_bin_description+'" readonly></td>'+'<td><input class="form-control" type="text" name="detail_bin['+cont_detail+'][code_bin]" value="'+code_bin+'" readonly></td>'+'<td><input class="form-control" type="text" name="detail_bin['+cont_detail+'][description_bin]" value="'+description_bin+'" readonly></td>'+'<td><a class="btn btn-moderation delete link_ajax" data-dataType="json" id="dell1"><i class="fa fa-trash"></i> {{ __('Delete') }} </a></td>'+'</tr>';
                var fila2='<tr>'+'<td><input class="form-control" type="hidden" name="detail_bin['+cont_detail+'][code_ica_bin]" value="'+code_ica_bin+'" readonly></td>'+'</tr>';

                $('#table_bin').append(fila);
                $('#table_bin2').append(fila2);
                cont_detail++;

                $('#code_bin').val('');
                $('#Description_bin').val('');
                $('#adds_bin').val('');
                $('#update_bin').val(''); 
            }else{
                Swal.fire(
                    data['title'],
                    data['message'],
                    data['type_message'],
                );
            }
            $('#code_bin').val('');
            $('#Description_bin').val('');
            $('#adds_bin').val('');
            $('#update_bin').val('');
        },'json');
    }
    function add_process(){
        $.post("{{route('banks.searchIcaProcess')}}", $('#code_process, #code_ica_process').serialize()+"&_token="+token,function(data){
            if(data.status==1){
                var code_ica_process=$('#code_ica_process').val();
                var code_ica_process_descripcion=$('#code_ica_process > :selected').text();
                var code_process=$('#code_process').val();
                var description_process=$('#Description_process').val();
                var fila='<tr>'+'<td><input class="form-control" type="text" name="detail_process['+cont_detail+'][code_ica_process_descripcion]" value="'+code_ica_process_descripcion+'" readonly></td>'+'<td><input class="form-control" type="text" name="detail_process['+cont_detail+'][code_process]" value="'+code_process+'" readonly></td>'+'<td><input class="form-control" type="text" name="detail_process['+cont_detail+'][description_process]" value="'+description_process+'" readonly></td>'+'<td><a class="btn btn-moderation delete link_ajax" data-dataType="html" id="dell2"><i class="fa fa-trash" onClick="dele()"></i> {{ __('Delete') }} </a></td>'+'</tr>';
                var fila2='<tr>'+'<td><input class="form-control" type="hidden" name="detail_process['+cont_detail+'][code_ica_process]" value="'+code_ica_process+'" readonly></td>'+'</tr>';

                $('#table_process').append(fila);
                $('#table_process2').append(fila2);
                cont_detail++; 
                $('#code_process').val('');
                $('#Description_process').val('');
                $('#adds_process').val('');
                $('#update_process').val('');

            }else{
                Swal.fire(
                    data['title'],
                    data['message'],
                    data['type_message'],
                );
            }
            $('#code_process').val('');
            $('#Description_process').val('');
            $('#adds_process').val('');
            $('#update_process').val('');
        },'json');
    }
    function edit_bin(id,code_ica,code,description_bin){
        $('#code_ica_bin').val(code_ica);
        $('#code_bin').val(code);
        $('#update_bin').val(id);
        $('#Description_bin').val(description_bin);
    }
    function edit_process(id,code_ica,code,description_process){
        $('#code_ica_process').val(code_ica);
        $('#code_process').val(code);
        $('#update_process').val(id);
        $('#Description_process').val(description_process);
    }
    function bin_update(){
        token="{{csrf_token()}}";
        if($('#code_ica_bin, #code_bin, #Description_bin').valid()){
            if($('#update_bin').val()==''){
                add_bin();
            }else{
               $.post("{{route('banks.updateIcaBin')}}", $('#code_ica_bin,#code_bin, #update_bin, #Description_bin').serialize()+"&_token="+token,function(data){
                    $('#bin_'+data.clear).remove();
                    $('#table_bin').append(data.data);
                },'json'); 
            $('#code_bin').val('');
            $('#Description_bin').val('');
            $('#adds_bin').val('');
            $('#update_bin').val('');  
            }
        }
    }
    function process_update(){
        token="{{csrf_token()}}";
        if($('#code_ica_process, #code_process, #Description_process').valid()){
            if($('#update_process').val()==''){
            add_process();
            }else{
                 $.post("{{route('banks.updateIcaProcess')}}", $('#code_ica_process,#code_process, #update_process, #Description_process').serialize()+"&_token="+token,function(data){
                    $('#process_'+data.clear).remove();
                    $('#table_process').append(data.data);
                },'json');
            $('#code_process').val('');
            $('#Description_process').val('');
            $('#adds_process').val('');
            $('#update_process').val('');
            }
        }
    }
    function save(){
        token="{{csrf_token()}}";
        $.post("{{route('banks.storeBinProcess')}}", $('#msform').serialize()+"&_token="+token,function(data){
            Swal.fire(
                data['title'],
                data['message'],
                data['type_message'],
            );
            if(data['status']==1){
                sendAjax(data['redirect']);
            }
        },'json');
    }
</script>