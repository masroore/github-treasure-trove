<!doctype html>
<html lang="ko">

<head>

	<!-- Global site tag (gtag.js) - Google Analytics -->

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

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
	

	<link rel="shortcut icon" href="yagong.ico" type="image/x-icon">
	{{-- <link rel="icon" href="yagong.ico" type="image/x-icon"> --}}


	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149705821-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-149705821-2');
</script>

	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:400,500,700,900&display=swap&subset=korean"
		rel="stylesheet">
	<link href="/vendor/tailwind.min.css" rel="stylesheet">
	<link href="/vendor/custom-forms.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/main.css?v=1237">

	{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
	<script src="https://unpkg.com/vue-cookies@1.5.12/vue-cookies.js"></script> --}}

	<script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js" defer></script>
	<script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine-ie11.min.js" defer></script>

	<script src="https://unpkg.com/vue-cookies@1.5.12/vue-cookies.js"></script>
	<script src="/js/common.js?v=1"></script>
	
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

<body class="">

	
	<div id="app" class="mx-auto  sm:max-w-6xl " >

		@include('parts.header')

		@if( isset( $cat) || ( isset( $post ) && isset( $post->cat) ) )
		<div class=" sm:hidden ">
			<div class="flex ml-2">
				<div class="border-b-2 border-teal-600 my-1 pb-1 font-semibold ">
					@if ( isset( $cat) )
					{{ $cat->title  }}

					@elseif( isset( $post ) && isset( $post->cat) )
					{{$post->cat->title }}
					@endif
				</div>
				<div class=" flex-grow border-b border-gray-400 my-1 pb-1 font-semibold "> </div>
			</div>

		</div>
		@endif


		@if( isset( $cat) || ( isset( $post ) && isset( $post->cat) ) )
		<div class="hidden sm:block sm:flex sm:items-end sm:content-end justify-between p-2 m-1 w-full">
			<div class="border-b-2 border-red-500 text-lg font-medium">
				@if ( isset( $cat) )
				{{ $cat->title  }}

				@elseif( isset( $post ) && isset( $post->cat) )
				{{$post->cat->title }}
				@endif
			</div>
			<div class="flex-grow  border-b border-gray-400 flex justify-end items-center  text-right  align-baseline ">
				<svg class="hidden sm:block w-3 h-3 fill-current text-gray-700 " xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 20 20">
					<path d="M8 20H3V10H0L10 0l10 10h-3v10h-5v-6H8v6z" />
				</svg>
				<span class="hidden sm:block  text-xs text-gray-700 px-2">
					홈 >
					@if ( isset( $cat) )
					{{ $cat->title  }}

					@elseif( isset( $post ) && isset( $post->cat) )
					{{$post->cat->title }}
					@endif
					>
					@if ( isset( $cat) )
					{{ $cat->title  }}

					@elseif( isset( $post ) && isset( $post->cat) )
					{{$post->cat->title }}
					@endif
				</span>
			</div>
		</div>
		@endif
		@yield('content')
	</div>

	{{-- <div class="m-32 ">
	</div> --}}

	{{-- <script src="/js/main.js?199"></script> --}}
	{{-- @include('recapcha.recapcha-inside') --}}
	@include('parts.footer')
</body>
</html>