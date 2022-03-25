@extends('layouts.main')


@section('title')
Add - Permission
@endsection

@section('mtitle')
Add - Permission
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div>
	
	<a href="{{ route('arrange-menu') }}" class="btn btn-success pull-right mr-3">
		<i class="fa fa-plus">Arrange Menu</i>
	</a>

	

	<a href="{{ route('add-menu') }}" class="btn btn-info pull-right mr-3">
		<i class="fa fa-plus">Add Menu</i>
	</a>

</div>
	<div class="clearfix"></div>

	<div class="row">
		<div class="col-md-3">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add Permission</h3>
				</div>
				<div class="box-body">
					<form method="post" action="{{route('save-permission')}}" autocomplete="off">
						@csrf

						<div class="form-group  @error('menu') has-error @enderror">
							<label class="control-label" for="inputError">Select Menu</label>
							<select name="menu" id="menu" class="form-control" required="required">
								<option value=""></option>
								@foreach ($data as $row)
								<option value="{{$row->id}}">{{$row->title}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<i class="fa fa-plus btn btn-info pull-right" id="addmore"></i>
						</div>

						<div class="clearfix"></div>

						<div class="form-group  @error('submenu') has-error @enderror">
							<label class="control-label" for="inputError">
								SubMenu Title
							</label>
							<input type="text" class="form-control" name="submenu[]" id="submenu" value="{{old('submenu')}}" placeholder="Enter ..." required>
							<span class="help-block">@error('submenu') {{ $message }} @enderror</span>
						</div>

						<div class="form-group  @error('menuorder') has-error @enderror">
							<label class="control-label" for="inputError">Menu Order</label>
							<input type="number" class="form-control" name="menuorder[]" id="inputError" placeholder="Enter ..." required>
							<span class="help-block">@error('menuorder') {{ $message }} @enderror</span>
						</div>

						<div id="appendhere"></div>

						<input type="submit" name="submit" value="Save" class="btn btn-success">
					</form> 

				</div>
			</div>
		</div>

		
		<div class="col-md-9">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Menu | Permissions</h3>
				</div>
				<div class="box-body">
					<form method="post" action="{{ route('save-permission-role') }}">
						@csrf
						@foreach($data as $row)
						
						<?php
						$id = $row->id;

						$submenu = App\SubMenu::orderBy('order','asc')->where('menu_id',$id)->get();

						$submenuper = App\Menupermission::where('menu_id',$id)->first();


						$subpermission = Spatie\Permission\Models\Permission::where('id', $submenuper->permission_id ?? 0)->first();

							//dd($subpermission);

						?>
					        
						<div class="row">
							<div class="col-md-5">
								<li style="padding: 10px; background-color: #ccc;">
									{{$row->title}}

									<a href="{{ route('arrange-submenu',['id' => $row->id]) }}" class="btn btn-sm btn-info pull-right">
											<i class="fa fa-edit"> Arrange Sub Menu</i>
										</a>

								</li>
									
								</div>
								<div class="col-md-6">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="permission[]" value="
											{{$subpermission->name ?? ''}}" disabled="true">
											{{$subpermission->name ?? ''}}
										</label>
									</div>
								</div>
								<div class="col-md-1">

								</div>
							</div>

							@foreach ($submenu as $sub)

							<div class="row">
								<div class="col-md-5">
									<li style="padding: 5px; background-color: #000;color: white;">{{$sub->sub_menu}}
									</li>

								</div>
								<div class="col-md-6">
									<?php
									$permission = App\Menupermission::where('sub_menu_id',$sub->id)->get();
									?>

									@foreach ($permission as $per)
									<?php
									$perid = $per->permission_id;
									$pernames = Spatie\Permission\Models\Permission::where('id',$perid)->get();
									?>
									@foreach ($pernames as $rows)
									@if ($rows->name == $subpermission->name)


									@else

									<div class="checkbox">
										<label>
											<input type="checkbox" name="permission[]" value="
											{{$rows->name}}" disabled="true">
											{{$rows->name}}
										</label>
									</div>

									@endif

									@endforeach
									@endforeach
								</div>
								<div class="col-md-1">
									<a href="{{ route('edit-permission',['id'=> $sub->id]) }}" onclick="return confirm('Are You Sure ?')" class="btn btn-danger fa fa-trash" title="Delete {{$sub->sub_menu}}"></a>
								</div>
							</div>

							@endforeach

							<div class="clearfix"></div>

							<hr>

							@endforeach

							<input type="submit" value="Save" name="submit" class="btn btn-success pull-right" style="display: none;">
						</form>
					</div>
				</div>
			</div>                  
		</div>
		@endsection




		@section('script')

		<script type="text/javascript">
			 $(function () {

				$(document).on("click","#addmore",function(e){
					e.preventDefault();

					var html = '<div><hr><input type="text" class="form-control" name="submenu[]" id="submenu"  placeholder="Enter ... Menu Sub Title" required><input type="number" class="form-control" name="menuorder[]" id="inputError" placeholder="Enter ... Menu Order" required><a href="#" class="remove_field">Remove</a></div>';

					$("#appendhere").append(html)
				});


				$(document).on("click",".remove_field",function(e){
					e.preventDefault();
					$(this).parent('div').remove();
				});

			});

		</script>


		@endsection
