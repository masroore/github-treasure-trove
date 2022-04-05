<div>
    <form wire:submit.prevent="">
        @foreach($notes as $note)
        <div class="form-group row">
            <div class="input-group align-items-center">
                <span class="form-control bg-gray" id="note_{{ $note->id }}">{{ $note->body }}</span>
                <span class="input-group-button">
                    <button class="btn btn-clippy ml-1" name="btn" id="btn" type="button" data-clipboard-target="#note_{{ $note->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                        <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                    </button>
                    <button wire:click="deleteNote({{$note->id}})" wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.delete') }}" class="btn btn-icon"><i class="fas fa-trash text-danger"></i>
                    </button>
                </span>
            </div>
        </div>
        @endforeach
    </form>
</div>

@push('scripts')
<script>
window.livewire.on('noteDeleted', msg => {
  notyf.open({
      type: 'error',
      message: msg
  });
});
window.livewire.on('noteAdded', msg => {
  notyf.open({
      type: 'success',
      message: msg
  });
});
</script>
@endpush