<!doctype html>

<html lang="en" class="light-style layout-wide" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $page_title }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/auth/penghargaan-main-logo.jpg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />


    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" />


    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

</head>

<body>
    <style>
        @page:first {
          margin-top: 0;
        }

        @page {
            margin-top: 2cm;
        }
    </style>
    <!-- Content -->

    <div class="invoice-print p-5">
        <table>
            <tr>
                <td>
                    <img style="max-width: 85%" src="{{ asset('assets/img/auth/penghargaan-main-logo.jpg') }}" alt="">
                </td>
                <td>
                    <img style="max-width: 20%;float: right;margin-right:10px" src="{{ asset('assets/img/logos/logo-ikan.png') }}" alt="">
                </td>
                <td>
                    <img style="max-width: 70%" src="{{ asset('assets/img/logos/logo-iaf.jpeg') }}" alt="">
                </td>
            </tr>
        </table>
       
        <br>
        <center>
            <h5>
                <b>
                    <u>SURAT IZIN KELUAR KANTOR</u>
                </b>
            </h5>
        </center>
        <br>

        <div class="row d-flex justify-content-between mb-4">
            <h6>Yang bertanda tangan dibawah ini:</h6>

            <div class="col-sm-6 w-50">
                @php
                    $user = \App\Models\Admin::where('id', $asg->id_user)->first();
                @endphp
                <table>
                    <tr>
                        <td style="width: 94px;">Nama</td>
                        <td>: {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>: </td>
                    </tr>
                </table>
                
            </div>
            <h6>Memohon izin untuk keluar kantor pada jam kerja untuk melakukan keperluan:</h6> <br>
            <h6>
                {{ $asg->note }}
            </h6>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table border-top m-0">
                <thead>
                    <tr>
                        <th style="border-left: 1px solid black;border-right:1px solid black" >Hari : {{ \Carbon\Carbon::parse($asg->tanggal)->locale('id')->translatedFormat('l') }}</th>
                        <th style="border-left: 1px solid black;border-right:1px solid black" >Tanggal : {{ \Carbon\Carbon::parse($asg->tanggal)->locale('id')->translatedFormat('j F Y') }}</th>
                        <th style="border-left: 1px solid black;border-right:1px solid black" >Jam : {{ $asg->time_start }} S/d {{ $asg->time_end }}</th>
                    </tr>
                </thead>
            </table>
            <br>
            <table class="table m-0">
                <thead>
                    <tr>
                        <th style="border:none" >
                            <center>
                                Pemohon
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <hr>
                            </center>
                        </th>
                        <th style="border:none" >
                            <center>
                                Diketahui Oleh,
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <hr>
                            </center>
                        </th>
                        <th style="border:none" >
                            <center>
                                Disetujui Oleh,
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <hr>
                            </center>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-invoice-print.js') }}"></script>
</body>

</html>
