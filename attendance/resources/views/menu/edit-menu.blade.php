@extends('layouts.main')


@section('title')
Edit - Menu
@endsection

@section('mtitle')
Edit - Menu
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Edit Menu</h3>
			</div>
			<div class="box-body">
				<form method="post" action="{{route('save-menu')}}">
					@csrf
					<input type="hidden" name="hiddenid" id="hiddenid" class="form-control" value="{{$data->id}}">
					
					<div class="form-group  @error('menu') has-error @enderror">
						<label class="control-label" for="inputError">Menu Title</label>
						<input type="text" class="form-control" name="menu" id="inputError" value="{{$data->title}}" placeholder="Enter ...">
						<span class="help-block">@error('menu') {{ $message }} @enderror</span>
					</div>

					<div class="form-group  @error('menuorder') has-error @enderror">
						<label class="control-label" for="inputError">Menu Order</label>
						<input type="text" value="{{$data->order}}" class="form-control" name="menuorder" id="inputError" placeholder="Enter ...">
						<span class="help-block">@error('menuorder') {{ $message }} @enderror</span>
					</div>

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
