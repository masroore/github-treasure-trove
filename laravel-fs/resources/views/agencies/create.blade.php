<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Create Agency') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frmStorageCreate','route' => 'agency.store', 'autocomplete' => 'Off','method'=>'post']) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('codea','', ['class' => 'form-control numeric number onlyTex required', 'id'=> 'codea','maxlength'=> '4', 'placeholder' => __('code'), 'required' => 'required' ]) }}
                                {{Form::label('labelname', __('code'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('name_storage','', ['class' => 'form-control alphanum onlyTex required', 'id'=> 'name_storage', 'placeholder' => __('Agency Name'), 'required' => 'required' ]) }}
                                {{Form::label('labelname', __('Agency Name'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                            <div class="form-group floating-label">
                                {!!Form::label('labelphoneAgency', __('Code Area'), ['class' => 'selec2label'])!!}
                                {{ Form::select('operator', $defaultCodeOperatorCountries, (isset($item['telephone_operator_id']))?$item['telephone_operator_id']:"", ['class' => 'form-control select2 required', 'id'=> 'operator','placeholder' =>  __('Select...'), 'required' => 'required' ]) }} 
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                            <div class="form-group floating-label">
                                {{ Form::text('phone', (isset($item['phone']))?$item['phone']:"", ['class' => 'form-control numeric number required', 'id'=> 'phone','minlength'=>'7','maxlength'=>'7','placeholder' =>  __('Phone'), 'required' => 'required' ]) }}
                                {!!Form::label('labelphoneAgency', __('Phone'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('email','', ['class' => 'form-control email required', 'id'=> 'email','placeholder' => __('Email'), 'required' => 'required' ]) }}
                                {{Form::label('labelemailAgency', __('Email'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::label('labelbankAgency', __('Bank'), ['class' => 'selec2label'])}}
                                {{Form::select('bank',$bank, null, ['id'=>'bank', 'class'=>'form-control select2 required','placeholder' =>  __('Select...'), 'required' => 'required'])}}
                            </div>
                        </div>
                        {{ Form::hidden('agency', $val , ['id'=>'agency']) }}
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('agency')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>