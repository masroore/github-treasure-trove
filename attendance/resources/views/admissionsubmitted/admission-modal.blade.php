<div class="modal modal-default fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          
            

            {{-- <h4 class="modal-title">Approve Admission For {{$appinfo->personalinfo->surname}} {{$appinfo->personalinfo->middlename}} {{$appinfo->personalinfo->firstnames}} </h4> --}}

             @if ($appinfo->personalinfo->approve == 1)

            <div class="alert alert-success"> Admission Already Approved For <br> {{$appinfo->personalinfo->surname}} {{$appinfo->personalinfo->middlename}} {{$appinfo->personalinfo->firstnames}}</div>

            @else

            <div class="alert alert-info"> Approve Admission For {{$appinfo->personalinfo->surname}} {{$appinfo->personalinfo->middlename}} {{$appinfo->personalinfo->firstnames}}</div>

            <img src="{{asset('storage')}}/{{$appinfo->personalinfo->profileimg}}" class="img-circle"width="50" height="50">

            @endif

            

        </div>
        <div class="modal-body">
          <input type="hidden" value="{{$id}}" id="osnid">
         <!--  <p>One fine body&hellip;</p> -->
         <input type="hidden" id="appname" value="{{$appinfo->personalinfo->surname}} {{$appinfo->personalinfo->middlename}} {{$appinfo->personalinfo->firstnames}}">

         @if ($appinfo->personalinfo->approve == 1)

         <input type="hidden" id="session" value="Morning Session">
         <input type="hidden" id="prog" value="null - null">
         @else

         <div class="form-group qnumber">
           <label class="control-label" for="inputError">Select Session</label>
           <select name="session" id="session" class="form-control">
             <option value=""></option>
             <option value="Morning Session">Morning Session</option>
             <option value="Evening Session">Evening Session</option>
             <option value="Weekend Session">Weekend Session</option>
           </select>
           <span class="help-block">@error('session') {{ $message }} @enderror</span>
         </div> 


         <div class="form-group qnumber">
           <label class="control-label" for="inputError">Select Programme</label>
           <select name="prog" id="prog" class="form-control">
             <option></option>
             <option value="{{$appinfo->firstchoice}} - {{$appinfo->fcode}}">{{$appinfo->firstchoice}}</option>
             <option value="{{$appinfo->secondchoice}} - {{$appinfo->scode}}">{{$appinfo->secondchoice}}</option>
             <option value="{{$appinfo->thirdchoice}} - {{$appinfo->tcode}}">{{$appinfo->thirdchoice}}</option>
           </select>
           <span class="help-block">@error('prog') {{ $message }} @enderror</span>
         </div>

         @endif
         

         
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Close</button>
        @if ($appinfo->personalinfo->approve == 1)
           <input type="hidden" value="0" id="status">
           @else
           <input type="hidden" value="1" id="status">
        @endif
        <button type="button" class="btn btn-success" id="addnow">
           @if ($appinfo->personalinfo->approve == 1)
            Revert Admission
           @else
           Approve Student
        @endif
      </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>