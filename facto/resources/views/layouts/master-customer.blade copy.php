<!doctype html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
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

	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:400,500,700,900&display=swap&subset=korean" rel="stylesheet">
	<link href="/vendor/tailwind.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/main.css">
	
	{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script> --}}


	<script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js" defer></script>
	<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine-ie11.min.js" defer></script>

	<style>
		[x-cloak] { display: none; }

		.text-xx {
			font-size: 0.625rem;
		}
		.text-xxx {
			font-size: 0.5rem;
		}
	</style>
	@livewireStyles
	
</head>
<body class="">
		<div id="app" class="  mx-auto container">

		{{-- @include('parts.header') --}}
		
		
		@yield('content')
	</div>
	
	{{-- <script src="/js/main.js"></script> --}}

	@livewireScripts

	@include('parts.footer')
</body>
</html>