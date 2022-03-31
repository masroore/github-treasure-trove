@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_before')
    <style>
        .fileContainer {
            overflow: hidden;
            position: relative;
        }

        .fileContainer [type=file] {
            cursor: inherit;
            display: block;
            font-size: 999px;
            filter: alpha(opacity=0);
            min-height: 34px;
            min-width: 100%;
            opacity: 0;
            position: absolute;
            right: 0;
            text-align: right;
            top: 0;
        }

        .fileContainer {
            background: #E3E3E3;
            float: left;
            padding: .5em 1.5rem;
            height: 34px;
        }

        .fileContainer [type=file] {
            cursor: pointer;
        }


        img.preview {
            width: 200px;
            background-color: white;
            border: 1px solid #DDD;
            padding: 5px;
        }
    </style>
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <form action="{{ isset($client) ? route('profile.client.update', ['client' => $client]) : route('profile.client.store') }}" method="post" enctype="multipart/form-data">
            {{ isset($client) ? method_field('PATCH') : '' }}
            @csrf
            <h2 class="content-heading"> <a href="{{ route('clients') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($client))
                    Uredi Prodavača <small class="text-primary pl-4">{{ $client->name }}</small>
                @else
                    Napravi Novog Prodavača
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-5"></i>Snimi Prodavača</button>
            </h2>

            <div class="block block-rounded block-shadow" id="actions-app">
                <div class="block-content">
                    @include('back.settings.profile.partials.general')
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-5"></i>Snimi Prodavača
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
      $(() => {
        $('#product-select').select2()

        $('#start-date-picker').flatpickr({
          enableTime: true,
          dateFormat: "d.m.Y. H:i",
        })

        $('#end-date-picker').flatpickr({
          enableTime: true,
          dateFormat: "d.m.Y. H:i",
        })
      })
    </script>
    <!-- Summernote -->
    <script>
        $(() => {
            $('#client-plan-select').select2()

            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Upišite neki info...",
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link', 'tabel', 'hr']],
                    ['view', ['help']]
                ],
                styleTags: ['p', 'h4', 'blockquote'],
            })
        })

        function setClientImage(e) {
            let file = e.target.files[0]
            document.getElementById('client-image-name').innerHTML = file.name

            let reader = new FileReader()
            let cx = this

            reader.onload = event => {
                document.getElementById('client-image-thumb').src = event.target.result
            }

            reader.readAsDataURL(file)
        }
    </script>

    @stack('client_scripts')

@endpush
