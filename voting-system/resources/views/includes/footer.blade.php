<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 footer_col">
                <div class="footer_column footer_contact">
                    <div class="logo_container">
                        <div class="logo"><a href="{{ config('app.url') }}">Revolt Rap League</a></div>
                    </div>
                    <div class="footer_title">Got Question? Call Us 24/7</div>
                    <div class="footer_phone" style="color: #F8A11C">+16143792522</div>
                    <div class="footer_contact_text">
                        <p>5440 Branchville dr</p>
                        <p>Canal Winchester OH 43110</p>
                    </div>
                    <div class="footer_social">
                        <ul>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fab fa-google"></i></a></li>
                            <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 offset-lg-2">
                <div class="footer_column">
                    <div class="footer_title"></div>
                    <ul class="footer_list">
                        {{-- @foreach ($popular_brands as $item)
                        <li><a href="{{ config('app.url') }}/all/{{ $item->id }}">{{$item->name}}</a></li>                    
                        @endforeach --}}
                    </ul>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="footer_column">
                    <ul class="footer_list footer_list_2">
                        {{-- @foreach ($popular_brands as $item)
                        <li><a href="{{ config('app.url') }}/all/{{ $item->id }}">{{$item->name}}</a></li>                    
                        @endforeach --}}
                    </ul>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="footer_column">
                    <div class="footer_title">Navigation</div>
                    <ul class="footer_list">
                        <li><a href="{{ config('app.url') }}/groups">Nominations</a></li>
                        <li><a href="{{ config('app.url') }}/profile">Profile</a></li>
                        <li><a href="{{ config('app.url') }}/dashboard">Results</a></li>
                        <li><a href="https://revoltdaily.com/contact/">Contact Us</a></li>
                        <li><a href="https://revoltdaily.com/about-us/">About Us</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>

<!-- Copyright -->

<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col">

                <div
                    class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
                    <div class="copyright_content">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());

                        </script> All rights reserved | Powered by <a style="color: #F8A11C"
                            href="https://77developers.com/" target="_blank">77developers Ghana</a>.
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                    <div class="logos ml-sm-auto">
                        <ul class="logos_list">
                            {{-- <li><a href="#"><i style="color: #F8A11C" class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i style="color: #F8A11C" class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i style="color: #F8A11C" class="fab fa-youtube"></i></a></li>
                            <li><a href="#"><i style="color: #F8A11C" class="fab fa-google"></i></a></li>
                            <li><a href="#"><i style="color: #F8A11C" class="fab fa-vimeo-v"></i></a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
