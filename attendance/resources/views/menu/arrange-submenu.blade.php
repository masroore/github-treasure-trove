@extends('layouts.main')


@section('title')
Arrange - Sub Menus
@endsection

@section('mtitle')
Arrange - Sub Menus
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
				<h3 class="box-title">Arrange Sub Menus</h3>
			</div>
			<div class="box-body">
				<form method="post" action="{{route('arrange-submenu-save')}}">
					@csrf

					<?php
						$id = $data->id;

						$submenu = App\SubMenu::orderBy('order','asc')->where('menu_id',$id)->get();
					?>
					<div class="form-group  @error('menu') has-error @enderror">
						
						<label class="control-label" for="inputError">{{$data->title}}</label>
					</div>

					@foreach ($submenu as $menu)
						<div class="form-group  @error('menu') has-error @enderror">
						<input type="hidden" name="hiddenid[]" value="{{$menu->id}}">
						<label class="control-label" for="inputError">{{$menu->sub_menu}}</label>
						<input type="number" class="form-control" name="order[]" id="inputError" value="{{$menu->order}}" placeholder="Enter ...">
						<span class="help-block">@error('menu') {{ $message }} @enderror</span>
					</div>
					@endforeach
					<hr>
										
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
