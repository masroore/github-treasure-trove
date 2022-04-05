@if(app()->isDownForMaintenance())
    <div class="alert alert-danger m-2">
        <a href="{{ route('admin.settings.system.index') }}">Maintenance Mode is Active</a>
    </div>
@endif