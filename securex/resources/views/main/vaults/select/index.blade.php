@extends('layouts.main')

@section('title')
{{ $vault->name }}
@endsection

@section('css')
<style>



</style>
@endsection

@section('content')
@include('main.vaults.select.partials.add-site')
@include('main.vaults.select.partials.create-folder')
@include('main.vaults.select.partials.add-to-folder')
@include('main.vaults.select.partials.remove-from-folder')
@include('main.vaults.select.partials.quick-view')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('vaults') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>{{ $vault->name }}</h1>
    <div class="section-header-button">
      <a href="{{ route('vaults.select.settings',$vault) }}" class="btn btn-warning"><i class="fas fa-cogs"></i> {{ __('vault.settings') }}</a>
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
      <div class="breadcrumb-item">{{ $vault->name }}</div>
    </div>
  </div>
  @include('main.vaults.select.partials.stats')
  <div class="section-body">
    <div class="row">
      <div class="col-md-3">
        <h2 class="section-title">{{ __('vault.quick_links') }}</h2>
        <button class="btn btn-icon btn-3 btn-success btn-block" type="button" data-toggle="modal" data-target="#add-site">
          <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
          <span class="btn-inner--text">{{ __('vault.add_new_site') }}</span>
        </button>
        <button class="btn btn-icon btn-3 btn-info btn-block" type="button" data-toggle="modal" data-target="#create-folder">
          <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
          <span class="btn-inner--text">{{ __('vault.create_new_folder') }}</span>
        </button>
        <hr>
        <h2 class="section-title">{{ __('vault.folders') }}</h2>
        @include('main.vaults.select.partials.folders')
      </div>
      <div class="col-md-9">
        <div class="row mt-4">
          <div class="col-md-12">
            {!! laraflash()->render() !!}
            @include('partials.errors')
          </div>
          @if($sites->count() == 0)
          <div class="col-md-6">
            <div class="card card-warning pull-up">
              <div class="card-header">
                <h4 class="text-warning">
                  No sites to show here. Add a new site to get started.
                </h4>
              </div>
            </div>
          </div>
          @endif
          @foreach($sites as $site)
          @include('main.vaults.select.partials.sites')
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
          notyf.open({
              type: 'success',
              message: 'Copied ' + e.text + ' to clipboard'
          });
          e.clearSelection();
      });
  });
</script>
@endsection