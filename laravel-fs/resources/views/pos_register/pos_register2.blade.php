{{ Form::open(['id'=>'pos_register','autocomplete'=>'Off',  "enctype"=>"multipart/form-data", "route"=>"pos_register.store2", 'class' => 'validate']) }}
<div class="content-table">
    <h3>{{ __('POS Register') }}</h3>
    <div class="content-space"> 
        <div class="content-table inside content-space">      
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('provider', $provider, null, ['class' => 'form-select required', 'id'=> 'provider','placeholder'=>__('Select...'), 'required' => 'required']) }} 
                        {{Form::label('provider', __('Provider'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('invoice_number', null, ['class' => 'form-control number required', 'id'=> 'invoice_number', 'placeholder'=>__('Invoice number'), 'required' => 'required']) }}
                        {{ Form::label('invoice_number', __('Invoice number'), ['class' => 'title'])}}
                    </div>
                </div>
				<div class="col-xs-1 col-sm-1 col-md-2 ">
                    {{ Form::button('<i class="fa fa-save"></i>', ['type'=>'submit', 'class' => 'btn btn-primary', 'id' => 'save']) }}
                </div>
                
                
            </div>
        </div>
    </div>
    
    
</div>
{{ Form::close() }}
<script type="text/javascript">


</script>
