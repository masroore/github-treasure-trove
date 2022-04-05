<html>
	<head>
	    <style>
	    	.imgpdf{padding: 10px;}
			.textpdf{font-family: arial, sans-serif; font-size: 12px;}
			.textpdf h1{text-align:center;font-size: 30px;}
			.textpdf th.title, .title{border: none;padding: 20px;background: tranparent; color: #f36d17;font-size: 20px;text-align: center;font-weight: 700}
			.textpdf th,.box-big th{border-bottom: 1px solid #ddd;background:#eeeeee ;padding: 5px 0;}
			.textpdf td{padding: 7px 0;}
			.textpdf tr:nth-child(even){background: rgba(0,0,0,.03);}
			.textpdf table.border td{border-right:1px solid #ddd;padding: 5px;font-size: .6rem}
			.textpdf table.border td:nth-child(10){border:0px;}

			.box-big th.title{border: none;padding: 20px;background: tranparent; color: #f36d17;font-size: 20px;font-family: arial, sans-serif; }
			.box-little {
			    width: 700px;
			    height: 100px;
			    background: #fff;
			    margin: 0 12px 5px 0;
			    border: 1px solid #ddd;
			    overflow: hidden;
			    border-radius: 3px;
			    font-size: .7rem;
			    position: relative;
			    font-family: arial, sans-serif; 
			}
			.box-medium {
				background: #f1f1f1;
			    width: 700px;
			    height: 30px;
			    padding: 0 5px;
			    
			    overflow: hidden;
			    text-align: center;
			    margin: 0px;
			}
			span.box-micro {
				width: auto;
				height: 60px;
			    padding: 10px 30px;
			    text-align: center;
			}
			.box-title{
		
			}
	    </style>
	</head>
	<body>
		<div class="imgpdf">
			<img src="img/login.png" width="200">
		</div>
		<div class="fecha"></div>
		<main>
			<div class="textpdf">
				<h1>{{__('POS Shipment')}}</h1>
				<strong>{{ __('Applicant Department:') }}</strong> {{ $data['name_storage'] }}<br>
				<strong>{{ __('Recipient Department:') }}</strong> {{ $data['name_storage_request'] }}<br>
				<strong>{{ __('Applicant:') }}</strong> {{ $data['name_user'] }}<br>
				<strong>{{ __('Date:') }}</strong> {{ show_full_date($data['date_register']) }}<br>
				<strong>{{ __('Delivery number:') }}</strong> {{ FullSerial($data['delivery_number']) }}<br>
				<br>
				<table width="100%" >
					<tr>
						<th colspan="3" class="title">{{ __('POS Requested') }}</th>
					</tr>
					<tr>
						<th >{{__('Model Request')}}</th>
						<th >{{__('Amount Request')}}</th>
						<th >{{__('Amount Send')}}</th>
					</tr>
					@foreach($data['quantity'] as $value)
					<tr>
						<td align="center" >{{$value['model_request']}}</td>
						<td align="center" >{{$value['quantity_request']}}</td>
						<td align="center" >{{$value['quantity_send']}}</td>
					</tr>
					@endforeach
				</table>
			<br>
				<div class="title">{{ __('Amount Box') }}</div>
					@if(array_key_exists("AMP 3000", $boxes))
						@foreach($boxes['AMP 3000'] as $value)
							<table width="100%" class="border">
								<tr>
									<th colspan="10">
										AMP 3000 Caja N°: {{$value[0]['box_number']}}	
									</th>
								</tr>
								<tr>
									@foreach($value as $pos_value)
									<td>
											{{$pos_value['serial']}}
									</td>
									@endforeach
								</tr>	
							</table>		
							<br>
						@endforeach
					@endif					
					@if(array_key_exists("AMP 7000", $boxes))
						@foreach($boxes['AMP 7000'] as $value)
							<table width="100%" class="border">
								<tr>
									<th colspan="10">
										AMP 7000 Caja N°: {{$value[0]['box_number']}}	
									</th>
								</tr>
								<tr>
									@foreach($value as $pos_value)
									<td>
											{{$pos_value['serial']}}
									</td>
									@endforeach
								</tr>	
							</table>		
							<br>
						@endforeach
					@endif					
					@if(array_key_exists("AMP 8000", $boxes))
						@foreach($boxes['AMP 8000'] as $value)
							<table width="100%" class="border">
								<tr>
									<th colspan="10">
										AMP 8000 Caja N°: {{$value[0]['box_number']}}	
									</th>
								</tr>
								<tr>
									@foreach($value as $pos_value)
									<td>
											{{$pos_value['serial']}}
									</td>
									@endforeach
								</tr>	
							</table>		
							<br>
						@endforeach
					@endif					
					@if(array_key_exists("AMP 9000", $boxes))
						@foreach($boxes['AMP 9000'] as $value)
							<table width="100%" class="border">
								<tr>
									<th colspan="10">
										AMP 9000 Caja N°: {{$value[0]['box_number']}}	
									</th>
								</tr>
								<tr>
									@foreach($value as $pos_value)
									<td>
											{{$pos_value['serial']}}
									</td>
									@endforeach
								</tr>	
							</table>		
							<br>
						@endforeach
					@endif
			</div>
		</main>
	</body>
</html>
