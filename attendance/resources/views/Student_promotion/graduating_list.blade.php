@extends('layouts.main')


@section('title')
Graduating List
@endsection

@section('mtitle')
Graduating List
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Graduating List</h3>
      </div>
      <div class="box-body">
        <form method="post" action="#" id="fetch_list">
          @csrf

          <div class="row">

           <div class="col-md-4">
            <div class="form-group @error('programme')has-error @enderror">
              <label>Programme</label>
              <select class="form-control" name="programme" id="programme" required>
                <option>{{ old('programme') }}</option>
                @foreach($prog as $progs)
                <option value="{{$progs->name}},{{$progs->code}},{{$progs->type}}">{{$progs->name}}</option>
                @endforeach
              </select>
              <span class="help-block" id="progerror" style="color: red;">@error('programme'){{ $message }}@enderror</span>
            </div>
          </div>


          <div class="col-md-4">
            <div class="form-group @error('level')has-error @enderror">
              <label>Level</label>
              <select class="form-control" name="level" id="level" required>
                <option>{{ old('level') }}</option>
                <option value="Level 100">Level 100</option>
                <option value="Level 200">Level 200</option>
                <option value="Level 300">Level 300</option>
                <option value="Level 400">Level 400</option>
              </select>
              <span class="help-block" id="levelerror" style="color: red;">@error('level'){{ $message }}@enderror</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group @error('session')has-error @enderror">
              <label>Session</label>
              <select class="form-control" name="session" id="session" required>
                <option>{{ old('session') }}</option>
                <option value="Morning Session">Morning Session</option>
                <option value="Evening Session">Evening Session</option>
                <option value="Weekend Session">Weekend Session</option>
              </select>
              <span class="help-block" id="sessionerror" style="color: red;">@error('session'){{ $message }}@enderror</span>
            </div>
          </div>
        </div>



        <input type="submit" name="submit" id="cancelresult" value="Fetch List" class="pull-right btn btn-success">


      </form> 
      <div class="clearfix"></div>
      <hr>
      <div style="border: 1px solid #ccc;">
        <div id="displaylist"></div>
      </div>

    </div>
  </div>
</div>               
</div>
@endsection




@section('script')

<script type="text/javascript">
  $('document').ready(function(){

      //start
      $(document).on("submit","#fetch_list", function(e){
        e.preventDefault();

        $.ajax({
          beforeSend: function(){
            $.LoadingOverlay("show");
          },
          complete: function(){
            $.LoadingOverlay("hide");
          },
          url: '{{route('graduating_list_script')}}',
          type: 'POST',
          dataType: 'json',
          data: $("form").serialize(),
          success: function(data){ 

          //$("#displaylist").text(data);

           var level = data.level;
           var prog = data.prog;
           var session = data.session;
           var academicyear = data.academicyear;
           var type = data.type;

           //console.log(data);

           var redrecturl = '/Promote/Student/fetch/graduating-List/'+level+'/'+prog+'/'+session+'/'+academicyear+'/'+type+'/';

           //$("#displaylist").text(redrecturl);
           window.open(redrecturl,"_blank");
           //window.location.href = redrecturl;

         },
         error: function (data) {
          console.log('Error:', data);
          $("#msg").text(data.message).show();
        }
      });    

      });
    //end



  });

</script>


@endsection