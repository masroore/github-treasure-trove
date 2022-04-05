<div class="content-table"> 
    <div class="row">

        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-money-bill-alt"></i>{{__('Coin type edit')}} </h3> 
        </div>

        <div class="col-md-9">

            <div class="content-space te-0">

                {{ Form::open(['route'=>'typeCoin.update','id'=>'frmUpdate','autocomplete'=>'Off', 'class' => 'validate' ]) }}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">

                            <div class="form-group floating-label">

                                
                                {{ Form::hidden('id', (isset($item['crypt_id']))?$item['crypt_id']:"")}}

                                {{ Form::text('symbol_edit', (isset($item['symbol']))?$item['symbol']:"", ['class' => 'form-control tooltips onlyText required', 'id'=> 'symbol_edit', 'maxlength'=>'5', 'placeholder' => __('Symbol'), 'required' => 'required' ]) }}

                                {!!Form::label('symbol_edit', __('Symbol'), ['class' => 'title'])!!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">

                                <div class="form-group floating-label">
       
                                    {{ Form::text('name_coin_edit', (isset($item['name_coin']))?$item['name_coin']:"", ['class' => 'form-control tooltips onlyText required', 'id'=> 'name_coin_edit', 'maxlength'=>'50', 'placeholder' => __('Description'), 'required' => 'required']) }}

                                    {!!Form::label('name_coin_edit', __('Description'), ['class' => 'title'])!!} 

                                </div>

                        </div>

                    </div>

                    <div class="col-5 mx-auto">

                        <a class="btn btn-secondary back link_ajax" data-dataType="html" href="{{route('typeCoin')}}">{{ __('Back') }} </a>

                        {{ Form::button(__('Save'), [ 'id' => 'update','class' => 'btn btn-primary save', 'type' => 'submit']) }}
                        
                    </div>
                   
                {{ Form::close() }} 

            </div>

        </div>

    </div>

</div>