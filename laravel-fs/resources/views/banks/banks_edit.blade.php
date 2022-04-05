<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-university"></i>{{ __('Edit Bank') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                <div class="container-form">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            {{ Form::open(['route'=>'banks.update','id'=>'msform','autocomplete'=>'Off','class'=>'validate','data-dataType'=>'json']) }}
                            <!-- progressbar -->
                            <ul id="progressbar" class="twostep">
                                <li class="active current" data-target="#fieldset-1" id="account"><i class="fas fa-university"></i><strong>{{__('BANK')}}</strong></li>
                                <li id="personal" data-target="#fieldset-2"><i class="fab fa-cc-mastercard"></i><strong>{{__('ICA')}}</strong></li>
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!-- fieldsets -->
                            <fieldset id="fieldset-1">
                                <legend></legend>
                                <div class="form-card">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{__('BANK')}}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{__('Step 1 - 2')}}</h2>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::hidden('id', (isset($item['crypt_id']))?$item['crypt_id']:"")}}
                                                    {{ Form::text('name_bank_edit', (isset($item['name_bank']))?$item['name_bank']:"", ['class' => 'form-control alphanum onlyText required', 'id'=> 'name_bank_edit', 'placeholder'=> __('Name Bank'), 'required' => 'required' ]) }}
                                                    {{ Form::label('name_bank_edit', __('Name Bank'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('name_fantasy_edit', (isset($item['name_fantasy']))?$item['name_fantasy']:"", ['class' => 'form-control alphanum onlyText required', 'id'=> 'name_fantasy_edit','placeholder'=> __('Name Fantasy'), 'required' => 'required' ]) }}
                                                    {{ Form::label('name_fantasy_edit', __('Name Fantasy'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::select('type_documents_edit', $document_type , $item['type_document_id'],  ['class' => 'form-select onlyText required', 'id'=> 'type_documents_edit', 'placeholder' => __('Select...'), 'required' => 'required' ]) }} 
                                                    {{Form::label('type_documents_edit', __('Type document'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('document_edit', (isset($item['document']))?$item['document']:"", ['class' => 'form-control numeric number required', 'id'=> 'document_edit', 'placeholder' => __('Document'), 'required' => 'required', 'maxlength'=>'9' ] ) }}
                                                    {{ Form::label('document_edit', __('Document'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::label('telephone_operators_edit', __('Local operator'), ['class' => 'selec2label'])}}
                                                    {{ Form::select('telephone_operators_edit',  $defaultCodeOperatorCountries , $item['telephone_operator_id'],  ['class' => 'form-control required select2', 'id'=> 'telephone_operators_edit', 'placeholder' => __('Select...'), 'required' => 'required' ]) }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('phone_edit', (isset($item['phone']))?$item['phone']:"", ['class' => 'form-control numeric number required', 'id'=> 'phone_edit', 'placeholder' => __('Phone'), 'required' => 'required', 'maxlength'=>'7' ]) }}
                                                    {{ Form::label('phone_edit', __('Phone'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('email_edit', (isset($item['email']))?$item['email']:"", ['class' => 'form-control email required', 'id'=> 'email_edit', 'placeholder' => __('Email'), 'required' => 'required' ]) }}
                                                    {{ Form::label('email_edit', __('Email'), ['class' => 'title'])}}
                                                </div>
                                            </div>
                                        </div>  
                                    </div>    
                                </div> 
                                {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-2']) }}
                                <a class="btn btn-secondary back link_ajax" href="{{route('banks')}}" data-dataType='html'> {{ __('Back') }} </a>
                            </fieldset>
                            <fieldset id="fieldset-2">
                            <legend></legend>
                                <div class="form-card">
                                    <div class="form-container">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">{{ __('ICA') }}</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">{{ __('Step 2 - 2') }}</h2>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                <div class="form-group floating-label">
                                                    {{Form::select('type_coin', $coin ,null, ['id'=>'type_coin1', 'class'=>'form-select required','placeholder' => __('Select...') ])}}
                                                    {{Form::label('labelcoin', __('Type Coin'), ['class' => 'title'])}}
                                                </div>
                                                {{ Form::hidden('update_ica','', ['id'=>'update_ica']) }}    
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                                                <div class="form-group floating-label">
                                                    {{ Form::text('code_ica', null, ['class' => 'form-control numeric number required', 'id'=> 'code_ica', 'maxlength'=>'5','minlength'=>'5', 'placeholder' => __('Code') ])}}

                                                    {{Form::label('labelcode', __('Code'), ['class' => 'title'])}}
                                                </div>    
                                            </div>
                                            <div class="col-md-1  mb-4">
                                                {{ Form::button('<i class="fa fa-plus-circle"></i>', ['class' => 'btn btn-primary', 'id' => 'adds_ica','onClick'=>'ica_update()']) }}
                                            </div>
                                            <div class="">
                                                <div class="table-formstep">
                                                    <table id="table_ica">
                                                        <thead>
                                                            <tr>
                                                                <th scope='col'>{{__('Type Coin')}}</th>
                                                                <th scope='col'>{{__('ICA')}}</th>
                                                                <th scope='col'>{{__('Action')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($ica as $index=>$key)
                                                            <tr id="ica_{{$key['crypt_id']}}" class="text-center">
                                                                <td>
                                                                    {{$key['type_coin']}}
                                                                </td>
                                                                <td>{{$key['code']}}</td>
                                                                <td>
                                                                    @if($key['status']==1)
                                                                    {{ Form::button('<i class="fa fa-pen"></i>'.__('Edit'), ['class' => 'btn btn-moderation edit', 'id' =>'edi','onClick'=>"edit_ica('".$key['crypt_id']."','".$key['type_coin_id']."','".$key['code']."')"]) }} 

                                                                    <a class="btn btn-moderation delete link_ajax" href="{{route('banks.deleteIca',$key['crypt_id'])}}" data-dataType="json"><i class="fa fa-trash"></i>{{__('Delete')}}</a> 
                                                                    @else
                                                                    <a href="{{route('banks.reactivateIca', $key['crypt_id'] )}}" class="btn btn-moderation edit link_ajax" data-dataType="json"><i class="fa fa-pen"></i>{{__('Activate')}}</a>
                                                                    @endif
                                                                </td>               
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <table type="hidden" id="table_ica2">
                                                        <thead>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                {{ Form::button(__('Update'), ['class' => 'btn btn-primary save', 'id' => 'updated', 'type' => 'submit','onClick'=>'update()']) }}
                                {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-1'])}}
                            </fieldset>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
cont_detail=0;
$(document).ready(function() {
    
    $(document).on('click', '#dell', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
});
function add_ica(){
    $.post("{{route('banks.searchIca')}}", $('#type_coin1, #code_ica').serialize()+"&_token="+token,function(data){
        if(data.status==1){
            var type_coin=$('#type_coin1').val();
            var description_type_coin=$('#type_coin1 > :selected').text();
            var code_ica=$('#code_ica').val();
            var fila='<tr>'+'<td><input class="form-control" type="text" name="detail['+cont_detail+'][description_type_coin]" value="'+description_type_coin+'" readonly></td>'+'<td><input class="form-control" type="text" name="detail['+cont_detail+'][code_ica]" value="'+code_ica+'" readonly></td>'+'<td><a class="btn btn-moderation delete link_ajax" data-dataType="json" id="dell"><i class="fa fa-trash"></i> {{ __('Delete')}} </a></td>'+'</tr>';

            var fila2='<tr>'+'<td><input type="hidden" class="form-control" name="detail['+cont_detail+'][type_coin]" value="'+type_coin+'" readonly></td>'+'</tr>';

            $('#table_ica').append(fila);
            $('#table_ica2').append(fila2);
            cont_detail++;
        }else{
            Swal.fire(
                data['title'],
                data['message'],
                data['type_message'],
            );
        }
        $('#code_ica').val('');
        $('#update_ica').val('');
        $('#adds_ica').val('');
    },'json');
}
function edit_ica(id,type_coin,code){
    $('#type_coin1').val(type_coin);
    $('#code_ica').val(code);
    $('#update_ica').val(id);
}
function ica_update(){
    token="{{csrf_token()}}";
    if($('#type_coin1, #code_ica').valid()){
       if($('#update_ica').val()==''){
            add_ica();
        }else{
            $.post("{{route('banks.updateIca')}}", $('#type_coin1,#code_ica, #update_ica').serialize()+"&_token="+token,function(data){
                $('#ica_'+data.clear).remove();
                $('#table_ica').append(data.data);
            },'json');    
            $('#code_ica').val('');
            $('#update_ica').val('');
            $('#adds_ica').val('');
        }
    }
}
function update(){
    token="{{csrf_token()}}";
    if($('#name_bank, #code_bank, #name_fantasy,#type_documents,#document, #countries, #telephone_operators, #phone, #email').valid()){
        $.post("{{route('banks.store')}}", $('#msform').serialize()+"&_token="+token,function(data){

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
}
</script>
