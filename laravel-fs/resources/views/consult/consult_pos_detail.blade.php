<div class="modal" tabindex="-1" id="detail_request_pos" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-search"></i> {{__('Detail Pos')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close"></button>
            </div>
            <div class="modal-body">
                <div class="content-space pa-1"> 
                    <div class="content-table inside mb-3">

                        <h3 class="pos mb-2">{{__('POS')}}</h3>

                        <div class="content-space"> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3 mb-3 view-info">
                                    {{ Form::label('label', __('Model'), ['class' => 'name-label']) }}<br>
                                    {{ Form::label('models', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'models']) }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 mb-3 view-info">
                                    {{ Form::label('label', __('Serial'), ['class' => 'name-label']) }}<br>
                                    {{ Form::label('serials', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'serials']) }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 mb-3 view-info">
                                    {{ Form::label('label', __('Box Number'), ['class' => 'name-label']) }}<br>
                                    {{ Form::label('number_box', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'number_boxs']) }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 mb-3 view-info">
                                    {{ Form::label('label', __('Department'), ['class' => 'name-label']) }}<br>
                                    {{ Form::label('departments', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'departments']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-table inside">

                        <h3 class="pos mb-2">{{__('Afiliate')}}</h3>
                        
                        <div class="content-space"> 
                                
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3 mb-3 view-info">
                                    {{ Form::label('label', __('Afiliate'), ['class' => 'name-label']) }}<br>
                                    {{ Form::label('afiliate', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'afiliate']) }}
                                </div>
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
