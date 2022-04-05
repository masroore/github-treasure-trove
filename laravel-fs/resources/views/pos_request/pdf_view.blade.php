<html>
	<head>
	    <style>
	    	.imgpdf{padding: 10px;}
			.textpdf{font-family: arial, sans-serif; font-size: 12px;}
			.textpdf h1{text-align:center;font-size: 30px;}
			.textpdf th.title{border: none;padding: 20px;background: tranparent; color: #f36d17;font-size: 20px;}
			.textpdf th{border-bottom: 1px solid #ddd;background:#eeeeee ;padding: 5px 0;}
			.textpdf td{padding: 7px 0;}
			.textpdf tr:nth-child(even){background: rgba(0,0,0,.03);}

	    </style>
	</head>
	<body>
		<div class="imgpdf">
			<img src="img/login.png" alt=“img” width="200">
		</div>
		<div class="fecha"></div>
		<main>
			<div class="textpdf">
				<h1>{{__('POS Request')}}</h1>
				<strong>Departamento:</strong> {{$data['get_storage']['name_storage']}}<br>
				<strong>Departamento Solicitado:</strong> {{$data['get_storage_request']['name_storage']}}<br>
				<strong>Solicitante:</strong> {{$data['get_user']['name_user'].' '.$data['get_user']['surname_user']}}<br>
				<strong>Fecha:</strong> {{show_full_date($data['date_register'])}}<br>
				<strong>Numero de Soicitud:</strong> {{FullSerial($data['id'])}}<br>
				<br>
				<table width="100%" >
					<tr>
						<th scope='col' colspan="2" class="title">POS Solicitados</th>
					</tr>
					<tr>
						<th scope='col' >{{__('Models')}}</th>
						<th scope='col' >{{__('Quantity')}}</th>
					</tr>
					@foreach($data['get_details'] as $value)
					<tr>
						<td align="center" >{{$value['model']}}</td>
						<td align="center" >{{$value['quantity']}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</main>

	<footer>

	</footer> 
	</body>
</html>