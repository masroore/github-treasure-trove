<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Edit Storages') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['id' => 'frmStorageUpdate', 'class' => 'validate', 'route' => 'storage.edit', 'autocomplete' => 'Off']) }}
                    {{ Form::hidden('id', (isset($item['crypt_id']))?$item['crypt_id']:"")}}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                            {{ Form::text('name_storage',(isset($item['name_storage']))?$item['name_storage']:"", ['class' => 'form-control alphanum required', 'id'=> 'name_storage','placeholder' => __('Storage Name'), 'required' => 'required','maxlength'=>'50' ]) }}
                            {{ Form::label('labelname', __('Storage Name'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::label('label', __('Type Storage'), ['class' => 'selec2label'])}}
                                {{ Form::select('type_storage_id',$typeStorages,(isset($item['type_storage_id']))?$item['type_storage_id']:"", ['id'=>'type_storage_id', 'class'=>'form-select select2 required','placeholder' =>  __('Select...'), 'required' => 'required'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::label('label', __('Code Area'), ['class' => 'selec2label'])}}
                                {{ Form::select('telephone_operator_id',$defaultCodeOperatorCountries, (isset($item['telephone_operator_id']))?$item['telephone_operator_id']:"", ['id'=>'telephone_operator_id', 'class'=>'form-select select2 required','placeholder' => __('Select...'), 'required' => 'required' ])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 mb-4 te-2">
                            <div class="form-group floating-label">
                                {{ Form::text('phone',(isset($item['phone']))?$item['phone']:"", ['class' => 'form-control numeric number required', 'id'=> 'phone','maxlength'=> '7','maxlength'=> '7', 'placeholder' => __('Phone'), 'required' => 'required' ]) }}
                                {{ Form::label('label', __('Phone'), ['class' => 'title'])}}
                            </div>
                        </div>

                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('storage')}}">{{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
 