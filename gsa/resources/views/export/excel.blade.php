<html>
<head>
	<title>SIGIS</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Sigis.xls");
	?>
 
	<table border="1">
		<tr>
			@foreach($data_table as $dt)
				@if($dt->column_name !== "geom")
					<th> {{ $dt->column_name }}</th>
				@endif
			@endforeach
		</tr>
		@foreach($map as $m)
		<tr>
			@foreach($data_table as $dt)
			<?php $column_name = $dt->column_name; ?>
			@if($dt->column_name !== "geom")
				<td>{{ $m->$column_name }}</td>
			@endif
			@endforeach
		</tr>
		@endforeach
	</table>
</body>
</html>