@foreach($error as $value)

   <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="note-footer"><i class="fa fa-exclamation"></i>
            {{ $value['message'] }}
        </div>
    </div>
@endforeach
