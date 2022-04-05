<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-file-invoice-dollar"></i>{{ __('Create Type Account') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frmAccountCreate','route' => 'type_account.create', 'autocomplete' => 'Off']) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('name_product','', ['class' => 'form-control alphanum required', 'id'=> 'name_product', 'placeholder' => __('Description'),'maxlength'=>'150']) }}
                                {{ Form::label('labeldescription', __('Description'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::label('labelcoin', __('Type Coin'), ['class' => 'selec2label'])}}
                                {{ Form::select('type_coin_id',$typeCoin, null, ['id'=>'type_coin_id', 'class'=>'form-select select2 required','placeholder' =>  __('Select...'), 'required' => 'required'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::label('labelbank', __('Bank'), ['class' => 'selec2label'])}}
                                {{ Form::select('bank_id',$bank, null, ['id'=>'bank_id', 'class'=>'form-select select2 required','placeholder' =>  __('Select...'), 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('type_account')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>