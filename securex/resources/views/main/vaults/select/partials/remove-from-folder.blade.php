@foreach($vault->sites as $site)
@if(! $site->folder->isEmpty())
<div class="modal fade" id="remove-from-folder-{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body bg-secondary p-0">
                <div class="modal-body">
                    <span class="text-center pb-15">
                        <h6>Remove <b><u>{{ $site->name }}</u></b> from Folder <b><u>{{ $site->folder[0]->name }}</u></b></h6>
                    </span>
                    <br />
                    <form method="POST" action="{{ route('vault.folder.removeFromFolder', [$vault,$site]) }}">
                        @csrf
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-danger btn-shadow"><i class="fas fa-folder-minus"></i> Yes, Remove From {{ $site->folder[0]->name }} Folder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach