<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <!-- <li>
                    <a href="{{url('admin')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboards</span>
                    </a>
                </li> -->

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.categories.index')}}">Categories</a></li>
                        <li><a href="{{route('admin.categories.create')}}">Add Categories</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>Skills</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.skills.index')}}">Skills</a></li>
                        <li><a href="{{route('admin.skills.create')}}">Add Skills</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span>Languages</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.languages.index')}}">Languages</a></li>
                        <li><a href="{{route('admin.languages.create')}}">Add Languages</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span>Project</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.projects.index')}}">Project</a></li>
                        <li><a href="{{route('admin.projects.create')}}">Create New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.freelancers-list')}}">Freelancers</a></li>
                        <li><a href="{{route('admin.clients-list')}}">Clients</a></li>
                        <li><a href="{{route('admin.verification-list')}}">Verification Requests</a></li>
                        <li><a href="{{route('admin.blocked-users')}}">Blocked Users</a></li>
                        <li><a href="{{route('admin.users.create')}}">Add User</a></li>
                    </ul>
                </li>



               <!--  <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bxs-eraser"></i>
                        <span class="badge badge-pill badge-danger float-right">10</span>
                        <span>Forms</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="form-elements">Form Elements</a></li>
                        <li><a href="form-layouts">Form Layouts</a></li>
                        <li><a href="form-validation">Form Validation</a></li>
                        <li><a href="form-advanced">Form Advanced</a></li>
                        <li><a href="form-editors">Form Editors</a></li>
                        <li><a href="form-uploads">Form File Upload</a></li>
                        <li><a href="form-xeditable">Form Xeditable</a></li>
                        <li><a href="form-repeater">Form Repeater</a></li>
                        <li><a href="form-wizard">Form Wizard</a></li>
                        <li><a href="form-mask">Form Mask</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-list-ul"></i>
                        <span>Tables</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tables-basic">Basic Tables</a></li>
                        <li><a href="tables-datatable">Data Tables</a></li>
                        <li><a href="tables-responsive">Responsive Table</a></li>
                        <li><a href="tables-editable">Editable Table</a></li>
                    </ul>
                </li> -->


                <li>
                    <a href="{{route('admin.supports.index')}}" class="waves-effect">
                        <i class="bx bx-aperture"></i>
                        <span>Supports</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.reports.index')}}" class="waves-effect">
                        <i class="bx bx-aperture"></i>
                        <span>Freelancer Reports</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off"></i> {{ __('Logout') }} </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End