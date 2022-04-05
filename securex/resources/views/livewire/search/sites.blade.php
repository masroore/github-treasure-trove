<div class="search-element">
    <input class="form-control" type="text" wire:model="search" placeholder="Search my sites" aria-label="Search" data-width="250">
    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    <div class="search-backdrop"></div>
    @if($this->search != '')
    <div class="search-result">
        <div class="search-header">
            Results
        </div>
        @if(! $sites->count())
        <div class="search-item">
            <a href="#">
                <i class="fas fa-window-close text-danger"></i> &nbsp;&nbsp;
                No matching sites found.
            </a>
        </div>
        @endif
        @foreach($sites as $site)
        <div class="search-item">
            <a href="{{ route('vault.site.show', [$site->vault->id, $site]) }}">
                <i class="fas fa-database text-primary"></i> &nbsp;&nbsp;
                {{ $site->name }} ({{ $site->vault->name }})
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>