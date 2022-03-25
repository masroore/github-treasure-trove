 <!-- sidebar menu: : style can be found in sidebar.less -->
 <ul class="sidebar-menu" data-widget="tree">
        <li class="header">@lang('site.main_nav')</li>
        <li class="@if(Route::current()->getName() == 'dashboard' )
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>@lang('site.dashboard')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Route::current()->getName() == 'dashboard' )
                    active                  
                  @endif"><a href="{{ route('dashboard') }}"><i class="fa fa-circle-o"></i> @lang('site.dashboard')</a></li>
          </ul>
        </li>
        @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service')
        <li class="@if(Request::segment(1) == 'LatestAdmission')
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>@lang('site.Admissions')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Route::current()->getName() == 'add-students' )
                    active                  
                  @endif" ><a href="{{route('add-students')}}"><i class="fa fa-circle-o"></i>Add Student</a></li>
            <li class="@if(Route::current()->getName() == 'admissions-home' )
                    active                  
                  @endif"><a href="{{route('admissions-home')}}"><i class="fa fa-circle-o"></i>Online Admissions Received</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level 100
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'admissions-home-level-100' )
                    active                  
                  @endif"><a href="{{route('admissions-home-level-100')}}"><i class="fa fa-circle-o"></i>All Level 100</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-home-level-100-app' )
                    active                  
                  @endif"><a href="{{route('admissions-home-level-100-app')}}"><i class="fa fa-circle-o"></i>Approved level 100</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level 200
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'admissions-home-level-200' )
                    active                  
                  @endif"><a href="{{route('admissions-home-level-200')}}"><i class="fa fa-circle-o"></i>All Level 200</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-home-level-200-app' )
                    active                  
                  @endif"><a href="{{route('admissions-home-level-200-app')}}"><i class="fa fa-circle-o"></i>Approved level 200</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level 300
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'dmissions-home-level-300' )
                    active                  
                  @endif"><a href="{{route('admissions-home-level-300')}}"><i class="fa fa-circle-o"></i>All Level 300</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-home-level-300-app' )
                    active                  
                  @endif"><a href="{{route('admissions-home-level-300-app')}}"><i class="fa fa-circle-o"></i>Approved level 300</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Student Admission
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'admissions-confirm' )
                    active                  
                  @endif"><a href="{{route('admissions-confirm')}}"><i class="fa fa-circle-o"></i>Confirm Admission</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-confirm-all' )
                    active                  
                  @endif"><a href="{{route('admissions-confirm-all')}}"><i class="fa fa-circle-o"></i>All Confirmed Admission</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-unconfirm-all' )
                    active                  
                  @endif"><a href="{{route('admissions-unconfirm-all')}}"><i class="fa fa-circle-o"></i>UnConfirm Admission</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="@if(Request::segment(1) == 'Allstudents')
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Student Info</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="{{route('all-students')}}"><i class="fa fa-circle-o"></i>All Students</a></li>
            <li><a href="{{route('all-studentsl1')}}"><i class="fa fa-circle-o"></i>Level 1oo</a></li>
            <li><a href="{{route('all-studentsl2')}}"><i class="fa fa-circle-o"></i>Level 200</a></li>
            <li><a href="{{route('all-studentsl3')}}"><i class="fa fa-circle-o"></i>Level 300</a></li>
            <li><a href="{{route('all-studentsl4')}}"><i class="fa fa-circle-o"></i>Level 400</a></li>
            <li><a href="{{route('all-studentsl1')}}"><i class="fa fa-circle-o"></i>Graduated Students</a></li>
          </ul>
        </li>
        <li class="@if(Request::segment(1) == 'AcademicYear')
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Academic Year</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Route::current()->getName() == 'add-academic-year' )
                    active                  
                  @endif"><a href="{{route('add-academic-year')}}"><i class="fa fa-circle-o"></i>Add Academic year</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Programme Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-programme')}}"><i class="fa fa-circle-o"></i>Add Programme</a></li>
            <li><a href="{{route('add-faculty')}}"><i class="fa fa-circle-o"></i>Add Faculty</a></li>
          </ul>
        </li>
        
        <li class="@if(Request::segment(1) == 'CourseManagement')
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Course Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Add Courses
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'add-course-degreel1' )
                    active                  
                  @endif"><a href="{{route('add-course-degreel1')}}"><i class="fa fa-circle-o"></i>Degree Level 100</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-degreel2' )
                    active                  
                  @endif"><a href="{{route('add-course-degreel2')}}"><i class="fa fa-circle-o"></i>Degree Level 200</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-degreel3' )
                    active                  
                  @endif"><a href="{{route('add-course-degreel3')}}"><i class="fa fa-circle-o"></i>Degree Level 300</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-degreel4' )
                    active                  
                  @endif"><a href="{{route('add-course-degreel4')}}"><i class="fa fa-circle-o"></i>Degree Level 400</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-diploma1' )
                    active                  
                  @endif"><a href="{{route('add-course-diploma1')}}"><i class="fa fa-circle-o"></i>Diploma Level 100</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-diploma2' )
                    active                  
                  @endif"><a href="{{route('add-course-diploma2')}}"><i class="fa fa-circle-o"></i>Diploma Level 200</a></li>

              </ul>
            </li>

            <li><a href="{{route('all-degree-course-registered-view')}}"><i class="fa fa-circle-o"></i>All Degree Courses</a></li>

             <li><a href="{{route('all-diploma-course-registered-view')}}"><i class="fa fa-circle-o"></i>All Diploma Courses</a></li>



            <li class="@if(Request::segment(1) == 'CourseManagement')
                    active                  
                  @endif treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Programme & Courses
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <!-- programme stsrt here -->
              <ul class="treeview-menu">
               

            @foreach($programmes as $prog)  

              @if($prog->type == 'Degree Programme')
                <li class="@if(Request::segment(7) == '{{$prog->code}}')
                    active                  
                  @endif treeview">
                    <a href="#"><i class="fa fa-circle-o"></i>{{$prog->code}}
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>

                    <ul class="treeview-menu">
                        <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active                  
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 100
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                        </li>

                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active                  
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 200
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>


                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                              active                  
                              @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 300
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l3', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l3', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>


                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                              active                  
                              @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 400
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l4', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l4', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>

                         

                    </ul>
                  </li>

                  @endif
              @endforeach
                
                 <!--  2 -->

                <!-- diploma programmes loop here -->

                 
            @foreach($programmes as $prog)  

              @if($prog->type == 'Diploma Programme')
                <li class="@if(Request::segment(7) == '{{$prog->code}}')
                    active                  
                  @endif treeview">
                    <a href="#"><i class="fa fa-circle-o"></i>{{$prog->code}}
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>

                    <ul class="treeview-menu">
                        <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active                  
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 100
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                        </li>

                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active                  
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 200
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>                         
                    </ul>
                  </li>

                  @endif
              @endforeach

               <!-- diploend -->
              </ul>
              <!--programme end -->
            </li>
              
           
          </ul>
        </li>
        @endhasanyrole

        @hasanyrole('Student|is_superAdmin|is_admin')
        <li class="@if(Request::segment(1) == 'Allstudents')
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Student</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Student Profile')
            <li><a href="{{route('students-profile-info-view')}}"><i class="fa fa-circle-o"></i>Profile</a></li>
            <li><a href="{{route('student-reg-course')}}"><i class="fa fa-circle-o"></i>Course Registration</a></li>
            <li><a href="{{route('student-results')}}"><i class="fa fa-circle-o"></i>My results</a></li>
            @endcan
            <li><a href="#"><i class="fa fa-circle-o"></i>TimeTable</a></li>
            <li><a href="{{route('students-assignment-views')}}"><i class="fa fa-circle-o"></i>Online Assignment</a></li>
            <li><a href="{{route('start-vote')}}"><i class="fa fa-circle-o"></i>Online Polls</a></li>
            <li><a href="{{route('start-exmas')}}"><i class="fa fa-circle-o"></i>Online Examination</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Report a Problem</a></li>
          </ul>
        </li>
        @endhasanyrole


         @hasanyrole('Lecturer|is_superAdmin|is_admin')
         <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Lecturer</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('lecturer-reg-lecturer')}}"><i class="fa fa-circle-o"></i>Add Lecturer</a></li>
            <li><a href="{{route('lecturer-all')}}"><i class="fa fa-circle-o"></i>ALL Lecturers</a></li>
            <li><a href="{{route('lecturer-student-results')}}"><i class="fa fa-circle-o"></i>Enter Students Results</a></li>
            <li><a href="{{route('lecturer-student-results-reenter')}}"><i class="fa fa-circle-o"></i>ReEnter Results</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>TimeTable</a></li>
            <li><a href="{{route('lecturer-student-assignment')}}"><i class="fa fa-circle-o"></i>Post Assignment</a></li>
            <li><a href="{{route('lecturer-student-assignment-view')}}"><i class="fa fa-circle-o"></i>View Assignment</a></li>
            <li><a href="{{route('start-vote')}}"><i class="fa fa-circle-o"></i>Online Polls</a></li>
            <li><a href="{{route('add-exams')}}"><i class="fa fa-circle-o"></i>Add Exams</a></li>
            <li><a href="{{route('view-exams')}}"><i class="fa fa-circle-o"></i>Online Exams</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Report a Problem</a></li>

          </ul>
        </li>

         @endhasanyrole

         @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service')

         <li class="@if(Request::segment(1) == 'Polls')
                    active                  
                  @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Polls Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-polls')}}"><i class="fa fa-circle-o"></i>Add Polls</a></li>
            <li><a href="{{route('manage-candidates')}}"><i class="fa fa-circle-o"></i>Manage Positions</a></li>
            <li><a href="{{route('add-candidates')}}"><i class="fa fa-circle-o"></i>Manage Candidates</a></li>
            <li><a href="{{route('poll-results')}}"><i class="fa fa-circle-o"></i>Poll Results</a></li>
            <li><a href="{{route('start-vote')}}"><i class="fa fa-circle-o"></i>Online Polls</a></li>

          </ul>
        </li>

         @endhasanyrole

         <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Exams Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-exams')}}"><i class="fa fa-circle-o"></i>Add Exams</a></li>
            <li><a href="{{route('view-exams')}}"><i class="fa fa-circle-o"></i>Online Exams</a></li>
            <li><a href="{{route('start-exmas')}}"><i class="fa fa-circle-o"></i>Start Exams</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Empty Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i>Empty</a></li>
          </ul>
        </li>

      @hasanyrole('is_superAdmin|is_admin')
        <li class="@if(Request::segment(1) == 'UserManagement')
                        active                  
                      @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-user-role')}}"><i class="fa fa-circle-o"></i>Add User Role / Perm</a></li>
            <li><a href="{{route('users-roles-display')}}"><i class="fa fa-circle-o"></i>Users and Their Roles</a></li>
            <li><a href="{{route('logout-user-force')}}"><i class="fa fa-circle-o"></i>Force Logout User</a></li>

          </ul>
        </li>

      @endhasanyrole
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">User</li>
        <li><a href="{{route('passconfirm')}}"><i class="fa fa-circle-o text-red"></i> <span>Lock Screen</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->