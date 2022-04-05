<div class="modal" tabindex="-1" id="detailConsultStorage" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::button('x', [ 'id' => 'close','class' => 'close-modal','type'=>'button','data-bs-dismiss'=>'modal','aria-label'=>'Close']) }}
            <div class="content-space">
                <div class="content-table inside">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tittle"><i class="fa fa-clipboard-list style"></i> {{__('Consult Available')}}</h5>
                    </div>
                    <div id="consultStorages" class="modal-body">
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

