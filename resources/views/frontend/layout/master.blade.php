<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madrasha</title>
    <link rel="icon" type="image/x-icon" href="{{asset('frontend')}}/img/logo.png">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/style.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="{{asset('js')}}/chart.js"></script>
    <script src="{{asset('js')}}/prism.js"></script>
    <script src="{{asset('js')}}/jquery.mCustomScrollbar.min.js"></script>
    <script src="{{asset('js')}}/jquery.newsTicker.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <style>
        
    </style>

</head>
<body>

    <!-- Start Header -->
    <section class="header_section">
        <div class="container">
            <div class="d-flex">
                <div class="logo col-lg-1 col-sm-2 col-xs-2">
                    <img src="{{asset('frontend')}}/img/logo.png" alt="logo">
                </div>
                <div class="headline text-start ms-1 mt-3 col-lg-8 col-sm-7 col-xs-7">
                    <h1 class="">@lang('frontend.headline')</h1>
                </div>
                <div class="text-center col-lg-3 col-sm-3 col-xs-3 m-auto">
                <form method="post" action="{{url('change_lang')}}">
                    @csrf
                    <select class="form-control" name="lang" onchange="this.form.submit()">
                        <option {{ session()->get('locale') == 'en' ? 'selected' : '' }} value="en">English</option>
                        <option {{ session()->get('locale') == 'bn' ? 'selected' : '' }} value="bn">বাংলা</option>
                    </select>
                </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <nav class="navbar navbar-expand-lg navbar-dark navbg">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon border"></span>
                </button>
                <div class="collapse navbar-collapse w-100 align-items-center justify-content-center" id="main_nav">
                    <ul class="navbar-nav">
                        @if($nav_item)
                        @foreach($nav_item as $n)
                        @php 
                        $count = DB::table('sub_nav_items')->where('nav_id',$n->id)->count();
                        @endphp
                            @if($count > 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" data-bs-toggle="dropdown">@if($lang == 'en') {{$n->nav_name_en}} @elseif($lang == 'bn') {{$n->nav_name_bn}} @endif</a>
                                <ul class="dropdown-menu">
                                @foreach($sub_nav_item as $s)
                                    @if($n->id == $s->nav_id)
                                        @if($s->route_name == "" or null)
                                        <li><a class="dropdown-item" href="{{url('informations')}}/{{$s->id}}">
                                            @if($lang == 'en') {{$s->sub_nav_name_en}} @elseif($lang == 'bn') {{$s->sub_nav_name_bn}} @endif</a></li>
                                        @else
                                        <li><a class="dropdown-item" href="{{url($s->route_name)}}">
                                            @if($lang == 'en') {{$s->sub_nav_name_en}} @elseif($lang == 'bn') {{$s->sub_nav_name_bn}} @endif</a></li>
                                        @endif
                                    @endif
                                @endforeach
                                </ul>
                            </li>
                            @else
                                <li class="nav-item {{request()->Is('/') ? 'active' : ''}} "> <a class="nav-link text-white"
                                @if($n->route_name == "" or null)
                                href="#"   
                                @else
                                href="{{url($n->route_name)}}"
                                @endif
                                >@if($lang == 'en') {{$n->nav_name_en}} @elseif($lang == 'bn') {{$n->nav_name_bn}} @endif </a> </li> 
                            @endif
                        @endforeach
                        

                        @if($notice_board)
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="drowpdown">@lang('frontend.notice')</a>
                                <ul class="dropdown-menu">
                                    @foreach($notice_board as $n)
                                    <li>
                                        <a href="" class="dropdown-item">@if($lang == 'en') {{$n->title_en}} @elseif($lang == 'bn') {{$n->title_bn}} @endif</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        @endif

                        
                    </ul>
                    
                    
                </div> <!-- navbar-collapse.// -->
            </div> <!-- container-fluid.// -->
        </nav>
    </section>

    <!-- End Header -->

    @yield('body')

   
     <!-- Footer -->
    <section>

        <div class="container my-5">
           
            <footer class="text-center text-lg-start text-dark shadow-lg" style="background-color: #ECEFF1">
                <!-- Section: Social media -->
                <section class="d-flex justify-content-between p-4 text-white" style="background-color: #2f3b89">
                    <!-- Left -->
                    <div class="me-5">
                        <span>Get connected with us on social networks</span>
                    </div>
                    <!-- Left -->
    
                    <!-- Right -->
                    <div>
                        <a href="" class="text-white me-4">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="" class="text-white me-4">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="" class="text-white me-4">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <!-- Right -->
                </section>
                <!-- Section: Social media -->
    
                <!-- Section: Links  -->
                <section class="">
                    <div class="container text-center text-md-start mt-5">
                        <!-- Grid row -->
                        <div class="row mt-3">
                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                                <!-- Content -->
                                <h6 class="text-uppercase fw-bold">@lang('frontend.headline')</h6>
                                <hr class="mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px; background-color: #106f46; height: 2px" />
                                <p>
                                   Lorem ipsum dolor sit amet, consectetur adipisicing
                                    elit.
                                </p>
                            </div>
                            <!-- Grid column -->
    
                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold">Useful links</h6>
                                <hr class="mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px; background-color: #106f46; height: 2px" />
                                <p>
                                    <a href="#!" class="text-dark">Our Location</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-dark">Admission</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-dark">Students</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-dark">Help</a>
                                </p>
                            </div>
                            <!-- Grid column -->
    
                            <!-- Grid column -->
                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold">Contact</h6>
                                <hr class="mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px; background-color: #106f46; height: 2px" />
                                <p><i class="fas fa-home mr-3"></i> Feni, Bangladesh</p>
                                <p><i class="fas fa-envelope mr-3"></i> info@example.com</p>
                                <p><i class="fas fa-phone mr-3"></i> + 01111 111111</p>
                                <p><i class="fas fa-print mr-3"></i> + 01111 111111</p>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                    </div>
                </section>
                <!-- Section: Links  -->
    
                <!-- Copyright -->
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                   <p class="fs-5 fw-bold"> DEVELOP BY SAIFUL ISLAM   </p>
                </div>
                <!-- Copyright -->
            </footer>
            <!-- Footer -->
        </div>
    </section>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

 <script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="https://risq.github.io/jquery-advanced-news-ticker/assets/js/jquery.newsTicker.js"></script>

 <script>
    document.addEventListener("DOMContentLoaded", function(){
    // make it as accordion for smaller screens
    if (window.innerWidth > 992) {

        document.querySelectorAll('.navbar .nav-item').forEach(function(everyitem){

            everyitem.addEventListener('mouseover', function(e){

                let el_link = this.querySelector('a[data-bs-toggle]');

                if(el_link != null){
                    let nextEl = el_link.nextElementSibling;
                    el_link.classList.add('show');
                    nextEl.classList.add('show');
                }

            });
            everyitem.addEventListener('mouseleave', function(e){
                let el_link = this.querySelector('a[data-bs-toggle]');

                if(el_link != null){
                    let nextEl = el_link.nextElementSibling;
                    el_link.classList.remove('show');
                    nextEl.classList.remove('show');
                }


            })
        });

    }
    // end if innerWidth
    }); 
    // DOMContentLoaded  end
 </script>

 
</body>
</html>