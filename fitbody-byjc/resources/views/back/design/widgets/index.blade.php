@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Widgets
            <small>
                <span class="pl-2">({{ $widgets->total() }})</span>
                <span class="float-right">
                    <a href="{{ route('widget.group.create') }}" class="btn btn-sm btn-secondary ml-10" data-toggle="tooltip" title="Novi Widget">
                        <i class="si si-plus"></i> Nova Widget Grupa
                    </a>
                    <a href="{{ route('widget.create') }}" class="btn btn-sm btn-secondary ml-10" data-toggle="tooltip" title="Novi Widget">
                        <i class="si si-plus"></i> Novi Widget
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block black">
            <div class="block-content bg-body-light">
                <div class="row mb-3">
                    <div class="col-12 col-md-9"></div>
                    <div class="col-12 col-md-3">
                        <select class="js-select2 form-control form-control-sm" id="group-select" style="width: 100%;">
                            <option></option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ $group->id == request()->input('group') ? 'selected="selected"' : '' }}>{{ strtoupper($group->title) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="block-content">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 30px;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Naslov</th>
                        <th class="text-center" style="width: 12%;">Grupa</th>
                        <th class="text-center" style="width: 12%;">Poredak</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 100px;">Akcija</th>
                    </tr>
                    </thead>
                    @foreach($widgets as $key => $widget)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $widget->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600">
                                <a href="{{ route('widget.edit', ['id' => $widget->id]) }}" class="js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi Widget">{{ $widget->title }}</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('widget.group.edit', ['id' => $widget->group->id]) }}" class="js-tooltip-enabled" data-toggle="tooltip" data-title="Uredi Widget">{{ $widget->group->slug }}</a>
                            </td>
                            <td class="text-center">{{ $widget->sort_order }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger" onclick="event.preventDefault(); shouldDeleteItem({{ json_encode($widget) }});">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>

            {{ $widgets->links('back.layouts.partials.paginate') }}

        </div>

    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script>
        $('#group-select').select2({
            placeholder: 'Odaberite grupu..',
            allowClear: true,
            //
        }).on('change', e => {
            setURL('group', e.currentTarget.selectedOptions[0]);
        });

        /**
         *
         * @param type
         * @param search
         */
        function setURL(type, search) {
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys = [];

            for(var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value);
                }
            })

            if (search.value) {
                params.append(type, search.value);
            }

            url.search = params;
            location.href = url;
        }

        /**
         *
         * @param item
         */
        function shouldDeleteItem(item) {
            console.log(item)

            confirmPopUp.fire({
                title: 'Jeste li sigurni!?',
                text: 'Potvrdi brisanje ' + item.name,
                type: 'warning',
                confirmButtonText: 'Da, obriši!',
            }).then((result) => {
                if (result.value) {
                    deleteItem(item)
                }
            })
        }

        /**
         *
         * @param item
         */
        function deleteItem(item) {
            axios.post("{{ route('widget.destroy') }}", {data: item})
            .then(r => {
                if (r.data) {
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
