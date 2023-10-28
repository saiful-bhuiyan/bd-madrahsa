@extends('frontend.layout.master')

@section('body')

<section class="marque">
    <marquee width="100%" direction="left" height="auto" scrollamount="10" onmouseover="this.stop()" onmouseleave="this.start()">
        This is a sample scrolling text that has scrolls in the upper direction.
    </marquee>
</section>

@if($banner_image)

<section class="slider container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @php
                    $count = DB::table('banner_images')->where('status',1)->count();

                    $slideCount = 0;

                    $checkActive = "";

                    @endphp

                    @if($count > 0)

                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    @endif

                    @for($i = 2; $i <= $count; $i++) @php $slide=$i - 1; @endphp <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$slide}}" aria-label="Slide {{$slide}}"></button>
                        @endfor


                </div>
                <div class="carousel-inner">
                    @foreach($banner_image as $b)
                    @php
                    $slideCount += 1;
                    @endphp

                    @php

                    if($slideCount == 1)
                    $checkActive = "active";
                    else
                    $checkActive = "";
                    @endphp

                    <div class="carousel-item {{$checkActive}}">
                        <img src="{{asset('backend')}}/bannerImage/{{$b->image}}" class="d-block w-100 slider_image" alt="...">
                        <div class="carousel-caption  d-md-block">
                            <h5>@if($lang == 'en') {{$b->title_en}} @elseif($lang == 'bn') {{$b->title_bn}} @endif</h5>
                            <p>@if($lang == 'en') {{$b->description_en}} @elseif($lang == 'bn') {{$b->description_bn}} @endif</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</section>

@endif

<section>
    <div class="container ">
        <div class="col-lg-12">
            <div class="row ">
                <div class="col-sm-8 col-12 ">

                    <!-- Notice board -->

                    <div class="col-lg-12 col-sm-12 mt-3 notice_info shadow-lg rounded-3 bg-white p-2 " >

                        <div class="col-lg-12 col-sm-12 bg-success rounded-top">
                            <div class="row">
                                <div class="col-8 text-center ">
                                    <h4 class="text-white ">@lang('frontend.notice')</h4>
                                </div>
                                <div class="col-4 ">
                                    <span id="prev-button" class="fs-4 p-2"><i class="fa fa-caret-left text-white"></i></span>
                                    <span id="next-button" class="fs-4"><i class="fa fa-caret-right text-white"></i></span>
                                </div>

                            </div>

                        </div>
                        <hr>

                        @if($notice_board)

                        <ul id="newsticker">
                        @foreach($notice_board as $n)
                        @php 
                        $newtime = strtotime($n->created_at);
	                    $date = date('d',$newtime);
	                    $month = date('M',$newtime);
                        $fullDate = date('d M Y',$newtime);
                        @endphp
                            <li class="list-unstyled list_notice ">
                                <a href="{{url('notice_view')}}/{{$n->id}}" class="text-decoration-none text-dark ">
                                <div class="col-lg-12">
                                    <div class="row list-group-item-action">
                                        <div class="col-2">
                                            <div class="m-2 text-center">
                                                <div style="width: 60px;" class="bg-danger text-white">
                                                    <p style="margin-bottom: 0 !important;">{{$date}}</p>
                                                </div>
                                                <div style="background-color: lightgray;width: 60px;">
                                                    <p>{{$month}}</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-10 ">
                                            <div class="p-2 ms-3">
                                                <h5 class="responsive-h5">@if($lang == 'en') {{$n->title_en}} @elseif($lang == 'bn') {{$n->title_bn}} @endif</h5>
                                                <i class="fa fa-calendar"></i> {{$fullDate}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                                <hr>
                            </li>
                        @endforeach

                            
                        </ul>
                        @endif
                    </div>

                    <div class="col-lg-12 col-sm-12 mt-3 about_institute border shadow-lg rounded-3 p-2">
                        <div class="col-lg-12 col-sm-12 bg-warning rounded-top">
                            <h3 class="text-center text-white">About Institute</h3>
                        </div>
                        <div class="col-lg-12">
                            <div class="p-3">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                                    and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($academic_detail)

                    <div class="col-lg-12 col-sm-12 mt-3 information_card ">
                        <div class="row">

                        @foreach($academic_detail as $ad)

                            <div class="card col-lg-5 col-md-5 col-sm-10 border shadow-lg rounded-3 m-2">
                                <div class="card-title pt-2">
                                    <h4 class="text-center">@if($lang == 'en') {{$ad->title_en}} @elseif($lang == 'bn') {{$ad->title_bn}} @endif</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{asset('backend')}}/img/academicImage/{{$ad->image}}" class="bg-white" width="70px" height="70px" alt="">
                                        </div>
                                        <div class="col-9">
                                            @if($sub_academic_detail)
                                            @foreach($sub_academic_detail as $sad)
                                                @if($ad->id == $sad->ad_id)
                                                <div>
                                                    <i class="fa fa-caret-right"></i>
                                                    &nbsp;
                                                    <a href="#" class="text-decoration-none text-dark">@if($lang == 'en') {{$sad->item_name_en}} @elseif($lang == 'bn') {{$sad->item_name_bn}} @endif</a>
                                                </div>
                                                @endif
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach

                    </div>
                    @endif
                </div>
            
                <div class="col-lg-4 col-sm-12">
                    @if($teacher_crud)
                    <div class="col-sm-12 col-lg-12 mt-3 teacher_section">

                        @foreach($teacher_crud as $t)
                        <div class="bg-white h-full border mb-2 teacher_card shadow-lg rounded-3">
                            <div class="col-12">
                                <div class="text-center bg-danger m-2 text-white rounded " style="padding-bottom: 1px;">
                                    <h3>@if($lang == 'en') {{$t->headline_en}} @elseif($lang == 'bn') {{$t->headline_bn}} @endif</h3>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-sm-12 ">
                                        <img src="{{asset('backend')}}/teacherCrudImage/{{$t->image}}" class="p-2 mx-auto d-block img_height" alt="">
                                    </div>
                                    <div class="col-lg-7 col-sm-12">
                                        <h5 class="text-center pt-2 pe-2 fw-bold">@if($lang == 'en') {{$t->title_en}} @elseif($lang == 'bn') {{$t->title_bn}} @endif</h5>
                                        <p class="ms-4 text-center">@if($lang == 'en') {{$t->description_en}} @elseif($lang == 'bn') {{$t->description_bn}} @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="col-sm-12 col-lg-12 mt-3 Important_links border">
                        <div class="col-sm-12 col-lg-12 shadow-lg ">
                            <div class="col-12 bg-info border">
                                <h4 class="text-center">Important link</h4>
                            </div>
                            <div class=" bg-white">
                                <div class="col-12 p-4">
                                    <div class="pt-2">
                                        <i class="fa fa-caret-right"></i>
                                        &nbsp;
                                        <a href="https://www.moedu.gov.bd/" class="text-decoration-none text-dark">শিক্ষা মন্ত্রণালয়</a>
                                    </div>
                                    <div class="pt-2">
                                        <i class="fa fa-caret-right"></i>
                                        &nbsp;
                                        <a href="https://bangladesh.gov.bd/index.php" class="text-decoration-none text-dark">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-sm-12 mt-3">
                        <div class="bg-white p-2">
                            <a href="#">
                                <img src="{{asset('frontend')}}/img/gov/gv_17.png" width="100%" height="100px" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 mt-3">
                        <div class="bg-white p-2">
                            <a href="#">
                                <img src="{{asset('frontend')}}/img/gov/gv_10.png" width="100%" height="100px" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 mt-3">
                        <div class="bg-white p-2">
                            <a href="#">
                                <img src="{{asset('frontend')}}/img/gov/gv_20.png" width="100%" height="100px" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 mt-3">
                        <div class="bg-white p-2">
                            <a href="#">
                                <img src="{{asset('frontend')}}/img/gov/gv_16.png" width="100%"  alt="">
                            </a>
                        </div>
                    </div>

                </div>

                
            </div>
        </div>
    </div>
</section>

<script>
    $('#newsticker').newsTicker({
        row_height: 120,
        max_rows: 2,
        speed: 600,
        direction: 'up',
        duration: 4000,
        autostart: 1,
        pauseOnHover: 0,
        prevButton:  $('#prev-button'),
        nextButton:  $('#next-button')
    });

    
</script>

@endsection