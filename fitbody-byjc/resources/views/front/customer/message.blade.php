@extends('front.layouts.core')

@push('css')

@endpush


@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li> <a href="{{ route('moj') }}">Moj račun</a></li>
            <li><a href="{{ route('moj.poruke') }}">Moje poruke</a></li>
            <li>Poruka</li>
        </ul>
        <div class="row">
            <div id="content" >
                <h1 id="page-title">Poruka </h1>
                <div class="col-md-12">
                    <div class="block">
                        <div class="block-header block-header-default">
                            @if (isset($recipient))
                                <h4 style="margin-bottom: 30px;"><b>Poruke sa <a href="#">{{ $recipient->name }}</a> <span class="text-muted">({{ $messages->count() }})</span></b></h4>
                            @else
                                <h4 style="margin-bottom: 30px;"><b>Napiši novu poruku</b></h4>
                            @endif
                        </div>
                        <form action="{{ route('moj.poruka.send') }}" method="post" class="form-horizontal">
                            @csrf
                            @if (isset($recipient) )
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label for="subject">Pošaljite novu poruka prema: <a href="#">{{ $recipient->name }}</a> <span class="text-gray">{{ date_format(date_create(now()), 'd.m.Y. h:i') }}</span></label>
                                        <input type="hidden" name="recipient" value="{{ $recipient->id }}">
                                    </div>
                                </div>
                            @else
                                <div>
                                    <div class="col-sm-12">
                                        <vendor-autosuggest target="user" url="{{ route('api.vendor.autocomplete') }}" min="1" title="Za koga je poruka?" placeholder="Upiši Korisničko ime...">
                                        </vendor-autosuggest>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group required">
                                <div class="col-sm-12">
                                    <label for="subject">Subjekt poruke @include('back.layouts.partials.required-star')</label>
                                    <input type="text" class="form-control grey" name="subject" value="{{ isset($messages[0]) ? $messages[0]->subject : '' }}">
                                </div>
                            </div>
                            <div class="form-group required">
                                <div class="col-sm-12">
                                    <div class="col-12">
                                        <label for="message_content">Sadržaj poruke @include('back.layouts.partials.required-star')</label>
                                        <textarea rows="8" class="form-control grey" name="message_content"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons clearfix">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-outline">Pošalji</button>
                                </div>
                            </div>
                        </form>
                        @if (isset($messages))
                            <h4><b>Prepiska</b></h4>
                            <div id="review">
                                @foreach($messages as $message)
                                    <div class="table">
                                        <div class="table-cell"><i class="fa fa-user"></i></div>
                                        <div class="table-cell right">
                                            @if ($message->from_user_id == auth()->user()->id)
                                                <p class="author"><b>Vi pišete: </b> {{ date_format(date_create($message->created_at), 'd.m.Y. h:i:s') }}</p>
                                            @else
                                                <p class="author"><b>{{ $message->sender->name }} piše: </b>{{ date_format(date_create($message->created_at), 'd.m.Y. h:i:s') }}</p>
                                            @endif
                                            <h5><strong>{{ $message->subject }}</strong></h5>
                                            <p>{!! $message->message_content !!}</p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                    @endif
                    <!-- END Discussion -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')

@endpush
