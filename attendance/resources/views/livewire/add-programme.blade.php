<div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Programme</h3>
      </div>
      <div class="box-body">
       	<form wire:submit.prevent="submitform" >
					<div class="form-group  @error('name') has-error @enderror">
				         <label class="control-label" for="inputError">Programme name</label>
				         <input type="text" class="form-control" wire:model="name" id="inputError" placeholder="Enter ...">
				          <span class="help-block">@error('name') {{ $message }} @enderror</span>
				    </div>
				    <div class="form-group  @error('typeofp') has-error @enderror">
				    	 <label class="control-label" for="inputError">Type of Programme</label>
				         <select name="prog" id="prog" wire:model="typeofp" class="form-control" required>
								<option value=""></option>
								<option value="Degree Programme">Degree Programme</option>
								<option value="Diploma Programme">Diploma Programme</option>
								<option value="Masters Programme">Masters Programme</option>
								<option value="Phd Programme">Phd Programme</option>
						</select>
				      <span class="help-block">@error('typeofp') {{ $message }} @enderror</span>
				    </div>
				    <div class="form-group  @error('code') has-error @enderror">
				         <label class="control-label" for="inputError">Programme Code</label>
				         <input type="text" class="form-control" wire:model="code" id="inputError" placeholder="Enter ...">
				          <span class="help-block">@error('code') {{ $message }} @enderror</span>
				    </div>
				    <div class="form-group  @error('duration') has-error @enderror">
				         <label class="control-label" for="inputError">Programme Duration</label>
				         <input type="number" class="form-control" wire:model="duration" id="inputError" placeholder="Enter ...">
				          <span class="help-block">@error('duration') {{ $message }} @enderror</span>
				    </div>
				    <div class="form-group  @error('department') has-error @enderror">
				         <label class="control-label" for="inputError">Department</label>
				         <input type="text" class="form-control" wire:model="department" id="inputError" placeholder="Enter ...">
				          <span class="help-block">@error('department') {{ $message }} @enderror</span>
				    </div>
				    <input type="submit" name="submit" value="Add Programme" class="btn btn-success">
				</form> 
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">All Programmes</h3>
      </div>
      <div class="box-body">
       	<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Programme name</th>
                  <th>Type</th>
                  <th>Code</th>
                  <th>Duration</th>
                  <th>Department</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                	@foreach($allprogram as $row)
	                	<tr>
	                		<td>{{$row->name}}</td>
	                		<td>{{$row->type}}</td>
	                		<td>{{$row->code}}</td>
	                		<td>{{$row->duration}} Years / {{$row->duration*2}} Sems</td>
	                		<td>{{$row->department}} </td>
	                	<td><a href="{{route('edit-programme', ['id'=>$row->id])}}" class="btn btn-info" ><i class='fa fa-pencil-square-o'></i>Edit</a></td>
	                	</tr>
	                @endforeach
                </tbody>
             </table>
      </div>
    </div>
  </div>                 
</div>


