<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <form action="{{route('push.store')}}">
                    @csrf
                    <div class="form-group">
                        <label for="endpoint">endpoint</label>
                        <input type="text" name="endpoint">
                    </div>
                    <div class="form-group">
                        <label for="keys.auth">keys.auth</label>
                        <input type="text" name="keys[auth]">
                    </div>
                    <div class="form-group">
                        <label for="keys.p256dh">keys.p256dh</label>
{{--                        BExXEJWpUrt0GW0yx-TV1xg1BR86FupndNZ5rmxnWcUvjjf-WTMqbD6-Nlt2NYB5WULglG7IwE1_MCjfimRShl4--}}
                        <input type="text" name="keys[p256dh]">
                    </div>
                    <button type="submit">
                        Send
                    </button>
                </form>

                <a href="{{route('pusher')}}" class="btn btn-outline-primary btn-block">Make a Push Notification!</a>


                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>

</html>

<!-- The core Firebase JS SDK is always required and must be listed first -->
{{--<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>--}}

{{--<!-- TODO: Add SDKs for Firebase products that you want to use--}}
{{--     https://firebase.google.com/docs/web/setup#available-libraries -->--}}

{{--<script>--}}
{{--    // Your web app's Firebase configuration--}}
{{--    var firebaseConfig = {--}}
{{--        apiKey: "AIzaSyBKUo8IlamThBrb1bBZiPD3l1CJzjAKI9c",--}}
{{--        authDomain: "cargasm-faff7.firebaseapp.com",--}}
{{--        projectId: "cargasm-faff7",--}}
{{--        storageBucket: "cargasm-faff7.appspot.com",--}}
{{--        messagingSenderId: "54927897260",--}}
{{--        appId: "1:54927897260:web:d62ab90e871dbd6cdde509"--}}
{{--    };--}}
{{--    // Initialize Firebase--}}
{{--    firebase.initializeApp(firebaseConfig);--}}
{{--</script>--}}
