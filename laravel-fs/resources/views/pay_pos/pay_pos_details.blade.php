<div class="modal" tabindex="-1" id="detail_pay" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            {{ Form::button('x', [ 'id' => 'close','class' => 'close-modal','type'=>'button','data-bs-dismiss'=>'modal','aria-label'=>'Close']) }}
        <div class="content-space">
            <div class="content-table inside">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-money-check-alt"></i> {{__('Pay POS')}}</h5>
                
            </div>
            <div class="modal-body">
                <div class="content-space pa-1"> 
                    <div class="content-table inside mb-4">

                        <h3 class="pos mb-2">{{__('Payments')}}</h3>

                        <div class="content-space"> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::select('pay_methods', [], null, ['class' => 'form-select required', 'id'=> 'pay_methods','placeholder'=>__('Select...'), 'required' => 'required']) }}
                                        {{ Form::label('pay_methods', __('Pay Method'), ['class' => 'title'])}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::text('date_pay', null, ['class' => 'form-control date_in required', 'id'=> 'date_pay','required'=>'required', 'placeholder' => __('Date Charge'), 'readonly'=>'readonly']) }}
                                         {{Form::label('date_pay', __('Date Charge'), ['class' => 'title'])}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::text('ref', null, ['class' => 'form-control required', 'id'=> 'ref','required'=>'required', 'placeholder' => __('Reference')])}}
                                        {{Form::label('ref', __('Reference'), ['class' => 'title'])}}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 mb-4">
                                    <div class="form-group floating-label">
                                        {{ Form::text('amount', null, ['class' => 'form-control numeric number required', 'id'=> 'amount', 'maxlength'=>'7','required'=>'required', 'placeholder' => __('Amount')])}}
                                         {{Form::label('amount', __('Amount'), ['class' => 'title'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 mx-auto">
                                {{ Form::button(__('Pay'), ['class' => 'btn btn-primary save', 'id'=>'save']) }}
                            </div>
                        </div>
                    </div>
                    
                        <div class="content-table inside">
                            <h3 class="pos mb-2">{{__('Payment History')}}</h3>

                            <table class="dataTable table" cellspacing="0" width="100%" id="table_2">
                                <thead>
                                    <tr>
                                        <th scope='col'>{{__('Payment Type')}}</th>
                                        <th scope='col'>{{__('Payment Date')}}</th>
                                        <th scope='col'>{{__('Reference')}}</th>
                                        <th scope='col'>{{__('Abonate')}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    
                </div>
            </div>  
        </div>

</div>
</div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

    });
    
</script>
