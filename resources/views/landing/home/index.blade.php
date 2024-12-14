@extends('landing.layouts.app')



@section('style-landing')
@endsection



@section('content-landing')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Blinker:wght@100;200;300;400;600;700;800;900&display=swap');

        h1 {
            padding: 0 0 30px;
        }

        a:hover {
            text-decoration: none;
        }

        .product-grid {
            font-family: "Blinker", sans-serif;
            text-align: center;
            padding: 10px 10px;
            margin: 0 auto;
            border: 2px solid #dedade;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .product-grid:hover {
            border: 2px solid #003844;
        }

        .product-grid .product-image {
            position: relative;
        }

        .product-grid .product-image a.image {
            display: block;
        }

        .product-grid .product-image img {
            width: 100%;
            height: auto;
        }

        .product-image .pic-1 {
            transition: all .5s ease;
        }

        .product-grid:hover .product-image .pic-1 {
            opacity: 0;
        }

        .product-image .pic-2 {
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            transition: all .5s ease;
        }

        .product-grid:hover .product-image .pic-2 {
            opacity: 1;
        }

        .product-grid .product-links {
            padding: 0;
            margin: 0;
            list-style: none;
            opacity: 1;
            border: 1px solid #aaa;
            position: absolute;
            top: 0;
            right: 0;
            transition: all .3s ease 0.3s;
        }

        .product-grid:hover .product-links {
            opacity: 1;
        }

        .product-grid .product-links li {
            margin: 0;
            display: block;
        }

        .product-grid .product-links li a i {
            line-height: inherit;
        }

        .product-grid .product-links li a {
            color: #aaa;
            background-color: #fff;
            font-size: 16px;
            font-weight: 600;
            line-height: 37px;
            height: 40px;
            width: 40px;
            margin: 0;
            border-bottom: 1px solid #aaa;
            display: block;
            position: relative;
            transition: all 0.3s ease 0.1s;
        }

        .product-grid .product-links li a:before,
        .product-grid .product-links li a:after {
            content: attr(data-tip);
            color: #fff;
            background: #000;
            font-size: 12px;
            line-height: 20px;
            padding: 5px 10px;
            border-radius: 5px 5px;
            white-space: nowrap;
            display: none;
            transform: translateY(-50%);
            position: absolute;
            right: 53px;
            top: 50%;
        }

        .product-grid .product-links li a:after {
            content: "";
            height: 15px;
            width: 15px;
            padding: 0;
            border-radius: 0;
            transform: translateY(-50%) rotate(45deg);
            right: 50px;
        }

        .product-grid .product-links li a:hover:before,
        .product-grid .product-links li a:hover:after {
            display: block;
        }

        .product-grid .product-links li a:hover {
            color: #fff;
            background-color: #003844;
        }

        .product-grid .product-content {
            padding: 10px 0 0;
        }

        .product-grid .rating {
            color: #ffd200;
            font-size: 14px;
            padding: 0;
            margin: 0 0 10px;
            list-style: none;
            display: inline-block;
        }

        .product-grid .rating li:last-child {
            color: #111;
            display: inline-block;
        }

        .product-grid .title {
            font-size: 17px;
            font-weight: 600;
            text-transform: capitalize;
            margin: 0 0 5px;
        }

        .product-grid .title a {
            color: #000;
            transition: all 0.3s ease 0s;
        }

        .product-grid .title a:hover {
            color: #003844;
        }

        .product-grid .price {
            color: #000;
            font-size: 20px;
            font-weight: 500;
            margin: 0 0 5px;
        }

        .product-grid .add-cart {
            color: #003844;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 11px 12px 10px;
            border: 1px solid #003844;
            display: block;
            position: relative;
            transition: all .3s ease;
            z-index: 1;
        }

        .product-grid .add-cart i {
            margin: 0 5px 0 0;
        }

        .product-grid .add-cart:hover {
            color: #fff;
        }

        .product-grid .add-cart:before {
            content: "";
            background: #003844;
            width: 0;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: all 0.3s ease-in-out;
            z-index: -1;
        }

        .product-grid .add-cart:hover:before {
            width: 100%;
        }

        @media screen and (max-width: 990px) {
            .product-grid {
                margin-bottom: 30px;
            }
        }

        /* SLIDER  */
        #container {
            /* height: 100vh; */
            width: 100vw;
            margin: 0;
            padding: 0;
            /* background: teal; */
            display: grid;
            place-items: center
        }

        #slider-container {
            height: auto;
            width: 85vw;
            max-width: 1400px;
            /* background: #54d5e4; */
            /* box-shadow: 5px 5px 8px gray inset; */
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        #slider-container .btn {
            z-index: 100000;
            position: absolute;
            top: calc(50% - 30px);
            height: 30px;
            width: 30px;
            border-left: 8px solid black;
            border-top: 8px solid black;
        }

        #slider-container .btn:hover {
            transform: scale(1.2);
        }

        #slider-container .btn.inactive {
            border-color: rgb(153, 121, 126)
        }

        #slider-container .btn:first-of-type {
            transform: rotate(-45deg);
            left: 10px
        }

        #slider-container .btn:last-of-type {
            transform: rotate(135deg);
            right: 10px;
        }

        #slider-container #slider {
            display: flex;
            width: 1000%;
            height: 100%;
            transition: all .5s;
        }

        #slider-container #slider .slide {
            height: 90%;
            /* margin: auto 10px; */
            /* background-color: #a847a4; */
            /* box-shadow: 2px 2px 4px 2px white, -2px -2px 4px 2px white; */
            display: grid;
            place-items: center;
        }

        #slider-container #slider .slide span {
            color: white;
            font-size: 150px;
        }

        @media only screen and (min-width: 1100px) {

            #slider-container #slider .slide {
                width: calc(2.5% - 20px);
            }

        }

        @media only screen and (max-width: 1100px) {

            #slider-container #slider .slide {
                width: calc(3.3333333% - 20px);
            }

        }

        @media only screen and (max-width: 900px) {

            #slider-container #slider .slide {
                width: calc(5% - 20px);
            }

        }

        @media only screen and (max-width: 550px) {

            #slider-container #slider .slide {
                width: calc(10% - 20px);
            }

        }
    </style>
    @include('pwa.layouts.partials.messages')

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

                @foreach ($slider as $s)
                    <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/slider/' . $s->image) }}" alt="">
                        <div class="carousel-container">
                            <h2>{{ $s->title }}<br></h2>
                            <p>{{ $s->description }}</p>
                            <a href="#featured-services" class="btn-get-started">Get Started</a>
                        </div>
                    </div><!-- End Carousel Item -->
                @endforeach

                <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>

                <ol class="carousel-indicators"></ol>

            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section" style="background: #FFBD7B;border-top:15px solid #F7941D ">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-emoji-smile"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/HASIL.png') }}" class="img-fluid"
                                style="max-width: 30%" alt="">
                            {{-- <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span> --}}
                            <p><strong>PRODUK BERKUALITAS</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-journal-richtext"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/ONGKIR.png') }}" class="img-fluid"
                                style="max-width: 30%" alt="">
                            <p><strong>FREE ONGKIR</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-headset"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/LAYANAN.png') }}" class="img-fluid"
                                style="max-width: 30%" alt="">
                            <p><strong>PELAYANAN PRIMA</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-people"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/ONLINE.png') }}" class="img-fluid"
                                style="max-width: 30%" alt="">
                            <p><strong>ONLINE SERVICE</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section -->

        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <center>
                    <h2>KATEGORI</h2>
                    <div><span>Kategori Produk</span></div>
                </center>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    @foreach ($category as $cat)
                        <div class="col-lg-3 col-md-2" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-item  position-relative">
                                <img src="{{ asset('assets/img/category/' . $cat->image) }}" class="img-fluid"
                                    style="max-width: 30%" alt="">
                                <a href="service-details.html" class="stretched-link" style="color: black">
                                    <p>
                                        <strong>
                                            {{ $cat->category }}
                                        </strong>
                                    </p>
                                </a>
                            </div>
                        </div><!-- End Service Item -->
                    @endforeach
                    <div class="col-lg-3 col-md-2" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item  position-relative">
                            <img src="{{ asset('assets-landing/img/home/LAIN LAIN.png') }}" class="img-fluid"
                                style="max-width: 30%" alt="">
                            <a href="service-details.html" class="stretched-link" style="color: black">
                                <p>
                                    <strong>
                                        Lain Lain
                                    </strong>
                                </p>
                            </a>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->


        <!-- Stats Section -->
        <section id="stats" class="stats section" style="background: #FFBD7B;border-top:15px solid #F7941D ">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    {{-- <div class="col-lg-2">
                        <img src="{{ asset('assets-landing/img/home/LAIN LAIN.png') }}" class="img-fluid">
                    </div> --}}
                        <div id="container">
                            <div id="slider-container">
                                <span onclick="slideRight()" class="btn"></span>
                                <div id="slider">
                                    @foreach ($product as $p)
                                    @php
    
                                        $catProd = App\Models\CategoryDocument::where('id', $p->id_category)->first();
    
                                    @endphp
                                    <div class="slide" style="margin: 10px">
                                        {{-- <div class="col-md-3 col-sm-6"> --}}
                                            <div class="product-grid" style="background: white">
                                                <div class="product-image">
                                                    <a href="#" class="image">
                                                        <img class="pic-1" src="{{ asset('assets/img/product/' . $p->image) }}">
                                                        <img class="pic-2" src="{{ asset('assets/img/product/' . $p->image) }}">
                                                    </a>
                                                    {{-- <ul class="product-links">
                                                        <li><a href="#" data-tip="Quick View">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul> --}}
                                                </div>
                                                <div class="product-content" style="text-align: left">
                                                    <h3 class="title"><a href="#"
                                                            style="color: #F7941D!important">{{ $p->service }}</a></h3>
                                                    <div class="price">From @currency($p->price) </div>
                                                    <a href="#" class="add-cart">Lihat
                                                        Detail</a>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                @endforeach
                                </div>
                                <span onclick="slideLeft()" class="btn"></span>
                            </div>
                        </div>
                </div>
            </div>

        </section><!-- /Stats Section -->


        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" style="color: #F7941D!important">
                <center>
                    <div style="color: #F7941D!important">NEW <span>PRODUCS</span></div>
                </center>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="container">
                        <div class="row">
                            @foreach ($product as $p)
                                @php

                                    $catProd = App\Models\CategoryDocument::where('id', $p->id_category)->first();

                                @endphp
                                <div class="col-md-3 col-sm-6">
                                    <div class="product-grid">
                                        <div class="product-image">
                                            <a href="#" class="image">
                                                <img class="pic-1" src="{{ asset('assets/img/product/' . $p->image) }}">
                                                <img class="pic-2" src="{{ asset('assets/img/product/' . $p->image) }}">
                                            </a>
                                            <ul class="product-links">
                                                <li><a href="#" data-tip="Quick View">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="title"><a href="#"
                                                    style="color: #F7941D!important">{{ $p->service }}</a></h3>
                                            <div class="price">From @currency($p->price) </div>
                                            <a href="#" class="add-cart"><i class="fas fa-cart-plus"></i>Lihat
                                                Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Testimonials Section -->

    </main>
    <script>
        var container = document.getElementById('container')
        var slider = document.getElementById('slider');
        var slides = document.getElementsByClassName('slide').length;
        var buttons = document.getElementsByClassName('btn');


        var currentPosition = 0;
        var currentMargin = 0;
        var slidesPerPage = 0;
        var slidesCount = slides - slidesPerPage;
        var containerWidth = container.offsetWidth;
        var prevKeyActive = false;
        var nextKeyActive = true;

        window.addEventListener("resize", checkWidth);

        function checkWidth() {
            containerWidth = container.offsetWidth;
            setParams(containerWidth);
        }

        function setParams(w) {
            if (w < 551) {
                slidesPerPage = 1;
            } else {
                if (w < 901) {
                    slidesPerPage = 2;
                } else {
                    if (w < 1101) {
                        slidesPerPage = 3;
                    } else {
                        slidesPerPage = 4;
                    }
                }
            }
            slidesCount = slides - slidesPerPage;
            if (currentPosition > slidesCount) {
                currentPosition -= slidesPerPage;
            };
            currentMargin = -currentPosition * (100 / slidesPerPage);
            slider.style.marginLeft = currentMargin + '%';
            if (currentPosition > 0) {
                buttons[0].classList.remove('inactive');
            }
            if (currentPosition < slidesCount) {
                buttons[1].classList.remove('inactive');
            }
            if (currentPosition >= slidesCount) {
                buttons[1].classList.add('inactive');
            }
        }

        setParams();

        function slideRight() {
            if (currentPosition != 0) {
                slider.style.marginLeft = currentMargin + (100 / slidesPerPage) + '%';
                currentMargin += (100 / slidesPerPage);
                currentPosition--;
            };
            if (currentPosition === 0) {
                buttons[0].classList.add('inactive');
            }
            if (currentPosition < slidesCount) {
                buttons[1].classList.remove('inactive');
            }
        };

        function slideLeft() {
            if (currentPosition != slidesCount) {
                slider.style.marginLeft = currentMargin - (100 / slidesPerPage) + '%';
                currentMargin -= (100 / slidesPerPage);
                currentPosition++;
            };
            if (currentPosition == slidesCount) {
                buttons[1].classList.add('inactive');
            }
            if (currentPosition > 0) {
                buttons[0].classList.remove('inactive');
            }
        };
    </script>
@endsection



@section('script-landing')
@endsection
