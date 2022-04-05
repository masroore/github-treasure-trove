<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Update Transaction') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frm_transac_update','route' => 'transactions.update', 'autocomplete' => 'Off']) }}
                    {{ Form::hidden('id', (isset($item[0]['crypt_id']))?$item[0]['crypt_id']:"")}}
                    <div class="row">   
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">
                            <div class="form-group floating-label">
                               {{ Form::select('coin_type_update',$typeCoin, (isset($item[0]['type_coin_id']))?$item[0]['type_coin_id']:"", ['class' => 'form-select required', 'id'=> 'coin_type_update','placeholder'=> __('Select...'), 'required' => 'required' ]) }}
                                {!!Form::label('coin_type_update', __('Coin Type'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">
                            <div class="form-group floating-label">
                             {{ Form::select('type_transaction_update',$typeTransaction, (isset($item[0]['type_transactions_id']))?$item[0]['type_transactions_id']:"", ['class' => 'form-select required', 'id'=> 'type_transaction_update','placeholder'=> __('Select...'), 'required' => 'required' ]) }}
                                {!!Form::label('type_transaction_update', __('Type Transaction'), ['class' => 'title'])!!}
                            </div>
                        </div>    
                    </div>    
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('transactions')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>