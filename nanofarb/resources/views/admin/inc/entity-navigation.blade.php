<div class="pull-right box-tools">
    <div class="btn-group">
        @if(isset($next) && $next)<a href="{{ $next }}" class="btn btn-default btn-sm"><i class="fa fa-caret-left"></i></a>@endisset
        @if(isset($current) && $current)<a href="{{ $current }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>@endisset
        @if(isset($previous) && $previous)<a href="{{ $previous ?? '#' }}" class="btn btn-default btn-sm"><i class="fa fa-caret-right"></i></a>@endisset
    </div>
</div>