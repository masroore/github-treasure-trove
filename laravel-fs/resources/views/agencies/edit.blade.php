<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Edit Agency') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['id' => 'frmStorageUpdate', 'class' => 'validate', 'route' => 'agency.update', 'autocomplete' => 'Off']) }}
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('codea',$agency->code, ['class' => 'form-control numeric number onlyTex required', 'id'=> 'codea','maxlength'=> '4', 'placeholder' => __('code'), 'required' => 'required' ]) }}

                                {{Form::label('labelname', __('code'), ['class' => 'title'])}}
                            </div> 
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                            {{ Form::text('name_storage',$agency->name_storage, ['class' => 'form-control alphanum onlyText required', 'id'=> 'name_storage','placeholder' => __('Agency Name'), 'required' => 'required' ]) }}
                            {{Form::label('labelname', __('Agency Name'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                            <div class="form-group floating-label">
                                {!!Form::label('labelbankAgency', __('Code Area'), ['class' => 'selec2label'])!!}
                                {{Form::select('telephone_operator_id',$defaultCodeOperatorCountries, $agency->telephone_operator_id, ['id'=>'telephone_operator_id', 'class'=>'form-control select2 required','placeholder' => __('Select...'), 'required' => 'required' ])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                            <div class="form-group floating-label">
                                {{ Form::text('phone',$agency->phone, ['class' => 'form-control numeric number required', 'id'=> 'phone','maxlength'=> '7','maxlength'=> '7', 'placeholder' => __('Phone'), 'required' => 'required' ]) }}

                                {{Form::label('labelphoneAgency', __('Phone'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('email',$agency->email, ['class' => 'form-control email required', 'id'=> 'email',  'placeholder' => __('Email'), 'required' => 'required' ]) }}
                                {{Form::label('labelemailAgency', __('Email'), ['class' => 'title'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('agency')}}">{{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                    {{ Form::hidden('agency', $val , ['id'=>'agency']) }}
                    {{ Form::hidden('id', $agency->crypt_id , ['id'=>'id']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
 