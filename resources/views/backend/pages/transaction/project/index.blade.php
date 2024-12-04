@extends('backend.layouts-new.app')

@section('content')

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
    </style>

    <div class="main-content-inner">
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>All Project</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($project) }} </h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx bx-chalkboard bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($customers_project) }} </h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-group bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>On Progress</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ getTotalStatusProject('On Progres') }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-stats bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Over Date</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ getTotalStatusProject('Overdue') }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-calendar-x bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header border-bottom">
                        <h5 class="card-title">Filter</h5>
                        <form action="" method="GET" id="filter-form">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-2 project_customer">
                                    <label for="">Customer</label>
                                    <select id="customer" name="id_customer" class="form-select select2 text-capitalize" onchange="$('#filter-form').submit()"
                                    fdprocessedid="tdo6sd">
                                    <option value="">Choose Customer</option>
                                        @foreach ($customers_project as $item)
                                            <option value="{{ $item->name }}" {{ $item->id == Request::get('id_customer') ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                </select></div>
                                <div class="col-md-2 project_mkt">
                                    <label for="">Team</label>
                                    <select id="id_marketing" name="id_marketing" class="select2 form-select text-capitalize" onchange="$('#filter-form').submit()"
                                        fdprocessedid="dzgave">
                                        <option value=""> Select Team </option>
                                        @foreach ($marketing_project as $team)
                                            <option value="{{ $team->name }}" {{ $team->id == Request::get('id_marketing') ? 'selected' : '' }}>{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 project_start_date">
                                    <label for="">Start Date</label>
                                    <input type="text" id="bs-rangepicker-dropdown-start"
                                            class="bs-rangepicker-dropdown form-control" value="{{ Request::get('start_date') }}"
                                            name="start_date" />
                                </div>
                                <div class="col-md-2 project_deadline_date">
                                    <label for="">Deadline</label>
                                    <input type="text" id="bs-rangepicker-dropdown-deadline"
                                            class="bs-rangepicker-dropdown form-control" value="{{ Request::get('deadline') }}"
                                            name="deadline" />
                                </div>
                                <div class="col-md-2 project_created_date">
                                    <label for="">Created At</label>
                                    <input type="text" id="bs-rangepicker-dropdown-created-at"
                                            class="bs-rangepicker-dropdown form-control" value="{{ Request::get('created_at') }}"
                                            name="created_at" />
                                </div>
                                <div class="col-md-2 project_status">
                                    <label for="">Status</label>
                                    <select id="project_status"
                                        class="form-select text-capitalize" name="status" fdprocessedid="ancyob" onchange="$('#filter-form').submit()">
                                        <option value=""> Select Status </option>
                                        <option value="On Progress" {{ Request::get('status') == 'On Progress' ? 'selected' : '' }} class="text-capitalize">On Progress</option>
                                        <option value="OverDue" {{ Request::get('status') == 'OverDue' ? 'selected' : '' }} class="text-capitalize">OverDue</option>
                                        <option value="Done" {{ Request::get('status') == 'Done' ? 'selected' : '' }} class="text-capitalize">Done</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">{{ $page_title }} List</h4>
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('project.create'))
                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Project</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Project</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('project.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-name">Name</label>
                                                    <input type="text" class="form-control"
                                                        id="ecommerce-customer-add-name"
                                                        value="{{ Auth::guard('admin')->user()->name }}"
                                                        name="customerName" aria-label="John Doe" disabled="">

                                                </div>
                                                @php
                                                    if (Auth::guard('admin')->user()->id_divisi != null) {
                                                        $actV = \App\Models\Divisi::where(
                                                            'id',
                                                            Auth::guard('admin')->user()->id_divisi,
                                                        )->first();
                                                    }
                                                @endphp
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-email">Division</label>
                                                    <input type="text" id="ecommerce-customer-add-email"
                                                        class="form-control" value="{{ $actV->divisi }}"
                                                        name="customerEmail" disabled="">

                                                </div>

                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-email">Title</label>
                                                    <input type="text" id="ecommerce-customer-add-email"
                                                        class="form-control" value="" name="name_project" required>

                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label" for="customer">Customer</label>
                                                    <select id="list-customer" name="id_customer"
                                                        class="select2 form-select" required>
                                                        <option value="">Select</option>
                                                        @foreach ($customers as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label for="name">Purchase
                                                        Order</label>
                                                    <select name="id_po" class="select2 form-control" required
                                                        id="">
                                                        <option value="">-- Puchase Order
                                                            --
                                                        </option>
                                                        @foreach ($purchaseOrder as $po)
                                                            <option value="{{ $po->id }}">
                                                                {{ $po->no_po }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-row mb-2">
                                                    <div class="row">
                                                        <div class="form-group mb-2 col-md-6 col-sm-6">
                                                            <label class="mb-2" for="password">Start
                                                                Date</label>
                                                            <input type="date" class="form-control" value=""
                                                                name="start_date">
                                                        </div>
                                                        <div class="form-group mb-2 col-md-6 col-sm-6">
                                                            <label class="mb-2"
                                                                for="password_confirmation">Deadline</label>
                                                            <input type="date" class="form-control" value=""
                                                                name="deadline">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-email">Note</label>
                                                    <textarea id="ecommerce-customer-add-email" class="form-control" name="note"></textarea>

                                                </div>

                                            </div>

                                            <div class="pt-3">
                                                <button type="submit"
                                                    class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                                                <button type="reset" class="btn bg-label-danger"
                                                    data-bs-dismiss="offcanvas">Discard</button>
                                            </div>
                                            <input type="hidden"><input type="hidden"><input type="hidden"><input
                                                type="hidden"><input type="hidden">
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </p>
                        <div class="clearfix"></div>
                        <div class="card-datatable table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="datatables-simply table border-top">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th >ID</th>
                                        <th >NO PO</th>
                                        <th >Title</th>
                                        <th >Customer</th>
                                        <th >City</th>
                                        <th >Marketing</th>
                                        <th >Start Date</th>
                                        <th >Deadline</th>
                                        <th >Created By</th>
                                        <th >Created Date</th>
                                        <th >Remaining</th>
                                        {{-- <th >Progress</th> --}}
                                        {{-- <th >Status</th> --}}
                                        <th  class="no-print">Action</th>
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


                                            // PIN CUSTOMER 
                                            $pin = $cust->pin_marketing;
                                            $idPin = $cust->$pin;
                                            $teamPin = \App\Models\Admin::where('id',$idPin)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $proj->no_project }}</td>
                                            <td>
                                                {{-- <a href="{{ route('project.activity',$proj->id) }}"><span
                                                    class="fw-medium">{{ $po->no_po }}</span>
                                                </a> --}}
                                                {{ $po->no_po }}
                                            </td>
                                            <td>{{ $proj->name_project }}</td>
                                            <td>{{ $cust->name }}</td>
                                            <td>{{ $citycust->city ?? '-' }}</td>
                                            <td>{{ $teamPin->name ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proj->start_date)->locale('id')->translatedFormat('l, j F Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proj->deadline)->locale('id')->translatedFormat('l, j F Y') }}</td>
                                            <td>{{ $marketing->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proj->created_at)->locale('id')->translatedFormat('l, j F Y') }}</td>
                                            @php
                                                $start_date = \Carbon\Carbon::parse($proj->start_date);
                                                $deadline = \Carbon\Carbon::parse($proj->deadline);
                                                $remaining = $start_date->diffInDays($deadline, false); // false to get negative value if past
                                            @endphp

                                            <td>{{ $remaining }} Day</td>
                                            {{-- <td>
                                                {{ getProgresPercentageProject($proj->id) }}%
                                            </td> --}}
                                            {{-- <td>
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
                                            </td> --}}
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('project.edit'))
                                                    <a class="text-dark" 
                                                        data-bs-toggle="offcanvas" data-bs-target="#edit-{{ $proj->id }}" aria-controls="offcanvasEnd" href="#">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-{{ $proj->id }}"
                                                        aria-labelledby="offcanvasActivityAdd" aria-modal="true"
                                                        role="dialog">
                                                        <div class="offcanvas-header">
                                                            <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                Project - {{ $proj->no_project }}</h5>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                                            <form action="{{ route('project.update',$proj->id) }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-name">Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="ecommerce-customer-add-name"
                                                                            value="{{ $marketing->name }}"
                                                                            name="customerName" aria-label="John Doe"
                                                                            disabled="">

                                                                    </div>
                                                                    @php
                                                                        if (
                                                                            $marketing->id !=
                                                                            null
                                                                        ) {
                                                                            $actV = \App\Models\Divisi::where(
                                                                                'id',
                                                                                $marketing->id_divisi,
                                                                            )->first();
                                                                        }
                                                                    @endphp
                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-email">Division</label>
                                                                        <input type="text"
                                                                            id="ecommerce-customer-add-email"
                                                                            class="form-control"
                                                                            value="{{ $actV->divisi }}"
                                                                            name="customerEmail" disabled="">

                                                                    </div>

                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-email">Title</label>
                                                                        <input type="text"
                                                                            id="ecommerce-customer-add-email"
                                                                            class="form-control" value="{{ $proj->name_project }}"
                                                                            name="name_project" required>

                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <label class="form-label"
                                                                            for="customer">Customer</label>
                                                                        <select id="list-customer" name="id_customer"
                                                                            class="select2 form-select" required>
                                                                            <option value="">Select</option>
                                                                            @foreach ($customers as $item)
                                                                                <option value="{{ $item->id }}" {{ $proj->id_customer == $item->id ? 'selected' : '' }}>
                                                                                    {{ $item->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="name">Purchase
                                                                            Order</label>
                                                                        <select name="id_po"
                                                                            class="select2 form-control" required
                                                                            id="">
                                                                            <option value="">-- Puchase Order
                                                                                --
                                                                            </option>
                                                                            @foreach ($purchaseOrder as $po)
                                                                                <option value="{{ $po->id }}" {{ $proj->id_po == $po->id ? 'selected' : '' }}>
                                                                                    {{ $po->no_po }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-row mb-2">
                                                                        <div class="row">
                                                                            <div class="form-group mb-2 col-md-6 col-sm-6">
                                                                                <label class="mb-2" for="password">Start
                                                                                    Date</label>
                                                                                <input type="date" class="form-control"
                                                                                    value="{{ $proj->start_date }}" name="start_date">
                                                                            </div>
                                                                            <div class="form-group mb-2 col-md-6 col-sm-6">
                                                                                <label class="mb-2"
                                                                                    for="password_confirmation">Deadline</label>
                                                                                <input type="date" class="form-control"
                                                                                    value="{{ $proj->deadline }}" name="deadline">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-email">Note</label>
                                                                        <textarea id="ecommerce-customer-add-email" class="form-control" name="note">{{ $proj->note }}</textarea>

                                                                    </div>

                                                                </div>

                                                                <div class="pt-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                                                                    <button type="reset" class="btn bg-label-danger"
                                                                        data-bs-dismiss="offcanvas">Discard</button>
                                                                </div>
                                                                <input type="hidden"><input type="hidden"><input
                                                                    type="hidden"><input type="hidden"><input
                                                                    type="hidden">
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('project.delete'))
                                                    <a class="text-dark" onclick="confirmDelete('{{ route('project.destroy', $proj->id) }}')" >
                                                        <i class="bx bx-trash"></i>
                                                    </a>
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


    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>

    <script>
        // Tombol preview PDF
        $('#previewButton').on('click', function() {
            var file = $('#file_po').prop('files')[0];
            if (file) {
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    $('#pdfViewer').attr('src', e.target.result);
                    // Setelah memuat file, buka modal preview PDF
                    $('#previewModal').modal('show');
                };
                fileReader.readAsDataURL(file);
            } else {
                alert('Please select a PDF file first.');
            }
        });

        function showLampiranEdit(fileExist, id) {
            var file = $('#file_po-' + id).prop('files')[0];

            if (file) {
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    $('#pdfViewer').attr('src', e.target.result);
                    // Setelah memuat file, buka modal preview PDF
                    $('#previewModal').modal('show');
                };
                fileReader.readAsDataURL(file);
            } else {
                if (fileExist) {
                    $('#pdfViewer').attr('src', fileExist);
                    $('#previewModal').modal('show');
                    // fileReader.readAsDataURL(file);
                } else {
                    alert('Please select a PDF file first.');
                }
            }

        }

        // Fungsi untuk mengatur fokus modal setelah modal tertutup
        $('#previewModal').on('hidden.bs.modal', function() {
            // Fokus kembali ke modalCreate jika modal previewModal ditutup
            $('#modalCreate').focus();
        });
    </script>

    <script>
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filter-form');

            document.getElementById('bs-rangepicker-dropdown-start').addEventListener('change', function() {
                form.submit();
            });
            document.getElementById('bs-rangepicker-dropdown-deadline').addEventListener('change', function() {
                form.submit();
            });
            document.getElementById('bs-rangepicker-dropdown-created-at').addEventListener('change', function() {
                form.submit();
            });

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('applyBtn')) {
                    console.log('apply');
                    var form = document.getElementById('filter-form');
                    form.submit();
                }
            });

        });
    </script>


@endsection

@section('script')
@endsection
