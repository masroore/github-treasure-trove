<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Create Storages') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frmStorageCreate','route' => 'storage.create', 'autocomplete' => 'Off']) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('code',$Code, ['class' => 'form-control number  required', 'id'=> 'code','minlength'=>'4', 'maxlength'=> '4', 'placeholder' => __('code'), 'required' => 'required','readonly'=> true ]) }}
                                {{ Form::label('labelname', __('code'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('name_storage','', ['class' => 'form-control alphanum  required', 'id'=> 'name_storage', 'placeholder' => __('Storage Name'), 'required' => 'required','maxlength'=>'50']) }}
                                {{ Form::label('labelname', __('Storage Name'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::label('labelphoneAgency', __('Code Area'), ['class' => 'selec2label'])}}
                                {{ Form::select('operator', $defaultCodeOperatorCountries, (isset($item['telephone_operator_id']))?$item['telephone_operator_id']:"", ['class' => 'form-select select2 required', 'id'=> 'operator','placeholder' =>  __('Select...'), 'required' => 'required' ]) }} 
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                            <div class="form-group floating-label">
                                {{ Form::text('phone', (isset($item['phone']))?$item['phone']:"", ['class' => 'form-control numeric number required', 'id'=> 'phone','minlength'=>'7','maxlength'=>'7','placeholder' =>  __('Phone'), 'required' => 'required' ]) }}
                                {{ Form::label('labelphoneAgency', __('Phone'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::label('label', __('Type Storage'), ['class' => 'selec2label'])}}
                                {{ Form::select('type_storage',$typeStorages, null, ['id'=>'type_storage', 'class'=>'form-select select2 required','placeholder' =>  __('Select...'), 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('storage')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>