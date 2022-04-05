<div class="content-table"> 

    <div class="row">

        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-money-bill-alt"></i>{{__('Coin type register')}} </h3> 
        </div>

        <div class="col-md-9">

            <div class="content-space te-0">

                {{ Form::open(['route'=>'typeCoin.store','id'=>'frmStorage','autocomplete'=>'Off', 'class' => 'validate' ]) }}

                    <div class="row">  

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">  

                            <div class="form-group floating-label">

                            {{ Form::text('symbol', null, ['class' => 'form-control tooltips onlyText required', 'id'=> 'symbol','maxlength'=>'5', 'placeholder'=>__('Symbol'), 'required' => 'required']) }}

                            {!!Form::label('symbol', __('Symbol'), ['class' => 'title'])!!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">  

                            <div class="form-group floating-label">
                            
                            {{ Form::text('name_coin', null, ['class' => 'form-control tooltips onlyText required', 'id'=> 'name_coin','maxlength'=>'50', 'placeholder'=>__('Description'), 'required' => 'required']) }}

                            {!!Form::label('name_coin', __('Description'), ['class' => 'title'])!!} 

                            </div>

                        </div>

                    </div>

                    <div class="col-5 mx-auto">

                        <a class="btn btn-secondary back link_ajax" data-dataType="html" href="{{route('typeCoin')}}">{{ __('Back') }} </a>

                        {{ Form::button(__('Save'), [ 'id' => 'save','class' => 'btn btn-primary save', 'type' => 'submit']) }}

                    </div>
                
                {{ Form::close() }} 

            </div>

        </div>

    </div>

</div>