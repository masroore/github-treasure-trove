<div class="content-table"> 
    <div class="row">
        <div class="col-md-3">
            <h3 class="left"><i class="fa fa-building"></i>{{ __('Update Type Transaction') }}</h3> 
        </div>
        <div class="col-md-9">
            <div class="content-space te-0">
                {{ Form::open(['class'=>'validate','id' => 'frmTransUpdate','route' => 'type_transactions.update', 'autocomplete' => 'Off']) }}
                    {{ Form::hidden('id', (isset($item[0]['crypt_id']))?$item[0]['crypt_id']:"")}}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                                {{Form::text('name_transaction',(isset($item[0]['name_transaction']))?$item[0]['name_transaction']:"", ['class' => 'form-control alphanum  required', 'id'=> 'name_transaction', 'placeholder' => __('Type Transaction'), 'required' => 'required']) }}
                                {{Form::label('name_transaction_label', __('Type Transaction'), ['class' => 'title'])}}
                            </div>
                        </div>  
                       <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                            <div class="form-group floating-label">
                            {{ Form::select('obligatory',[1 => 'SI', 0 => 'NO'], (isset($item[0]['obligatory']))?$item[0]['obligatory']:"", ['class' => 'form-select required', 'id'=> 'obligatory','placeholder'=>__('Select...')]) }} 
                            {{ Form::label('obligatory_label', __('Obligatory'), ['class' => 'title'])}}
                            </div>
                        </div>                 
                    </div>
                    <div class="col-5 mx-auto">  
                        <a class="btn btn-secondary back mb-1 link_ajax" data-dataType = "html" href="{{route('type_transactions')}}"> {{ __('Back') }} </a>
                        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save mb-1', 'id' => 'save', 'type' => 'submit']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>