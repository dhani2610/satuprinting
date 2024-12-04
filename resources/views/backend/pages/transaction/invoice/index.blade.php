@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important
        }

        label {
            float: left;
        }
    </style>

    <div class="main-content-inner">
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>All Invoice</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($invoices) }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-receipt bx-sm"></i>
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
                                    <h4 class="mb-0 me-2">{{ count($cust_inv) }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
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
                                <span>Total Bill</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">@currency($total_bill)</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-money bx-sm"></i>
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
                                <span>Total Remaining</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">@currency($totalRemaining)</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-credit-card-front bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <form action="" method="get" id="filter-form">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-header border-bottom">
                            <h5 class="card-title">Filter</h5>
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-3 invoice_customer">
                                    <select id="UserRole" name="customer" class="form-select text-capitalize"
                                        onchange="$('#filter-form').submit()" fdprocessedid="7fm0qj">
                                        <option value=""> All Customer </option>
                                        @foreach ($customer as $cusFilter)
                                            <option value="{{ $cusFilter->id }}"
                                                {{ Request::get('customer') == $cusFilter->id ? 'selected' : '' }}>
                                                {{ $cusFilter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 invoice_project">
                                    <select name="project" class="form-select text-capitalize"
                                        onchange="$('#filter-form').submit()" required>
                                        <option value="">-- Project --</option>
                                        @foreach ($project as $proj)
                                            <option value="{{ $proj->id }}"
                                                {{ Request::get('project') == $proj->id ? 'selected' : '' }}>
                                                {{ $proj->no_project }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 invoice_date">
                                    <input type="text" id="bs-rangepicker-dropdown"
                                        class="bs-rangepicker-dropdown form-control" value="{{ Request::get('date') }}"
                                        name="date" />
                                </div>
                                <div class="col-md-3 invoice_status"><select id="invoice_status"
                                        class="form-select text-capitalize" fdprocessedid="uxn6" name="status" onchange="$('#filter-form').submit()">
                                        <option value=""> Select Status </option>
                                        <option value="UNPAID" {{ Request::get('status') == 'UNPAID' ? 'selected' : '' }} class="text-capitalize">UNPAID</option>
                                        <option value="PARTIAL" {{ Request::get('status') == 'PARTIAL' ? 'selected' : '' }} class="text-capitalize">PARTIAL</option>
                                        <option value="PAID" {{ Request::get('status') == 'PAID' ? 'selected' : '' }} class="text-capitalize">PAID</option>
                                    </select></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('invoice.create'))
                                <button class="btn btn-primary text-white mb-3 buttonCreate d-none" style="float: right"
                                    data-bs-toggle="modal" data-bs-target="#modalCreate">
                                    <i class='bx bx-plus'></i>
                                    Create Invoice
                                </button>

                                <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create {{ $page_title }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-2 px-md-4">
                                                <form action="{{ route('invoice.store') }}" method="POST"
                                                    class="form-create" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        {{-- <label for="defaultSelect" class="form-label">Purchase Order</label> --}}
                                                        <div class="form-group mb-2">
                                                            <label for="name">Project</label>
                                                            <select name="id_project" class="select2 form-control"
                                                                required>
                                                                <option value="">-- Project --</option>
                                                                @foreach ($project as $proj)
                                                                    <option value="{{ $proj->id }}">
                                                                        {{ $proj->no_project }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        {{-- <label for="defaultSelect" class="form-label">Purchase Order</label> --}}
                                                        <div class="form-group mb-2">
                                                            <label for="name">Purchase Order</label>
                                                            <select name="id_po" class="select2 form-control" required
                                                                readonly>
                                                                <option value="">-- Purchase Order --</option>
                                                                @foreach ($purchaseOrder as $po)
                                                                    <option value="{{ $po->id }}">
                                                                        {{ $po->no_po }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="collapsible-fullname">Created
                                                                Date</label>
                                                            <input type="date" id="collapsible-fullname"
                                                                class="form-control" placeholder="John Doe"
                                                                name="created_date" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="collapsible-phone">Deadline
                                                                Date</label>
                                                            <input type="date" name="deadline_date"
                                                                class="form-control" placeholder="658 799 8941" required
                                                                aria-label="658 799 8941">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="card">
                                                            <h5 class="card-header">Detail</h5>
                                                            <div class="table-responsive text-nowrap">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr class="text-nowrap">
                                                                            <th>Item</th>
                                                                            <th>Qty</th>
                                                                            <th>Price</th>
                                                                            <th>Total Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-border-bottom-0">
                                                                        <!-- Rows will be appended here dynamically -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="input-group input-group-lg mb-3">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="text" class="form-control" name="total"
                                                            placeholder="Total" readonly name="total">
                                                    </div>

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-4">
                                                            <label for="defaultSelect" class="form-label">Category</label>
                                                            <select id="defaultSelect" class="form-select select-category"
                                                                name="category">
                                                                <option value="1">DP</option>
                                                                <option value="2">Full Payment</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-partial">
                                                            <label class="form-label"
                                                                for="description">Description</label>
                                                            <input type="text" id="description" class="form-control"
                                                                name="description" placeholder="Description">
                                                        </div>
                                                        <div class="col-md-4 form-partial">
                                                            <label class="form-label" for="bill">Bill</label>
                                                            <input type="text" id="bill" class="form-control"
                                                                name="bill" value="0" placeholder="50.000.000">
                                                        </div>
                                                    </div>


                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="ppn_percentage">PPN (%)</label>
                                                            <div class="input-group input-group-lg mb-3">
                                                                <input type="number" class="form-control" name="ppn"
                                                                    placeholder="11">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label" for="total_ppn">Total PPN</label>
                                                            <div class="input-group input-group-lg mb-3">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" class="form-control"
                                                                    name="total_ppn" placeholder="10.000.000" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="ppn_percentage">PPH (%)</label>
                                                            <div class="input-group input-group-lg mb-3">
                                                                <input type="text" class="form-control" name="pph"
                                                                    placeholder="11">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label" for="total_pph">Total PPH</label>
                                                            <div class="input-group input-group-lg mb-3">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" class="form-control"
                                                                    name="total_pph" placeholder="10.000.000" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="grand_total" class="form-label">Grand Total</label>
                                                        <div class="input-group input-group-lg mb-3">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="text" class="form-control" name="grand_total"
                                                                placeholder="Grand Total" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <label for="name">Notes</label>
                                                        <textarea name="catatan" class="form-control" id="" cols="10" rows="5"></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </p>

                        {{-- <div class="container">
                            <h1>Generate PDF from Laravel View</h1>
                            <button id="generatePDF" class="btn btn-primary">Generate PDF</button>
                        </div> --}}
                    
                        <!-- Modal -->
                        <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pdfModalLabel">Print Invoice</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe id="pdfFrame" style="width:100%; height:500px;" frameborder="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="card-datatable table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="datatables-simply table border-top">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Purchase Order</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Bill</th>
                                        <th>Remaining</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $inv)
                                        @php
                                            $po = \App\Models\PurchaseOrder::where('id', $inv->id_po)->first();
                                            $cust = \App\Models\Admin::where('id', $po->customer_id)->first();
                                            $proj = \App\Models\Project::where('id', $inv->id_project)->first();
                                            $created_by = \App\Models\Admin::where('id', $inv->created_by)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $inv->no_inv }}</td>
                                            <td>{{ $po->no_po }}</td>
                                            <td>{{ $cust->name }}</td>
                                            <td>{{ $proj->no_project ?? '-' }}</td>
                                            <td> @currency($inv->grand_total)</td>
                                            @php
                                                $getPaymentInfo = getPaymentInvoice($inv->id);
                                            @endphp
                                            {{-- @dd($getPaymentInfo); --}}
                                            <td>
                                                @currency($getPaymentInfo[0]['sisa'])
                                            </td>
                                            <td>{{ $created_by->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($inv->created_date)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>
                                                @if ($inv->category == 1)
                                                    @if ($getPaymentInfo[0]['payment'] == 0)
                                                        <span class="badge bg-label-danger">UNPAID</span>
                                                    @elseif ($getPaymentInfo[0]['sisa'] > 0)
                                                            <span class="badge bg-label-warning">PARTIAL</span>
                                                    @else
                                                        <span class="badge bg-label-success">PAID</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-label-success">PAID</span>
                                                @endif
                                                {{-- @endif --}}
                                            </td>
                                            <td>
                                                <div class="d-inline-block text-nowrap">
                                                    <a href="{{ route('pdf-invoice',$inv->id) }}" target="_blank" class="btn btn-sm btn-icon"><i class="bx bx-printer"></i></a>
                                                    @if (Auth::guard('admin')->user()->can('invoice.payment'))
                                                        <button class="btn btn-sm btn-icon payment-button" data-bs-toggle="modal"
                                                            data-bs-target="#modalPayment" data-id="{{ $inv->id }}"
                                                            onclick="payment('{{ $inv->id }}')">
                                                            <i class="bx bx-credit-card"></i>
                                                        </button>
                                                    @endif
                                                    @if (Auth::guard('admin')->user()->can('invoice.edit'))
                                                        <button class="btn btn-sm btn-icon edit-button" data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit" data-id="{{ $inv->id }}">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    @endif
                                                    @if (Auth::guard('admin')->user()->can('invoice.delete'))
                                                        <button class="btn btn-sm btn-icon"
                                                            onclick="confirmDelete('{{ route('invoice.destroy', $inv->id) }}')">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- Data rows will go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
    <input type="hidden" class="sisa_payment">


    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $page_title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-4">
                    <form action="{{ route('invoice.update') }}" id="form-edit" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="inv_id" name="inv_id">
                        <div class="mb-3">
                            {{-- <label for="defaultSelect" class="form-label">Purchase Order</label> --}}
                            <div class="form-group mb-2">
                                <label for="name">Project</label>
                                <select name="id_project" class="select2 form-control" required>
                                    <option value="">-- Project --</option>
                                    @foreach ($project as $proj)
                                        <option value="{{ $proj->id }}">
                                            {{ $proj->no_project }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            {{-- <label for="defaultSelect" class="form-label">Purchase Order</label> --}}
                            <div class="form-group mb-2">
                                <label for="name">Purchase Order</label>
                                <select name="id_po" class="select2 form-control" required readonly>
                                    <option value="">-- Purchase Order --</option>
                                    @foreach ($purchaseOrder as $po)
                                        <option value="{{ $po->id }}">{{ $po->no_po }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="collapsible-fullname">Created
                                    Date</label>
                                <input type="date" id="collapsible-fullname" class="form-control"
                                    placeholder="John Doe" name="created_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="collapsible-phone">Deadline
                                    Date</label>
                                <input type="date" name="deadline_date" class="form-control"
                                    placeholder="658 799 8941" required aria-label="658 799 8941">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="card">
                                <h5 class="card-header">Detail</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <!-- Rows will be appended here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="input-group input-group-lg mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" name="total" placeholder="Total" readonly
                                name="total">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="defaultSelect" class="form-label">Category</label>
                                <select id="defaultSelect" class="form-select select-category" name="category">
                                    <option value="1">DP</option>
                                    <option value="2">Full Payment</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-partial">
                                <label class="form-label" for="description">Description</label>
                                <input type="text" id="description" class="form-control" name="description"
                                    placeholder="Description">
                            </div>
                            <div class="col-md-4 form-partial">
                                <label class="form-label" for="bill">Bill</label>
                                <input type="text" id="bill" class="form-control bill-edit" name="bill"
                                    value="0" placeholder="50.000.000">
                            </div>
                        </div>


                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="ppn_percentage">PPN (%)</label>
                                <div class="input-group input-group-lg mb-3">
                                    <input type="number" class="form-control ppn-edit" name="ppn" placeholder="11">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="total_ppn">Total PPN</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text total-ppn">Rp</span>
                                    <input type="text" class="form-control" name="total_ppn" placeholder="10.000.000"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="ppn_percentage">PPH (%)</label>
                                <div class="input-group input-group-lg mb-3">
                                    <input type="text" class="form-control" name="pph"
                                        placeholder="11">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="total_pph">Total PPH</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control"
                                        name="total_pph" placeholder="10.000.000" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="grand_total" class="form-label">Grand Total</label>
                            <div class="input-group input-group-lg mb-3">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control grand-total" name="grand_total"
                                    placeholder="Grand Total" readonly>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="name">Notes</label>
                            <textarea name="catatan" class="form-control" id="" cols="10" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>



    {{-- MODAL TABLE PAYMENT  --}}
    <div class="modal fade" id="modalPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-simple modal-upgrade-plan">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-2" style="padding: 10px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        fdprocessedid="xnh7m"></button>
                    <div class="text-center">
                        <h3 class="mb-4">Payment</h3>
                    </div>
                    <button class="btn btn-primary text-white mb-3 addpaymentButtonCreate d-none" style="float: right"
                        data-bs-toggle="modal" data-bs-target="#addpayment">
                        <i class='bx bx-plus'></i>
                        Create Payment
                    </button>
                    <div class="card-datatable table-responsive">
                        <table id="dataTable" class="datatables-basic2 table border-top">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>NO</th>
                                    <th>Total</th>
                                    <th>Created Pay</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-payment">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ App Wizard -->
            </div>
        </div>
    </div>
    <button class="btn btn-primary text-white mb-3 addpayment d-none" style="float: right" data-bs-toggle="modal"
        data-bs-target="#addpayment">
        <i class='bx bx-plus'></i>
        Create Payment
    </button>
    <div class="modal fade" id="addpayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">

            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-2" style="padding: 10px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        fdprocessedid="xnh7m"></button>
                    <div class="text-center">
                        <h3 class="mb-4">Payment</h3>
                    </div>

                    <div class="">
                        <form action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_inv" class="invoice_id">
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">ID Transaction</label>
                                <input type="text" class="form-control" id="ecommerce-customer-add-name"
                                placeholder="TRX-3292389983" name="id_transaksi" aria-label="John Doe"
                                fdprocessedid="3gudd4" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">Upload Receipt</label>
                                <input type="file" class="form-control" id="ecommerce-customer-add-name"
                                    name="receipt" aria-label="John Doe" required accept="image/*">
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">Payment Date</label>
                                <input type="date" class="form-control" id="ecommerce-customer-add-name"
                                    name="payment_date" aria-label="John Doe" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">Total</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">Rp</span>
                                    <input type="total" name="total" class="form-control total_payment"
                                        placeholder="10.000.000" fdprocessedid="vpa282" required>
                                </div>
                                <small style="color: red" class="sisa_text"></small>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3"
                                    fdprocessedid="v3df2l">Submit</button>
                                <button type="reset" class="btn btn-label-secondary btn-reset mt-3"
                                    data-bs-dismiss="modal" aria-label="Close" fdprocessedid="qtuf9"
                                    required>Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ App Wizard -->
            </div>
        </div>
    </div>

    <button class="btn btn-primary text-white mb-3 editpayment d-none" style="float: right" data-bs-toggle="modal"
        data-bs-target="#editpayment">
        <i class='bx bx-plus'></i>
        Edit Payment
    </button>
    <div class="modal fade" id="editpayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">

            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-2" style="padding: 10px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        fdprocessedid="xnh7m"></button>
                    <div class="text-center">
                        <h3 class="mb-4"> Edit Payment</h3>
                    </div>

                    <div class="">
                        <form action="{{ route('payment.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_payment" class="id_payment">
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">ID Transaction</label>
                                <input type="text" class="form-control id_trans_edit" id="ecommerce-customer-add-name"
                                    placeholder="TRX-3292389983" name="id_transaksi" aria-label="John Doe"
                                    fdprocessedid="3gudd4" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">Upload Receipt</label>
                                <input type="file" class="form-control" id="ecommerce-customer-add-name"
                                    accept="image/*" name="receipt" aria-label="John Doe">
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">Payment Date</label>
                                <input type="date" class="form-control payment_date_edit"
                                    id="ecommerce-customer-add-name" name="payment_date" aria-label="John Doe" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="ecommerce-customer-add-name">Total</label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="total" name="total" class="form-control total_edit"
                                        placeholder="10.000.000" fdprocessedid="vpa282" required>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-3"
                                    fdprocessedid="v3df2l">Submit</button>
                                <button type="reset" class="btn btn-label-secondary btn-reset mt-3"
                                    data-bs-dismiss="modal" aria-label="Close" fdprocessedid="qtuf9"
                                    required>Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ App Wizard -->
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('filter-form');

        document.getElementById('statusFilter').addEventListener('change', function() {
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
    <script>
        function payment(id) {
            $('.invoice_id').val(id);

            if (id) {
                $.ajax({
                    url: "{{ route('list-payment-invoice') }}",
                    type: "GET",
                    data: {
                        invId: id
                    },
                    success: function(response) {
                        if (response.msg == 'berhasil') {
                            var inv = response.inv;
                            var total = response.total;
                            console.log(response);
                            // Clear existing rows
                            $('.table-body-payment').empty();

                            // console.log(inv);
                            $('.sisa_payment').val(numberFormat(response.payment_info[0]['sisa']));
                            console.log(response.payment_info[0]['sisa']);
                            $('.sisa_text').html('Remaining Rp. ' + numberFormat(response.payment_info[0][
                                'sisa']));

                            // Append new rows
                            inv.forEach(function(detail) {
                                const url = "{{ route('payment.destroy', ['id' => '__ID__']) }}";
                                var row = `
                            <tr>
                                <td>${detail.no_payment}</td>
                                <td>
                                    ${numberFormat(detail.total)}
                                </td>
                                <td>${detail.created_pay}</td>
                                <td>${detail.created_by ? detail.created_by : '-'}</td>
                                <td>${new Date(detail.created_date).toLocaleString()}</td>
                                <td>
                                    <a class="text-dark" onclick="editPayment('${detail.id}')" data-id="${detail.id}">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a class="text-dark" onclick="confirmDelete('${url.replace('__ID__', detail.id)}')">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                                const deleteUrl = url.replace('__ID__', detail.id);

                                $('.table-body-payment').append(row);
                            });
                        } else {
                            alert('Failed to retrieve purchase order details.');
                        }
                    }
                });
            }
        }

        $('.total_payment').on('input keyup', function() {
            let total_payment = parseNumber($(this).val());
            let sisa_payment = parseNumber($('.sisa_payment').val());
            // console.log(total_payment);

            let sisa = total_payment - sisa_payment;

            $('.sisa_text').html('Remaining Rp. ' + numberFormat(sisa));
            if (total_payment > sisa_payment) {
                $('.total_payment').val(numberFormat(0));
            } else {
                $('.total_payment').val(numberFormat(total_payment));
            }
        });

        function editPayment(id) {
            $('.editpayment').trigger('click');
            $('.id_payment').val(id);

            if (id) {
                $.ajax({
                    url: "{{ route('payment-invoice-by-id') }}",
                    type: "GET",
                    data: {
                        invId: id
                    },
                    success: function(response) {
                        if (response.msg == 'berhasil') {
                            var inv = response.inv;

                            $('.id_trans_edit').val(inv.id_transaksi);
                            $('.payment_date_edit').val(inv.payment_date);
                            $('.total_edit').val(inv.total);
                        } else {
                            alert('Failed to retrieve payment.');
                        }
                    }
                });
            }
        }

        // Function to show or hide fields based on category selection
        function toggleFields() {
            $('.form-partial').hide();

            var category = $('.select-category').val();
            $('input[name="ppn"]').val('');
            $('input[name="total_ppn"]').val('');
            $('input[name="grand_total"]').val('');
            $('input[name="description"]').val('');
            $('input[name="bill"]').val('0');
            if (category == '1') { // DP selected
                $('.form-partial').show();
                $('#description').prop('required', true);
                $('#bill').prop('required', true);
            } else { // Full Payment selected
                $('.form-partial').hide();
                $('#description').prop('required', false);
                $('#bill').prop('required', false);
            }
        }

        // Initialize the fields on page load
        toggleFields();

        // Event listener for category change
        $('.select-category').change(function() {
            toggleFields();
        });

        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
            $('.form-create').trigger('reset');
            $('table.table-bordered tbody').empty();
            $('input[name="id_project"]').val('');
            $('input[name="id_po"]').val('');
            $('input[name="total"]').val('');
            $('input[name="description"]').val('');
            $('input[name="ppn"]').val('');
            $('input[name="total_ppn"]').val('');
            $('input[name="grand_total"]').val('');
            $('input[name="bill"]').val('0');
        }

        function showCreateButtonv2() {
            $('.addpayment').trigger('click');
        }

        // Function to format numbers as currency
        function numberFormat(number) {
            return number.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function parseNumber(numberString) {
            return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
        }


        $(document).ready(function() {
            var services = @json($services);

            function getServiceNameById(serviceId) {
                let serviceName = '';
                services.forEach(service => {
                    if (service.id == serviceId) {
                        serviceName = service.service;
                    }
                });
                return serviceName;
            }
            function parseNumberPPH(numberString) {
                return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
            }

            function getTablePO(poId, modalClass) {
                if (poId) {
                    $.ajax({
                        url: "{{ route('getPO') }}",
                        type: "GET",
                        data: {
                            id_po: poId
                        },
                        success: function(response) {
                            if (response.msg == 'berhasil') {
                                var poDetails = response.poDetail;
                                var po = response.po;

                                // Clear existing rows
                                $(modalClass + ' table.table-bordered tbody').empty();

                                // Append new rows
                                poDetails.forEach(function(detail) {
                                    let serviceName = getServiceNameById(detail.id_item);
                                    let total_price = numberFormat(parseNumber(detail.total_prices));
                                    console.log(total_price, detail.total_prices);
                                    var row = `
                            <tr>
                                <td>${serviceName}</td>
                                <td>${detail.qty}</td>
                                <td>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control item-price" value="${numberFormat(detail.price)}" readonly>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control item-total-price" value="${total_price}" readonly>
                                    </div>
                                </td>
                            </tr>
                        `;
                                    $(modalClass + ' table.table-bordered tbody').append(row);
                                });

                                // Update total using the retrieved PO data
                                $(modalClass + ' input[name="total"]').val(numberFormat(parseNumber(po
                                    .total)));
                                // Update total using the retrieved PO data
                                $(modalClass + ' input[name="ppn"]').val(numberFormat(parseNumber(po
                                    .ppn)));
                                // Update total using the retrieved PO data
                                $(modalClass + ' input[name="total_ppn"]').val(numberFormat(parseNumber(po
                                    .total_ppn)));
                                // Update total using the retrieved PO data
                                $(modalClass + ' input[name="pph"]').val(parseNumberPPH(po
                                    .pph));
                                // Update total using the retrieved PO data
                                $(modalClass + ' input[name="total_pph"]').val(numberFormat(parseNumber(po
                                    .total_pph)));
                                $(modalClass + ' input[name="grand_total"]').val(numberFormat(parseNumber(po
                                    .grand_total)));
                            } else {
                                alert('Failed to retrieve purchase order details.');
                            }
                        }
                    });
                }
            }

            // Event listener for purchase order change
            $('select[name="id_project"]').change(function() {
                var projId = $(this).val();
                var modalClass = $(this).closest('.modal').attr('id') === 'modalCreate' ? '#modalCreate' :
                    '#modal-edit';

                if (projId) {
                    $.ajax({
                        url: "{{ route('getProject') }}",
                        type: "GET",
                        data: {
                            projId: projId
                        },
                        success: function(response) {
                            if (response.msg == 'berhasil') {
                                var proj = response.proj;
                                $(modalClass + ' select[name="id_po"]').val(proj.id_po)
                                    .change();
                                getTablePO(proj.id_po, modalClass);
                            } else {
                                alert('Failed to retrieve purchase order details.');
                            }
                        }
                    });
                }
            });

            // Event listener for PPn percentage and bill change
            $('input[class="ppn-edit"], input[class="bill-edit"]').on('input keyup', function() {
                updatePPn(this);
            });

            $('input[name="ppn"],input[name="pph"], input[name="bill"]').on('input keyup', function() {
                updatePPn(this);
            });

            function fetchInvoiceDetails(invId) {
                $.ajax({
                    url: "{{ route('getInvoice') }}",
                    type: "GET",
                    data: {
                        invId: invId
                    },
                    success: function(response) {
                        if (response.msg == 'berhasil') {
                            var inv = response.inv;
                            console.log(inv);
                            var modalClass = '#modal-edit';
                            $(modalClass + ' input[name="created_date"]').val(inv.created_date);
                            $(modalClass + ' input[name="deadline_date"]').val(inv.deadline);
                            $(modalClass + ' input[name="description"]').val(inv.description);
                            $(modalClass + ' select[name="category"]').val(inv.category).change();
                            $(modalClass + ' input[name="ppn"]').val(inv.ppn);
                            $(modalClass + ' input[name="bill"]').val(numberFormat(inv.bill));
                            $(modalClass + ' input[name="grand_total"]').val(numberFormat(parseNumber(inv.grand_total)));
                            $(modalClass + ' input[name="total_ppn"]').val(numberFormat(inv.total_ppn));
                            $(modalClass + ' input[name="pph"]').val(numberFormat(inv.pph));
                            $(modalClass + ' input[name="total_pph"]').val(numberFormat(inv.total_pph));

                            $(modalClass + ' select[name="id_project"]').val(inv.id_project).change();
                            $(modalClass + ' select[name="id_po"]').val(inv.id_po).change();
                            $(modalClass + ' textarea[name="catatan"]').val(inv.catatan);
                            getTablePO(inv.id_po, modalClass);
                        } else {
                            alert('Failed to retrieve invoice details.');
                        }
                    }
                });
            }

            function updatePPn(element) {
                var modalClass = $(element).closest('.modal').attr('id') === 'modalCreate' ? '#modalCreate' :
                    '#modal-edit';
                var ppnPercentage = parseFloat($(modalClass + ' input[name="ppn"]').val()) || 0;
                var pphPercentage = $(modalClass + ' input[name="pph"]').val() || 0;
                var bill = parseNumber($(modalClass + ' input[name="bill"]').val()) || 0;
                var category = $(modalClass + ' .select-category').val();
                var total = parseNumber($(modalClass + ' input[name="total"]').val()) || 0;

                $(element).val(numberFormat(parseNumber($(element).val())));

                var baseAmount = category == '1' ? bill : total;
                var totalPPn = baseAmount * (ppnPercentage / 100);
                var totalPph = baseAmount * (pphPercentage / 100) + totalPPn;
                var grandTotal = baseAmount + totalPPn - totalPph;

                $(modalClass + ' input[name="total_pph"]').val(numberFormat(totalPph));
                $(modalClass + ' input[name="total_ppn"]').val(numberFormat(totalPPn));
                $(modalClass + ' input[name="grand_total"]').val(numberFormat(grandTotal));
            }

            function toggleFormFields(modalClass) {
                var category = $(modalClass + ' select[name="category"]').val();
                if (category == '1') {
                    $(modalClass + ' .form-partial').show();
                } else {
                    $(modalClass + ' .form-partial').hide();
                }
            }

            $('select[name="category"]').change(function() {
                var modalClass = $(this).closest('.modal').attr('id') === 'modalCreate' ? '#modalCreate' :
                    '#modal-edit';
                toggleFormFields(modalClass);
            });

            $('.edit-button').on('click', function() {
                var invId = $(this).data('id');
                $('.inv_id').val(invId);
                fetchInvoiceDetails(invId);
            });

            // Initialize form fields visibility
            toggleFormFields('#modalCreate');
            toggleFormFields('#modal-edit');
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('filter-form');
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
