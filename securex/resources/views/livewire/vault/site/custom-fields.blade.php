<div>
  <form wire:submit.prevent="">
      @foreach($cfields as $field)
      <div class="form-group row">
          <div class="input-group align-items-center">
            <span class="form-control bg-gray" id="cfn_{{ $field->id }}">{{ $field->name }}</span>
            <span class="form-control bg-gray ml-1" id="cf_{{ $field->id }}">{{ $field->value }}</span>
            <span class="input-group-button">
                <button class="btn btn-clippy ml-1" name="btn" id="btn" type="button" data-clipboard-target="#cf_{{ $field->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                    <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                </button>
                <button wire:click="deleteField({{$field->id}})" wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.delete') }}" class="btn ml-1"><i class="fas fa-trash text-danger"></i>
                </button>
            </span>
          </div>
      </div>
      @endforeach
  </form>
</div>

@push('scripts')
<script>
window.livewire.on('fieldDeleted', msg => {
  notyf.open({
      type: 'error',
      message: msg
  });
});
window.livewire.on('fieldAdded', msg => {
  notyf.open({
      type: 'success',
      message: msg
  });
});
</script>
@endpush