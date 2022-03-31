
<div id="side-panel" class="dark">
    <div id="side-panel-trigger-close"><a href="#"><i class="icon-line-cross"></i></a></div>
    <div class="side-panel-wrap" style="padding-top: 25px;">
        <div class="widget clearfix">
            <h4 style="padding-bottom: 12px; border-bottom: 1px solid #4e4e4e; margin-bottom: 18px; color: #c23138;">Navigacija</h4>
            <nav class="nav-tree nobottommargin">
                <ul>
                    @foreach ($categories as $category)
                        @if ( ! $category->subcategory)
                            <li style="margin-top: 3px;"><a href="{{ route('page', ['cat' => $category->slug]) }}">{{ $category->name }}</a></li>
                        @else
                            @if ($category->single_page)
                                <li style="margin-top: 3px;"><a href="{{ route('page', ['cat' => $category->slug, 'subcat' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                            @else
                                <li style="margin-top: 3px;"><a href="{{ route('page', ['cat' => $category->slug]) }}">{{ $category->name }}</a>
                                    <ul>
                                        @foreach ($category->subcategory as $subcategory)
                                            <li style="padding-left: 0;"><a href="{{ route('page', ['cat' => $category->slug, 'subcat' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </nav>

            <h4 style="padding-bottom: 12px; border-bottom: 1px solid #4e4e4e; margin-bottom: 18px; margin-top: 40px; color: #c23138;">Informacije</h4>
            <nav class="nav-tree nobottommargin">
                <ul>
                    <li><a href="#">Korisne informacije</a>
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
                    </li>
                    <li><a href="#">RA Mrav Agencija</a>
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
                    </li>
                </ul>
            </nav>

            <h4 style="padding-bottom: 12px; border-bottom: 1px solid #4e4e4e; margin-bottom: 18px; margin-top: 60px; color: #c23138;">Sjedište</h4>
            <div class="col-full nobottommargin t500" style="color: #9c9c9c">
                <address style="margin-bottom: 10px;">
                    Razvojna agencija MRAV d.o.o.<br>
                    Hrvatskih branitelja 2<br>
                    44320 Kutina, Hrvatska<br>
                </address>
                <address style="margin-bottom: 15px;">
                    <span style="margin-bottom: 0;"><abbr title="Phone Number"><strong>Tel:</strong></abbr> +385 44 659 078</span><br>
                    <span style="margin-bottom: 0;"><abbr title="Fax"><strong>Fax:</strong></abbr> +385 44 659 078</span><br>
                    <span style="margin-bottom: 0;"><abbr title="Email Address"><strong>Email:</strong></abbr> <a href="{{ url('kontakt') }}">Kontaktirajte nas!</a></span>
                </address>
                <div class="clearfix" style="font-size: 13px; position: absolute; bottom: -75px;">
                    Web napravljen <span style="color: #c23138;">&hearts;</span> <a href="https://www.agmedia.hr"><img src="https://www.agmedia.hr/themes/agmedia/assets/images/ag-footer-logo.svg" height="25" alt="AGmedia"></a>
                </div>
            </div>
        </div>
    </div>
</div>
