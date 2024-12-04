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
        .table {
            padding: 3px !important;
        }

        .table-invoice> :not(caption)>*>* {
            padding: 3px !important;

        }
        @page:first {
          margin-top: 0;
        }

        @page {
            margin-top: 2cm;
        }
    </style>
    <!-- Content -->

    <div class="invoice-print p-5" style="padding-left: 2% ! Important;padding-right: 2% !important;">
        <table>
            <tr>
                <td>
                    <img style="max-width: 40%" src="{{ asset('assets/img/auth/penghargaan-main-logo.jpg') }}"
                        alt="">
                </td>
                <td>
                    <img style="max-width: 20%;float: right;margin-right:10px"
                        src="{{ asset('assets/img/logos/logo-ikan.png') }}" alt="">
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
                    Invoice
                </b>
            </h5>
        </center>
        <br>

        <div class="row d-flex justify-content-between mb-4">
            <div class="col-sm-6 w-50">
                @php
                    $po = \App\Models\PurchaseOrder::where('id', $inv->id_po)->first();
                    $cust = \App\Models\Admin::where('id', $po->customer_id)->first();
                    $proj = \App\Models\Project::where('id', $inv->id_project)->first();
                    $created_by = \App\Models\Admin::where('id', $inv->created_by)->first();
                @endphp
                <h6><b>CUSTOMER</b></h6>
                <p class="mb-1"><b>{{ $cust->name }}</b></p>
                <p class="mb-1">{{ $cust->address }}</p>
            </div>
            <div class="col-sm-6 w-50">
                <table>
                    <tr>
                        <td style="width: 94px;">No</td>
                        <td>: {{ $inv->no_inv }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>:
                            {{ \Carbon\Carbon::parse($inv->created_date)->locale('id')->translatedFormat('l, j F Y') }}
                    </tr>
                    <tr>
                        <td>No PO</td>
                        <td>: {{ $po->no_po }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-invoice border-top m-0">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; background: silver">No</th>
                        <th style="border: 1px solid black; text-align: center; background: silver">Description</th>
                        <th style="border: 1px solid black; text-align: center; background: silver">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $detailPO = \App\Models\PurchaseOrderDetail::where('id_po', $inv->id_po)->get();
                    @endphp
                    @foreach ($detailPO as $item)
                        <tr>
                            <td style="border: 1px solid black">
                                <center>
                                    {{ $loop->iteration }}
                                </center>
                            </td>
                            @php
                                $service = \App\Models\Services::where('id', $item->id_item)->first();
                            @endphp
                            <td style="border: 1px solid black">{{ $service->service }}</td>
                            <td style="border: 1px solid black">@currency($item->total_prices)</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align: right;border:1px solid black">
                            Total
                        </td>
                        <td style="border : 1px solid black">@currency($po->total)</td>
                    </tr>
                    @if ($inv->category == 1)
                        <tr>
                            <td colspan="2" style="text-align: right;border:1px solid black">
                                {{ $inv->catatan }}
                            </td>
                            <td style="border : 1px solid black">@currency($inv->bill)</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2" style="text-align: right;border:1px solid black">
                            PPN {{ $inv->ppn }}%
                        </td>
                        <td style="border : 1px solid black">@currency($inv->total_ppn)</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;border:1px solid black">
                            PPH {{ $inv->pph }}%
                        </td>
                        <td style="border : 1px solid black">@currency($inv->total_pph)</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;border:1px solid black">
                            Grand Total
                        </td>
                        <td style="border : 1px solid black">@currency($inv->grand_total)</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h6>
                Note: PPh PT. PENGHARGAAN INDONESIA Menggunakan Tarif PPh Final Pasal 4 ayat (2) -3,5% (Jasa
                Konsultan Konstruksi)
            </h6>
            <h6>
                <b>
                    <i>Account Payment:</i> <br>
                    <i>a/n PT. PENGHARGAAN INDONESIA</i> <br>
                    <i>Bank Central Asia</i> <br>
                    <i>No. Rek 9328492332</i>
                </b>
            </h6>
            <br>

            <table class="table m-0" style="padding: 0">
                <thead>
                    <tr>
                        <th style="border:none;padding:0">
                            {{-- <center> --}}
                            <b>
                                Issued by Signature <br>
                                PT. PENGHARGAAN INDONESIA
                            </b>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <b>
                                Staff Accounting
                            </b>
                        </th>
                        <th style="border:none;padding:0">

                        </th>
                        <th style="border:none;padding:0">

                        </th>
                    </tr>
                </thead>
            </table>
            <br>
            {{-- <img style="max-width: 100%;position:absolute" src="{{ asset('assets/img/logos/footer-print.png') }}"
                alt=""> --}}
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
