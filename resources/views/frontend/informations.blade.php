@extends('frontend.layout.master')

@section('body')

@if($sub_nav_info)


<!-- sajjjad -->
<div class="container text-center w-100 h-auto" style="height: 40px;">
    <h2 class="p-2 ToP">{{$sub_nav_info->title_en}}</h2>
</div>


<section class="aboutAcademy">

    <div class="container h-auto mt-5">

        <div class="row align-items-center">
            <div class="col-lg-8 col-sm-8 container px-4 h5 lh-base">
                <img class="col-12" src="{{asset('backend')}}/img/subNavInformation/{{$sub_nav_info->image}}" alt="">
            </div>
            <div class="col-lg-8 col-sm-8 container mt-5 px-4 h5 lh-base">
                <P>
                  {{$sub_nav_info->description_en}}
                </P>
            </div>
        </div>

    </div>
</section>




<!-- email -->

<div class="container" style=" background-color: #052e59;">
    <div>
        <div class="row footer-contact-desc">
            <div class="col-md-4">
                <div class="contact-inner">
                    <p style="text-align:center !important;"><i class="fa fa-map-marker text-center text-light"></i></p>

                    <h4 class="contact-title text-light text-center">Address</h4>
                    <p class="contact-desc text-light text-center">
                        G. P. O. Box No. 5
                        Toyenbee Circular Rd, Dhaka 1000, Bangladesh
                    </p>

                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-inner">
                    <p style="text-align:center !important;"><i class="fa fa-map-marker text-center text-light"></i></p>
                    <h4 class="contact-title text-light text-center">Phone Number</h4>
                    <p class="contact-desc text-light text-center">
                        +88-02-41070712
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-inner">
                    <p style="text-align:center !important;"><i class="fa fa-map-marker text-center text-light"></i></p>
                    <h4 class="contact-title text-light text-center">Email Address</h4>
                    <p class="contact-desc text-light text-center">
                        notredamecollege@ndc.edu.bd<br>
                        ndc.edu.bd
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endif




<!-- sajjad end -->

@endsection