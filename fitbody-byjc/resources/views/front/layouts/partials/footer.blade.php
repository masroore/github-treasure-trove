<footer id="footer" class="dark" {{--style="background: url({{ asset('media/images/bg1.jpg') }}) repeat; background-size: cover;"--}}>
    <div class="container d-none d-sm-block">
        <!-- Footer Widgets -->
        <div class="footer-widgets-wrap clearfix"{{-- style="padding: 60px 0 40px 0;"--}}>
            <div class="col_two_third">
                <div class="widget clearfix">
                    <img src="{{ asset('media/images/logo-mrav.svg') }}" alt="" height="80" class="alignleft" style="margin: 0 20px 0 0; padding-right: 18px; border-right: 1px solid #4A4A4A;">
                    <p style="padding-top: 18px;">Poduzetnik ste, poljoprivrednik, udruga, javna ustanova? Posjetite nas da popričamo o tome kako možete koristiti EU fondove za ostvarenje razvojnih ciljeva.</p>
                    <div class="line" style="margin: 30px 0;"></div>
                    <div class="row">
                        <div class="col-md-4 bottommargin-sm widget_links">
                            <h4 style="margin-bottom: 10px;">Sjedište</h4>
                            <address>
                                {{ $appinfo->long_name }}<br>
                                {{ $appinfo->address }}<br>
                                {{ $appinfo->zip }} {{ $appinfo->city }}<br>
                            </address>
                            <div class="row time-table">
                                <h5 class="col-md-3" style="margin-bottom: 0;"><abbr title="Phone Number">Tel:</abbr></h5>
                                <span class="col-md-9">{{ $appinfo->phone }}</span>
                            </div>
                            <div class="row time-table">
                                <h5 class="col-md-3" style="margin-bottom: 0;"><abbr title="Fax">Mob:</abbr></h5>
                                <span class="col-md-9">{{ $appinfo->mobile }}</span>
                            </div>
                            <div class="row time-table">
                                <h5 class="col-md-3" style="margin-bottom: 0;"><abbr title="Email Address">Email:</abbr></h5>
                                <span class="col-md-9"><a href="{{ url('kontakt') }}">Kontaktirajte nas!</a></span>
                            </div>
                        </div>

                        <div class="col-md-4 bottommargin-sm widget_links">
                            <h4 style="margin-bottom: 10px;">Informacije</h4>
                            @if(isset($info_menu))
                                <ul>
                                    @foreach ($info_menu as $page)
                                        @if (isset($page->subcat->parent))
                                            <li style="padding-left: 0;"><a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}">{{ $page->name }}</a></li>
                                        @else
                                            <li style="padding-left: 0;"><a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}">{{ $page->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="col-md-4 bottommargin-sm widget_links">
                            <h4 style="margin-bottom: 10px;">RA Mrav</h4>
                            @if(isset($mrav_menu))
                                <ul>
                                    @foreach ($mrav_menu as $page)
                                        @if (isset($page->subcat->parent))
                                            <li style="padding-left: 0;"><a href="{{ route('page', ['cat' => $page->subcat->parent->slug, 'subcat' => $page->subcat->slug, 'page' => $page->slug]) }}">{{ $page->name }}</a></li>
                                        @else
                                            <li style="padding-left: 0;"><a href="{{ route('page', ['cat' => $page->cat->slug, 'subcat' => $page->slug]) }}">{{ $page->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col_one_third col_last">
                <div class="widget clearfix" style="margin-bottom: -20px;">
                    <div class="row">
                        <div class="col-lg-7 bottommargin-sm">
                            <div class="counter counter-small" style="color: #bbbbbb;"><span data-from="100" data-to="{{ isset($products_data) ? number_format($products_data['amount'], 0, '', '') : 0 }}" data-refresh-interval="90" data-speed="2500" data-comma="true"></span></div>
                            <h5 class="nobottommargin">Kuna odobreno</h5>
                        </div>
                        <div class="col-lg-5 bottommargin-sm">
                            <div class="counter counter-small" style="color: #bbbbbb;"><span data-from="0" data-to="{{ isset($products_data) ? $products_data['count'] : 0 }}" data-refresh-interval="3" data-speed="2000" data-comma="true"></span></div>
                            <h5 class="nobottommargin">Projekata</h5>
                        </div>
                    </div>
                </div>

                <div class="widget subscribe-widget clearfix topmargin-sm">
                    <p style="margin-bottom: 0;">Svaki poduzetnički pothvat je je odraz hrabrosti i zaslužuje naše poštovanje.</p>
                    <hr>
                    <p style="margin-bottom: 10px;">Prijavite se na naš Newsletter da biste dobili važne obavjesti oko novih natječaja i posebnih ponuda.</p>
                    <div class="widget-subscribe-form-result"></div>
                    <form id="widget-subscribe-form" action="include/subscribe.php" role="form" method="post" class="nobottommargin">
                        <div class="input-group divcenter">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="icon-email2"></i></div>
                            </div>
                            <input type="email" id="widget-subscribe-form-email" name="widget-subscribe-form-email" class="form-control required email" placeholder="Upišite Vaš Email">
                            <div class="input-group-append">
                                <button class="btn btn-mrav" type="submit">Slažem se!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyrights -->
    <div id="copyrights" class="d-none d-sm-block">
        <div class="container clearfix">
            <div class="col_three_fourth nobottommargin">
                <div class="copyrights-menu copyright-links clearfix">
                    <a href="{{ route('index') }}">Naslovna</a>/
                    @foreach ($categories as $category)
                        @if ($loop->first)
                            <a href="{{ route('page', ['cat' => $category->slug]) }}">{{ $category->name }}</a>
                        @else
                            /<a href="{{ route('page', ['cat' => $category->slug]) }}">{{ $category->name }}</a>
                        @endif
                    @endforeach
                </div>
                Copyrights <span style="color: #c23138;">&copy;</span> {{ $appinfo->name }} {{ date('Y') }} Sva prava pridržana.
            </div>
            <div class="col_one_fourth col_last tright nobottommargin">
                <div class="fright clearfix">
                    <a href="#" class="social-icon si-small si-light nobottommargin si-facebook">
                        <i class="icon-facebook"></i>
                        <i class="icon-facebook"></i>
                    </a>
                    <a href="#" class="social-icon si-small si-light nobottommargin si-linkedin">
                        <i class="icon-linkedin"></i>
                        <i class="icon-linkedin"></i>
                    </a>
                </div>
                <div class="row col_full" style="font-size: 13px; padding-top: 3px; padding-right: 0; margin-right: 0;">
                    Napravljeno s <span style="color: #c23138;">&hearts;</span> <a href="https://www.agmedia.hr"><img src="https://www.agmedia.hr/themes/agmedia/assets/images/ag-footer-logo.svg" alt="AGmedia"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Copyrights -->
    <div id="copyrights" class="d-block d-sm-none" style="padding: 10px 0 20px 0; color: grey">
        <div class="container clearfix">
            <div class="col_full nobottommargin" style="margin-bottom: 0px !important;">
                Copyrights <span style="color: #c23138;">&copy;</span> {{ $appinfo->name }} {{ date('Y') }}
                <div id="side-panel-trigger" class="side-panel-trigger hidden-xs-down" style="right: 5px; margin: 0;"><i class="icon-info"></i></div>
            </div>
        </div>
    </div>
</footer>
