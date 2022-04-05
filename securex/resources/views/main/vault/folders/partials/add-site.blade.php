<div class="modal fade" id="add-site" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if(Auth::user()->hasReachedSiteLimit())
            <div class="card card-danger mb-0">
                <div class="card-header">
                    <b>{{ __('vault.site_limit') }}</b>
                </div>
            </div>
            @else
            @livewire('vault.site.add-site', ['vault' => $vault, 'folder' => $folder])
            @endif
        </div>
    </div>
</div>