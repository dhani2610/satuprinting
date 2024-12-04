@extends('backend.layouts-client.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />

    <style>
        /* .form-check-label {
                          text-transform: capitalize;
                      } */
        .select2 {
            width: 100% !important
        }

        label {
            float: left;
        }

        .form-check-label,
        .form-group label {
            text-transform: uppercase;
            font-weight: 500;
            `
        }

        .row {
            width: 100%
        }

        .dt-buttons {
            height: 10%;
            margin-top: 14px;
            margin-left: 2%;

        }

        .header-title {
            margin-bottom: 0px;
        }
       
    </style>

    <div class="main-content-inner">
        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-task"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $quotation_count }}</h4>
                        </div>
                        <p class="mb-1">Quotation</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">All Quotation</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-cart-add"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $po_count }}</h4>
                        </div>
                        <p class="mb-1">Purchase Order</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">All Purchase Order</span>
                        </p>
                    </div>
                </div>
            </div>
            {{-- @dd(Auth::guard('admin')->user()->getRoleNames()[0]); --}}
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-chalkboard"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $proj_count }}</h4>
                        </div>
                        <p class="mb-1">Project</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">All Project</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-receipt"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $invoice_count }}</h4>
                        </div>
                        <p class="mb-1">Invoice</p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">All Invoice</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">All Project</h4>
                        <div class="clearfix"></div>
                        <div class="card-datatable table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="" class="datatables-basic-client table border-top">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Action</th>
                                        <th>ID</th>
                                        <th>NO PO</th>
                                        <th>Title</th>
                                        <th>Customer</th>
                                        <th>City</th>
                                        <th>Marketing</th>
                                        <th>Start Date</th>
                                        <th>Deadline</th>
                                        <th>Created Date</th>
                                        <th>Remaining</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalOverDue = 0;
                                    @endphp
                                    @foreach ($project as $proj)
                                        @php
                                            $po = \App\Models\PurchaseOrder::where('id', $proj->id_po)->first();
                                            $cust = App\Models\Admin::where('type', 'customer')
                                                ->where('id', $proj->id_customer)
                                                ->first();
                                            $poDetail = \App\Models\PurchaseOrderDetail::where(
                                                'id_po',
                                                $proj->id_po,
                                            )->get();
                                            $citycust = \App\Models\City::where('id', $cust->id_city)->first();
                                            $marketing = App\Models\Admin::where('id', $proj->id_marketing)->first();

                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-sm btn-icon" href="{{ route('tracking',$proj->no_project) }}" target="_blank" title="Link Drive">
                                                        <i class="fa fa-link"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ $proj->no_project }}</td>
                                            <td>
                                                <a data-bs-toggle="modal" style="color: #696cff"
                                                    data-bs-target="#modalactivity-{{ $proj->id }}"><span
                                                            class="fw-medium">{{ $po->no_po }}</span>
                                                </a>
                                                @include('backend.client.modal-client')
                                               
                                            </td>
                                            <td>{{ $proj->name_project }}</td>
                                            <td>{{ $cust->name }}</td>
                                            <td>{{ $citycust->city ?? '-' }}</td>
                                            <td>{{ $marketing->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proj->start_date)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($proj->deadline)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($proj->created_at)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            @php
                                                $start_date = \Carbon\Carbon::parse($proj->start_date);
                                                $deadline = \Carbon\Carbon::parse($proj->deadline);
                                                $remaining = $start_date->diffInDays($deadline, false); // false to get negative value if past
                                            @endphp

                                            <td>{{ $remaining }} Day</td>
                                            <td>
                                                {{ getProgresPercentageProject($proj->id) }}%
                                            </td>
                                            <td>
                                                @if (getProgresPercentageProject($proj->id) < 100)
                                                    @if (date('Y-m-d') > $proj->deadline)
                                                        @php
                                                            $totalOverDue += 1;
                                                        @endphp
                                                        <span class="badge bg-label-danger">Overdue</span>
                                                    @else
                                                        <span class="badge bg-label-warning">On Progress</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-label-success">Done</span>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>

    {{-- <button class="btn btn-primary text-white mb-3 buttonCreate d-none" style="float: right" data-bs-toggle="modal"
        data-bs-target="#modalCreate">
        <i class='bx bx-plus'></i>
        Activity Invoice
    </button> --}}

 
    <!-- Modal for PDF Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>
    <script>
        function showLampiranEdit(fileExist) {
            $('#pdfViewer').attr('src', fileExist);
            $('#previewModal').modal('show');
        }
    </script>
@endsection

@section('script')

@endsection
