@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-header block-header-default">
                @if (isset($recipient))
                    <h3 class="block-title"><a href="{{ route('messages') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>Poruke sa <a href="#">{{ $recipient->name }}</a> <span class="text-muted">({{ $messages->count() }})</span></h3>
                @else
                    <h3 class="block-title"><a href="{{ route('messages') }}" class="mr-10 text-gray font-size-h4"><i class="si si-action-undo"></i></a>Napiši novu poruku</h3>
                @endif
                <div class="block-options">

                </div>
            </div>
            <div class="block-content">
                <!-- Discussion -->
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td class="d-none d-sm-table-cell text-center">
                            <div class="mb-10">
                                <a href="#">
                                    <img class="img-avatar" src="{{ auth()->user()->details->avatar }}" alt="">
                                </a>
                            </div>
                            <small></small>
                        </td>
                        <td>
                            <form action="{{ route('message.send') }}" method="post">
                                @csrf
                                @if (isset($recipient))
                                    <div class="form-group mb-30">
                                        <label for="subject">Pošaljite novu poruka prema: <a href="#">{{ $recipient->name }}</a> <span class="text-gray">{{ date_format(date_create(now()), 'd.m.Y. h:i') }}</span></label>
                                        <input type="hidden" name="recipient" value="{{ $recipient->id }}">
                                    </div>
                                @else
                                    <div id="ag-auto-suggestion-app">
                                        <ag-auto-suggestion target="user" url="{{ route('users.autocomplete') }}" min="1" title="Za koga je poruka?" placeholder="Upiši Korisničko ime...">
                                        </ag-auto-suggestion>
                                    </div>
                                @endif
                                <div class="form-group mb-50">
                                    <label for="subject">Subjekt poruke @include('back.layouts.partials.required-star')</label>
                                    <input type="text" class="form-control form-control-lg" name="subject" value="{{ isset($messages[0]) ? $messages[0]->subject : '' }}">
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="message_content">Sadržaj poruke @include('back.layouts.partials.required-star')</label>
                                        <textarea class="js-summernote" name="message_content"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-alt-primary">
                                        <i class="fa fa-reply"></i> Pošalji
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>

                    @if (isset($messages))
                        @foreach($messages as $message)
                            <tr class="table-active">
                                <td class="d-none d-sm-table-cell"></td>
                                <td class="font-size-sm">
                                    @if ($message->from_user_id == auth()->user()->id)
                                        <a href="#">Vi</a> <span class="text-gray mx-10">pišete</span><em>{{ date_format(date_create($message->created_at), 'd.m.Y. h:i:s') }}</em>
                                    @else
                                        @if (Bouncer::is(auth()->user())->an('admin'))
                                            <a href="{{ route('user.edit', ['id' => $message->sender->id]) }}">{{ $message->sender->name }}</a> <span class="text-gray mx-10">piše</span><em>{{ date_format(date_create($message->created_at), 'd.m.Y. h:i:s') }}</em>
                                        @else
                                            <a href="#">{{ $message->sender->name }}</a> <span class="text-gray mx-10">piše</span><em>{{ date_format(date_create($message->created_at), 'd.m.Y. h:i:s') }}</em>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                    <div class="mb-10">
                                        <a href="be_pages_generic_profile.html">
                                            <img class="img-avatar" src="{{ asset($message->sender->details->avatar) }}" alt="">
                                        </a>
                                    </div>
                                    <small>{{ $message->sender->name }}</small>
                                </td>
                                <td>
                                    <p class="font-size-sm mb-5"><span class="font-w600">Subjekt: </span>{{ $message->subject }}</p>
                                    <hr class="text-muted mt-0">
                                    <p>{!! $message->message_content !!}</p>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
                <!-- END Discussion -->
            </div>
        </div>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="{{ asset('js/components/ag-autosuggestion.js') }}"></script>

    <script>
        $(() => {

            $('.js-summernote').summernote({
                height: 333,
                minHeight: 126,
                placeholder: "Write some description about the product...",
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
    </script>

@endpush
