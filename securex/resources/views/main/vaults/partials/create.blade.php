<div class="modal fade" id="create-vault" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      @if(Auth::user()->hasReachedVaultLimit())
      <div class="card card-danger mb-0">
        <div class="card-header">
          <b>{{ __('vaults.limit') }}</b>
        </div>
      </div>
      @else
        @livewire('vault.create-vault')
      @endif
    </div>
  </div>
</div>