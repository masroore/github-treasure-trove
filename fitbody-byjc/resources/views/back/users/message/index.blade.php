@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Poruke
            <small>
                <span class="pl-2">({{ $messages->total() }})</span>
                <span class="float-right">{{--{{ $count }}--}}
                    <a href="{{ route('message.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                        <i class="si si-plus"></i> Nova Poruka
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block black">
            <div class="block-content">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 45px;">#</th>
                        <th style="width: 140px;">Datum</th>
                        <th style="width: 18%;">Od</th>
                        <th style="width: 18%;">Prema</th>
                        <th>Subject</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 120px;">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $key => $message)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-light">{{ date_format(date_create($message->created_at), 'd.m.Y. h:i:s') }}</span>
                            </td>
                            <td class="font-w600 font-size-sm">{{ $message->sender->name }}</td>
                            <td class="font-w600 font-size-sm">{{ $message->recipient->name }}</td>
                            <td class="font-size-sm">{{ $message->subject }}</td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('message.edit', ['message' => $message]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="View">
                                    <i class="fa fa-pencil"></i> Pogledaj
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $messages->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('js_after')

@endpush
