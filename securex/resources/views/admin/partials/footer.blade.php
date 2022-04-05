<div class="footer-left">
  {!! Setting::get('copyright_footer') !!}
</div>
@if(setting()->get('display_version') == "true")
<div class="footer-right">
  {{ setting()->get('app_version') }}
</div>
@endif