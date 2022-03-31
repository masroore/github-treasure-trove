<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link {{ (isset($menu) && $menu =='home') ? 'active' :'' }}">Home</a>
      </li>

       <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.settings') }}" class="nav-link {{ (isset($menu) && $menu =='settings') ? 'active' :'' }}"><i class="fa fa-cogs" aria-hidden="true"></i> SETTINGS</a>
      </li>

       <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('users') }}" class="nav-link {{ (isset($menu) && $menu =='users') ? 'active' :'' }}"><i class="fa fa-user" aria-hidden="true"></i> USERS</a>
      </li>


  
     </ul>
</nav>
<!-- /.navbar -->


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="small-logo" style="    background-color: white;padding: 8px 11px 0px 11px;">
        <a href="{{ route('home') }}" class="brand-link" style="border-bottom:none">
          <img src="{{url('images/'.Option::get('site_logo'))}}" alt="Speedy Orders" class="brand-image elevation-3" style="opacity: .8">
        </a>
        <br>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <a href="#" class="d-block">{{ auth('admin')->user()->first_name  ?? null}}{{ auth('admin')->user()->last_name  ?? null}}</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                   

            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ isset($menu) && $menu == 'dashboard' ? 'active' : '' }}">                
                    <i class="fa fa-home" aria-hidden="true"></i> <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ isset($menu) && $menu == 'categories' ? 'active' : '' }}">                
                    <i class="fa fa-align-justify" aria-hidden="true"></i> <p>Categories</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ isset($menu) && $menu == 'products' ? 'active' : '' }}">                
                    <i class="fa fa-list" aria-hidden="true"></i> <p>Products</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ isset($menu) && $menu == 'orders' ? 'active' : '' }}">                
                    <i class="fas fa-shopping-cart" aria-hidden="true"></i> <p>Orders</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.inventry.index') }}" class="nav-link {{ isset($menu) && $menu == 'inventryList' ? 'active' : '' }}">                
                    <i class="fas fa-list-alt" aria-hidden="true"></i> <p>Inventry</p>                
                </a>
            </li>


               
            <li class="nav-item {{ isset($menu) && ( $menu == 'packagesList' || $menu == 'deliverytimesList' || $menu == 'zonepricesList') ? 'active' : '' }}">
                <a href="#" class="nav-link {{ isset($menu) && ( $menu == 'packagesList' || $menu == 'deliverytimesList' || $menu == 'zonepricesList') ? 'active' : '' }}"> 
                    <i class="fa fa-truck-moving" aria-hidden="true"></i> 
                    <p>
                        Shipping
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.package.index') }}" class="nav-link {{ isset($menu) && $menu == 'packagesList' ? 'active' : '' }}">
                            <p>List Packages</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.deliverytime.index') }}" class="nav-link {{ isset($menu) && $menu == 'deliverytimesList' ? 'active' : '' }}">
                            <p>List Delivery Times</p>
                        </a>
                    </li>
                    
                   <li class="nav-item">
                        <a href="{{ route('admin.zoneprice.index') }}" class="nav-link {{ isset($menu) && $menu == 'zonepricesList' ? 'active' : '' }}">
                            <p>List Zone Prices</p>
                        </a>
                    </li>
                </ul>
            </li>
            

            <li class="nav-item {{ isset($menu) && ( $menu == 'couponsList' || $menu =='couponHistory') ? 'active' : '' }}">
                <a href="#" class="nav-link"> <i class="fas fa-tags" aria-hidden="true"></i> <p>Coupons <i class="right fas fa-angle-left"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ isset($menu) && $menu == 'couponsList' ? 'active' : '' }}">
                            <p>List Coupons</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.coupons.histories.index') }}" class="nav-link {{ isset($menu) && $menu == 'couponHistory' ? 'active' : '' }}">
                            <p>Coupon History</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ isset($menu) && ( $menu == 'pageComponents' || $menu =='pages' || $menu =='banners') ? 'active' : '' }}">
                <a href="#" class="nav-link"> <i class="far fa-file" aria-hidden="true"></i> <p>CMS <i class="right fas fa-angle-left"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.components.index') }}" class="nav-link {{ isset($menu) && $menu == 'pageComponents' ? 'active' : '' }}">
                            <p>Pages Components</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ isset($menu) && $menu == 'pages' ? 'active' : '' }}">
                            <p>Pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.banners.index') }}" class="nav-link {{ isset($menu) && $menu == 'banners' ? 'active' : '' }}">
                            <p>Banners</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ isset($menu) && $menu == 'customers' ? 'active' : '' }}">                
                        <i class="fa fa-user" aria-hidden="true"></i> <p>Customers</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.product.options.index') }}" class="nav-link {{ isset($menu) && $menu == 'options' ? 'active' : '' }}">                
                    <i class="fas fa-th-list" aria-hidden="true"></i> <p>Options</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.product.attributes.index') }}" class="nav-link {{ isset($menu) && $menu == 'attributes' ? 'active' : '' }}">                
                    <i class="fas fa-list-ul" aria-hidden="true"></i> <p>Attributes</p>                
                </a>
            </li>

            <li class="nav-item {{ isset($menu) && ($menu == 'customerOrder' || $menu =='customerTransaction' || $menu  =='tax') ? 'active' : '' }}">
                <a href="#" class="nav-link"> <i class="fas fa-file" aria-hidden="true"></i> <p>Reports <i class="right fas fa-angle-left"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link {{ isset($menu) && $menu == 'customerOrder' ? 'active' : '' }}" href="{{ route('admin.reports.customerorder.index') }}"><p>Customer Order</p></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isset($menu) && $menu == 'customerTransaction' ? 'active' : '' }}" href="{{ route('admin.reports.customertransaction.index') }}">
                            <p>Customer Transaction</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ isset($menu) && $menu == 'tax' ? 'active' : '' }}" href="{{ route('admin.reports.tax.index') }}">
                            <p>Tax</p>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item">
                <a href="{{ route('admin.product.questions.index') }}" class="nav-link {{ isset($menu) && $menu == 'product-questions' ? 'active' : '' }}">                
                    <i class="fas fa-question-circle" aria-hidden="true"></i> <p>Questions</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ isset($menu) && $menu == 'reviews' ? 'active' : '' }}">                
                    <i class="fas fa-search" aria-hidden="true"></i> <p>Reviews</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.faq.categories.index') }}" class="nav-link {{ isset($menu) && $menu == 'faq-categories' ? 'active' : '' }}">                
                    <i class="fa fa-list" aria-hidden="true"></i> <p>Faq Categories</p>                
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.faqs.index') }}" class="nav-link nav-link {{ isset($menu) && $menu == 'faqs' ? 'active' : '' }}">
                    <i class="fas fa-question" aria-hidden="true"></i> <p>Faqs</p>
                </a>
            </li>
            </ul>
        </nav>
    </div>
</aside>
