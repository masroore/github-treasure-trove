@extends('layouts.master')

@section('content')
    <script type="text/javascript">
    var verifyCallback = function(response) {
      // alert(response);
    };
    var onloadCallback = function() {
      grecaptcha.render('example3', {
        'sitekey' : '6Leqxq0aAAAAAIekzg2V5TKZgbXn8jBRsdgHQMuh',
        'callback' : verifyCallback,
        'theme' : 'dark'
      });
    };
  </script>

  <div class="w-full min-h-screen ">
    <div class="my-24 flex items-center justify-center ">

      <div class="` flex flex-col items-center justify-start space-y-6">
        {!! ($errors->has('g-recaptcha-response') ? '<p class="text-red-700 font-semibold">'.$errors->first('g-recaptcha-response').'</p>' : '') !!}
        <form action="recaptcha" method="POST">
          @csrf
          <div id="example3"></div>
          <div class=" mt-6 flex items-center justify-center">
            <input type="submit" value="확인" class="bg-indigo-700 text-white font-semibold px-6 py-2">
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

@endsection
