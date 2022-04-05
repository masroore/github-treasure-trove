@if($errors->any())
@foreach ($errors->all() as $error)
<div class="custom-error">
  <div class="cerror danger">
    <strong>@lang('alerts.warning')</strong> {{ $error }}
  </div>
</div>
@endforeach
@endif