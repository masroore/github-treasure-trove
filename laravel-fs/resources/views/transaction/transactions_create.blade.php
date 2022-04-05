<div class="content-table">  
    <div class="row">
       <div class="col-md-3">
            <h3 class="left"><i class="fa fa-user"></i>{{ __('Create Transaction') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">  
                {{ Form::open(['id'=>'frm_transac_create','route' => 'transactions.store','autocomplete'=>'Off', 'class' => 'validate' ]) }}
                    <div class="row">   
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">
                            <div class="form-group floating-label">
                               {{ Form::select('coin_type', $typeCoin, null, ['class' => 'form-select required', 'id'=> 'coin_type','placeholder'=> __('Select...'), 'required' => 'required' ]) }}

                                {!!Form::label('coin_type', __('Coin Type'), ['class' => 'title'])!!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4 ">
                            <div class="form-group floating-label">
                             {{ Form::select('type_transaction', $typeTransaction, null, ['class' => 'form-select required', 'id'=> 'type_transaction','placeholder'=> __('Select...'), 'required' => 'required' ]) }}
                                {!!Form::label('type_transaction', __('Type Transaction'), ['class' => 'title'])!!}
                            </div>
                        </div>    
                    </div>    
                    <div class="col-5 mx-auto">      
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType="html" href="{{route('transactions')}}">{{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
           </div>
        </div>
    </div>
</div> 