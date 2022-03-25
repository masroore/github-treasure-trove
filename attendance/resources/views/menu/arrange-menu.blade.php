@extends('layouts.main')


@section('title')
Arrange - Menu
@endsection

@section('mtitle')
Arrange - Menu
@endsection


@section('mtitlesub')

@endsection



@section('main_content')
<div class="col-md-4">
	
	<a href="{{ route('add-menu') }}" class="btn btn-success pull-right mr-3">
		<i class="fa fa-plus">Add Menu</i>
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
				<h3 class="box-title">Arrange Menu</h3>
			</div>
			<div class="box-body">
				<form method="post" action="{{route('arrange-menu-save')}}">
					@csrf

					@foreach ($data as $row)
					<div class="form-group  @error('menu') has-error @enderror">
						<input type="hidden" name="hiddenid[]" value="{{$row->id}}">
						<label class="control-label" for="inputError">{{$row->title}}</label>
						<input type="number" class="form-control" name="order[]" id="inputError" value="{{$row->order}}" placeholder="Enter ...">
						<span class="help-block">@error('menu') {{ $message }} @enderror</span>
					</div>
					@endforeach
										
					<input type="submit" name="submit" value="Save" class="btn btn-success">
				</form> 

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
