@extends('layouts.main')

@section('title')
{{ $site->name }}
@endsection

@section('content')
@include('main.vault.sites.partials.delete')
@include('main.vault.sites.partials.move')
<section class="section">
    <div class="section-header">
        @if($site->folder->count())
        <a href="{{ route('vault.folder.show', [$vault, $site->folder[0]]) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        <h1>{{ $site->name }} | {{ $site->folder[0]->name }} | {{ $site->vault->name }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults.select', $vault) }}">{{ $vault->name }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vault.folder.show', [$vault, $site->folder[0]]) }}">{{ $site->folder[0]->name }}</a></div>
            <div class="breadcrumb-item">{{ $site->name }}</div>
        </div>
        @else
        <a href="{{ route('vaults.select', $vault) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        <h1>{{ $site->name }} | {{ $site->vault->name }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults.select', $vault) }}">{{ $vault->name }}</a></div>
            <div class="breadcrumb-item">{{ $site->name }}</div>
        </div>
        @endif
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xl-6">
                {!! laraflash()->render() !!}
                @include('partials.errors')
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="col-7">
                            <h4>
                                {{ __('site.details') }}
                                @if($site->is_fav)
                                <i class="fas fa-heart text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Favorited"></i>
                                @endif
                            </h4>
                        </div>
                        <div class="col-5 text-right">
                            <a class="btn btn-primary text-white" onClick="showNotes()" role="button" aria-expanded="false">
                                <i class="fas fa-eye"></i> <span id="showNotesBtn">Show Notes</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4 mt-4">
                            <div class="form-group row align-items-center">
                                <label for="link" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_link') }}</b></label>
                                <div class="col-md-9 col-sm-4"> 
                                    <div class="input-group align-items-center">
                                        <span class="form-control bg-gray" id="link">
                                            <a href="https://{{ $site->getLinkWithoutProtocol() }}" target="_blank" class="text-decoration-none text-dark"><b>{{ $site->link }}</b></a>
                                        </span>
                                        <span class="input-group-button">
                                            <button class="btn btn-clippy" name="btn" id="btn" type="button" data-clipboard-target="#link" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                                                <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="login_id" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.login_id') }}</b></label>
                                <div class="col-md-9 col-sm-4">
                                    <div class="input-group align-items-center">
                                        <span class="form-control bg-gray" id="login_id">{{ $site->login_id }}</span>
                                        <span class="input-group-button">
                                            <button class="btn btn-clippy" name="btn" id="btn" type="button" data-clipboard-target="#login_id" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                                                <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="login_password" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.login_pass') }}</b></label>
                                <div class="col-md-9 col-sm-4">
                                    <div class="input-group align-items-center">
                                        <span class="form-control bg-gray" id="login_password">{{ $site->login_password }}</span>
                                        <span class="input-group-button">
                                            <button class="btn btn-clippy" name="btn" id="btn" type="button" data-clipboard-target="#login_password" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                                                <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if(! $site->folder->isEmpty())
                            <div class="form-group row align-items-center">
                                <label for="folder" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.folder_name') }}</b></label>
                                <div class="col-md-9 col-sm-4">
                                    <div class="input-group align-items-center">
                                        <span class="form-control bg-gray" id="folder">{{ $site->folder[0]->name }}</span>
                                        <span class="input-group-button">
                                            <form method="POST" action="{{ route('vault.folder.removeFromFolder', [$vault,$site]) }}">
                                                @csrf
                                                <button type="submit" name="btn" id="btn" class="btn btn-outline-danger ml-1" data-toggle="tooltip" data-placement="top" title="Remove from Folder"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group row align-items-center">
                                <label for="additional_info" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_add_info') }}</b></label>
                                <div class="col-md-9 col-sm-4">
                                    <textarea type="text" class="form-control" id="additional_info" placeholder="{{ __('site.no_add_info') }}" readonly>{{ $site->additional_info }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row text-center">
                                <div class="col-lg-4 col-sm-12">
                                    <a href="{{ route('vault.site.edit', [$vault,$site]) }}" class="btn btn-warning btn-icon my-4">
                                        <i class="fas fa-edit"></i> {{ __('site.edit') }}
                                    </a>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <button type="submit" data-toggle="modal" data-target="#move-site" class="btn btn-outline-primary btn-icon my-4">
                                        <i class="fas fa-people-carry"></i> {{ __('site.move') }}</button>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <button type="submit" data-toggle="modal" data-target="#delete-site" class="btn btn-danger btn-icon my-4">
                                        <i class="fas fa-window-close"></i> {{ __('site.delete') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <span>{!! Lang::get('site.created', ['created_at' => $site->created_at, 'updated_at' => $site->updated_at]) !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="customFields" style="display: block;">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="col-8">
                            <h4>{{ __('site.custom_fields') }}</h4>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4 mt-4">
                            @livewire('vault.site.custom-fields', ['site' => $site])
                        </div>
                        @livewire('vault.site.add-custom-field', ['site' => $site])
                    </div>
                    <div class="card-footer bg-white text-center">
                        <span>{!! Lang::get('site.custom_fields_sub') !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="notes" style="display: none;">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-dark border-0">
                        <div class="col-8">
                            <h4 class="text-white">{{ __('site.notes') }}</h4>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4 mt-4">
                            @livewire('vault.site.notes', ['site' => $site])
                        </div>
                        @livewire('vault.site.add-note', ['site' => $site])
                    </div>
                    <div class="card-footer bg-white text-center">
                        <span>{!! Lang::get('site.notes_sub') !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/clipboard.min.js') }}"></script>

<script type="text/javascript">
    // Clipboard
    var clipboard = new ClipboardJS('.btn');

    $(document).ready(function() {
        clipboard.on('success', function(e) {
            notyf.open({
                type: 'success',
                message: 'Copied ' + e.text + ' to clipboard'
            });
            e.clearSelection();
        });
    });

    function showNotes() {
        $(document).ready(function() {
            var x = document.getElementById("customFields");
            var y = document.getElementById('notes');

            if (x.style.display === "none" && y.style.display === 'block') {
                x.style.display = "block";
                y.style.display = "none";
                document.getElementById("showNotesBtn").innerHTML = "Show Notes";
            } else {
                x.style.display = "none";
                y.style.display = "block";
                document.getElementById("showNotesBtn").innerHTML = "Show Custom Fields";
            }
        });
    }
</script>
@endsection