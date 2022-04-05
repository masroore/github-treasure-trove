<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="../assets/img/profile.png" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{Auth()->user()->company->company_name ?? ''}}
									<span class="caret"></span>
								</span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="/profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="/profile">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a href="/dashboard">
                        <i class="fa fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="calendar.html">
                        <i class="far fa-calendar-alt"></i>
                        <p>Calendar</p>
                    </a>
                </li>
                <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                    <h4 class="text-section">Company Menu</h4>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#estimates">
                        <i class="fal fa-file-invoice"></i>
                        <p>Estimates</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="estimates">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/estimate">
                                    <span class="sub-item">Pending Estimates</span>
                                </a>
                            </li>
                            <li>
                                <a href="/estimate/canceled">
                                    <span class="sub-item">Canceled Estimates</span>
                                </a>
                            </li>
                            <li>
                                <a href="/estimate/completed">
                                    <span class="sub-item">Completed Estimates</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#workOrders">
                        <i class="far fa-tools"></i>
                        <p>Work Orders</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="workOrders">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/workorder">
                                    <span class="sub-item">Active Work Orders</span>
                                </a>
                            </li>
                            <li>
                                <a href="/workorder/canceled">
                                    <span class="sub-item">Canceled Work Orders</span>
                                </a>
                            </li>
                            <li>
                                <a href="/workorder/completed">
                                    <span class="sub-item">Completed Work Orders</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#packages">
                        <i class="fas fa-cubes"></i>
                        <p>Packages</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="packages">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/packages">
                                    <span class="sub-item">Package List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#services">
                        <i class="fab fa-servicestack"></i>
                        <p>Services</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="services">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="/service">
                                    <span class="sub-item">Services List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                    <h4 class="text-section">Web Site Settings</h4>
                </li>

                @role('business_admin')
                <li class="nav-item">
                    <a href="/company/{{Auth()->user()->companyId}}">
                        <i class="fas fa-cogs"></i>
                        <p>Company Settings</p>
                    </a>
                </li>
                @endrole

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
