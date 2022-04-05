@extends('layouts.main')

@section('title')
{!! Lang::get('vault.folder.name' , ['name' => $folder->name]) !!} | {{ $vault->name }}
@endsection

@section('css')
<style>



</style>
@endsection

@section('content')
@include('main.vaults.select.partials.add-to-folder')
@include('main.vaults.select.partials.remove-from-folder')
@include('main.vaults.select.partials.quick-view')
@include('main.vault.folders.partials.add-site')
@include('main.vault.folders.partials.delete-folder')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('vaults.select', $vault) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{!! Lang::get('vault.folder.name' , ['name' => $folder->name]) !!}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
            <div class="breadcrumb-item">{!! Lang::get('vault.folder.name' , ['name' => $folder->name]) !!}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-3">
                <h2 class="section-title">{{ __('vault.quick_links') }}</h2>
                <button class="btn btn-icon btn-3 btn-success btn-block" type="button" data-toggle="modal" data-target="#add-site">
                    <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                    <span class="btn-inner--text">{{ __('vault.add_new_site') }}</span>
                </button>
                <hr>
                <h2 class="section-title">{{ __('vault.folder.current') }}</h2>
                <div class="pb-5">
                    <span>
                        <a class="btn btn-dark btn-block btn-icon icon-left text-white" data-toggle="tooltip" data-placement="left" title="{{ __('vault.folder.current') }}">
                            <i class="fa fa-{{ $folder->icon }}"></i>&nbsp;&nbsp;&nbsp;{{ $folder->name }}
                            <span class="badge badge-transparent">{{ $folder->sites()->count() }}</span>
                        </a>
                    </span>
                </div>
                <hr>
                <h2 class="section-title">{{ __('snippets.actions') }}</h2>
                <button class="btn btn-icon btn-3 btn-danger btn-block" type="button" data-toggle="modal" data-target="#delete-folder">
                    <span class="btn-inner--icon"><i class="fas fa-trash-alt"></i></span>
                    <span class="btn-inner--text">{{ __('vault.folder.delete') }}</span>
                </button>
            </div>
            <div class="col-md-9">
                <div class="row mt-4">
                    <div class="col-md-12">
                        {!! laraflash()->render() !!}
                        @include('partials.errors')
                    </div>
                    @if($sites->count() == 0)
                    <div class="col-md-6">
                        <div class="card card-primary pull-up">
                            <div class="card-header">
                                <h4>
                                    Add a site to this folder to get started.
                                </h4>
                            </div>
                        </div>
                    </div>
                    @endif
                    @foreach($sites as $site)
                    @include('main.vault.folders.partials.sites')
                    @endforeach
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
            $(e.trigger).text("Copied!");
            e.clearSelection();
            setTimeout(function() {
                $(e.trigger).text("Copy");
            }, 2500);
        });
    });

    $(document).ready(function() {
        $('.random').click(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/rng',
                type: "POST",
                data: '',
                success: function(data) {
                    document.getElementById("new_login_password").value = data.random;
                }
            });
        });
    });
</script>
@endsection