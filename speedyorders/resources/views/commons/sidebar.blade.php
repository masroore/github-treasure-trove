<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        {{--<div class="profile-picture">
            <a href="#">
                <img src="{{ asset('images/profile.jpg') }}" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">
                    {{ auth('admin')->user()->name ?? null }}
                </span>
                <span class="text-success"><i class="fa fa-circle"></i> Online</span>
            </div>
        </div>
--}}
        <ul class="nav" id="side-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ isset($menu) && $menu == 'dashboard' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Dashboard
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.categories.index') }}" class="{{ isset($menu) && $menu == 'categories' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Categories
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products.index') }}" class="{{ isset($menu) && $menu == 'products' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Products
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders.index') }}" class="{{ isset($menu) && $menu == 'orders' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Orders
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.inventry.index') }}" class="{{ isset($menu) && $menu == 'inventryList' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Inventry
                    </span>
                </a>
            </li>

            
            <li class="{{ isset($menu) && ( $menu == 'packagesList' || $menu == 'deliverytimesList' || $menu == 'zonepricesList') ? 'active' : '' }}">
                <a href="#" class="{{ isset($menu) && ( $menu == 'packagesList' || $menu == 'deliverytimesList' || $menu == 'zonepricesList') ? 'side-bar-active' : '' }}"><span class="nav-label"> <i class="fa fa-home" aria-hidden="true"></i> Shipping</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin.package.index') }}" class="{{ isset($menu) && $menu == 'packagesList' ? 'side-bar-active' : '' }}">List Packages</a></li>
                    
                    <li><a href="{{ route('admin.deliverytime.index') }}" class="{{ isset($menu) && $menu == 'deliverytimesList' ? 'side-bar-active' : '' }}">List Delivery Times</a></li>
                    
                   <li><a href="{{ route('admin.zoneprice.index') }}" class="{{ isset($menu) && $menu == 'zonepricesList' ? 'side-bar-active' : '' }}">List Zone Prices</a></li>
                    
                    
                </ul>
            </li>
            

            <li class="{{ isset($menu) && ( $menu == 'couponsList' || $menu =='couponHistory') ? 'active' : '' }}">
                <a href="#"><span class="nav-label"> <i class="fa fa-home" aria-hidden="true"></i> Coupons</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin.coupons.index') }}" class="{{ isset($menu) && $menu == 'couponsList' ? 'side-bar-active' : '' }}">List Coupons</a></li>
                    <li><a href="{{ route('admin.coupons.histories.index') }}" class="{{ isset($menu) && $menu == 'couponHistory' ? 'side-bar-active' : '' }}">Coupon History</a></li>
                </ul>
            </li>

            <li class="{{ isset($menu) && ( $menu == 'pageComponents' || $menu =='pages' || $menu =='banners') ? 'active' : '' }}">
                <a href="#"><span class="nav-label"> <i class="fa fa-home" aria-hidden="true"></i> CMS</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin.pages.components.index') }}" class="{{ isset($menu) && $menu == 'pageComponents' ? 'side-bar-active' : '' }}">Pages Components</a></li>
                    <li><a href="{{ route('admin.pages.index') }}" class="{{ isset($menu) && $menu == 'pages' ? 'side-bar-active' : '' }}">Pages</a></li>
                    <li><a href="{{ route('admin.pages.banners.index') }}" class="{{ isset($menu) && $menu == 'banners' ? 'side-bar-active' : '' }}">Banners</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.customers.index') }}" class="{{ isset($menu) && $menu == 'customers' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Customers
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.product.options.index') }}" class="{{ isset($menu) && $menu == 'options' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Options
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.product.attributes.index') }}" class="{{ isset($menu) && $menu == 'attributes' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i> Attributes
                    </span>
                </a>
            </li>

            <li class="{{ isset($menu) && ($menu == 'customerOrder' || $menu =='customerTransaction' || $menu  =='tax') ? 'active' : '' }}">
                <a href="#"><span class="nav-label"> <i class="fa fa-home" aria-hidden="true"></i> Reports</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a class="{{ isset($menu) && $menu == 'customerOrder' ? 'side-bar-active' : '' }}" href="{{ route('admin.reports.customerorder.index') }}">Customer Order</a></li>
                    <li><a class="{{ isset($menu) && $menu == 'customerTransaction' ? 'side-bar-active' : '' }}" href="{{ route('admin.reports.customertransaction.index') }}">Customer Transaction</a></li>
                    <li><a class="{{ isset($menu) && $menu == 'tax' ? 'side-bar-active' : '' }}" href="{{ route('admin.reports.tax.index') }}">Tax</a></li>
                </ul>
            </li>


            <li>
                <a href="{{ route('admin.product.questions.index') }}" class="{{ isset($menu) && $menu == 'product-questions' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i>Questions
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reviews.index') }}" class="{{ isset($menu) && $menu == 'reviews' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i>Reviews
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.faq.categories.index') }}" class="{{ isset($menu) && $menu == 'faq-categories' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i>Faq Categories
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.faqs.index') }}" class="{{ isset($menu) && $menu == 'faqs' ? 'side-bar-active' : '' }}">
                    <span class="nav-label">
                        <i class="fa fa-home" aria-hidden="true"></i>Faqs
                    </span>
                </a>
            </li>

        </ul>
    </div>
</aside>
