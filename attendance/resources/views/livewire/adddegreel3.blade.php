<div class="row">
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Couse Level 300 <span class="badge badge-pill badge-secondary">CODE (BACT)</span></h3>
      </div>
      <div class="box-body">
        <form wire:submit.prevent="submitform" style="margin :4px;">
          <div class="form-group  @error('name') has-error @enderror">
           <label class="control-label" for="inputError">Course Title</label>
           <input type="text" class="form-control" wire:model="name" id="inputError" placeholder="Enter ...">
           <span class="help-block">@error('name') {{ $message }} @enderror</span>
         </div>

         <div class="form-group  @error('type') has-error @enderror">
           <label class="control-label" for="inputError">Course Type</label>
           <select wire:model="type" class="form-control">
             <option value=""></option>
             <option>Core</option>
             <option>Elective</option>
           </select>
           <span class="help-block">@error('type') {{ $message }} @enderror</span>
         </div>

         <div class="form-group  @error('chrs') has-error @enderror">
           <label class="control-label" for="inputError">Credit Hours</label>
           <input type="number" value="3" class="form-control" wire:model="chrs" id="inputError" placeholder="Enter ...">
           <span class="help-block">@error('chrs') {{ $message }} @enderror</span>
         </div>

         <input type="submit" name="submit" value="Add Course" class="btn btn-success">
       </form> 
     </div>
   </div>
 </div>
 <div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"></h3>
    </div>
    <div class="box-body" wire:ignore>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Course code</th>
            <th>Title</th>
            <th>Type</th>
            <th>CH</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody>
          @foreach($course as $row)
          <tr>
            <td>{{$row->code}}</td>
            <td>{{$row->title}}</td>
             <td>{{$row->type}}</td>
            <td>{{$row->credithours}} </td>
            <td>
              <a href="{{route('add-course-degreel3-edit', ['id'=>$row->id])}}" class="btn btn-info" ><i class='fa fa-pencil-square-o'></i></a>

              <a href="" class="btn btn-danger" wire:click.prevent="deletecourse('{{$row->code}}')" onclick="return confirm('Are You Sure ?')"><i class='fa fa-trash'></i></a>
              
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>                 
</div>