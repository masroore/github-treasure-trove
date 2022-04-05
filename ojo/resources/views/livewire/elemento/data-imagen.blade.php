<div>
    @if($pagina == "index")
    <h4 class="mb-5">Búsqueda de imagenes</h4>

    @if (session()->has('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
     @endif

        <div class="card">
            <div class="card-body">
                @if(count($imagenes) > 0)

                <div class="row">
                    <div class="animate__animated animate__fadeIn @if($show_status==TRUE) col-md-9 @else col-md-12 @endif">
                        <div class="row grid">
                        @foreach($imagenes as $i)  
                        <div class="col-md-2">
                            <a href="#" wire:click="show('{{$i->image_url}}')">
                                <img src="{{ Storage::url($i->image_url) }}" class="img-thumbnail" alt="{{ $i->nombres }}, {{ $i->paterno }} {{ $i->materno }}">
                            </a>
                
                            <a class="btn btn-light btn-sm mute" href="{{ route('personas') }}?show={{ base64_encode(Crypt::encryptString($i->person_id)) }}"><i class="bi bi-person-fill"></i> {{$i->nombres}}, {{$i->paterno}} {{$i->materno}}</a>
                       
                        </div>
                        @endforeach
                        </div>

                        <div class="pagination">
                            {{ $imagenes->links('livewire.paginate.custom') }}
                        </div>
                    </div>

                    @if($show_status==TRUE)
                        <div class="card col-md-3 animate__animated animate__fadeIn">
                            <div class="my-2">
                                <button class="btn btn-secondary float-right" wire:click="$set('show_status', 0)">Cerrar</button>
                            </div>
                        <img src="{{ $selected_url }}" class="img-thumbnail">
                        <br>

                        
                        </div>
                    @endif
                
                </div>
                @else
                <p>No se encuentraron datos.</p>
                @endif
            </div>
        </div>

    @endif
</div>
