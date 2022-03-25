<style>
    input[type="file"]{
        opacity: unset;
        position:relative;
    }
</style>
<div class="card bg-none card-box">
    {{ Form::open(array('url' => 'document-entry','files' => 'true','enctype'=>'multipart/form-data')) }}
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('payment_text', __('Payment Text'),['class'=>'form-control-label']) }}
            {{ Form::text('payment_text', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('file_type', __('File Type'),['class'=>'form-control-label']) }}
            {{ Form::select('file_type', array('JV' => 'Journal Voucher', 'BPV' => 'Bank payment Voucher', 'CPV' => 'Cash payment Voucher', 'BR' => 'Bank Receipt' , 'CR' => 'Cash Receipt'), 'JV', array('class' => 'form-control','required'=>'required'))  }}
            <!--{{ Form::text('file_type', '', array('class' => 'form-control','required'=>'required')) }}-->
        </div>

       <div class="form-group col-md-6">
             {{ Form::label('file_upload', __('Upload File'),['class'=>'form-control-label']) }}
            {{ Form::file('file_upload',null, array('class' => 'form-control')) }}
        </div>
        <div class="col-md-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
