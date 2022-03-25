<style>
    input[type="file"]{
        opacity: unset;
        position:relative;
    }
</style>
<div class="card bg-none card-box">
    {{ Form::model($document, array('route' => array('document-entry.update', $document->id), 'files' => 'true','enctype'=>'multipart/form-data', 'method' => 'PUT')) }}
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('payment_text', __('Payment Text'),['class'=>'form-control-label']) }}
            {{ Form::text('payment_text', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('file_type', __('File Type'),['class'=>'form-control-label']) }}
             {{ Form::select('file_type', array('JV' => 'Journal Voucher', 'BPV' => 'Bank payment Voucher', 'CPV' => 'Cash payment Voucher', 'BR' => 'Bank Receipt' , 'CR' => 'Cash Receipt'), null, array('class' => 'form-control','required'=>'required'))  }}
            <!--{{ Form::text('file_type', null, array('class' => 'form-control','required'=>'required')) }}-->
        </div>
        <div class="form-group col-md-6">
             {{ Form::label('file_upload', __('Upload File'),['class'=>'form-control-label']) }}
            {{ Form::file('file_upload',null, array('class' => 'form-control')) }}
        </div>
        <div class="col-md-12">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
