@extends('pwa.layouts.app')



@section('style-pwa')
@endsection



@section('content-pwa')
    <style>
        .box_order {

            /* left: 0px;

     background-color: #ffffff;

     color: #4B4B4D;

     z-index: 6;

     border-radius: 10px;

     padding: 5px;

     margin-bottom: 10px; */

        }

        .no_padd_order {

            padding: 0;

        }

        .padd_order {

            padding-left: 10px;

            padding-right: 10px;

            margin-bottom: 10px;

            margin-top: 10px;

        }

        .pos_img {

            text-align: left;

            height: 102px;

            line-height: 102px;

        }

        div.box_order .row_order {

            display: inline-block;

            color: #4B4B4D;

            text-align: center;

            padding: 5px;

            text-decoration: none;

            vertical-align: top;

        }

        .row_order {

            margin-left: 0;

            margin-right: 0;

        }

        .box_img img {

            width: 30%;

        }

        .col_order {

            float: left;

            background: linear-gradient(163deg, rgb(164, 80, 142) 65%, rgba(251, 205, 63, 0.6) 98%);

            border: 1px solid #E6E7E8;

            padding: 5px;

            border-radius: 10px;

            font-size: 16px;

            color: #ffffff;

            /* margin-right: 10px; */

            margin-bottom: 5px;

            /* width: 270px; */

        }

        .col_order .image {

            float: left;

            width: 90px;

        }

        .col_order .image img {

            width: 100%;

        }

        .col_order .text,
        .col_order .text div {

            white-space: normal;

            /* width: 150px; */

        }

        .col_order .text .title {

            font-size: 16px;

            font-weight: 600;

            padding: 0px;

            padding-bottom: 0px;

            padding-left: 0px;

            padding-bottom: 0px;

            padding-left: 0px;

            padding-bottom: 0px;

            padding-left: 0px;

            color: #ffffff !important;

        }

        .col_order .text .desc {

            font-size: 14px;

            padding: 0px;

            padding-bottom: 0px;

            padding-left: 0px;

            padding-bottom: 0px;

            padding-left: 0px;

            padding-bottom: 0px;

            padding-left: 0px;

            color: #ffffff !important;

        }



        .icon_whay__ img {

            width: 100%;

            padding: 0px;

            background-color: #FFFFFF;

            border-radius: 10px;

            margin: 10px;

        }

        .single-line-text {

            white-space: nowrap;

            /* Pastikan teks tidak membungkus ke baris berikutnya */

            overflow: hidden;

            /* Sembunyikan teks yang melampaui batas elemen */

            text-overflow: ellipsis;

            /* Tambahkan tanda titik-titik (...) jika teks terpotong */

            width: 200px;

        }

        .order-now {

            padding: 3px;

            background: green;

            padding-right: 6px;

            border-radius: 5px;

            color: white !important;

            padding-left: 6px;

            width: 100%
        }

        .buy-now {

            background: var(--1, #FFF);

            box-shadow: 0px -4px 4px 0px rgba(0, 0, 0, 0.04);

            padding: 16px;

            width: 100%;

            z-index: 2;

            max-width: 600px;

            margin: 0 auto;

        }
    </style>
    @php
        $setting = \App\Models\Setting::first()
    @endphp

    <section id="single-description-screen">

        <div class="first-desc-img-sec">

            <div class="hero-img-desc">

                <img src="{{ asset('assets/img/product/' . $prod->image) }}" alt="social-media-img" class="img-fluid w-100">

                <div class="single-courses-top">

                    <div class="course-back-icon">

                        <a href="{{ url('/') }}">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                                <mask id="mask0_330_7385" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                    width="24" height="24">

                                    <rect width="24" height="24" fill="black" />

                                </mask>

                                <g mask="url(#mask0_330_7385)">

                                    <path d="M15 18L9 12L15 6" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />

                                </g>

                            </svg>

                        </a>

                    </div>

                    <div class="single-courses-bookmark-icon">



                    </div>

                </div>

                {{-- <div class="cousr-play-btn">

                    <a href="#" data-bs-toggle="modal" data-bs-target="#review-video-modal"><img

                            src="{{ asset('assets-pwa/images/single-courses/play-icon.svg')}}" alt="play-icon"></a>

                </div> --}}

            </div>

            <div class="container">

                <div class="single-courses-description">

                    <div class="first-decs-sec mt-16">

                        <div class="first-decs-sec-wrap">

                            @php

                                $catProd = App\Models\CategoryDocument::where('id', $prod->id_category)->first();

                            @endphp

                            <div class="first-left-sec">{{ $catProd->category ?? '-' }}</div>


                        </div>

                        <div class="second-decs-sec mt-16">

                            <div class="second-decs-sec-wrap">

                                <div class="second-decs-sec-top">

                                    <h1 class="second-txt1">{{ $prod->service }}</h1>

                                </div>

                            </div>
                            <a href="{{ $setting->link_wa }}" target="_blank" class="btn btn-success" style="width: 100%"><i class="fa-brands fa-whatsapp"></i> Pesan
                                Sekarang</a>

                        </div>



                    </div>



                    <div class="fifth-decs-sec mt-32">

                        <div class="fifth-decs-sec-wrap">

                            <ul class="nav nav-pills single-courses-tab" id="description-tab" role="tablist">

                                <li class="nav-item" role="presentation">

                                    <button class="nav-link active" id="description-tab-btn" data-bs-toggle="pill"
                                        data-bs-target="#description-content" type="button" role="tab"
                                        aria-selected="true">Description</button>

                                </li>

                                <li class="nav-item" role="presentation">

                                    <button class="nav-link" id="lessons-tab-btn" data-bs-toggle="pill"
                                        data-bs-target="#lesson-content" type="button" role="tab"
                                        aria-selected="false">How To Buy</button>

                                </li>



                            </ul>

                            <div class="tab-content" id="description-tabContent">

                                <div class="tab-pane fade show active" id="description-content" role="tabpanel"
                                    tabindex="0">

                                    <div class="description-content-wrap mt-24">

                                        <div class="description-first-content">

                                            {!! $prod->content ?? 'No data.' !!}

                                        </div>



                                    </div>

                                </div>

                            </div>

                            <div class="tab-content" id="lessons-tabContent">

                                <div class="tab-pane fade show" id="lesson-content" role="tabpanel" tabindex="0">

                                    <div class="lesson-content-wrap mt-24">

                                        <div class="container text-center container_home">

                                            <div class="row">

                                                <div class="col-md-12 bg_left_home__">

                                                    <div class="title_vide__">Cara Pemesanan</div>

                                                    <div class="col-md-12 text-left no_padd_order">

                                                        <div class="row row_order">

                                                            <div class="col-md-12 no_padd_order" style="float: left;">



                                                                <div class="col-xs-6 col-md-3 padd_order">

                                                                    <div class="col-sm-12 col_order">

                                                                        <div class="col-sm-3 pos_img box_img no_padd_order">

                                                                            <center>

                                                                                <img src="https://buatplakat.id/image/search.png"
                                                                                    alt="Image">

                                                                            </center>

                                                                        </div>

                                                                        <div class="col-sm-9 no_padd_order">

                                                                            <div class="text">

                                                                                <div class="title">Pilih Produk</div>

                                                                                <div class="desc">Pilih contoh produk yang
                                                                                    kami sediakan atau bisa sesuai dengan
                                                                                    konsep yang telah anda buat.</div>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>



                                                                <div class="col-xs-6 col-md-3 padd_order">

                                                                    <div class="col-sm-12 col_order">

                                                                        <div class="col-sm-3 pos_img box_img no_padd_order">

                                                                            <center>

                                                                                <img src="https://buatplakat.id/image/checklist.png"
                                                                                    alt="Image">

                                                                            </center>

                                                                        </div>

                                                                        <div class="col-sm-9 no_padd_order">

                                                                            <div class="text">

                                                                                <div class="title">Konfirmasi Order</div>

                                                                                <div class="desc">Kami akan mencatat dan
                                                                                    menginformasikan detail order beserta
                                                                                    rincian harganya.</div>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>



                                                                <div class="col-xs-6 col-md-3 padd_order">

                                                                    <div class="col-sm-12 col_order">

                                                                        <div
                                                                            class="col-sm-3 pos_img box_img no_padd_order">

                                                                            <center>

                                                                                <img src="https://buatplakat.id/image/cash.png"
                                                                                    alt="Image">

                                                                            </center>

                                                                        </div>

                                                                        <div class="col-sm-9 no_padd_order">

                                                                            <div class="text">

                                                                                <div class="title">Pembayaran</div>

                                                                                <div class="desc">DP min 50% sebelum
                                                                                    order di proses dan pelunasan dibayarkan
                                                                                    setelah orderan selesai.</div>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>



                                                                <div class="col-xs-6 col-md-3 padd_order">

                                                                    <div class="col-sm-12 col_order">

                                                                        <div
                                                                            class="col-sm-3 pos_img box_img no_padd_order">

                                                                            <center>

                                                                                <img src="https://buatplakat.id/image/delivery.png"
                                                                                    alt="Image">

                                                                            </center>

                                                                        </div>

                                                                        <div class="col-sm-9 no_padd_order">

                                                                            <div class="text">

                                                                                <div class="title">Pengiriman</div>

                                                                                <div class="desc">Kami akan mengirimkan
                                                                                    pesanan anda melalui jasa pengiriman
                                                                                    yang telah disepakati sebelumnya.</div>

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

                            </div>



                        </div>

                    </div>

                </div>

            </div>

            <div class="home-release mt-32">

                <div class="home-category-wrap container">

                    <div class="homescreen-second-wrapper-top">

                        <div class="categories-first">

                            <h2 class="home1-txt3">🙌 Other Product</h2>

                        </div>

                        <div class="view-all-second">



                        </div>

                    </div>

                </div>

                <div class="home-release-bottom-sec mt-16">

                    @foreach ($product as $p)
                        @php

                            $catProd = App\Models\CategoryDocument::where('id', $p->id_category)->first();

                        @endphp

                        <div class="new-courses-sec">

                            <a href="{{ route('detail-prod', $p->id) }}" class="">

                                <div class="new-courses">

                                    <img src="{{ asset('assets/img/product/' . $p->image) }}" alt="course-img">

                                    <div class="new-courses-txt">

                                        <p>{{ $catProd->category ?? '-' }}</p>

                                    </div>

                                </div>

                                <div class="trending-course-bottom mt-12">

                                    <div>

                                        <p class="new-courses-txt1 single-line-text">{{ $p->service }}</p>

                                    </div>

                                    <div class="trending-course-price">

                                        <div>

                                            <a href="" class="">

                                                <span class="new-courses-txt3 order-now"><i
                                                        class="fa-brands fa-whatsapp"></i>

                                                    Pesan Sekarang</i></span>

                                            </a>

                                        </div>



                                    </div>

                                </div>

                            </a>

                        </div>
                    @endforeach

                </div>

            </div>



        </div>

    </section>
@endsection



@section('script-pwa')
@endsection
