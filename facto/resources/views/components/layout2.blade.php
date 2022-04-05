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
	
	<link rel="stylesheet" href="/css/main.css?v={{ now()}}">
	
	
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
	<script src="https://unpkg.com/vue-cookies@1.5.12/vue-cookies.js"></script>

	
	{{-- <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js"></script>
	<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine-ie11.min.js" defer></script> --}}


	@livewireStyles
	@notifyCss

	
</head>

<body class=" ">
	<div id="app" class="mx-auto min-h-screen  sm:max-w-6xl " v-cloak>
		@include('parts.header')
		@include('upsos.partials.flash-message')

		
        {{ $slot }}
	</div>

	@livewireScripts

	
	<script src="/js/main.js?1116"></script>

	@notifyJs
	@include('parts.footer')



    
    <script type="text/javascript">
        window.onscroll = function(ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.livewire.emit('load-more');
            }
        };
    </script>
	
	
</body>

</html>