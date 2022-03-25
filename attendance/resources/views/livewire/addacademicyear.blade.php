<div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Academic Year</h3>
      </div>
      <div class="box-body">
          <div class="box-body">
          <form wire:submit.prevent="submitform" >
          <div class="form-group  @error('academic') has-error @enderror">
                 <label class="control-label" for="inputError">Academic Year</label>
                 <input type="text" class="form-control" wire:model="academics" id="inputError" placeholder="Enter ...">
                  <span class="help-block">@error('academic') {{ $message }} @enderror</span>
            </div>
            <div class="form-group  @error('semester') has-error @enderror">
                 <label class="control-label" for="inputError">Semester Year</label>
                <select wire:model="semester" class="form-control">
                    <option value=""></option>
                    <option value="First Semester">First Semester</option>
                    <option value="Second Semester">Second Semester</option>
                </select>
                  <span class="help-block">@error('semester') {{ $message }} @enderror</span>
            </div>

            <input type="submit" name="submit" value="Add Academic Year / Semester" class="btn btn-success">

        </form> 
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">All Academic Year</h3>
      </div>
          <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Academic Year</th>
                  <th>Semester</th>
                  <th>Status</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($allacdemics as $row)
                    <tr>
                      <td>{{$row->acdemicyear}}</td>
                       <td>{{$row->semester}}</td>
                      <td>
                        @if($row->status == 1)
                          <input type="checkbox" checked data-toggle="toggle" cid="{{$row->id}}" class="checkit" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">
                        @else
                          <input type="checkbox" cid="{{$row->id}}" class="checkit" data-toggle="toggle" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">
                        @endif
                      </td>
                      <td><a href="{{route('academic-year-edit', ['id'=>$row->id])}}" class="btn btn-info" ><i class='fa fa-pencil-square-o'></i>Edit</a></td>
                    </tr>
                  @endforeach
                </tbody>
             </table>
            
    </div>
  </div>                 
</div>



