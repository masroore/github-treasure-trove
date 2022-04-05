@extends('layouts.main')

@section('title')
{{ __('dashboard.my_dashboard') }}
@endsection

@section('css')
<style>
  .text-muted {
    color: #8898aa !important;
  }

  .text-uppercase {
    text-transform: uppercase !important;
  }

  .mb-0,
  .my-0 {
    margin-bottom: 0 !important;
  }

  .rpg {
    font-size: 2em;
  }
</style>
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ __('dashboard.my_dashboard') }}</h1>
  </div>
  @include('partials.errors')
  {!! laraflash()->render() !!}
  @include('main.partials.marked-for-deletion')
  @include('main.partials.hero')
  @include('main.partials.tfa-alert')
  @include('main.partials.no-vault-alert')
  @include('main.dashboard.partials.stats')
  <div class="section-body">
    <div class="row">
      @include('main.dashboard.partials.announcements')
      @include('main.dashboard.partials.rpg')
      @include('main.dashboard.partials.side-cards')
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('assets/js/modules/clipboard.min.js') }}"></script>
<script type="text/javascript">
  function startTime() {
    var today = new Date(),
      curr_hour = today.getHours(),
      curr_min = today.getMinutes(),
      curr_sec = today.getSeconds();
    curr_hour = checkTime(curr_hour);
    curr_min = checkTime(curr_min);
    curr_sec = checkTime(curr_sec);
    document.getElementById('clock').innerHTML = curr_hour + ":" + curr_min + ":" + curr_sec;
  }

  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }
  setInterval(startTime, 500);

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
<script src="{{ asset('assets/js/modules/moment-timezone-with-data-2012-2022.min.js') }}"></script>
<script>
  $(function() {
    // guess user timezone
    $('#tz').val(moment.tz.guess())
  })
</script>
@endsection
