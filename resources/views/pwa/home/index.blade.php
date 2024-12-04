@extends('pwa.layouts.app')



@section('style-pwa')
@endsection



@section('content-pwa')
    <style>
        .bg-category {

            background: #d9d9d9 !important;

        }



        .grayscale {

            filter: grayscale(100%);

        }



        .fade {

            z-index: 1200;

            cursor: pointer;

        }



        .modal {

            z-index: 1202;

        }



        .modal._web {

            top: 0px;

            z-index: 1202;

        }



        .modal.in {

            cursor: pointer;

            background-color: rgba(75, 75, 77, 0.1);

        }



        .modal button {

            border-radius: 5px;

        }



        .modal .modal-content {

            border-radius: 10px;

            cursor: default;

        }



        .modal .modal-footer {

            border-top: 1px solid #E6E7E8;

        }



        .modal .modal-footer button {

            padding: 5px 10px 5px 10px;

        }



        .modal .alert {

            border-radius: 10px;

            margin-bottom: 0px;

        }



        .modal .data-view {

            max-height: 500px;

            overflow-y: auto;

            margin-bottom: 10px;

        }



        .modal .data-view img {

            width: 100%;

            border-radius: 10px;

        }



        .modal-body {

            padding: 10px;

        }



        .modal-body .close {

            position: absolute;

            top: -15px;

            right: -15px;

            padding: 10px 15px;

            background-color: #A4508E;

            color: #FFFFFF;

            opacity: 0.8;

            z-index: 9;

        }



        .modal-body .close:hover {

            background-color: #A4508E;

            color: #FFFFFF;

            opacity: 1;

        }



        .model_hd_page {

            border: 1px solid #E6E7E8;

        }



        .hd_model {

            font-size: 16px;

            font-weight: 600;

            padding-bottom: 5px;

            border-bottom: 1px solid #E6E7E8;

            margin-bottom: 10px;

        }



        .text_model {

            padding-top: 10px;

        }



        .modal-body .image_data {

            width: 100%;

            margin-bottom: 10px;

        }



        .modal-body .image_data img {

            width: 100%;

            border: 1px solid #E6E7E8;

        }



        .title_detail {

            font-size: 18px;

            margin-top: -5px;

            padding: 0px;

            padding-left: 5px;

            padding-bottom: 5px;

            color: rgb(41, 41, 41) !important;

        }



        .tabcontent {

            display: none;

            padding: 6px 0px;

            border-top: none;

        }



        .list_advantage {

            font-size: 16px;

            color: #A4508E;

            padding-left: 0;

            margin-bottom: 10px;

        }



        .list_advantage_pad {

            padding-top: 5px;

        }



        .btn_cat_home button {

            border: 1px solid #E6E7E8;

            background-color: #A4508E;

            color: #FFFFFF;

            font-size: 14px;

            font-weight: 600;

            padding-top: 10px;

            padding-bottom: 10px;

            margin-bottom: 4px;

            border-color: #E6E7E8;

        }



        .single-line-text {

            white-space: nowrap;

            /* Pastikan teks tidak membungkus ke baris berikutnya */

            overflow: hidden;

            /* Sembunyikan teks yang melampaui batas elemen */

            text-overflow: ellipsis;

            /* width:80%; */

            /* Tambahkan tanda titik-titik (...) jika teks terpotong */

        }



        .order-now {

            padding: 3px;

            background: green;

            padding-right: 6px;

            border-radius: 5px;

            color: white !important;

            padding-left: 6px;

        }
    </style>

    @include('pwa.layouts.partials.messages')

    <section id="homescreen">

        {{-- <div class="home-first-sec mt-32">

            <div class="container">

                <div class="serachbar-homepage2 mt-24">

                    <div class="input-group search-page-searchbar ">

                        <span class="input-group-text search-iconn">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"

                                xmlns="http://www.w3.org/2000/svg">

                                <path

                                    d="M10.9395 1.9313C5.98074 1.9313 1.94141 5.97063 1.94141 10.9294C1.94141 15.8881 5.98074 19.9353 10.9395 19.9353C13.0575 19.9353 15.0054 19.193 16.5449 17.9606L20.293 21.7067C20.4821 21.888 20.7347 21.988 20.9967 21.9854C21.2587 21.9827 21.5093 21.8775 21.6947 21.6924C21.8801 21.5073 21.9856 21.2569 21.9886 20.9949C21.9917 20.7329 21.892 20.4802 21.7109 20.2908L17.9629 16.5427C19.1963 15.0008 19.9395 13.0498 19.9395 10.9294C19.9395 5.97063 15.8982 1.9313 10.9395 1.9313ZM10.9395 3.93134C14.8173 3.93134 17.9375 7.05153 17.9375 10.9294C17.9375 14.8072 14.8173 17.9352 10.9395 17.9352C7.06162 17.9352 3.94141 14.8072 3.94141 10.9294C3.94141 7.05153 7.06162 3.93134 10.9395 3.93134Z"

                                    fill="black"></path>

                            </svg>

                        </span>

                        <input type="search" placeholder="Search Here" class="form-control search-text-result"

                            id="search-input">

                    </div>

                    <button class="close-btn">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"

                            xmlns="http://www.w3.org/2000/svg">

                            <mask id="mask0_210_244" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"

                                width="24" height="24">

                                <rect width="24" height="24" fill="white" />

                            </mask>

                            <g mask="url(#mask0_210_244)">

                                <path

                                    d="M14 8C15.1046 8 16 7.10457 16 6C16 4.89543 15.1046 4 14 4C12.8954 4 12 4.89543 12 6C12 7.10457 12.8954 8 14 8Z"

                                    stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />

                                <path d="M4 6H12" stroke="#F97316" stroke-width="2" stroke-linecap="round"

                                    stroke-linejoin="round" />

                                <path d="M16 6H20" stroke="#F97316" stroke-width="2" stroke-linecap="round"

                                    stroke-linejoin="round" />

                                <path

                                    d="M8 14C9.10457 14 10 13.1046 10 12C10 10.8954 9.10457 10 8 10C6.89543 10 6 10.8954 6 12C6 13.1046 6.89543 14 8 14Z"

                                    stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />

                                <path d="M4 12H6" stroke="#F97316" stroke-width="2" stroke-linecap="round"

                                    stroke-linejoin="round" />

                                <path d="M10 12H20" stroke="#F97316" stroke-width="2" stroke-linecap="round"

                                    stroke-linejoin="round" />

                                <path

                                    d="M17 20C18.1046 20 19 19.1046 19 18C19 16.8954 18.1046 16 17 16C15.8954 16 15 16.8954 15 18C15 19.1046 15.8954 20 17 20Z"

                                    stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />

                                <path d="M4 18H15" stroke="#F97316" stroke-width="2" stroke-linecap="round"

                                    stroke-linejoin="round" />

                                <path d="M19 18H20" stroke="#F97316" stroke-width="2" stroke-linecap="round"

                                    stroke-linejoin="round" />

                            </g>

                        </svg>

                    </button>

                </div>

            </div>

        </div> --}}

        @php
            $setting = \App\Models\Setting::first()
        @endphp

        <div class="home-category mt-32">

            <div class="home-category-wrap container">

                <div class="homescreen-second-wrapper-top">

                    <div class="categories-first">

                        <h2 class="home1-txt3">💡 Category Plakat</h2>

                    </div>

                </div>

            </div>

            <div class="categories-slider mt-16">

                @foreach ($category as $cat)
                    <div class="categories-content">

                        <a href="#catProd">

                            <div>

                                @if ($cat->image != null)
                                    <img src="{{ asset('assets/img/category/' . $cat->image) }}" alt="category-img"
                                        class="w-100" style="width: 100px; height: 100px; object-fit: cover;">

                                    {{-- <img src="{{ asset('assets/img/category/'.$cat->image) }}" style="max-width: 100px" alt="category-img" class="w-100"> --}}
                                @else
                                    <img src="assets-pwa/images/homescreen/category1.png" alt="category-img" class="w-100">
                                @endif

                            </div>

                            <div class="categories-title">

                                <h3 class="category-txt1 text-center">{{ $cat->category }}</h3>

                            </div>

                        </a>

                    </div>
                @endforeach



            </div>

        </div>

        <div class="home-offer-sec mt-32">

            <div class="container">

                <div id="carouselExampleIndicators" class="carousel slide carousel slide-shop-now2" data-bs-ride="carousel">

                    <div class="carousel-indicators">

                        @foreach ($slider as $s)
                            <button type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide-to="{{ $loop->iteration - 1 }}" class="active show-now2-custom-btn"
                                aria-current="true" aria-label="Slide {{ $loop->iteration - 1 }}"></button>
                        @endforeach

                    </div>

                    <div class="carousel-inner">

                        @foreach ($slider as $s)
                            <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">

                                <div class="shop-now2-sec"
                                    style="background-image: url('{{ asset('assets/img/slider/' . $s->image) }}')">

                                    <div class="offer-details">

                                        <div class="offer-details-wrap">

                                            <div class="offer-price">

                                                <h2 class="mt-12">{{ $s->title }}</h2>

                                            </div>

                                        </div>

                                        <div class="discount-txt mt-16">

                                            <p>{{ $s->description }} </p>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>



        <div class="home-release mt-32">

            <div class="home-category-wrap container">

                <div class="homescreen-second-wrapper-top">

                    <div class="categories-first">

                        <h2 class="home1-txt3">🙌 New Release</h2>

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

                                        <a href="{{ $setting->link_wa }}" class="">

                                            <span class="new-courses-txt3 order-now"><i class="fa-brands fa-whatsapp"></i>

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

        <div class="home-course mt-32" id="catProd">

            <div class="home-course-wrapper-top">

                <div class="container">

                    <div class="categories-first">

                        <h2 class="home1-txt3">🧿 All Product</h2>

                    </div>

                </div>

            </div>

            <div class="home-course-wrapper-bottom mt-16">

                <div class="home-course-wrapper-bottom-full">

                    <ul class="nav nav-pills" id="homepage1-tab" role="tablist">

                        <li class="nav-item" role="presentation">

                            <button class="nav-link active custom-home1-tab-btn single-line-text" id="pills-all-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab"
                                aria-selected="true">🔥All</button>

                        </li>

                        @foreach ($category as $cat)
                            <li class="nav-item" role="presentation">

                                <button class="nav-link custom-home1-tab-btn single-line-text" id="pills-all-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-{{ $cat->id }}" type="button"
                                    role="tab" aria-selected="false">{{ $cat->category }}</button>

                            </li>
                        @endforeach

                    </ul>



                    <div class="tab-content" id="pills-tabContent">

                        <!-- Tab Semua Produk -->

                        <div class="tab-pane show active" id="pills-all" role="tabpanel" tabindex="0">

                            <div class="container">

                                @foreach ($allProducts as $ap)
                                    <div class="result-found-bottom-wrap mt-16">

                                        <a href="{{ route('detail-prod', $ap->id) }}">

                                            <div class="result-img-sec">

                                                <img src="{{ asset('assets/img/product/' . $ap->image) }}"
                                                    alt="course-img" style="    max-width: 100px!important;">

                                            </div>

                                            <div class="result-content-sec">

                                                <div class="result-content-sec-wrap">

                                                    <div class="content-first">

                                                        @php

                                                            $catProdap = App\Models\CategoryDocument::where(
                                                                'id',

                                                                $ap->id_category,
                                                            )->first();

                                                        @endphp

                                                        <div class="result-bottom-txt">

                                                            <p>{{ $catProdap->category ?? '-' }}</p>

                                                        </div>

                                                        <div class="result-bookmark">

                                                            <a href="{{ $setting->link_wa }}" class="item-bookmark"
                                                                tabindex="0">

                                                                <i class="fa-brands fa-whatsapp" style="color: green"></i>

                                                            </a>

                                                        </div>

                                                    </div>

                                                    <div class="content-second mt-12">

                                                        <h2>{{ $ap->service }}</h2>

                                                    </div>

                                                    {{-- <div class="content-third mt-12">

                                                        <div>

                                                            <p class="result-price">@currency($ap->price)</p>

                                                        </div>

                                                    </div> --}}

                                                </div>

                                            </div>

                                        </a>

                                    </div>
                                @endforeach

                            </div>

                        </div>



                        <!-- Tab Berdasarkan Kategori -->

                        @foreach ($category as $cat)
                            <div class="tab-pane" id="pills-{{ $cat->id }}" role="tabpanel" tabindex="0">

                                <div class="container">

                                    @php

                                        $catProdkat = \App\Models\Services::where('id_category', $cat->id)->get();

                                    @endphp

                                    @foreach ($catProdkat as $cp)
                                        <div class="result-found-bottom-wrap mt-16">

                                            <a href="{{ route('detail-prod', $cp->id) }}">



                                                <div class="result-img-sec">

                                                    <img src="{{ asset('assets/img/product/' . $cp->image) }}"
                                                        alt="course-img" style="max-width:100px">

                                                </div>

                                                <div class="result-content-sec">

                                                    <div class="result-content-sec-wrap">

                                                        <div class="content-first">

                                                            @php

                                                                $catProdcatp = App\Models\CategoryDocument::where(
                                                                    'id',

                                                                    $cp->id_category,
                                                                )->first();

                                                            @endphp

                                                            <div class="result-bottom-txt">

                                                                <p>{{ $catProdcatp->category ?? '-' }}</p>

                                                            </div>

                                                            <div class="result-bookmark">

                                                                <a href="{{ $setting->link_wa }}" class="item-bookmark"
                                                                    tabindex="0">

                                                                    <i class="fa-brands fa-whatsapp"
                                                                        style="color: green"></i>

                                                                </a>

                                                            </div>

                                                        </div>

                                                        <div class="content-second mt-12">

                                                            <h2 class="single-line-text">{{ $cp->service }}</h2>

                                                        </div>

                                                        {{-- <div class="content-third mt-12">

                                                            <p class="result-price">@currency($cp->price)</p>

                                                        </div> --}}



                                                    </div>

                                                </div>

                                            </a>



                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>







    </section>



    <!-- Button trigger modal -->







    <div class="modal fade" id="showAlertFirst" role="dialog" data-model="bumper">

        <div class="modal-dialog modal-md modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body bumper">

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>

                    <div class="col-sm-12 data-view" style="padding:0px; margin-bottom: 10px;">
                       
                        <img src="{{ asset('assets/img/banner_popup/' . $setting->banner_popup) }}" alt="banner" style="" />

                    </div>

                    <div class="col-sm-12 list_home"
                        style="border: 1px solid #E6E7E8;border-radius:10px;padding:10px;margin-bottom: 0px;">

                        <div class="title_detail" style="margin-top:10px;">

                            <b>Chat Sekarang Dapatkan Semua Keuntungannya :</b>



                        </div>



                        <div id="Deskripsi" class="tabcontent" style="display:block; padding-left:6px;">

                            <div class="col-md-12">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="col-sm-6 list_advantage">

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Gratis Desain </div>

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Bergaransi </div>

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Bahan Kualitas Terbaik </div>

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Gratis Ongkos Kirim </div>

                                        </div>

                                        <div class="col-sm-6 list_advantage">

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Pengiriman Aman </div>

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Harga Terbaik </div>

                                            <div class="list_advantage_pad"> <i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Pembayaran Mudah </div>

                                            <div class="list_advantage_pad"><i class="fa fa-hand-o-right"
                                                    aria-hidden="true"></i> Pelayanan 24/7 </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <div class="col-sm-12 btn pad_price btn_cat_home" style="margin-top: 10px; width: 100%;"><a
                                href="{{ $setting->link_wa }}" target="_blank" onclick="gtag_report_conversion()"><button
                                    type="button" class="btn bt_pesan_detail" style="width:100%;"
                                    onclick="gtag_report_conversion()"><i class="fa fa-whatsapp" aria-hidden="true"></i>

                                    Chat Sekarang</button></a></div>

                    </div>

                    <div class="modal-footer"
                        style="padding-top: 0px; padding-bottom: 0px; border-top: 0px solid #E6E7E8;">

                        <!-- <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" btn="closebumper">Tutup</button> -->

                    </div>

                </div>

            </div>

        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script type="text/javascript">
        $(document).ready(function() {

            console.log('msk');



            $('#showAlertFirst').modal({

                backdrop: true

            });

            $('#showAlertFirst').modal('show');

        });
    </script>
@endsection



@section('script-pwa')
@endsection
