@extends('frontend.layouts.app')
@section('title', 'Change Password')
@section('style')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/owl.carousel.min.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
@endsection
@section('content')
<!--Inner Home Banner Start-->
<div class="wt-haslayout wt-innerbannerholder">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
        <div class="wt-innerbannercontent">
          <div class="wt-title"><h2>See How It Works?</h2></div>
          <ol class="wt-breadcrumb">
            <li><a href="index-2.html">Home</a></li>
            <li class="wt-active">How It Works</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Inner Home End-->
<!--Main Start-->
<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
  <!--Categories Start-->
  <div class="wt-haslayout wt-main-section">
    <div class="wt-contentwrappers">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-start">
            <div class="wt-howitwork-hold wt-bgwhite wt-haslayout">
              <ul class="wt-navarticletab wt-navarticletabvtwo nav navbar-nav">
                <li class="nav-item">
                  <a class="active cursor-pointer" id="all-tab" data-bs-toggle="tab" data-bs-target="#forhiring" role="tab" aria-controls="forhiring" aria-selected="true">For Hiring</a>
                </li>
                <li class="nav-item">
                  <a id="business-tab" class="cursor-pointer" data-bs-toggle="tab" data-bs-target="#forfreelancing" role="tab" aria-controls="forfreelancing" aria-selected="false">For Freelancing</a>
                </li>
                <li class="nav-item">
                  <a id="trading-tab" class="cursor-pointer" data-bs-toggle="tab" data-bs-target="#faq" role="tab" aria-controls="faq" aria-selected="false">FAQ</a>
                </li>
              </ul>
              <div class="tab-content wt-haslayout">
                <div class="wt-contentarticle tab-pane active fade show" id="forhiring">
                  <div class="row">
                    <div class="wt-starthiringhold wt-innerspace wt-haslayout">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-7 float-start">
                        <div class="wt-starthiringcontent">
                          <div class="wt-sectionhead">
                            <div class="wt-sectiontitle">
                              <h2>How To Start Hiring</h2>
                              <span>Start Today For a Great Future</span>
                            </div>
                            <div class="wt-description">
                              <p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua eniina ilukita ylokem lokateise ination voluptate velite esse cillum dolore eu fugnulla pariatur lokaim urianewce animid <a href="javascript:void(0);">Learn more</a></p>
                            </div>
                          </div>
                          <ul class="wt-accordionhold accordion">
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingOne" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <span>Adipisicing elit, sed do eiusmod tempor incididunt?</span>
                              </div>
                              <div class="wt-accordiondetails collapse show" id="collapseOne" aria-labelledby="headingOne">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore eta dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingtwo" data-bs-toggle="collapse" data-bs-target="#collapsetwo">
                                <span>Dolore magna aliqua enim ad minim veniam?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsetwo" aria-labelledby="headingtwo">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingthreea" data-bs-toggle="collapse" data-bs-target="#collapsethree">
                                <span>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsethree" aria-labelledby="headingthreea">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-5 float-end">
                        <div class="wt-howtoworkimg">
                          <figure>
                            <img src="{{asset('assets/images/work/img-01.jpg')}}" alt="img description">
                          </figure>
                        </div>
                      </div>
                    </div>
                    <div class="wt-starthiringhold wt-innerspace wt-haslayout">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-7 float-end">
                        <div class="wt-starthiringcontent">
                          <div class="wt-sectionhead">
                            <div class="wt-sectiontitle">
                              <h2>Getting Into Business</h2>
                              <span>Focus on Your Work &amp; Team</span>
                            </div>
                            <div class="wt-description">
                              <p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua eniina ilukita ylokem lokateise ination voluptate velite esse cillum dolore eu fugnulla pariatur lokaim urianewce animid learn <a href="javascript:void(0);">more</a></p>
                            </div>
                          </div>
                          <ul class="wt-accordionhold accordion">
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingtwo2" data-bs-toggle="collapse" data-bs-target="#collapsetwo2">
                                <span>Nostrud exercitation ullamco laboris nisi ut aliquip?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsetwo2" aria-labelledby="headingtwo2">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingtwo4" data-bs-toggle="collapse" data-bs-target="#collapsetwo4">
                                <span>Commodo consequat aute irure dolor in reprehenderit in voluptate velit?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsetwo4" aria-labelledby="headingtwo4">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingthree2" data-bs-toggle="collapse" data-bs-target="#collapsethree2">
                                <span>Cillum dolore eu fugiat nulla pariatur?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsethree2" aria-labelledby="headingthree2">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-5 float-start">
                        <div class="wt-howtoworkimg">
                          <figure>
                            <img src="{{asset('assets/images/work/img-02.jpg')}}" alt="img description">
                          </figure>
                        </div>
                      </div>
                    </div>
                    <div class="wt-starthiringhold wt-innerspace wt-haslayout">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-7 float-start">
                        <div class="wt-starthiringcontent">
                          <div class="wt-sectionhead">
                            <div class="wt-sectiontitle">
                              <h2>Making Serious Profit</h2>
                              <span>Manage Your Profitable Account</span>
                            </div>
                            <div class="wt-description">
                              <p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua eniina ilukita ylokem lokateise ination voluptate velite esse cillum dolore eu fugnulla pariatur lokaim urianewce animid learn <a href="javascript:void(0);">more</a></p>
                            </div>
                          </div>
                          <ul class="wt-accordionhold accordion">
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingOne3" data-bs-toggle="collapse" data-bs-target="#collapseOne3">
                                <span>Excepteur sint occaecat cupidatat non proident?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapseOne3" aria-labelledby="headingOne3">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingtwo3" data-bs-toggle="collapse" data-bs-target="#collapsetwo3">
                                <span>Sunt in culpa qui officia deserunt mollit anim id est laborum?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsetwo3" aria-labelledby="headingtwo3">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingthree3" data-bs-toggle="collapse" data-bs-target="#collapsethree3">
                                <span>Sed ut perspiciatis unde omnis iste natus error sit voluptatem?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsethree3" aria-labelledby="headingthree3">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-5 float-end">
                        <div class="wt-howtoworkimg">
                          <figure>
                            <img src="{{asset('assets/images/work/img-03.jpg')}}" alt="img description">
                          </figure>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="wt-contentarticle tab-pane fade" id="forfreelancing">
                  <div class="row">
                    <div class="wt-starthiringhold wt-innerspace wt-haslayout">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-7 float-end">
                        <div class="wt-starthiringcontent">
                          <div class="wt-sectionhead">
                            <div class="wt-sectiontitle">
                              <h2>How To Start Hiring</h2>
                              <span>Start Today For a Great Future</span>
                            </div>
                            <div class="wt-description">
                              <p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua eniina ilukita ylokem lokateise ination voluptate velite esse cillum dolore eu fugnulla pariatur lokaim urianewce animid learn <a href="javascript:void(0);">more</a></p>
                            </div>
                          </div>
                          <ul class="wt-accordionhold accordion">
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingOneq" data-bs-toggle="collapse" data-bs-target="#collapseOneq">
                                <span>Adipisicing elit, sed do eiusmod tempor incididunt?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapseOneq" aria-labelledby="headingOneq">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingtwoq" data-bs-toggle="collapse" data-bs-target="#collapsetwoq">
                                <span>Dolore magna aliqua enim ad minim veniam?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsetwoq" aria-labelledby="headingtwoq">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingthreeq" data-bs-toggle="collapse" data-bs-target="#collapsethreeq">
                                <span>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsethreeq" aria-labelledby="headingthreeq">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 col-lg-5 float-start">
                        <div class="wt-howtoworkimg">
                          <figure>
                            <img src="{{asset('assets/images/work/img-01.jpg')}}" alt="img description">
                          </figure>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="wt-contentarticle tab-pane fade" id="faq">
                  <div class="row">
                    <div class="wt-starthiringhold wt-innerspace wt-haslayout">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-7 float-start">
                        <div class="wt-starthiringcontent">
                          <div class="wt-sectionhead">
                            <div class="wt-sectiontitle">
                              <h2>How To Start Hiring</h2>
                              <span>Start Today For a Great Future</span>
                            </div>
                            <div class="wt-description">
                              <p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua eniina ilukita ylokem lokateise ination voluptate velite esse cillum dolore eu fugnulla pariatur lokaim urianewce animid learn <a href="javascript:void(0);">more</a></p>
                            </div>
                          </div>
                          <ul class="wt-accordionhold accordion">
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingOnea" data-bs-toggle="collapse" data-bs-target="#collapseOnea">
                                <span>Nostrud exercitation ullamco laboris nisi ut aliquip?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapseOnea" aria-labelledby="headingOne">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingtwoa" data-bs-toggle="collapse" data-bs-target="#collapsetwoa">
                                <span>Commodo consequat aute irure dolor in reprehenderit in voluptate velit?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsetwoa" aria-labelledby="headingtwoa">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                            <li>
                              <div class="wt-accordiontitle collapsed" id="headingthree" data-bs-toggle="collapse" data-bs-target="#collapsethreea">
                                <span>Cillum dolore eu fugiat nulla pariatur?</span>
                              </div>
                              <div class="wt-accordiondetails collapse" id="collapsethreea" aria-labelledby="headingthree">
                                <div class="wt-title">
                                  <h3>Digital Marketing</h3>
                                </div>
                                <div class="wt-description">
                                  <p>
                                    Consectetur adipisicing elit sed aeiusmisuod tempor incididunt labore dolore ma alaeiqua enim ade minim veniam quis nostr xecitation ullamcoaris nisi ut aliquipa extaea coedmmmodo equate irure dolawor in reprehenderit.
                                  </p>
                                </div>
                                <!-- <div class="wt-likeunlike">
                                  <span>Did you find this useful?</span>
                                  <a href="javascript:void(0);" class="wt-like"><i class="fa fa-thumbs-up"></i></a>
                                  <a href="javascript:void(0);" class="wt-unlike"><i class="fa fa-thumbs-down"></i></a>
                                </div> -->
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4 col-lg-5 float-end">
                        <div class="wt-howtoworkimg">
                          <figure>
                            <img src="{{asset('assets/images/work/img-01.jpg')}}" alt="img description">
                          </figure>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Limitless Experience End-->
</main>
<!--Main End-->
@endsection
@section('script')
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.hoverdir.js') }}"></script>
@endsection
