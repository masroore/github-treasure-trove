@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Info Stranice
            <small>
                <span class="float-right">
                    @if (Bouncer::is(auth()->user())->an('admin'))
                        <a href="{{ route('page.create') }}" class="btn btn-secondary ml-30" data-toggle="tooltip" title="New">
                                <i class="si si-plus"></i> Nova Stranica
                            </a>
                    @endif
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-content bg-body-light">
                <div class="row items-push">
                    <div class="col-12 col-md-3">
                        <input type="text" name="date_start" id="start-date-picker" class="form-control " placeholder="Od..."
                               value="{{ request()->input('from') ? date_format(date_create(request()->input('from')), 'd.m.Y.') : '' }}" style="height: 34px; background-color: white;">
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="text" name="date_end" id="end-date-picker" class="form-control " placeholder="Do..."
                               value="{{ request()->input('to') ? date_format(date_create(request()->input('to')), 'd.m.Y.') : '' }}" style="height: 34px; background-color: white;">
                    </div>
                    <div class="col-12 col-md-6">
                        <select class="form-control" id="group-select">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach ($page_groups as $group)
                                <option value="{{ $group['id'] }}" {{ ($group['id'] == request()->input('group')) ? 'selected' : '' }}>{{ \Illuminate\Support\Str::upper($group['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="block-content">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 90px;">Pogledano</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 120px;">Akcije</th>
                    </tr>
                    </thead>
                    @foreach($pages as $key => $page)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $page->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600"><a href="{{ route('page.edit', ['id' => $page->id]) }}">{{ $page->name }}</a></td>
                            <td class="text-right">{{ $page->viewed }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                @if ( ! in_array($page->slug, ['o-nama', 'kontakt']))
                                    <button type="button" class="btn btn-sm btn-circle btn-alt-danger" data-toggle="tooltip" data-placement="left" title="Obriši - {{ $page->name }}"
                                            onclick="event.preventDefault(); shouldDeletePage({{ json_encode($page) }});">
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
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        /* Datepickers */
        $('#start-date-picker').flatpickr({
            enableTime: false,
            dateFormat: "d.m.Y.",
        })
        $('#end-date-picker').flatpickr({
            enableTime: false,
            dateFormat: "d.m.Y.",
        })

        $('#group-select').select2({
            placeholder: "Odaberi Grupu stranica...",
            allowClear: true,
            width: '100%'
        })

        $('#group-select').on('change', (e) => {
            let search = e.currentTarget.selectedOptions[0]
            let url = new URL(location.href)
            let params = new URLSearchParams(url.search)
            let keys = []

            for(var key of params.keys()) {
                if (key === 'group') {
                    keys.push(key)
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value)
                }
            })

            if (search.value) {
                params.append('group', search.value)
            }

            url.search = params
            location.href = url
        })

        $('#start-date-picker').on('change', (e) => {
            let search = e.currentTarget.value
            let url = new URL(location.href)
            let params = new URLSearchParams(url.search)
            let keys = []

            for(var key of params.keys()) {
                if (key === 'from') {
                    keys.push(key)
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value)
                }
            })

            if (search) {
                params.append('from', search)
            }

            url.search = params
            location.href = url
        })

        $('#end-date-picker').on('change', (e) => {
            let search = e.currentTarget.value
            let url = new URL(location.href)
            let params = new URLSearchParams(url.search)
            let keys = []

            for(var key of params.keys()) {
                if (key === 'to') {
                    keys.push(key)
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value)
                }
            })

            if (search) {
                params.append('to', search)
            }

            url.search = params
            location.href = url
        })


        function shouldDeletePage(page) {
            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Izbriši info stranicu: ' + page.name,
                type: 'warning',
                confirmButtonText: 'Da, Obriši ju!',
            }).then((result) => {
                if (result.value) {
                    deletePage(page)
                }
            })
        }

        function deletePage(page) {
            axios.post("{{ route('page.destroy') }}", {data: page})
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
