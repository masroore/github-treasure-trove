@extends('front.layouts.core')

@push('css')
@endpush


@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li> <a href="{{ route('moj') }}">Moj račun</a></li>
            <li>Moje poruke</li>
        </ul>
        <div class="row">
            <div id="content" >
                <h1 id="page-title">Moje poruke</h1>
                <div class="col-md-12 text-right">
                    <a href="{{ route('moj.poruka.nova') }}" class="btn btn-secondary btn-sm">Nova poruka</a>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <td>Datum</td>
                                <td>Od</td>
                                <td>Prema</td>
                                <td>Naslov</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{{ $message->created_at }}</td>
                                    <td>{{ isset($message->sender->name) ? $message->sender->name : 'Nije upisano' }}</td>
                                    <td>{{ isset($message->recipient->name) ? $message->recipient->name : 'Nije upisano' }}</td>
                                    <td>{{ isset($message->subject) ? $message->subject : 'Nije upisano' }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('moj.poruka', ['message' => $message]) }}" class="btn btn-primary btn-sm">Pogledaj</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
@endpush
