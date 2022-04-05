<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-university"></i>{{ __('Create Bank') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                <div class="container-form">
                    <div class="container-fluid">
                        <div class="row">
                            {{ Form::open(['route'=>'banks.store','id'=>'msform','autocomplete'=>'Off','class'=>'validate', 'data-dataType'=>'json']) }}
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
                                    <div id="step-1" class="form-card">
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
                                                        {{ Form::text('name_bank', null, ['class' => 'form-control alphanum onlyText required', 'id'=> 'name_bank','placeholder'=>__('Name Bank'), 'required' => 'required' ]) }}

                                                        {{Form::label('name_bank', __('Name Bank'), ['class' => 'title'])}}
                                                    </div>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::number('code_bank', null, ['class' => 'form-control numeric number required', 'id'=> 'code_bank', 'maxlength'=>'4','placeholder'=>__('Code'), 'required' => 'required', 'min'=>'1']) }}

                                                        {{Form::label('code_bank', __('Code'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('name_fantasy', null, ['class' => 'form-control alphanum onlyText required', 'id'=> 'name_fantasy','placeholder'=>__('Name Fantasy'), 'required' => 'required' ]) }}

                                                        {{Form::label('name_fantasy', __('Name Fantasy'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::select('type_documents', $document_type , null,  ['class' => 'form-select required', 'id'=> 'type_documents', 'placeholder' => __('Select...'), 'required' => 'required' ]) }} 

                                                        {{Form::label('type_documents', __('Type Document'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('document', null, ['class' => 'form-control numeric number required', 'id'=> 'document', 'maxlength'=>'9','placeholder'=>__('Document'), 'required' => 'required' ]) }}

                                                        {{Form::label('document', __('Document'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::label('telephone_operators', __('Local Operator'), ['class' => 'selec2label'])}}
                                                        {{ Form::select('telephone_operators', $defaultCodeOperatorCountries , 0,  ['class' => 'form-control select2 required', 'id'=> 'telephone_operators_id', 'placeholder' => __('Select...'), 'required' => 'required' ]) }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('phone', null, ['class' => 'form-control numeric number required', 'id'=> 'phone', 'data-msg-required'=>__('Este campo es requerido'), 'maxlength'=>'7', 'placeholder' => __('Phone Number'), 'required' => 'required' ])}}
                                                        {{Form::label('phone', __('Phone Number'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('email', null, ['class' => 'form-control email required', 'id'=> 'email','placeholder' => __('Email'), 'required' => 'required']) }} 
                                                         {{Form::label('email', __('Email'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>    
                                    </div> 
                                    {{ Form::button(__('Next'), ['class' => 'next-step btn btn-primary next', 'data-step'=>'#fieldset-2']) }}
                                    <a class="btn btn-secondary back link_ajax" href="{{route('banks')}}" data-dataType="html"> {{ __('Back') }} </a>
                                </fieldset>
                                <fieldset id="fieldset-2">
                                <legend></legend>
                                    <div class="form-card" id="step-2">
                                        <div class="form-container">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{ __('ICAS') }}</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{ __('Step 2 - 2') }}</h2>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{Form::select('type_coin', $type_coin ,null, ['id'=>'type_coin', 'class'=>'form-select required','placeholder' => __('Select...')])}}
                                                        {{Form::label('labelcoin', __('Type Coin'), ['class' => 'title'])}}
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                                                    <div class="form-group floating-label">
                                                        {{ Form::text('code_ica', null, ['class' => 'form-control numeric number', 'id'=> 'code_ica', 'maxlength'=>'5','minlength'=>'5','placeholder' => __('Code')])}}

                                                        {{Form::label('labelcode', __('Code'), ['class' => 'title'])}}
                                                    </div>  
                                                </div>
                                                    <div class="col-md-1 mb-4">
                                                        {{ Form::button('<i class="fa fa-plus-circle"></i>', ['class' => 'btn btn-primary','data-step-valid'=>'#step-1', 'id' => 'add_ica']) }}
                                                    </div>
                                                <div class="col-lg-12">
                                                    <div class="table-formstep">
                                                        <table id="table_ica">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2" scope='col'>{{__('Type Coin')}}</th>
                                                                    <th scope='col'>{{__('Code')}}</th>
                                                                    <th scope='col'>{{__('Action')}}</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    {{ Form::button(__('Save'), ['class' => 'btn btn-primary save', 'id' => 'save1', 'type' => 'submit','onClick'=>'save();']) }}
                                    {{ Form::button(__('Previous'), ['class' => 'previous-step btn btn-secondary back', 'data-step'=>'#fieldset-1'])}}
                                </fieldset>
                            {{ Form::close() }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var cont_detail=0;
$(document).ready(function() {
    $(document).on('click', '#dell', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
    $('#add_ica').click(function(){
        add_ica();
    });
});
function add_ica(){
    if($('#type_coin, #code_ica').valid()){
        var type_coin=$('#type_coin').val();
        var code_ica=$('#code_ica').val();
        var description_type_coin=$('#type_coin > :selected').text();
        var fila='<tr>'+'<td><input class="form-control" type="hidden" name="detail['+cont_detail+'][type_coin]" value="'+type_coin+'" readonly></td>'+ '<td><input class="form-control" type="text" name="detail['+cont_detail+'][description_type_coin]" value="'+description_type_coin+'" readonly></td>'+'<td><input class="form-control" type="text"  name="detail['+cont_detail+'][code_ica]" value="'+code_ica+'" readonly></td>'+'<td><a class="btn btn-moderation delete link_ajax" data-dataType="json" id="dell"><i class="fa fa-trash"></i> {{ __('Delete')}} </a></td>'+'</tr>';

        $('#table_ica').append(fila);
        cont_detail++;
        $('#code_ica').val('');
    }
}
function save(){
token="{{csrf_token()}}";
    $.post("{{route('banks.store')}}", $('#msform').serialize()+"&_token="+token,function(data){
        Swal.fire(
            data['title'],
            data['message'],
            data['type_message'],
        );
        if(data['status']==1){
            sendAjax(data['redirect']);
        }

    });
}
</script>