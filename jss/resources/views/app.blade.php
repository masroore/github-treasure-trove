<!DOCTYPE html>
<html lang="cn">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ env('APP_NAME') }}</title>
		<link href="/assets/css/bootstrap.min.css?v=20211006104500" rel="stylesheet" />
		<link rel="stylesheet" href="{{ cAsset('assets/css/font-awesome.min.css') }}" />
		<link rel="icon" type="image/png" href="{{ cAsset('/assets/css/img/logo.png') }}" sizes="192x192">
		<link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />


		<link rel="stylesheet" href="{{ cAsset('assets/css/ace.min.css') }}" />
		<link rel="stylesheet" href="{{ cAsset('assets/css/theme.css?v=20211006104500') }}" />
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	</head>
	<body>
		@yield('content')
	</body>
</html>