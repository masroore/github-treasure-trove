<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Create Models') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frmModelsCreate','route' => 'models.create', 'autocomplete' => 'Off']) }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{Form::label('label', __('Trade Marks'), ['class' => 'selec2label'])}}
                                {{Form::select('trade_mark_id',$TradeMark, null, ['id'=>'trade_mark_id', 'class'=>'form-select select2 required','placeholder' =>  __('Select...'), 'required' => 'required'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::number('serial','', ['class' => 'form-control alphanum  required', 'id'=> 'serial', 'maxlength'=> '15', 'placeholder' => __('Serial'), 'required' => 'required']) }}
                                {{Form::label('labelname', __('Serial'), ['class' => 'title'])}}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('weight','', ['class' => 'form-control alphanum  required', 'id'=> 'weight','maxlength'=> '100', 'placeholder' => __('Weight'), 'required' => 'required']) }}
                                {{Form::label('labelname', __('Weight'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('color','', ['class' => 'form-control alphanum  required', 'id'=> 'color', 'placeholder' => __('Color'), 'required' => 'required','maxlength'=> '100' ]) }}
                                {{Form::label('labelname', __('Color'), ['class' => 'title'])}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::number('quantity','', ['class' => 'form-control number  required', 'id'=> 'quantity', 'maxlength'=> '255', 'placeholder' => __('Quantity Per Box'), 'required' => 'required']) }}
                                {{Form::label('labelname', __('Quantity Per Box'), ['class' => 'title'])}}
                            </div>
                        </div>                         
                        <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                            <div class="form-group floating-label">
                                {{ Form::text('price','', ['class' => 'form-control maskmoney  required', 'id'=> 'price', 'required' => 'required', 'placeholder' => __('Price ($)')]) }}
                                {{Form::label('labelname', __('Price ($)'), ['class' => 'title'])}}
                            </div>
                        </div>                   
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('models')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>