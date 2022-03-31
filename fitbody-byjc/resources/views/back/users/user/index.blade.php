@extends('back.layouts.backend')

@section('content')

    <div class="content">
        <h2 class="content-heading">Korisnici
            <small>
                <span class="pl-2">({{ $users->total() }})</span>
                <span class="float-right">
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New">
                        <i class="si si-plus"></i> Novi Korisnik
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
                        <th style="width: 30px;">#</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 18%;">Email</th>
                        <th class="text-center" style="width: 15%;">Grad</th>
                        @if (Bouncer::is(auth()->user())->an('admin'))
                            <th class="text-center" style="width: 10%;">Uloga</th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($users as $key => $user)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $user->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600">
                                @if (Bouncer::is(auth()->user())->an('admin'))
                                    <a href="{{ route('user.edit', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                @elseif(Bouncer::is(auth()->user())->an('editor'))
                                    <a href="{{ route('user.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                @endif
                            </td>
                            <td class="text-center font-size-sm">{{ $user->email }}</td>
                            <td class="text-center font-size-sm">{{ isset($user->details) ? $user->details->city : '' }}</td>
                            @if (Bouncer::is(auth()->user())->an('admin'))
                                <td class="text-center">
                                    @if ($user->role == 'admin')
                                        <span class="badge badge-pill badge-info">{{ $user->role }}</span>
                                    @elseif($user->role == 'editor')
                                        <span class="badge badge-pill badge-primary">{{ $user->role }}</span>
                                    @else
                                        <span class="badge badge-pill badge-warning">{{ $user->role }}</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                        </tbody>
                    @endforeach
                </table>

                {{ $users->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('js_after')

@endpush
