@if(session('success_message'))
    <div class="alert alert-success alert-dismissable">
        <button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
        <strong><i class="fa fa-check"></i></strong> {!! Session::get('success_message') !!}
    </div>
@elseif(session('error_message'))
    <div class="alert alert-danger alert-dismissable">
        <button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
        <strong><i class="fa fa-warning"></i></strong> {!! Session::get('error_message') !!}
    </div>
@endif
