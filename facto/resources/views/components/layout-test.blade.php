<!doctype html>
<html lang="ko">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	@php
		$host = parse_url( request()->fullUrl())['host'] ;
	@endphp
	@if( ! Str::contains( $host, '.test'))
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
	@endif

	<meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	
	<meta name="title" content="야동공장" />
	<meta name="publisher" content="야동공장" />
	<meta name="author" content="야동공장" />
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="야동공장" />
	<meta name="description" content="야동공장" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta property="og:title" content="야동공장" />
	<meta property="og:site_name" content="야동공장" />
	<meta property="og:author" content="야동공장" />
	<meta property="og:type" content="" />
	<meta property="og:description" content="야동공장" />
	<meta property="og:url" content="/" />
	<link rel="canonical" href="/" />
	<title>{{ env('APP_NAME')}}</title>

	
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149705821-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-149705821-2');
    </script>

	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:400,500,700,900&display=swap&subset=korean"
		rel="stylesheet">
	{{-- <link href="/vendor/tailwind.min.css" rel="stylesheet"> --}}
	<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
	{{-- <link href="/vendor/custom-forms.min.css" rel="stylesheet"> --}}
	{{-- <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/custom-forms@0.2.1/src/index.min.js" rel="stylesheet"> --}}
	
	<link rel="stylesheet" href="/css/main.css?v=1242">
	
	
	{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script> --}}
	{{-- <script src="https://unpkg.com/vue-cookies@1.5.12/vue-cookies.js"></script> --}}


	<script src="https://unpkg.com/vue-cookies@1.5.12/vue-cookies.js"></script>

	<script src="/js/common.js?v=1"></script>

	@livewireStyles
	@notifyCss
	<style>
		[x-cloak] { display: none; }
		.text-xx {
			font-size: 0.625rem;
		}
		.text-xxx {
			font-size: 0.5rem;
		}
	</style>

</head>

<body class=" ">
	<div id="app2" class="mx-auto min-h-screen  sm:max-w-6xl ">
		{{-- @include('parts.header') --}}
		@include('upsos.partials.flash-message')

        {{ $slot }}
	</div>

	@livewireScripts

	
	{{-- <script src="/js/main.js?v={{ date('H:i:s') }}"></script> --}}

	@notifyJs
	@include('parts.footer')

	<script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js" defer></script>
	<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine-ie11.min.js" defer></script>

	

    <script type="text/javascript">
		var _is_doing = false;
        window.onscroll = function(ev) {
			
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200 ) {
				if( window._is_doing == false ){
					window._is_doing = true;
					setTimeout( function(){
						window.livewire.emit('load-more');
					}, 200)

					setTimeout( function(){
						window._is_doing = false;
					}, 1000)
					
				}
                
            }
        };

    </script>
	
	
</body>

</html>
