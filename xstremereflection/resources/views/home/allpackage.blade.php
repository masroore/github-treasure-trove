<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>XtremeReflection | Auto Detail at it's Best</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <script src="https://kit.fontawesome.com/6c1803817f.js" crossorigin="anonymous"></script>
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="/assets/css/opp.min.css" rel="stylesheet" />
    <link href="/assets/css/default/listapp.min.css" rel="stylesheet" />

    <link href="/assets/css/theme/blue.min.css" id="theme" rel="stylesheet" />

    <!-- ================== END BASE CSS STYLE ================== -->
</head>
<body data-spy="scroll"  data-offset="51">
<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-transparent navbar-fixed-top navbar-expand-lg">
        <!-- begin container -->
        <div class="container">
            <!-- begin navbar-brand -->
            <a href="index.html" class="navbar-brand">
                <span class="brand-logo"></span>
                <span class="brand-text">
						<span class="text-primary">Xtreme</span> Reflection
					</span>
            </a>
            <!-- end navbar-brand -->
            <!-- begin navbar-toggle -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- end navbar-header -->
            <!-- begin navbar-collapse -->
            <div class="collapse navbar-collapse" id="header-navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="#home" data-click="scroll-to-target" data-scroll-target="#home">HOME <b class="caret"></b></a>
                        <div class="dropdown-menu dropdown-menu-left animated fadeInDown">
                            <a class="dropdown-item" href="index.html">All Services</a>
                            <a class="dropdown-item" href="index_inverse_header.html">Blog / Tutorials</a>
                            <a class="dropdown-item" href="index_default_header.html">Page with White Header</a>
                            <a class="dropdown-item" href="extra_element.html">Extra Element</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#about" data-click="scroll-to-target">ABOUT</a></li>
                    <li class="nav-item"><a class="nav-link" href="#service" data-click="scroll-to-target">SERVICES</a></li>
                    <li class="nav-item"><a class="nav-link" href="#work" data-click="scroll-to-target">WORK</a></li>
                    <li class="nav-item"><a class="nav-link" href="#client" data-click="scroll-to-target">CLIENT</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing" data-click="scroll-to-target">PRICING</a></li>
                    <li class="nav-item"><a class="nav-link" href="#protection" data-click="scroll-to-target">CERAMIC</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products" data-click="scroll-to-target">PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact" data-click="scroll-to-target">CONTACT</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login" >SIGN IN</a></li>
                </ul>
            </div>
            <!-- end navbar-collapse -->
        </div>
        <!-- end container -->
    </div>
    <!-- end #header -->

    <div class="content mt-5">
        @foreach($packageTypes as $pt)
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <h2>{{$pt->description ?? ''}} Packages</h2>
                    <hr>
                    <ul class="result-list">
                        @foreach($packages->where('packageType', $pt->id) as $package)
                            <li>
                                <a href="#" class="result-image" style="background-image: url(../assets/img/gallery/gallery-51.jpg)"></a>
                                <div class="result-info">
                                    <h4 class="title"><a href="javascript:;">{{$package->description ?? 'Unknown Package'}} Package</a></h4>
                                    <p class="location">United State, BY 10089</p>
                                    <p class="desc">
                                        Nunc et ornare ligula. Aenean commodo lectus turpis, eu laoreet risus lobortis quis. Suspendisse vehicula mollis magna vel aliquet. Donec ac tempor neque, convallis euismod mauris. Integer dictum dictum ipsum quis viverra.
                                    </p>
                                    <div class="btn-row">
                                        <a href="javascript:;" data-toggle="tooltip" data-container="body" data-title="Analytics"><i class="fa fa-fw fa-chart-bar"></i></a>
                                        <a href="javascript:;" data-toggle="tooltip" data-container="body" data-title="Tasks"><i class="fa fa-fw fa-tasks"></i></a>
                                        <a href="javascript:;" data-toggle="tooltip" data-container="body" data-title="Configuration"><i class="fa fa-fw fa-cog"></i></a>
                                        <a href="javascript:;" data-toggle="tooltip" data-container="body" data-title="Performance"><i class="fa fa-fw fa-tachometer-alt"></i></a>
                                        <a href="javascript:;" data-toggle="tooltip" data-container="body" data-title="Users"><i class="fa fa-fw fa-user"></i></a>
                                    </div>
                                </div>
                                <div class="result-price">
                                     <small>STARTING AT</small> ${{$package->cost ?? 'Call Today'}}
                                    <a href="javascript:;" class="btn btn-yellow btn-block">View Details</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>



    <!-- begin #footer -->
    <div id="footer" class="footer">
        <div class="container">
            <div class="footer-brand">
                <div class="footer-brand-logo"></div>
                XtremeReflection
            </div>
            <p>
                &copy; Copyright XtremeReflection {{\Carbon\Carbon::now()->format('Y')}} <br />
            </p>
            <p class="social-list">
                <a href="#"><i class="fab fa-facebook-f fa-fw"></i></a>
                <a href="#"><i class="fab fa-instagram fa-fw"></i></a>
                <a href="#"><i class="fab fa-twitter fa-fw"></i></a>
                <a href="#"><i class="fab fa-google-plus-g fa-fw"></i></a>
                <a href="#"><i class="fab fa-dribbble fa-fw"></i></a>
            </p>
        </div>
    </div>
    <!-- end #footer -->

    <!-- begin theme-panel -->
    <div class="theme-panel">
        <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
        <div class="theme-panel-content">
            <ul class="theme-list clearfix">
                <li class="active"><a href="javascript:;" class="bg-blue" data-theme="blue" data-theme-file="/assets/css/theme/blue.min.css" data-click="default" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue" data-original-title="" title="">&nbsp;</a></li>

            </ul>
        </div>
    </div>
    <!-- end theme-panel -->
</div>
<!-- end #page-container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/js/opp.min.js"></script>
<!-- ================== END BASE JS ================== -->
</body>
</html>
