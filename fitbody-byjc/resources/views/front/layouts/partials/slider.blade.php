@if (isset($sliders[0]))
    <section id="slider" class="slider-element slider-parallax swiper_wrapper">
        <div class="slider-parallax-inner">
            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide {{ $slider->text_color == 'white' ? 'dark' : '' }}" style="background-image: url({{ asset($slider->image) }});">
                            <div class="container clearfix">
                                <div class="slider-caption {{ $slider->text_placement == 'center' ? 'slider-caption-center' : '' }}">
                                    <h2 data-animate="fadeInUp">{{ $slider->title }}</h2>
                                    <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">{{ $slider->subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($sliders->count() > 1)
                    <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
                    <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
                @endif
            </div>
        </div>
    </section>
@else
    <section id="slider" class="slider-element slider-parallax swiper_wrapper">
        <div class="slider-parallax-inner">
            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    <div class="swiper-slide dark" style="background-image: url({{ asset('media/images/default_slider.jpg') }});">
                        <div class="container clearfix">
                            <div class="slider-caption slider-caption-center">
                                <h2 data-animate="fadeInUp">Dobrodošli</h2>
                                <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">Mi smo digitalna agencija koja primarno pruža usluge web dizajna i web developmenta te marketinga i brandinga.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


{{--
<section id="slider" class="slider-element swiper_wrapper full-screen clearfix" data-loop="false" data-autoplay="5000">

    <div class="swiper-container swiper-parent">
        <div class="swiper-wrapper">
            <!--<div class="swiper-slide" style="background-image: url('demos/mrav/images/slider/1.jpg');">
                <div class="container clearfix">
                    <div class="slider-caption slider-caption-right" style="max-width: 700px;">
                        <h2 data-animate="flipInX">Team of Experts<span>.</span></h2>
                        <p class="d-none d-sm-block" data-animate="flipInX" data-delay="500">Our Team of Doctors are specialized in Various Disciplines to make sure you get the Best Treatment.</p>
                    </div>
                </div>
            </div>-->


            <div class="swiper-slide" style="background-image: url('{{ asset('media/temp/slider/1.jpg') }}');
                ;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;">
                <div class="container clearfix">
                    <div class="slider-caption slider-caption-top-left">
                        <h2 data-animate="zoomIn">RAZVOJNA AGENCIJA<br><span>RA Mrav</span>.</h2>
                        <p class="d-none d-sm-block" data-animate="zoomIn" data-delay="500">Održivo povećanje životnog standarda i lokalnog razvoja Moslavačke regije  i šire</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <a href="#" class="scroll-down d-none d-lg-block" data-scrollto="#content" data-offset="80">
        <span class="scroll-mouse"><span class="scroll-wheel"></span></span>
    </a>

</section>
--}}
