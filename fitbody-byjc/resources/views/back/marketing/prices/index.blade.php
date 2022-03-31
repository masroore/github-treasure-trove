@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Cjenici
            <small>
                <span class="float-right">
                    @if (Bouncer::is(auth()->user())->an('admin'))
                        <a href="{{ route('price.create') }}" class="btn btn-secondary ml-30" data-toggle="tooltip" title="New">
                            <i class="si si-plus"></i> Novi Cjenik
                        </a>
                    @endif
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
                        <th>Naslov</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 120px;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($prices as $key => $price)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $price->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600"><a href="{{ route('price.edit', ['id' => $price->id]) }}">{{ $price->title }}</a></td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger" data-toggle="tooltip" data-placement="left" title="Obriši - {{ $price->title }}"
                                        onclick="event.preventDefault(); shouldDeletePrice({{ json_encode($price) }});">
                                    <i class="fa fa-times"></i>
                                </button>
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
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        function shouldDeletePrice(price) {
            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Izbriši info stranicu: ' + price.title,
                type: 'warning',
                confirmButtonText: 'Da, Obriši ju!',
            }).then((result) => {
                if (result.value) {
                    deletePrice(price)
                }
            })
        }

        function deletePrice(price) {
            axios.post("{{ route('price.destroy') }}", {data: price})
                .then(r => {
                    if (r.data) {
                        successToast.fire({
                            text: '',
                        })

                        location.reload()
                    }
                })
                .catch(e => {
                    errorToast.fire({
                        text: e,
                    })
                })
        }
    </script>
@endpush
