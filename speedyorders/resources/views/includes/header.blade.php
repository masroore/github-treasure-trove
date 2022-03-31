<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/style_call.css" />
</head>

<body>

    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto col-md-4 col-lg-3 mr-auto d-flex align-items-center">
                    <a href="javascript:;" class="header-item header-item-menu d-lg-none" rel="nofollow" data-open=".main-menu-wrapper">
                        <span class="icon-menu-bar"></span>
                        <span class="icon-menu-bar"></span>
                        <span class="icon-menu-bar"></span>
                    </a>
                    <a href="/speedyorders" title="Homepage" class="d-lg-block mx-lg-auto ml-xl-0"><img srcset="assets/img/logo@2x.png 2x" src="assets/img/logo.png" width="245" class="header-logo" alt="Speedy Orders"></a>
                </div>
                <div class="col-auto order-md-3 d-lg-none">
                    <a href="wishlist.php" title="Orders" class="header-item header-item-wishlist"><i class="icon-wishlist"></i>
                        <div class="qtd">10</div>
                    </a>
                    <a href="cart.php" title="Cart" class="header-item header-item-cart"><i class="icon-cart"></i>
                        <div class="qtd">1</div>
                    </a>
                </div>
                <div class="col-12 col-md header-search-wrapper">
                    <form class="d-flex header-search-form">
                        <div class="dropdown search-filter-dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="searchFilterBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                All
                            </button>
                            <div class="dropdown-menu custom-scroll" aria-labelledby="searchFilterBtn">
                                <a href="#" title="filter">All</a>
                                <a href="#" title="filter">Acrylic</a>
                                <a href="#" title="filter">Backdrops</a>
                                <a href="#" title="filter">Business Sign</a>
                                <a href="#" title="filter">Calendars</a>
                                <a href="#" title="filter">Custom Products</a>
                                <a href="#" title="filter">Home decor</a>
                                <a href="#" title="filter">Invitations</a>
                                <a href="#" title="filter">Acrylic</a>
                                <a href="#" title="filter">Backdrops</a>
                                <a href="#" title="filter">Business Sign</a>
                                <a href="#" title="filter">Calendars</a>
                                <a href="#" title="filter">Custom Products</a>
                                <a href="#" title="filter">Home decor</a>
                                <a href="#" title="filter">Invitations</a>
                            </div>
                        </div>
                        <div class="col px-0 form-floating">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search products">
                            <label for="searchInput">Search products </label>
                        </div>
                        <button type="submit" class="btn header-search-btn"><i class="icon-search"></i></button>
                    </form>
                </div>
                <div class="d-none d-lg-flex align-items-center justify-content-end col-lg-3">
                    <div class="dropdown currency-dropdown">
                        <button class="btn dropdown-toggle" type="button" id="currencyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="header-item-text">USD</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="currencyDropdown">
                            <a href="#" title="currency" class="active">USD</a>
                            <a href="#" title="currency">Euro</a>
                            <a href="#" title="currency">GBP</a>
                        </div>
                    </div>
                    <a href="#" title="Register" class="header-item header-item-register"><i class="fa fa-id-badge"></i><span class="header-item-text">Register</span></a>
                    <a href="#" title="Login" class="header-item header-item-login"><i class="fa fa-user"></i><span class="header-item-text">Login</span></a>
                </div>
            </div>
        </div>
        <div class="header-bottom-bar">
            <div class="container d-lg-flex align-items-center">
                <div class="header-mobile-login d-lg-none">
                    <a href="#" title="Register">Register</a>
                    <a href="#" title="Login">Login</a>
                    <!-- after login shows user's name 
                        <p>Hello, <br> Mr. Goras</p>
                        -->
                </div>
                <ul class="d-lg-flex flex-lg-wrap align-items-lg-center justify-content-xl-center px-0 col-lg offset-xl-2 main-menu-wrapper">
                    <li><a href="" title="Store" class="<?= ($activePage == 'e') ? 'active' : ''; ?>">Store</a></li>
                    <li><a href="promotions.php" title="Promotions" class="<?= ($activePage == 'promotions') ? 'active' : ''; ?>">Promotions</a></li>
                    <li><a href="trending.php" title="Trending" class="<?= ($activePage == 'trending') ? 'active' : ''; ?>">Trending</a></li>
                    <li><a href="categories.php" title="Categories" class="<?= ($activePage == 'categories') ? 'active' : ''; ?>">Categories</a></li>
                    <li><a href="b2b-home.php" title="Business" class="<?= ($activePage == 'b2b-home') ? 'active' : ''; ?>">Business</a></li>
                    <li><a href="" title="Support" class="<?= ($activePage == 'e') ? 'active' : ''; ?>">Support</a></li>
                </ul>
                <div class="header-mobile-location-currency px-0 col-lg-auto">
                    <div class="dropdown">
                        <button class="dropdown-toggle d-flex align-items-end float-lg-right" type="button" id="headerAddress" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-map-pointer"></i>
                            <div>
                                <div class="btn-text">Deliver to</div>
                                <div class="address-value text-truncate">Elk Grove 60007 Elk Grove 60007</div>
                            </div>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="headerAddress">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="mobileAddress" placeholder="Address ZIP">
                                <label for="mobileAddress">Address ZIP </label>
                            </div>
                            <a href="#" title="Save" class="btn btn-small btn-outline-primary mt-2">Save</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="dropdown currency-dropdown d-lg-none">
                        <button class="btn dropdown-toggle" type="button" id="currencyDropdownMobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="header-item-text">USD</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="currencyDropdownMobile">
                            <a href="#" title="currency" class="active">USD</a>
                            <a href="#" title="currency">Euro</a>
                            <a href="#" title="currency">GBP</a>
                        </div>
                    </div>
                </div>
                <a href="wishlist.php" title="Orders" class="header-item header-item-wishlist d-none d-lg-flex"><i class="icon-wishlist"></i>
                    <div class="qtd">10</div>
                </a>
                <a href="cart.php" title="Cart" class="header-item header-item-cart d-none d-lg-flex"><i class="icon-cart"></i>
                    <div class="qtd">1</div>
                </a>
                <!-- logout link only when user is logged in -->
                <a href="#" title="Logout" class="header-mobile-logout d-lg-none">Logout</a>
            </div>
        </div>
    </header>

    <main role="main">