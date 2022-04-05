@if (session('success'))
<div class="custom-error">
    <div class="cerror success pull-up">
        <strong>@lang('alerts.success')</strong> {{ session('success') }}
    </div>
</div>
@endif
@if (session('info'))
<div class="custom-error">
    <div class="cerror info pull-up">
        <strong>@lang('alerts.success')</strong> {{ session('info') }}
    </div>
</div>
@endif
