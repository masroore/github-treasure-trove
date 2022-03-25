@extends('layouts.main')


@section('title')
  OSMS | All ONLINE Admissions
@endsection

@section('mtitle')
  Student Admission Information
@endsection


@section('mtitlesub')

@endsection



@section('main_content')

  
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="{{asset('storage')}}/{{$personal->profileimg}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$personal->surname}} {{$personal->firstnames}} {{$personal->middlename}}</h3>

              <p class="text-muted text-center">Applicant</p>

              <!-- <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Date of Birth</b> <a class="pull-right">{{$personal->dateofbirth}}</a>
                </li>
                <li class="list-group-item">
                  <b>Session</b> <a class="pull-right">{{$appinfo->session}}</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">{{$personal->email}}</a>
                </li>
              </ul> -->
              @if($personal->approve == 1)
                <a href="#" class="btn btn-primary btn-block"><b>Applicant Approved</b></a>
              @else
              <a href="#" class="btn btn-primary btn-block"><b>Pending Approval</b></a>
              @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gurdian Information</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-edit margin-r-5"></i>Name</strong>
              <p class="text-muted margin-r-5">
                {{$gurdian->gurdianname}}
              </p>


              <strong><i class="fa fa-edit margin-r-5"></i>Relationship</strong>

              <p class="text-muted margin-r-5">{{$gurdian->relationshp}}</p>


              <strong><i class="fa fa-edit margin-r-5"></i>Mobile Number</strong>

              <p class="margin-r-5">
                <span class="label label-danger">{{$gurdian->mobile}}</span>
               <!--  <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span> -->
              </p>


              <strong><i class="fa fa-edit margin-r-5"></i>Employed</strong>

              <p class="margin-r-5">{{$gurdian->employed}}</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Personal Infomation</a></li>
              <li><a href="#timeline" data-toggle="tab">Results</a></li>
              <li><a href="#settings" data-toggle="tab">Supporting Documents</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="alert alert-success" id="msg" style="display: none;">
              
                </div>
                <div class="alert alert-danger" id="error" style="display: none;">
              
                </div>

                {{-- <div class="row">
                  <div class="col-md-4">
                    
                    <div class="form-group">
                      <label>Approve Programme</label>
                       <select name="Programme" 
            cid="{{$appinfo->osncode_id}}" class="progamme form-control">
                        @if ($appinfo->programme !=null) 
                            <option value="{{$appinfo->programme}}">{{$appinfo->programme}}</option>
                        @else
                            <option value=""></option>
                        @endif
                    <option value="{{$appinfo->firstchoice}}">{{$appinfo->firstchoice}}</option>
                    <option value="{{$appinfo->secondchoice}}">{{$appinfo->secondchoice}}</option>
                    <option value="{{$appinfo->thirdchoice}}">{{$appinfo->thirdchoice}}</option>
                    </select>
                    </div>

                    <div class="form-group">
                      <!-- <label>Status @if($personal->approve == 1)
                <b style="color: red;">Applicant Approved</b>
              @else
              <b>Pending Approval</b>
              @endif</label> -->
                        <label>Approve Admission</label>

                        <select name="appadm" cid="{{$appinfo->osncode_id}}" id="appadm" class="appprove form-control">

                        <option value=""></option>
                        <option value="1">Approve Addmission</option>
                        <option value="0">DisApprove Admission</option>
                        </select>
                    </div>
                    
                  </div>
                </div>

                <hr> --}}

                <div class="box-body">
                        <table class="table table-bordered table-striped">
                          <thead>
                  
                          </thead>
                          <tbody>
                            <tr>
                                <td colspan="2" class="bg-info"><b> Personnal Information </b></td>
                              </tr>
                            <tr>
                                <td>Fullname</td>
                                <td>{{$personal->surname}} {{$personal->firstnames}} {{$personal->middlename}}</td>
                              </tr>
                              <tr>
                                <td>Date of birth</td>
                                <td>{{$personal->dateofbirth}}</td>
                              </tr>
                    
                              <tr>
                                <td>Email</td>
                                <td>{{$personal->email}}</td>
                              </tr>
                              <tr>
                                <td>Phone</td>
                                <td>{{$personal->phone}}</td>
                              </tr>
                              <tr>
                              <td>Marital Status</td>
                                <td>{{$personal->maritalstutus}}</td>
                              </tr>
                            </tbody>
                        </table>



                        <table class="table table-bordered table-striped">
                          <thead>
                  
                          </thead>
                          <tbody>
                            <tr>
                                <td colspan="2" class="bg-info"><b> Application Information </b></td>
                              </tr>
                            <tr>
                                <td>Entry Level</td>
                                <td>{{$appinfo->entrylevel}}</td>
                              </tr>
                              <tr>
                                <td>Session</td>
                                <td>{{$appinfo->session}}</td>
                              </tr>
                    
                              <tr>
                                <td>First Choice</td>
                                <td>{{$appinfo->firstchoice}}</td>
                              </tr>
                              <tr>
                                <td>Second Choice</td>
                                <td>{{$appinfo->secondchoice}}</td>
                              </tr>
                              <tr>
                                <td>Third Choice</td>
                                <td>{{$appinfo->thirdchoice}}</td>
                              </tr>
                            </tbody>
                        </table>

                        @if($personal->approve == 1)
                        <table class="table table-bordered table-striped">
                          <thead>
                  
                          </thead>
                          <tbody>
                            <tr>
                                <td colspan="2" class="bg-info"><b> Aprroved Programme </b></td>
                              </tr>
                              <tr>
                                <td>Programme</td>
                                <td>{{$appinfo->programme}}</td>
                              </tr>
                              <tr>
                                <td>Programme Type</td>
                                <td>{{$appinfo->type}}</td>
                              </tr>
                              <tr>
                                <td>Session</td>
                                <td>{{$appinfo->session}}</td>
                              </tr>
                    
                            </tbody>
                        </table>
                        @endif

                      </div>  



              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          <?php echo date('d-m-Y')?>
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> &nbsp; <?php echo date('d-m-Y')?></span>
                      <div class="timeline-body">
                       
                          <div class="box-body">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                                <td colspan="4" class="bg-info"><b>Examination results</b></td>
                              </tr>
                        <tr>
                              <th>Subject</th>
                              <th>Grade</th>
                              <th>Index Number</th>
                              <th>Year of Sitting</th>
                            </tr>
                          </thead>
                          <tbody> 

                            <!--- Results 1 -->

                            @if($result1->subject1)
                     <tr>
                                <td>{{$result1->subject1}}</td>
                                <td>{{$result1->grade1}}</td>
                                <td>{{$result1->indexnumber}}</td>
                                <td>{{$result1->examyear}}</td>
                               </tr>
                    @endif

                    @if($result1->subject2)
                     <tr>
                                <td>{{$result1->subject2}}</td>
                                <td>{{$result1->grade2}}</td>
                                <td>{{$result1->indexnumber}}</td>
                                <td>{{$result1->examyear}}</td>
                               </tr>
                    @endif

                    @if($result1->subject3)
                     <tr>
                                <td>{{$result1->subject3}}</td>
                                <td>{{$result1->grade3}}</td>
                                <td>{{$result1->indexnumber}}</td>
                                <td>{{$result1->examyear}}</td>
                               </tr>
                    @endif

                    @if($result1->subject4)
                     <tr>
                                <td>{{$result1->subject4}}</td>
                                <td>{{$result1->grade4}}</td>
                                <td>{{$result1->indexnumber}}</td>
                                <td>{{$result1->examyear}}</td>
                               </tr>
                    @endif


                    @if($result1->subject5)
                     <tr>
                                <td>{{$result1->subject5}}</td>
                                <td>{{$result1->grade5}}</td>
                                <td>{{$result1->indexnumber}}</td>
                                <td>{{$result1->examyear}}</td>
                               </tr>
                    @endif


                    @if($result1->subject6)
                     <tr>
                                <td>{{$result1->subject6}}</td>
                                <td>{{$result1->grade6}}</td>
                                <td>{{$result1->indexnumber}}</td>
                                <td>{{$result1->examyear}}</td>
                               </tr>
                    @endif

                            
                    <!--- Results 2 -->
                    @if(isset($result2->subject1))
                      @if($result2->subject1)
                       <tr>
                                  <td>{{$result2->subject1}}</td>
                                  <td>{{$result2->grade1}}</td>
                                  <td>{{$result2->indexnumber}}</td>
                                  <td>{{$result2->examyear}}</td>
                                 </tr>
                      @endif
                    @endif

                     @if(isset($result2->subject2))
                        @if($result2->subject2)
                         <tr>
                                    <td>{{$result2->subject2}}</td>
                                    <td>{{$result2->grade2}}</td>
                                    <td>{{$result2->indexnumber}}</td>
                                    <td>{{$result2->examyear}}</td>
                                   </tr>
                        @endif
                    @endif

                     @if(isset($result2->subject3))
                    @if($result2->subject3)
                     <tr>
                                <td>{{$result2->subject3}}</td>
                                <td>{{$result2->grade3}}</td>
                                <td>{{$result2->indexnumber}}</td>
                                <td>{{$result2->examyear}}</td>
                               </tr>
                    @endif
                    @endif



                     @if(isset($result2->subject4))
                    @if($result2->subject4)
                     <tr>
                                <td>{{$result2->subject4}}</td>
                                <td>{{$result2->grade4}}</td>
                                <td>{{$result2->indexnumber}}</td>
                                <td>{{$result2->examyear}}</td>
                               </tr>
                    @endif
                    @endif


                     @if(isset($result2->subject5))
                    @if($result2->subject5)
                     <tr>
                                <td>{{$result2->subject5}}</td>
                                <td>{{$result2->grade5}}</td>
                                <td>{{$result2->indexnumber}}</td>
                                <td>{{$result2->examyear}}</td>
                               </tr>
                    @endif
                    @endif


                     @if(isset($result2->subject6))
                    @if($result2->subject6)
                     <tr>
                                <td>{{$result2->subject6}}</td>
                                <td>{{$result2->grade6}}</td>
                                <td>{{$result2->indexnumber}}</td>
                                <td>{{$result2->examyear}}</td>
                               </tr>
                    @endif
                    @endif



                <!---- Results3 ----->

                   @if(isset($result3->subject1))
                    @if($result3->subject1)
                     <tr>
                                <td>{{$result3->subject1}}</td>
                                <td>{{$result3->grade1}}</td>
                                <td>{{$result3->indexnumber}}</td>
                                <td>{{$result3->examyear}}</td>
                               </tr>
                    @endif
                    @endif


                     @if(isset($result3->subject2))
                    @if($result3->subject2)
                     <tr>
                                <td>{{$result3->subject2}}</td>
                                <td>{{$result3->grade2}}</td>
                                <td>{{$result3->indexnumber}}</td>
                                <td>{{$result3->examyear}}</td>
                               </tr>
                    @endif
                    @endif



                     @if(isset($result3->subject3))
                    @if($result3->subject3)
                     <tr>
                                <td>{{$result3->subject3}}</td>
                                <td>{{$result3->grade3}}</td>
                                <td>{{$result3->indexnumber}}</td>
                                <td>{{$result3->examyear}}</td>
                               </tr>
                    @endif
                    @endif

                     @if(isset($result3->subject4))
                    @if($result3->subject4)
                     <tr>
                                <td>{{$result3->subject4}}</td>
                                <td>{{$result3->grade4}}</td>
                                <td>{{$result3->indexnumber}}</td>
                                <td>{{$result3->examyear}}</td>
                               </tr>
                    @endif
                    @endif


                     @if(isset($result3->subject5))
                    @if($result3->subject5)
                     <tr>
                                <td>{{$result3->subject5}}</td>
                                <td>{{$result3->grade5}}</td>
                                <td>{{$result3->indexnumber}}</td>
                                <td>{{$result3->examyear}}</td>
                               </tr>
                    @endif
                    @endif


                     @if(isset($result3->subject6))
                    @if($result3->subject6)
                     <tr>
                                <td>{{$result3->subject6}}</td>
                                <td>{{$result3->grade6}}</td>
                                <td>{{$result3->indexnumber}}</td>
                                <td>{{$result3->examyear}}</td>
                               </tr>
                    @endif
                    @endif




                            </tbody>
                        </table>
                      </div>  



                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->

                  
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                  @if($supportdoc)
        <div class="table-responsive">
          <button class="btn btn-default">Total Document Uploaded&nbsp;<span style="font-size:1.0em;"class="badge">{{ count($supportdoc )}}</span></button>
          <div id="showAirtest">
            <table class="table table-striped"  border="1" cellpadding="10">
              <tr>
                <th>Document Type</th>
                <th>filename</th>
                <th>Uploaded</th>
                <th>View</th>
                <th>Delect</th>
              </tr>
              @foreach($supportdoc as $docs)
                <tr>
                  <td>{{$docs->doctype}}</td>
                  <td>{{$docs->filename}}</td>
                  <td>{{$docs->created_at}}</td>
                <td><a href="{{asset('storage')}}/{{$docs->name}}" target="_blank" class="btn btn-success"><span class="fa fa-eye"></span></a></td>
                  <!-- <td>{{asset('storage', $docs->name)}}</td> -->
      <td>
        <a href="#" onclick="if(confirm('Are You Sure ?')){ event.preventDefault(); document.getElementById('delete_doc_{{$docs->id}}').submit(); }" class="btn btn-danger"><i class='fa fa-trash'></i>Delete</a>
<form id="delete_doc_{{$docs->id}}" 
  action="{{ route('doc-delete', ['id'=> $docs->id ]) }}" method="POST" style="display: none;">
                            
                                @csrf
                            </form> 
                </td>
                </tr> 
              @endforeach
            </table>
          </div>
        </div>
        @endif
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->

        </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

@endsection




@section('script')

<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


	$('document').ready(function(){
		$(document).on('change','.progamme',function(e){
			e.preventDefault();
			var prog = $(this).val();
			var cid = $(this).attr("cid");
			var _token = $('meta[name=csrf-token]').attr('content');
			_this = $(this);
			$.ajax({
					url: '{{route('admissions-update-programme')}}',
					type: 'POST',
					data: {_token : _token , prog: prog, cid: cid},
					 dataType: 'json',
					success: function(data){
						$("#msg").text(data.msg).show();
					},
			          error: function (data) {
			            console.log('Error:', data);
			            $("#msg").text('Sorry, Something error :(').show();
			          }
				});
		});

		
    $(document).on('change','.appprove',function(e){
      e.preventDefault();
      var status = $(this).val();
      var cid = $(this).attr("cid");
      var _token = $('meta[name=csrf-token]').attr('content');
      _this = $(this);
      $.ajax({
          url: '{{route('admissions-approve-admission')}}',
          type: 'POST',
          data: {_token : _token , status: status, cid: cid},
           dataType: 'json',
          success: function(data){
            if (data.msg) {
              $("#msg").text(data.msg).show();
            }else{
              $("#error").text(data.error).show();
            }
            
          },
                error: function (data) {
                  console.log('Error:', data);
                  $("#msg").text(data.message).show();
                }
        });
    });


		


	$('#admission').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admissions-all-confirm') }}',
        dom: 'lBfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print'
        ],
        columns: [
            {data: 'id'},
            {data: 'profileimg', render: function(data){
            	return '<img src="{{asset('storage')}}/'+data+'" class="img-circle"width="50" height="50">';
            },
            orderable: false
        },
            {data: 'firstnames'},
            {data: 'gender'},
            {data: 'entrylevel'},
            {data: 'year'},
            {data: 'programme'},
            {data: 'indexnumber'},
           {data: 'approve', render: function(data,type,row,meta){
            	$html = "";
                $html += '<a href="#" class="btn btn-success confirm" cid="'+row['indexnumber']+'">';
                $html += 'confirm now</a>';
                return $html;
            }, 
             orderable: false
        },
            {data: 'action', name: 'action'},
        ]




    });





	$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    	console.log(message);
};

	});
</script>


@endsection
