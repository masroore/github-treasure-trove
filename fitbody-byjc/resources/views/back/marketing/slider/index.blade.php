@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Slideri
            <small>
                <span class="float-right">
                    <a href="{{ route('slider.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                        <i class="si si-plus"></i> Nov Grupa Slidera
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-content">

                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 15%;">Količina</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 30%;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($sliders as $key => $slider)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $slider->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600"><a href="{{ route('slider.edit', ['id' => $slider->id]) }}">{{ $slider->name }}</a></td>
                            <td class="text-center pl-3">{{ isset($slider->sliders) ? count($slider->sliders) : 0 }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                @if ( ! in_array($slider->id, [1]))
                                    <button type="button" class="btn btn-sm btn-circle btn-alt-danger" data-toggle="tooltip" data-placement="left" title="Obriši {{ $slider->name }}"
                                            onclick="event.preventDefault(); shouldDeleteSlider({{ json_encode($slider) }});">
                                        <i class="fa fa-times"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>

    </div>

@endsection

@push('js_after')
    <script>
        function shouldDeleteSlider(slider) {
            console.log(slider)

            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Potvrdi brisanje Slidera: ' + slider.name,
                type: 'warning',
                confirmButtonText: 'Da, Obriši ga!',
            }).then((result) => {
                if (result.value) {
                    deleteSlider(slider)
                }
            })
        }

        function deleteSlider(slider) {
            axios.post("{{ route('slider.destroy') }}", {data: slider})
                .then(r => {
                    successToast.fire({
                        text: '',
                    })

                    location.reload()
                })
                .catch(e => {
                    errorToast.fire({
                        text: e,
                    })
                })
        }
    </script>
@endpush
