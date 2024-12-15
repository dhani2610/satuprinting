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

        .slide-container {
            max-width: 1120px;
            width: 100%;
            padding: 40px 0;
        }

        .slide-content {
            margin: 0 40px;
            overflow: hidden;
            border-radius: 25px;
        }

        .card {
            border-radius: 25px;
            /* background-color: #FFF; */
        }

        .image-content,
        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 14px;
        }

        .image-content {
            position: relative;
            row-gap: 5px;
            padding: 25px 0;
        }

        .overlay {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background-color: #4070F4;
            border-radius: 25px 25px 0 25px;
        }

        .overlay::before,
        .overlay::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: -40px;
            height: 40px;
            width: 40px;
            background-color: #4070F4;
        }

        .overlay::after {
            border-radius: 0 25px 0 0;
            background-color: #FFF;
        }

        /* .card-image {
                position: relative;
                height: 150px;
                width: 150px;
                border-radius: 50%;
                background: #FFF;
                padding: 3px;
            }

            .card-image .card-img {
                height: 100%;
                width: 100%;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid #4070F4;
            } */

        .name {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }

        .description {
            font-size: 14px;
            color: #707070;
            text-align: center;
        }

        .button {
            border: none;
            font-size: 16px;
            color: #FFF;
            padding: 8px 16px;
            background-color: #4070F4;
            border-radius: 6px;
            margin: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button:hover {
            background: #265DF2;
        }

        .swiper-navBtn {
            color: #6E93f7;
            transition: color 0.3s ease;
        }

        .swiper-navBtn:hover {
            color: #4070F4;
        }

        .swiper-navBtn::before,
        .swiper-navBtn::after {
            font-size: 35px;
        }

        .swiper-button-next {
            right: 0;
        }

        .swiper-button-prev {
            left: 0;
        }

        .swiper-pagination-bullet {
            background-color: #6E93f7;
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background-color: #4070F4;
        }

        @media screen and (max-width: 768px) {
            .slide-content {
                margin: 0 10px;
            }

            .swiper-navBtn {
                display: none;
            }
        }
        

        @media (max-width: 768px) {
            .text-cat {
                font-size: 8px !important;
            }

            .sc-cat {
                display: none
            }

            .cat-prod {
                font-size: 18px !important
            }
            .img-layanan{
                max-width: 39px!important;
            }
            .text-layanan{
                font-size: 8px !important;
            }

            .stats .stats-item {
                padding: 0px!important;
                border: none!important;
                box-shadow: none !important; 
            }
        }

        .swiper-button-next,
        .swiper-rtl .swiper-button-prev {
            background: white;
            padding: 29px;
            left: auto;
            border-radius: 50%;
            font-size: 10px;
            color: black;
            font-weight: bold;
        }

        .swiper-button-prev,
        .swiper-rtl .swiper-button-next {
            background: white;
            left: 10px;
            right: auto;
            padding: 29px;
            border-radius: 50%;
            font-weight: 900;
        }

        .hero .carousel-control-next-icon,
        .hero .carousel-control-prev-icon {
            background: #F7971E !important;
            font-size: 32px;
            line-height: 1;
            color: white;
            z-index: 9999999 !important
        }

        .hero .carousel-control-prev,
        .hero .carousel-control-next {
            width: 10%;
            transition: 0.3s;
            opacity: 2.5;
            z-index: 999999999999999!important;
        }
        @media (max-width: 768px) {
            .carousel-item img {
                object-fit: contain; /* Menjaga agar seluruh gambar terlihat tanpa terpotong */
            }
            .hero .carousel {
                min-height: 13vh!important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">
    @include('landing.layouts.partials.messages')

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div id="hero-carousel" class="carousel slide " data-bs-ride="carousel" data-bs-interval="3000">

                @foreach ($slider as $s)
                    <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                        <img src="{{ asset('assets/img/slider/' . $s->image) }}" alt="">
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
        <section id="stats" class="stats section"
            style="background: linear-gradient(to bottom, #FCE15A, #F7971E);
            border-top:15px solid #F7941D ">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 col-3 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-emoji-smile"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/HASIL.png') }}" class="img-fluid img-layanan"
                                style="max-width: 30%" alt="">
                            <p class="text-layanan"><strong>PRODUK BERKUALITAS</strong></p>
                        </div>

                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 col-3 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-journal-richtext"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/ONGKIR.png') }}" class="img-fluid img-layanan"
                                style="max-width: 30%" alt="">
                            <p class="text-layanan"><strong>FREE ONGKIR</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 col-3 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-headset"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/LAYANAN.png') }}" class="img-fluid img-layanan"
                                style="max-width: 30%" alt="">
                            <p class="text-layanan"><strong>PELAYANAN PRIMA</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 col-3 d-flex flex-column align-items-center">
                        {{-- <i class="bi bi-people"></i> --}}
                        <div class="stats-item" style="background: transparent">
                            <img src="{{ asset('assets-landing/img/home/ONLINE.png') }}" class="img-fluid img-layanan"
                                style="max-width: 30%" alt="">
                            <p class="text-layanan"><strong>ONLINE SERVICE</strong></p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section -->

        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title " data-aos="fade-up">
                <center>
                    <div><span class="cat-prod">Kategori Produk</span></div>
                </center>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">
                    @foreach ($category as $cat)
                        <div class="col-lg-3 col-md-2 col-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-item position-relative" style="border: none">
                                <img src="{{ asset('assets/img/category/' . $cat['image']) }}" class="img-fluid img-cat"
                                    style="max-width: 50%" alt="">
                                @if ($cat['category'] == 'Pasang Stiker')
                                    <a href="https://wrappingtroops.com" target="_blank" class="stretched-link"
                                        style="color: black">
                                    @else
                                        <a href="{{ route('category-landing') }}?category={{ $cat['id'] }}"
                                            class="stretched-link" style="color: black">
                                @endif
                                <p class="fs-6 fs-md-5 fs-lg-4 text-cat">
                                    <strong>{{ $cat['category'] }}</strong>
                                </p>
                                </a>
                            </div>
                        </div><!-- End Service Item -->
                    @endforeach
                </div>


            </div>

        </section><!-- /Services Section -->


        <!-- Stats Section -->
        <section id="stats" class="stats section" style="background: linear-gradient(to bottom, #FCE15A, #F7971E);">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    {{-- <div class="col-lg-2">
                        <img src="{{ asset('assets-landing/img/home/LAIN LAIN.png') }}" class="img-fluid">
                    </div> --}}
                    <div id="container">

                        <div class="row">
                            <div class="col-lg-3">
                                <h5 style="color: bronze">
                                    <b>
                                        Promo Bulan ini
                                    </b>
                                </h5>
                                <p style="color: burlywood">Nikmati Promosinya</p>

                                <img src="{{ asset('assets-landing/img/home/MERCHANDISE.png') }}" class="img-fluid">
                            </div>
                            <div class="col-lg-9">
                                <div class="slide-container swiper">
                                    <div class="slide-content">
                                        <div class="card-wrapper swiper-wrapper">
                                            @foreach ($allProductsDisc as $p)
                                                @php

                                                    $catProd = App\Models\CategoryDocument::where(
                                                        'id',
                                                        $p->id_category,
                                                    )->first();

                                                @endphp
                                                <div class="card swiper-slide" style="">
                                                    <div class="product-grid">
                                                        <div class="product-image">
                                                            <a href="{{ route('detail-prod', $p->id) }}" class="image">
                                                                <img class="pic-1"
                                                                    src="{{ asset('assets/img/product/' . $p->image) }}">
                                                                <img class="pic-2"
                                                                    src="{{ asset('assets/img/product/' . $p->image) }}">
                                                            </a>
                                                        </div>
                                                        <div class="product-content">
                                                            <h3 class="title">
                                                                <a href="#"
                                                                    style="color: #F7941D!important">{{ $p->service }}</a>
                                                            </h3>
                                                            <div class="price">From @currency($p->price)</div>
                                                            <a href="{{ route('detail-prod', $p->id) }}"
                                                                class="add-cart">
                                                                Lihat Detail
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="swiper-button-next swiper-navBtn"></div>
                                    <div class="swiper-button-prev swiper-navBtn"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Stats Section -->


        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" style="">
                <center>
                    <div><span class="cat-prod">Produk Baru</span></div>

                </center>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="container">
                        <div class="row" id="product-container">
                            @foreach ($allProducts as $index => $p)
                                @php
                                    $catProd = App\Models\CategoryDocument::where('id', $p->id_category)->first();
                                @endphp
                                <div class="col-md-3 col-sm-6 product-item "
                                    @if ($index >= 10) style="display: none;" @endif>
                                    <div class="product-grid">
                                        <div class="product-image">
                                            <a href="{{ route('detail-prod', $p->id) }}" class="image">
                                                <img class="pic-1" src="{{ asset('assets/img/product/' . $p->image) }}">
                                                <img class="pic-2" src="{{ asset('assets/img/product/' . $p->image) }}">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="title">
                                                <a href="#"
                                                    style="color: #F7941D!important">{{ $p->service }}</a>
                                            </h3>
                                            <div class="price">From @currency($p->price)</div>
                                            <a href="{{ route('detail-prod', $p->id) }}" class="add-cart">
                                                <i class="fas fa-cart-plus"></i>Lihat Detail
                                            </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('load-more-btn');
            const loadLessBtn = document.getElementById('load-less-btn');
            const products = document.querySelectorAll('.product-item');
            let itemsToShow = 8; // Jumlah awal item yang ditampilkan

            loadMoreBtn.addEventListener('click', function() {
                itemsToShow += 10;
                products.forEach((product, index) => {
                    if (index < itemsToShow) {
                        product.style.display = 'block';
                    }
                });

                if (itemsToShow >= products.length) {
                    loadMoreBtn.style.display = 'none';
                    loadLessBtn.style.display = 'inline-block';
                }
            });

            loadLessBtn.addEventListener('click', function() {
                itemsToShow = 8;
                products.forEach((product, index) => {
                    if (index >= itemsToShow) {
                        product.style.display = 'none';
                    }
                });

                loadMoreBtn.style.display = 'inline-block';
                loadLessBtn.style.display = 'none';
            });
        });
    </script>
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/script.js"></script>

    <script>
        var swiper = new Swiper(".slide-content", {
            slidesPerView: 4,
            spaceBetween: 10,
            loop: false,
            centerSlide: 'true',
            fade: 'true',
            grabCursor: 'true',
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                520: {
                    slidesPerView: 2,
                },
                950: {
                    slidesPerView: 4,
                },
            },
        });
    </script>
@endsection



@section('script-landing')
@endsection
