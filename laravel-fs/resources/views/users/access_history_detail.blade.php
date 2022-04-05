<div class="modal" tabindex="-1" id="detail_history" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-history"></i> {{__('Access History')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 mb-3 view-info">
                                {{ Form::label('label', __('User'), ['class' => 'name-label']) }}<br>
                                {{ Form::label('user', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'user']) }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 mb-3 view-info">
                                {{ Form::label('label', __('Date Start'), ['class' => 'name-label']) }}<br>
                                {{ Form::label('date_in', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'in']) }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 mb-3 view-info">
                                {{ Form::label('label', __('Date End'), ['class' => 'name-label']) }}<br>
                                {{ Form::label('date_out', '', ['class' => 'text-muted m-b-15 m-t-20 font-13 text-uppercase', 'id'=>'out']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="table-formstep">
                    <table class="dataTable table" cellspacing="0" width="100%" id="histories">
                        <thead>
                            <tr>
                                <th scope='col'>{{__('Date')}}</th>
                                <th scope='col'>{{__('Module')}}</th>
                                <th scope='col'>{{__('Action')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#close').on('click',function(){
            $('#histories').dataTable().fnClearTable();
        });
    });
    
</script>
