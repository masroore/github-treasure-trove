@extends('layouts.main')


@section('title')
OSMS | Admission Document
@endsection

@section('mtitle')
OSMS Admission Document
@endsection


@section('mtitlesub')

@endsection



@section('main_content')


<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> Admission Document</h3>
    </div>
    <div class="box-body">
       <form action="{{ route('admissions-confirm-doc') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="panel panel-primary">
            <div class="panel panel-heading">Upload Document</div>
            <div class="panel panel-body">

                <div class="form-group @error('file') has-error @enderror">
                    <label class="control-label" for="file">File</label>
                    <input type="file" name="file" class="form-control" required>
                    <span class="help-block">@error('file'){{ $message }}@enderror</span>
                </div>

            </div>
        </div>

        <input type="submit" class="btn btn-info" value="Upload">
    </form>   
</div>
</div>
</div>

<div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Document</h3>
    </div>

    <div class="box-body">
     <table id="admission" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th>#</th>
              <th>Academic Year</th>
              <th>Document</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        @forelse ($data as $row)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$row->academicyear}}</td>
            <td><a href="{{asset('storage')}}/{{$row->file}}" target="_blank" class="btn"><span class="fa fa-download"></span></a></td>
            <td>
                <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('delete_doc_{{$row->id}}').submit(); }" class="btn"><i class='fa fa-trash'></i></a>
                <form id="delete_doc_{{$row->id}}" 
                    action="{{ route('admissions-confirm-delete', ['id'=> $row->id ]) }}" method="POST" style="display: none;">

                    @csrf
                </form>  
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="4">
                <div class="alert alert-info">No Document Uploaded Yet</div>
            </td>
        </tr>
        @endforelse
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

    //start
    $(document).on("change",".checkit", function(e){
      e.preventDefault();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
      
      if ($(this).prop('checked')) {

        if (confirm("Confirm Academic Year Activation")) {
            $.ajax({
                url: '{{route('academic-year-update-status')}}',
                type: 'POST',
                data: {_token : _token , cid: cid, status: 1},
                dataType: 'json',
                success: function(data){
                    if (data.msg) {
                        alert(data.msg);
                    }else{
                        $("#error").text(data.error).show();
                    }
                    
                },
                error: function (data) {
                    console.log('Error:', data);
                    $("#msg").text(data.message).show();
                }
            });

        }


    }else{

        if (confirm("Confirm Academic Year Deactivation !")) {
            $.ajax({
                url: '{{route('academic-year-update-status')}}',
                type: 'POST',
                data: {_token : _token , cid: cid, status: 0},
                dataType: 'json',
                success: function(data){
                    if (data.msg) {
                        alert(data.msg);
                    }else{
                        $("#error").text(data.error).show();
                    }
                    
                },
                error: function (data) {
                    console.log('Error:', data);
                    $("#msg").text(data.message).show();
                }
            });

        }

    }
    
    
});
    //end

});

</script>


@endsection
