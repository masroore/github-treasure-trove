@extends('layouts.main')


@section('title')
Add - Menu
@endsection

@section('mtitle')
Add - Menu
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div>
	
	<a href="{{ route('arrange-menu') }}" class="btn btn-success pull-right mr-3">
		<i class="fa fa-plus">Arrange Menu</i>
	</a>

	<a href="{{ route('add-permission') }}" class="btn btn-info pull-right mr-3">
		<i class="fa fa-plus">Add Submenu | Permissions</i>
	</a>

</div>
	<div class="clearfix"></div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Add Menu</h3>
			</div>
			<div class="box-body">
				<form method="post" action="{{route('save-menu')}}">
					@csrf
					<div class="form-group  @error('menu') has-error @enderror">
						<label class="control-label" for="inputError">Menu Title</label>
						<input type="text" class="form-control" name="menu" id="inputError" placeholder="Enter ...">
						<span class="help-block">@error('menu') {{ $message }} @enderror</span>
					</div>

					<div class="form-group  @error('menuorder') has-error @enderror">
						<label class="control-label" for="inputError">Menu Order</label>
						<input type="number" class="form-control" name="menuorder" id="inputError" placeholder="Enter ...">
						<span class="help-block">@error('menuorder') {{ $message }} @enderror</span>
					</div>

					<input type="submit" name="submit" value="Save" class="btn btn-success">
				</form> 

			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-striped" id="example1">
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Order</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $row)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{$row->title}}</td>
							<td>{{$row->order}}</td>
							<td>
							<a href="{{ route('edit-menu',['id' => $row->id]) }}" class="btn btn-info"><i class='fa fa-pencil-square-o'></i>Edit</a>

							<a href="{{ route('delete-menu',['id' => $row->id]) }}" onclick="return confirm('Are You Sure ?')" class="btn btn-danger"><i class='fa fa-trash'></i>Delete</a>
						
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>                  
</div>
@endsection




@section('script')

<script type="text/javascript">
	$('document').ready(function(){

	});

</script>


@endsection
