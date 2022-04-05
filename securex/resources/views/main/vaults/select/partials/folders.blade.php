@foreach($vault->folders as $folder)
<div class="pb-1">
    <span>
        <a href="{{ route('vault.folder.show', [$vault,$folder]) }}" class="btn btn-dark btn-block btn-icon icon-left text-white" data-toggle="tooltip" data-placement="left" title="Open Folder">
            <i class="fa fa-{{ $folder->icon }}"></i>&nbsp;&nbsp;&nbsp;{{ $folder->name }}
            <span class="badge badge-transparent">{{ $folder->sites()->count() }}</span>
        </a>
    </span>
</div>
@endforeach