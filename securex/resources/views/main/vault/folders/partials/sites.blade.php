<div class="col-md-4">
    <div class="card card-primary pull-up" style="border-top: 2px solid @if($site->is_fav) #FC544B @else {{ $vault->color }} @endif">
        <div class="card-header">
            <h4>
                <a href="{{ route('vault.site.show', [$vault,$site]) }}" class="font-weight-bold" style="color: {{ $vault->color }}">
                    <i class="fas fa-caret-right"></i>
                    {{ $site->name }}</a>
            </h4>
            <div class="card-header-action" style="width: 5%">
                @if($site->folder->isEmpty())
                <a href="#">
                    <span class="text-dark" data-toggle="modal" data-target="#add-to-folder-{{ $site->id }}">
                        <i class="far fa-folder-open" data-toggle="tooltip" title data-original-title="{{ __('vault.add_site_to_folder') }}"></i>
                    </span>
                </a>
                @else
                <a href="#">
                    <span class="text-dark" data-toggle="modal" data-target="#remove-from-folder-{{ $site->id }}">
                        <i class="fas fa-folder" data-toggle="tooltip" title data-original-title="{{ $site->folder[0]->name }}"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row text-center">
                <div class="col-md-4 col-4">
                    <a href="#" class="text-primary">
                        <span data-toggle="modal" data-target="#quick-view-{{ $site->id }}">
                            <i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title data-original-title="{{ __('vault.quick_view') }}"></i>
                        </span>
                    </a>
                </div>
                <div class="col-md-4 col-4">
                    <a href="{{ route('vault.site.show', [$vault,$site]) }}" class="text-warning">
                        <i class="fas fa-door-open" data-toggle="tooltip" data-placement="bottom" title data-original-title="{{ __('vault.open_site') }}"></i>
                    </a>
                </div>
                <div class="col-md-4 col-4">
                    @if($site->is_fav)
                    <a href="{{ route('vault.site.fav.delete', [$vault,$site]) }}" class="text-danger">
                        <i class="fas fa-heart" data-toggle="tooltip" data-placement="bottom" title data-original-title="{{ __('vault.fav') }}"></i>
                    </a>
                    @else
                    <a href="{{ route('vault.site.fav.store', [$vault,$site]) }}" class="text-secondary">
                        <i class="fas fa-heart" data-toggle="tooltip" data-placement="bottom" title data-original-title="{{ __('vault.fav_this_site') }}"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>