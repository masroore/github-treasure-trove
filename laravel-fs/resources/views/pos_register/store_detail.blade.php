{{ Form::open(['id'=>'pos_register','autocomplete'=>'Off', "data-dataType"=>"html"  ,"enctype"=>"multipart/form-data", "route"=>["pos_register.store_detail",$PosRegister['crypt_id'] ], 'class' => 'validate']) }}


<div class="content-table">
    <h3>{{ __('POS Register') }}</h3>
    <div class="content-space"> 
        <div class="content-table inside content-space">      
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        
						{{ Form::text('provider', $PosRegister['provider']['name_provider'], ['readonly'=>'readonly', 'disabled'=>'disabled', 'class' => 'form-control  ', 'id'=> 'provider', 'placeholder'=>__('provider')]) }}
                        {{Form::label('provider', __('Provider'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::text('invoice_number', $PosRegister['number_control'], ['readonly'=>'readonly', 'disabled'=>'disabled', 'class' => 'form-control  ', 'id'=> 'invoice_number', 'placeholder'=>__('Invoice number')]) }}
                        {{ Form::label('invoice_number', __('Invoice number'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::select('model', $models, null, ['class' => 'form-select required', 'id'=> 'model', 'placeholder'=>__('Select...')]) }} 
                         {{ Form::label('model', __('Model'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::number('num_box', null, ['max'=>'99999999', 'class' => 'form-control number required', 'id'=> 'num_box', 'min'=>'1', 'placeholder'=>__('N° number')]) }}
                         {{ Form::label('num_box', __('N° Box'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::number('amo_box', null, ['max'=>'1000','class' => 'form-control number required', 'id'=> 'amo_box', 'min'=>'1', 'placeholder'=>__('Amount of box'), 'maxlength'=>'4']) }}
                        {{ Form::label('amo_box', __('Amount of box'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::number('ini_serial', null, ['max'=>'99999999','class' => 'form-control onlyText required', 'id'=> 'ini_serial', 'min'=>'1', 'placeholder'=>__('Initial serial')]) }}
                        {{ Form::label('ini_serial', __('Initial serial'), ['class' => 'title'])}}
                    </div>
                </div>
                <div class="col-xs-11 col-sm-11 col-md-2 mb-4">
                    <div class="form-group floating-label">
                        {{ Form::number('num_lot', null, ['max'=>'99999999','class' => 'form-control number required', 'id'=> 'num_lot', 'min'=>'1', 'placeholder'=>__('N° Lot'), 'maxlength'=>'8']) }}
                         {{ Form::label('num_lot', __('N° Lot'), ['class' => 'title'])}}
                    </div>
                </div>
                 <div class="col-xs-1 col-sm-1 col-md-1 ">
                    {{ Form::button('<i class="fa fa-plus"></i>', ['type'=>'submit', 'class' => 'btn btn-primary', 'id' => 'add_pos']) }}
                </div>
            </div>
        </div>
    </div>
    <table class="dataTable table" cellspacing="0" width="100%" id="table_pos">
        <thead>
            <tr>
                <th>{{__('Model')}}</th>
                <th>{{__('N° Box')}}</th>
                <th>{{__('Serial')}}</th>
                <th>{{__('Amount of POS')}}</th>
                <th>{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="col-3 mx-auto content-space">
        {{ Form::button(__('Save'), ['class' => 'btn btn-primary save','id'=>'save']) }}
    </div>
</div>
{{ Form::close() }}
<script type="text/javascript">

</script>
