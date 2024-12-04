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
        .modal-history .create-new {
        display: none;
    }
    </style>

    <div class="main-content-inner">
        <div class="row mb-4">

            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Purchase Order</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($purchase_order) }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-cart-add bx-sm"></i>
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
                                    <h4 class="mb-0 me-2">{{ $customerCount }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
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
                                <span>Quotation</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $purchaseOrderQuotation }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx bx-task bx-sm"></i>
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
                                <span>Amount</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">@currency($purchaseOrderAmount)</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-wallet bx-sm"></i>
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
                    <form action="" method="get" id="filter-form">
                        @csrf
                        <div class="card-header border-bottom">
                            <h5 class="card-title">Filter</h5>
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-3 user_role">
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
                                <div class="col-md-3 user_plan">
                                    <select id="teamFilter" name="team" class=" form-select text-capitalize"
                                        fdprocessedid="dzgave" onchange="$('#filter-form').submit()">
                                        <option value=""> All Team </option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}"
                                                {{ Request::get('team') == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 user_status">
                                    <select id="FilterTransaction" name="status" class="form-select text-capitalize"
                                        onchange="$('#filter-form').submit()" fdprocessedid="2wa8wc">
                                        <option value=""> All Status </option>
                                        <option value="1" {{ Request::get('status') == 1 ? 'selected' : '' }}
                                            class="text-capitalize">Waiting</option>
                                        <option value="2" {{ Request::get('status') == 2 ? 'selected' : '' }}
                                            class="text-capitalize">Approve</option>
                                        <option value="3" {{ Request::get('status') == 3 ? 'selected' : '' }}
                                            class="text-capitalize">Cancel</option>
                                    </select>
                                </div>
                                <div class="col-md-3 user_plan">
                                    <input type="text" id="bs-rangepicker-dropdown"
                                        class="bs-rangepicker-dropdown form-control" value="{{ Request::get('date') }}"
                                        name="date" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title float-left">{{ $page_title }} List</h4> --}}
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('purchase.order.create'))
                                <button class="btn btn-primary text-white mb-3 buttonCreate d-none" style="float: right"
                                    data-bs-toggle="modal" data-bs-target="#modalCreate">
                                    <i class='bx bx-plus'></i>
                                    Create Purchase Order
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
                                            <div class="modal-body">
                                                <form action="{{ route('purchase-order.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <div class="form-group mb-2">
                                                                    <label for="no_po">NO PURCHASE ORDER</label>
                                                                    <input type="text" class="form-control"
                                                                        id="no_po" name="no_po" placeholder=""
                                                                        value="" required>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Quotation</label>
                                                                    <select name="id_quo" class="form-control id_quo"
                                                                        id="" required>
                                                                        <option value="">-- Choose Quotation --
                                                                        </option>
                                                                        @foreach ($quotation as $quo)
                                                                            @php
                                                                                if ($quo->type != 'New') {
                                                                                    $tambahNo = '-' . $quo->type;
                                                                                } else {
                                                                                    $tambahNo = '';
                                                                                }
                                                                            @endphp
                                                                            <option value="{{ $quo->id }}">
                                                                                {{ $quo->no_quo . $tambahNo }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Customer</label>
                                                                    <select name="customer_id" class="form-control"
                                                                        id="customer_id" required>
                                                                        <option value="">-- Choose Customer --
                                                                        </option>
                                                                        @foreach ($customer as $cus)
                                                                            <option value="{{ $cus->id }}">
                                                                                {{ $cus->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="state">Marketing
                                                                                HO</label>
                                                                            <select name="marketing_ho"
                                                                                class="stateselect select2 form-control"
                                                                                id="" disabled>
                                                                                <option value="">Choose Team
                                                                                </option>
                                                                                @foreach ($teamCust as $t)
                                                                                    <option value="{{ $t->id }}">
                                                                                        {{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input disabled type="checkbox"
                                                                            name="pin_marketing" value="marketing_ho"
                                                                            class="required-checkbox"
                                                                            style="margin-top: 37px;">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="state">Marketing
                                                                                Branch</label>
                                                                            <select name="marketing_branch"
                                                                                class="stateselect select2 form-control"
                                                                                id="" disabled>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($teamCust as $t)
                                                                                    <option value="{{ $t->id }}">
                                                                                        {{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing"
                                                                            value="marketing_branch"
                                                                            class="required-checkbox"
                                                                            style="margin-top: 37px;" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="state">Marketing
                                                                                PIC
                                                                                Branch</label>
                                                                            <select name="marketing_pic_branch"
                                                                                class="stateselect select2 form-control"
                                                                                id="" disabled>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($teamCust as $t)
                                                                                    <option value="{{ $t->id }}">
                                                                                        {{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing"
                                                                            value="marketing_pic_branch"
                                                                            class="required-checkbox" disabled
                                                                            style="margin-top: 37px;">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="state">Marketing
                                                                                Perwakilan</label>
                                                                            <select name="marketing_perwakilan"
                                                                                class="stateselect select2 form-control"
                                                                                id="" disabled>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($teamCust as $t)
                                                                                    <option value="{{ $t->id }}">
                                                                                        {{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing"
                                                                            value="marketing_perwakilan"
                                                                            class="required-checkbox" disabled
                                                                            style="margin-top: 37px;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label"
                                                                        for="state">Marketer</label>
                                                                    <select name="marketer"
                                                                        class="stateselect select2 form-control"
                                                                        id="" disabled>
                                                                        <option value="">Choose Team</option>
                                                                        @foreach ($teamCust as $t)
                                                                            <option value="{{ $t->id }}">
                                                                                {{ $t->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="name">Created Date</label>
                                                                <input type="date" class="form-control" id="date"
                                                                    name="date" placeholder="" value=""
                                                                    required>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="name">Deadline</label>
                                                                <input type="date" class="form-control" id="date"
                                                                    name="deadline" placeholder="" value=""
                                                                    required>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="name">Lampiran</label>
                                                                <input type="text" class="form-control" id="lampiran"
                                                                    name="lampiran" placeholder="" value=""
                                                                    required>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="lampiran">File PO Masuk (PDF only)</label>
                                                                <div class="input-group">
                                                                    <input type="file" class="form-control"
                                                                        id="file_po" name="file_po" accept=".pdf"
                                                                        required>
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="previewButton">
                                                                        Preview
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="name">Notes</label>
                                                                <textarea name="catatan" class="form-control" id="" cols="10" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <p class="float-right mb-2">
                                                            <button type="button"
                                                                class="btn btn-primary addItemButton"><i
                                                                    class="fa fa-plus"></i></button>
                                                        </p>
                                                        <div class="table-responsive text-nowrap">
                                                            <table class=" table-item table table-bordered">
                                                                <thead>
                                                                    <tr class="text-nowrap" style="background: #38b6ff;">
                                                                        <th style="color: white">ITEM</th>
                                                                        <th style="color: white">QTY</th>
                                                                        <th style="color: white">PRICE</th>
                                                                        <th style="color: white">TOTAL PRICE</th>
                                                                        <th style="color: white">ACTION </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Item rows will be appended here -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-2">
                                                                <label for="total">Total (Rp)</label>
                                                                <input type="text" class="form-control" id="total"
                                                                    name="total" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="total">PPN (%)</label>
                                                                <input type="number" class="form-control" id="ppn"
                                                                    name="ppn" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="total">Total PPN (Rp)</label>
                                                                <input type="text" class="form-control" id="total_ppn"
                                                                    name="total_ppn" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="total">PPH (%)</label>
                                                                <input type="text" class="form-control" id="pph"
                                                                    name="pph" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="total">Total PPH (Rp)</label>
                                                                <input type="text" class="form-control" id="total_pph"
                                                                    name="total_pph" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-2">
                                                                <label for="total">GRAND TOTAL (Rp)</label>
                                                                <input type="text" class="form-control"
                                                                    id="grand_total" name="grand_total" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"
                                                        style="float: right">Save</button>
                                                </form>
                                            </div>
                                        </div>
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
                                        <th>NUMBER</th>
                                        <th>CUSTOMER</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Deadline</th>
                                        <th>Created By</th>
                                        <th>Created DATE</th>
                                        <th>Status</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_order as $po)
                                        <tr>
                                            <td>{{ $po->no_po }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center user-name">
                                                    <div class="avatar-wrapper">
                                                        @php
                                                            $custIndex = \App\Models\Admin::where(
                                                                'id',
                                                                $po->customer_id,
                                                            )->first();
                                                            $words = explode(' ', $custIndex->name);
                                                            $initials = '';
                                                            foreach ($words as $word) {
                                                                $initials .= strtoupper($word[0]);
                                                            }
                                                            // return $initials;
                                                        @endphp
                                                        <div class="avatar avatar-sm me-3">
                                                            @if ($custIndex->foto == null)
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-primary">{{ $initials }}</span>
                                                            @else
                                                                <img src="{{ asset('assets/img/customer/' . $custIndex->foto) }}"
                                                                    alt="Avatar" class="rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"><a href="#"
                                                            class="text-body text-truncate"><span
                                                                class="fw-medium">{{ $custIndex->name }}</span></a><small
                                                            class="text-muted">{{ $custIndex->email }}</small></div>
                                                </div>
                                            </td>
                                            @php
                                                $cust = \App\Models\Admin::where('type', 'customer')
                                                    ->where('id', $po->customer_id)
                                                    ->first();
                                                $detail = App\Models\PurchaseOrderDetail::where(
                                                    'id_po',
                                                    $po->id,
                                                )->get();
                                            @endphp
                                            <td>
                                                @php
                                                    $gabungTitle = '';
                                                    $detailCount = count($detail);
                                                    foreach ($detail as $key => $dt) {
                                                        $serv = \App\Models\Services::where(
                                                            'id',
                                                            $dt->id_item,
                                                        )->first();
                                                        $gabungTitle .= $serv->service;
                                                        if ($key < $detailCount - 1) {
                                                            $gabungTitle .= ',';
                                                        }
                                                    }
                                                @endphp
                                                {{ $gabungTitle }}
                                            </td>

                                            <td>@currency($po->grand_total)</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($po->deadline)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>{{ $po->name_user }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($po->date)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>
                                                @if ($po->status == 1)
                                                    <span class="badge bg-label-warning">Waiting</span>
                                                @elseif ($po->status == 2)
                                                    <span class="badge bg-label-success">Approve</span>
                                                @elseif ($po->status == 3)
                                                    <span class="badge bg-label-danger">Cancel</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline-block text-nowrap">
                                                    <button class="btn btn-sm btn-icon" data-bs-toggle="modal"
                                                    data-bs-target="#history-{{ $po->id }}">
                                                        <i class='bx bx-history'></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade modal-history" id="history-{{ $po->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">History {{ $po->no_po }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
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
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php
                                                                                    $dataInvoice = \App\Models\Invoice::whereIn('id_po',[$po->id])->get();
                                                                                @endphp
                                                                                @foreach ($dataInvoice as $inv)
                                                                                    @php
                                                                                        // $po = \App\Models\PurchaseOrder::where('id', $inv->id_po)->first();
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
                                                                                    </tr>
                                                                                @endforeach
                                                                                <!-- Data rows will go here -->
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (Auth::guard('admin')->user()->can('purchase.order.edit'))
                                                        <button class="btn btn-sm btn-icon editButton" data-bs-toggle="modal"
                                                            data-bs-target="#modalEdit{{ $po->id }}" href="#"
                                                            onclick="onChangeEdit('{{ $po->id }}','{{ $po->id_quo }}')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>

                                                        <div class="modal fade" id="modalEdit{{ $po->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Update
                                                                            {{ $page_title }} - {{ $po->no_po }}</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('purchase-order.update', $po->id) }}"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-row">
                                                                                        <div class="form-group mb-2">
                                                                                            <label for="no_po">NO
                                                                                                PURCHASE
                                                                                                ORDER</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                id="no_po"
                                                                                                name="no_po"
                                                                                                placeholder=""
                                                                                                value="{{ $po->no_po }}">
                                                                                        </div>
                                                                                        <div class="form-group mb-2">
                                                                                            <label
                                                                                                for="name">Quotation</label>
                                                                                            <select name="id_quo"
                                                                                                class="form-control id_quo-{{ $po->id }}"
                                                                                                id="">
                                                                                                <option value="">--
                                                                                                    Choose Quotation --
                                                                                                </option>
                                                                                                @foreach ($quotation as $quo)
                                                                                                    @php
                                                                                                        if ($quo->type != 'New') {
                                                                                                            $tambahNo = '-' . $quo->type;
                                                                                                        } else {
                                                                                                            $tambahNo = '';
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option
                                                                                                        value="{{ $quo->id }}"
                                                                                                        {{ $po->id_quo == $quo->id ? 'selected' : '' }}>
                                                                                                        {{ $quo->no_quo.$tambahNo }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group mb-2">
                                                                                            <label
                                                                                                for="name">Customer</label>
                                                                                            <select name="customer_id"
                                                                                                class="form-control"
                                                                                                id="customer_id-{{ $po->id }}">
                                                                                                <option value="">--
                                                                                                    Choose Customer --
                                                                                                </option>
                                                                                                @foreach ($customer as $cus2)
                                                                                                    <option
                                                                                                        value="{{ $cus2->id }}"
                                                                                                        {{ $cus2->id == $po->customer_id ? 'selected' : '' }}>
                                                                                                        {{ $cus2->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-11">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        class="form-label"
                                                                                                        for="state">Marketing
                                                                                                        HO</label>
                                                                                                    <select
                                                                                                        name="marketing_ho"
                                                                                                        class="stateselect form-control"
                                                                                                        id=""
                                                                                                        disabled>
                                                                                                        <option
                                                                                                            value="">
                                                                                                            Choose State
                                                                                                        </option>
                                                                                                        @foreach ($teamCust as $t)
                                                                                                            <option
                                                                                                                value="{{ $t->id }}">
                                                                                                                {{ $t->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label
                                                                                                    for=""></label>
                                                                                                <input disabled
                                                                                                    type="checkbox"
                                                                                                    name="pin_marketing"
                                                                                                    value="marketing_ho"
                                                                                                    class="required-checkbox"
                                                                                                    style="margin-top: 37px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-11">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        class="form-label"
                                                                                                        for="state">Marketing
                                                                                                        Branch</label>
                                                                                                    <select
                                                                                                        name="marketing_branch"
                                                                                                        class="stateselect form-control"
                                                                                                        id=""
                                                                                                        disabled>
                                                                                                        <option
                                                                                                            value="">
                                                                                                            Choose Team
                                                                                                        </option>
                                                                                                        @foreach ($teamCust as $t)
                                                                                                            <option
                                                                                                                value="{{ $t->id }}">
                                                                                                                {{ $t->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label
                                                                                                    for=""></label>
                                                                                                <input type="checkbox"
                                                                                                    name="pin_marketing"
                                                                                                    value="marketing_branch"
                                                                                                    class="required-checkbox"
                                                                                                    style="margin-top: 37px;"
                                                                                                    disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-11">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        class="form-label"
                                                                                                        for="state">Marketing
                                                                                                        PIC
                                                                                                        Branch</label>
                                                                                                    <select
                                                                                                        name="marketing_pic_branch"
                                                                                                        class="stateselect form-control"
                                                                                                        id=""
                                                                                                        disabled>
                                                                                                        <option
                                                                                                            value="">
                                                                                                            Choose Team
                                                                                                        </option>
                                                                                                        @foreach ($teamCust as $t)
                                                                                                            <option
                                                                                                                value="{{ $t->id }}">
                                                                                                                {{ $t->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label
                                                                                                    for=""></label>
                                                                                                <input type="checkbox"
                                                                                                    name="pin_marketing"
                                                                                                    value="marketing_pic_branch"
                                                                                                    class="required-checkbox"
                                                                                                    disabled
                                                                                                    style="margin-top: 37px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-11">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        class="form-label"
                                                                                                        for="state">Marketing
                                                                                                        Perwakilan</label>
                                                                                                    <select
                                                                                                        name="marketing_perwakilan"
                                                                                                        class="stateselect form-control"
                                                                                                        id=""
                                                                                                        disabled>
                                                                                                        <option
                                                                                                            value="">
                                                                                                            Choose Team
                                                                                                        </option>
                                                                                                        @foreach ($teamCust as $t)
                                                                                                            <option
                                                                                                                value="{{ $t->id }}">
                                                                                                                {{ $t->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label
                                                                                                    for=""></label>
                                                                                                <input type="checkbox"
                                                                                                    name="pin_marketing"
                                                                                                    value="marketing_perwakilan"
                                                                                                    class="required-checkbox"
                                                                                                    disabled
                                                                                                    style="margin-top: 37px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group mb-3">
                                                                                            <label class="form-label"
                                                                                                for="state">Marketer</label>
                                                                                            <select name="marketer"
                                                                                                class="stateselect form-control"
                                                                                                id="" disabled>
                                                                                                <option value="">
                                                                                                    Choose
                                                                                                    Team</option>
                                                                                                @foreach ($teamCust as $t)
                                                                                                    <option
                                                                                                        value="{{ $t->id }}">
                                                                                                        {{ $t->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">Created
                                                                                            Date</label>
                                                                                        <input type="date"
                                                                                            class="form-control"
                                                                                            id="date"
                                                                                            value="{{ $po->date }}"
                                                                                            name="date" placeholder=""
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label
                                                                                            for="name">Deadline</label>
                                                                                        <input type="date"
                                                                                            class="form-control"
                                                                                            id="date"
                                                                                            value="{{ $po->deadline }}"
                                                                                            name="deadline" placeholder=""
                                                                                            value="" required>
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label
                                                                                            for="name">Lampiran</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="lampiran" name="lampiran"
                                                                                            placeholder=""
                                                                                            value="{{ $quo->lampiran }}">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="lampiran">File PO Masuk
                                                                                            (PDF
                                                                                            only)
                                                                                        </label>
                                                                                        <div class="input-group">
                                                                                            {{-- <input type="text" value="{{ asset('documents/quo/'.$po->lampiran) }}"> --}}
                                                                                            <input type="file"
                                                                                                class="form-control"
                                                                                                id="file_po-{{ $po->id }}"
                                                                                                name="file_po"
                                                                                                accept=".pdf">
                                                                                            @php
                                                                                                // Path ke file PDF di direktori public
                                                                                                $pathToFile =
                                                                                                    public_path(
                                                                                                        'documents/po/',
                                                                                                    ) . $po->file_po;

                                                                                                // Cek apakah file ada
                                                                                                if (
                                                                                                    file_exists(
                                                                                                        $pathToFile,
                                                                                                    )
                                                                                                ) {
                                                                                                    // Baca file dan konversi ke base64
                                                                                                    $base64 = base64_encode(
                                                                                                        file_get_contents(
                                                                                                            $pathToFile,
                                                                                                        ),
                                                                                                    );
                                                                                                    // Format base64 untuk ditampilkan di iframe
                                                                                                    $base64PDF =
                                                                                                        'data:application/pdf;base64,' .
                                                                                                        $base64;
                                                                                                } else {
                                                                                                    // File tidak ditemukan, beri pesan kesalahan atau fallback
                                                                                                    $base64PDF = null;
                                                                                                }
                                                                                            @endphp


                                                                                            <button type="button"
                                                                                                class="btn btn-primary"
                                                                                                id="previewButton"
                                                                                                onclick="showLampiranEdit('{{ $base64PDF }}','{{ $po->id }}')">
                                                                                                Preview
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">Notes</label>
                                                                                        <textarea name="catatan" class="form-control" id="" cols="10" rows="5">{{ $po->catatan }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <p class="float-right mb-2">
                                                                                    <button type="button"
                                                                                        class="btn btn-primary editButton addItemButton-{{ $po->id }}"
                                                                                        {{-- onclick="addItemEdit('{{ $po->id }}')" --}}
                                                                                        data-item-id="{{ $po->id }}"
                                                                                        style="float: right"><i
                                                                                            class="fa fa-plus"></i></button>
                                                                                </p>
                                                                                <div class="table-responsive text-nowrap">
                                                                                    <table
                                                                                        class="table table-item-{{ $po->id }}">
                                                                                        <thead>
                                                                                            <tr class="text-nowrap"
                                                                                                style="background: #38b6ff;">
                                                                                                <th style="color: white">
                                                                                                    ITEM
                                                                                                </th>
                                                                                                <th style="color: white">
                                                                                                    QTY
                                                                                                </th>
                                                                                                <th style="color: white">
                                                                                                    PRICE
                                                                                                </th>
                                                                                                <th style="color: white">
                                                                                                    TOTAL
                                                                                                    PRICE</th>
                                                                                                <th style="color: white">
                                                                                                    ACTION
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($detail as $qd)
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <select
                                                                                                            name="services[]"
                                                                                                            class="form-control service-select">
                                                                                                            <option
                                                                                                                value="">
                                                                                                                -- Choose
                                                                                                                Service --
                                                                                                            </option>
                                                                                                            @foreach ($services as $service)
                                                                                                                <option
                                                                                                                    value="{{ $service->id }}"
                                                                                                                    {{ $qd->id_item == $service->id ? 'selected' : '' }}
                                                                                                                    data-price="{{ $service->price }}">
                                                                                                                    {{ $service->service }}
                                                                                                                </option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            name="qty[]"
                                                                                                            value="{{ $qd->qty }}"
                                                                                                            class="form-control item-qty"
                                                                                                            min="1">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            name="prices[]"
                                                                                                            value="{{ number_format($qd->price, 0, ',', '.') }}"
                                                                                                            class="form-control item-price">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            name="total_prices[]"
                                                                                                            value="{{ number_format($qd->total_prices, 0, ',', '.') }}"
                                                                                                            class="form-control item-total-price">
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn btn-danger remove-item-button"><i
                                                                                                                class="bx bx-trash"></i></button>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                            <!-- Item rows will be appended here -->
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="total">Total
                                                                                            (Rp)
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="total-{{ $po->id }}"
                                                                                            value="{{ $po->total }}"
                                                                                            name="total" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="total">PPN
                                                                                            (%)</label>
                                                                                        <input type="number"
                                                                                            class="form-control"
                                                                                            id="ppn-{{ $po->id }}"
                                                                                            name="ppn"
                                                                                            value="{{ $po->ppn }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="total">Total PPN
                                                                                            (Rp)</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="total_ppn-{{ $po->id }}"
                                                                                            name="total_ppn"
                                                                                            value="{{ $po->total_ppn }}"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="total">PPH
                                                                                            (%)</label>
                                                                                        <input type="text"
                                                                                            class="form-control pph-input"
                                                                                            id="pph-{{ $po->id }}"
                                                                                            name="pph"
                                                                                            value="{{ $po->pph }}"
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="total">Total PPH
                                                                                            (Rp)</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="total_pph-{{ $po->id }}"
                                                                                            name="total_pph"
                                                                                            value="{{ $po->total_pph }}"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="total">GRAND TOTAL
                                                                                            (Rp)</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="grand_total-{{ $po->id }}"
                                                                                            name="grand_total" readonly
                                                                                            value="{{ $po->grand_total }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-4">
                                                                                <label class="form-label"
                                                                                    for="status-{{ $po->id }}"
                                                                                    required>Status</label>
                                                                                <select id="status-{{ $po->id }}"
                                                                                    name="status" class="form-select"
                                                                                    onchange="toggleCatatan({{ $po->id }})">
                                                                                    <option value="1"
                                                                                        {{ $po->status == 1 ? 'selected' : '' }}>
                                                                                        Waiting</option>
                                                                                    <option value="2"
                                                                                        {{ $po->status == 2 ? 'selected' : '' }}>
                                                                                        Approve</option>
                                                                                    <option value="3"
                                                                                        {{ $po->status == 3 ? 'selected' : '' }}>
                                                                                        Cancel</option>
                                                                                </select>
                                                                            </div>

                                                                            <div id="catatan-container-{{ $po->id }}"
                                                                                class="mb-4"
                                                                                style="display: {{ $po->status == 3 ? 'block' : 'none' }}">
                                                                                <label class="form-label"
                                                                                    for="catatan-{{ $po->id }}">Notes
                                                                                    Cancel</label>
                                                                                <textarea id="catatan-{{ $po->id }}" name="catatan_cancel" class="form-control">{{ $po->catatan_cancel }}</textarea>
                                                                            </div>
                                                                            <button type="submit"
                                                                                class="btn btn-primary mt-4 pr-4 pl-4"
                                                                                style="float: right">Save</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if (Auth::guard('admin')->user()->can('purchase.order.delete'))
                                                        <button class="btn btn-sm btn-icon"
                                                            onclick="confirmDelete('{{ route('purchase-order.destroy', $po->id) }}')">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
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


    <!-- Template for new item row -->
    <script type="text/template" id="itemRowTemplate">
    <tr class="item-row">
        <td>
            <select name="services[]" class="select2 form-control service-select">
                <option value="">-- Choose Service --</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->service }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="qty[]" class="form-control item-qty" value="1" min="1"></td>
        <td><input type="text" name="prices[]" class="form-control item-price"></td>
        <td><input type="text" name="total_prices[]" class="form-control item-total-price"></td>
        <td>
            <button type="button" class="btn btn-danger remove-item-button"><i class="bx bx-trash"></i></button>
        </td>
    </tr>
</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>

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
        function loadSwal() {
            let timerInterval;
            Swal.fire({
                title: "",
                html: "",
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        // timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                // if (result.dismiss === Swal.DismissReason.timer) {
                //     console.log("I was closed by the timer");
                // }
            });
        }
        
        $(document).ready(function() {
            const id_quo = $('.id_quo');
            const customerSelect = $('#customer_id');
            const addItemButton = $('.addItemButton');
            const itemTable = $('.table-item tbody');
            const totalInput = $('input[name="total"]');
            const totalPpnInput = $('input[name="total_ppn"]');
            const grandTotalInput = $('input[name="grand_total"]');
            const ppnInput = $('input[name="ppn"]');
            const pphInput = $('input[name="pph"]'); // Update this line
            const totalPphInput = $('input[name="total_pph"]'); // Update this line
            const marketingHoSelect = $('select[name="marketing_ho"]');
            const marketingBranchSelect = $('select[name="marketing_branch"]');
            const marketingPicBranchSelect = $('select[name="marketing_pic_branch"]');
            const marketingPerwakilanSelect = $('select[name="marketing_perwakilan"]');
            const marketerSelect = $('select[name="marketer"]');
            const marketingHoCheckbox = $('input[name="pin_marketing"][value="marketing_ho"]');
            const marketingBranchCheckbox = $('input[name="pin_marketing"][value="marketing_branch"]');
            const marketingPicBranchCheckbox = $('input[name="pin_marketing"][value="marketing_pic_branch"]');
            const marketingPerwakilanCheckbox = $('input[name="pin_marketing"][value="marketing_perwakilan"]');

            id_quo.on('change', function() {
                const selectedQuoID = $(this).val();
                if (selectedQuoID) {
                    $.ajax({
                        url: '{{ route('getQuotation') }}',
                        type: 'GET',
                        data: {
                            quo_id: selectedQuoID,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            const quotation = response.quotation;
                            const quotationDetail = response.quotationDetail;

                            // Set customer
                            customerSelect.val(quotation.customer_id);

                            if (quotation.customer_id) {
                                $.ajax({
                                    url: '{{ route('getCustomerDetails') }}',
                                    type: 'POST',
                                    data: {
                                        customer_id: quotation.customer_id,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(customer) {
                                        // Set Select2 values
                                        marketingHoSelect.val(customer
                                            .marketing_ho || '').trigger(
                                            'change');
                                        marketingBranchSelect.val(customer
                                            .marketing_branch || '').trigger(
                                            'change');
                                        marketingPicBranchSelect.val(customer
                                                .marketing_pic_branch || '')
                                            .trigger('change');
                                        marketingPerwakilanSelect.val(customer
                                                .marketing_perwakilan || '')
                                            .trigger('change');
                                        marketerSelect.val(customer.marketer || '')
                                            .trigger('change');

                                        // Set checkboxes
                                        marketingHoCheckbox.prop('checked', customer
                                            .pin_marketing === 'marketing_ho');
                                        marketingBranchCheckbox.prop('checked',
                                            customer.pin_marketing ===
                                            'marketing_branch');
                                        marketingPicBranchCheckbox.prop('checked',
                                            customer.pin_marketing ===
                                            'marketing_pic_branch');
                                        marketingPerwakilanCheckbox.prop('checked',
                                            customer.pin_marketing ===
                                            'marketing_perwakilan');
                                    }
                                });
                            } else {
                                // Clear Select2 values
                                marketingHoSelect.val('').trigger('change');
                                marketingBranchSelect.val('').trigger('change');
                                marketingPicBranchSelect.val('').trigger('change');
                                marketingPerwakilanSelect.val('').trigger('change');
                                marketerSelect.val('').trigger('change');

                                // Uncheck all checkboxes
                                marketingHoCheckbox.prop('checked', false);
                                marketingBranchCheckbox.prop('checked', false);
                                marketingPicBranchCheckbox.prop('checked', false);
                                marketingPerwakilanCheckbox.prop('checked', false);
                            }

                            // Clear current items in table
                            itemTable.empty();

                            // Add items from quotation detail
                            quotationDetail.forEach(detail => {
                                const newRow = $($('#itemRowTemplate').html());
                                newRow.find('.service-select').val(detail.id_item);
                                newRow.find('.item-price').val(numberFormat(detail.price));
                                newRow.find('.item-qty').val(detail.qty);
                                newRow.find('.item-total-price').val(numberFormat(detail
                                    .total_prices));
                                itemTable.append(newRow);

                                newRow.find('.service-select').on('change', function() {
                                    const selectedService = $(this).find(
                                        ':selected');
                                    const price = selectedService.data(
                                        'price') || 0;
                                    $(this).closest('tr').find('.item-price')
                                        .val(price);
                                    calculateItemTotal(newRow);
                                    calculateTotal();
                                });

                                newRow.find('.item-qty, .item-price').on('keyup',
                                    function() {
                                        calculateItemTotal(newRow);
                                        calculateTotal();
                                    });

                                newRow.find('.remove-item-button').on('click',
                                    function() {
                                        $(this).closest('tr').remove();
                                        calculateTotal();
                                    });
                            });

                            calculateTotal();
                        }
                    });
                } else {
                    // Clear customer and items if no quotation selected
                    customerSelect.val('');
                    itemTable.empty();
                    calculateTotal();
                }
            });

            addItemButton.on('click', function() {
                const newRow = $($('#itemRowTemplate').html());
                itemTable.append(newRow);

                newRow.find('.service-select').on('change', function() {
                    const selectedService = $(this).find(':selected');
                    const price = selectedService.data('price') || 0;
                    $(this).closest('tr').find('.item-price').val(price);
                    calculateItemTotal(newRow);
                    calculateTotal();
                });

                newRow.find('.item-qty, .item-price').on('keyup', function() {
                    calculateItemTotal(newRow);
                    calculateTotal();
                });

                newRow.find('.remove-item-button').on('click', function() {
                    $(this).closest('tr').remove();
                    calculateTotal();
                });

                calculateTotal();
            });

         

            function calculateItemTotal(row) {
                const qty = parseInt(row.find('.item-qty').val()) || 0;
                const price = parseNumber(row.find('.item-price').val()) || 0;
                const total = qty * price;
                row.find('.item-price').val(numberFormat(price));
                row.find('.item-total-price').val(numberFormat(total));
            }

            function calculateTotal() {
                let total = 0;
                itemTable.find('.item-total-price').each(function() {
                    total += parseNumber($(this).val());
                });
                const ppn = parseFloat(parseNumber(ppnInput.val())) || 0;
                const pph = parseNumberPPH(pphInput.val()) || 0; // Update parsing
                const totalPpn = total * (ppn / 100);
                const totalPph = total * (pph / 100);
                const grandTotal = total + totalPpn - totalPph; // Adjusted for PPH
                totalPpnInput.val(numberFormat(totalPpn));
                totalPphInput.val(numberFormat(totalPph)); // Display total PPH
                console.log(total);
                
                totalInput.val(numberFormat(total));
                grandTotalInput.val(numberFormat(grandTotal));
            }

            function parseNumber(numberString) {
                return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
            }

            function parseNumberPPH(numberString) {
                return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
            }

            function numberFormat(number) {
                return new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                }).format(number);
            }

            // Auto format number inputs
            $('.item-price, input[name="ppn"]').on('keyup', function() {
                $(this).val(numberFormat(parseNumber($(this).val())));
            });

            // Trigger calculation when ppn or pph input changes
            ppnInput.on('keyup', function() {
                calculateTotal();
            });

            pphInput.on('keyup', function() {
                calculateTotal();
            });
        });
    </script>

    <script>

        function toggleCatatan(quoId) {
            var statusSelect = document.getElementById('status-' + quoId);
            var catatanContainer = document.getElementById('catatan-container-' + quoId);
            var catatanTextarea = document.getElementById('catatan-' + quoId);

            if (statusSelect.value == '3') {
                catatanContainer.style.display = 'block';
                catatanTextarea.required = true;
            } else {
                catatanContainer.style.display = 'none';
                catatanTextarea.required = false;
            }
        }

        // Check the status on page load for each quote
        document.addEventListener('DOMContentLoaded', function() {
            var statusSelects = document.querySelectorAll('.form-select');
            statusSelects.forEach(function(select) {
                var quoId = select.id.split('-')[1];
                toggleCatatan(quoId);
            });
        });

        function onChangeCustomer(id_quo){
            const marketingHoSelect = $('select[name="marketing_ho"]');
            const marketingBranchSelect = $('select[name="marketing_branch"]');
            const marketingPicBranchSelect = $('select[name="marketing_pic_branch"]');
            const marketingPerwakilanSelect = $('select[name="marketing_perwakilan"]');
            const marketerSelect = $('select[name="marketer"]');
            const marketingHoCheckbox = $('input[name="pin_marketing"][value="marketing_ho"]');
            const marketingBranchCheckbox = $('input[name="pin_marketing"][value="marketing_branch"]');
            const marketingPicBranchCheckbox = $('input[name="pin_marketing"][value="marketing_pic_branch"]');
            const marketingPerwakilanCheckbox = $('input[name="pin_marketing"][value="marketing_perwakilan"]');
            
            const selectedQuoID = id_quo;
            if (selectedQuoID) {
                $.ajax({
                    url: '{{ route('getQuotation') }}',
                    type: 'GET',
                    data: {
                        quo_id: selectedQuoID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        const quotation = response.quotation;
                        
                        if (quotation.customer_id) {
                            $.ajax({
                                url: '{{ route('getCustomerDetails') }}',
                                type: 'POST',
                                data: {
                                    customer_id: quotation.customer_id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(customer) {

                                    console.log('customer',customer);
                                    
                                    // Set Select2 values
                                    marketingHoSelect.val(customer.marketing_ho || '')
                                        .trigger('change');
                                    marketingBranchSelect.val(customer
                                        .marketing_branch || '').trigger('change');
                                    marketingPicBranchSelect.val(customer
                                        .marketing_pic_branch || '').trigger(
                                        'change');
                                    marketingPerwakilanSelect.val(customer
                                        .marketing_perwakilan || '').trigger(
                                        'change');
                                    marketerSelect.val(customer.marketer || '').trigger(
                                        'change');

                                    // Set checkboxes
                                    marketingHoCheckbox.prop('checked', customer
                                        .pin_marketing === 'marketing_ho');
                                    marketingBranchCheckbox.prop('checked', customer
                                        .pin_marketing === 'marketing_branch');
                                    marketingPicBranchCheckbox.prop('checked', customer
                                        .pin_marketing === 'marketing_pic_branch');
                                    marketingPerwakilanCheckbox.prop('checked', customer
                                        .pin_marketing === 'marketing_perwakilan');
                                }
                            });
                        } else {
                            // Clear Select2 values and checkboxes
                            marketingHoSelect.val('').trigger('change');
                            marketingBranchSelect.val('').trigger('change');
                            marketingPicBranchSelect.val('').trigger('change');
                            marketingPerwakilanSelect.val('').trigger('change');
                            marketerSelect.val('').trigger('change');
                            marketingHoCheckbox.prop('checked', false);
                            marketingBranchCheckbox.prop('checked', false);
                            marketingPicBranchCheckbox.prop('checked', false);
                            marketingPerwakilanCheckbox.prop('checked', false);
                        }
                    }
                });
            } else {
            }
        }
        
        function numberFormatEdit(number) {
                return new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            }

        function onChangeEdit(id_po,id_quo) {
            const modalSelector = '#modalEdit' + id_po;
            const itemTableEdit = $(modalSelector + ' .table-item-' + id_po + ' tbody');
            const inputTotal = $(modalSelector + ' #total-' + id_po);
            const totalPpnInputEdit = $(modalSelector + ' #total_ppn-' + id_po);
            const grandTotalInputEdit = $(modalSelector + ' #grand_total-' + id_po);
            const ppnInputEdit = $(modalSelector + ' #ppn-' + id_po);
            const pphInputEdit = $(modalSelector + ' #pph-' + id_po);
            const totalPphInput = $(modalSelector + ' #total_pph-' + id_po);
            const customerSelectEdit = $(modalSelector + ' #customer_id-' + id_po);

            const marketingHoSelect = $('select[name="marketing_ho"]');
            const marketingBranchSelect = $('select[name="marketing_branch"]');
            const marketingPicBranchSelect = $('select[name="marketing_pic_branch"]');
            const marketingPerwakilanSelect = $('select[name="marketing_perwakilan"]');
            const marketerSelect = $('select[name="marketer"]');
            const marketingHoCheckbox = $('input[name="pin_marketing"][value="marketing_ho"]');
            const marketingBranchCheckbox = $('input[name="pin_marketing"][value="marketing_branch"]');
            const marketingPicBranchCheckbox = $('input[name="pin_marketing"][value="marketing_pic_branch"]');
            const marketingPerwakilanCheckbox = $('input[name="pin_marketing"][value="marketing_perwakilan"]');

            function parseNumberPPHEdit(numberString) {
                return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
            }

            onChangeCustomer(id_quo);

            function calculateTotalEdit() {
                let total = 0;
                itemTableEdit.find('.item-total-price').each(function() {
                    total += parseNumberEdit($(this).val());
                });

                const ppn = parseFloat(ppnInputEdit.val()) || 0;
                const pph = parseNumberPPHEdit(pphInputEdit.val()) || 0; // Fixed parsing

                const totalPpn = total * (ppn / 100);
                const totalPph = total * (pph / 100);
                const grandTotal = total + totalPpn - totalPph; // Adjust for PPH deduction

                totalPpnInputEdit.val(numberFormatEdit(totalPpn));
                totalPphInput.val(numberFormatEdit(totalPph)); // Display total PPH
                inputTotal.val(numberFormatEdit(total));
                grandTotalInputEdit.val(numberFormatEdit(grandTotal));
            }

            function parseNumberEdit(numberString) {
                return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
            }

            

            // Event listener for the quotation selection
            $(modalSelector + ' .id_quo-' + id_po).on('change', function() {
                const selectedQuoID = $(this).val();
                if (selectedQuoID) {
                    $.ajax({
                        url: '{{ route('getQuotation') }}',
                        type: 'GET',
                        data: {
                            quo_id: selectedQuoID,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            const quotation = response.quotation;
                            const quotationDetail = response.quotationDetail;

                            customerSelectEdit.val(quotation.customer_id);
                            console.log(quotation.customer_id);
                            
                            if (quotation.customer_id) {
                                $.ajax({
                                    url: '{{ route('getCustomerDetails') }}',
                                    type: 'POST',
                                    data: {
                                        customer_id: quotation.customer_id,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(customer) {
                                        console.log('customer',customer);
                                        
                                        // Set Select2 values
                                        marketingHoSelect.val(customer.marketing_ho || '')
                                            .trigger('change');
                                        marketingBranchSelect.val(customer
                                            .marketing_branch || '').trigger('change');
                                        marketingPicBranchSelect.val(customer
                                            .marketing_pic_branch || '').trigger(
                                            'change');
                                        marketingPerwakilanSelect.val(customer
                                            .marketing_perwakilan || '').trigger(
                                            'change');
                                        marketerSelect.val(customer.marketer || '').trigger(
                                            'change');

                                        // Set checkboxes
                                        marketingHoCheckbox.prop('checked', customer
                                            .pin_marketing === 'marketing_ho');
                                        marketingBranchCheckbox.prop('checked', customer
                                            .pin_marketing === 'marketing_branch');
                                        marketingPicBranchCheckbox.prop('checked', customer
                                            .pin_marketing === 'marketing_pic_branch');
                                        marketingPerwakilanCheckbox.prop('checked', customer
                                            .pin_marketing === 'marketing_perwakilan');
                                    }
                                });
                            } else {
                                // Clear Select2 values and checkboxes
                                marketingHoSelect.val('').trigger('change');
                                marketingBranchSelect.val('').trigger('change');
                                marketingPicBranchSelect.val('').trigger('change');
                                marketingPerwakilanSelect.val('').trigger('change');
                                marketerSelect.val('').trigger('change');
                                marketingHoCheckbox.prop('checked', false);
                                marketingBranchCheckbox.prop('checked', false);
                                marketingPicBranchCheckbox.prop('checked', false);
                                marketingPerwakilanCheckbox.prop('checked', false);
                            }

                            itemTableEdit.empty();
                            quotationDetail.forEach(detail => {
                                const newRow = $($('#itemRowTemplate').html());
                                newRow.find('.service-select').val(detail.id_item);
                                newRow.find('.item-price').val(numberFormatEdit(detail.price));
                                newRow.find('.item-qty').val(detail.qty);
                                newRow.find('.item-total-price').val(numberFormatEdit(detail
                                    .total_prices));
                                itemTableEdit.append(newRow);

                                newRow.find('.service-select').on('change', function() {
                                    const selectedService = $(this).find(':selected');
                                    const price = selectedService.data('price') || 0;
                                    $(this).closest('tr').find('.item-price').val(
                                    price);
                                    calculateItemTotalEdit(newRow);
                                    calculateTotalEdit();
                                });

                                newRow.find('.item-qty, .item-price').on('keyup', function() {
                                    calculateItemTotalEdit(newRow);
                                    calculateTotalEdit();
                                });

                                newRow.find('.remove-item-button').on('click', function() {
                                    $(this).closest('tr').remove();
                                    calculateTotalEdit();
                                });
                            });

                            calculateTotalEdit();
                        }
                    });
                } else {
                    customerSelectEdit.val('');
                    itemTableEdit.empty();
                    calculateTotalEdit();
                }
            });

            
            $('.editButton').on('click', function() {
                var itemId = $(this).data('item-id'); // Get item ID from button data attribute
                addItemEdit(itemId); // Call the function with the item ID
            });

            function addItemEdit(id) {
                const newRow = $($('#itemRowTemplate').html());
                itemTableEdit.append(newRow);

                newRow.find('.service-select').on('change', function() {
                    const selectedService = $(this).find(':selected');
                    const price = selectedService.data('price') || 0;
                    $(this).closest('tr').find('.item-price').val(price);
                    calculateItemTotalEdit(newRow);
                    calculateTotalEdit();
                });

                newRow.find('.item-qty, .item-price').on('keyup', function() {
                    calculateItemTotalEdit(newRow);
                    calculateTotalEdit();
                });

                newRow.find('.remove-item-button').on('click', function() {
                    $(this).closest('tr').remove();
                    calculateTotalEdit();
                });

                calculateTotalEdit();
            }

            function calculateItemTotalEdit(row) {
                const qty = parseInt(row.find('.item-qty').val()) || 0;
                const price = parseNumberEdit(row.find('.item-price').val()) || 0;
                const total = qty * price;
                row.find('.item-price').val(numberFormatEdit(price));
                row.find('.item-total-price').val(numberFormatEdit(total));
            }

            // Event listeners for dynamically added rows
            $(document).on('click', modalSelector + ' .remove-item-button', function() {
                $(this).closest('tr').remove();
                calculateTotalEdit();
            });

            $(document).on('keyup', modalSelector + ' .item-price, ' + modalSelector + ' .item-qty', function() {
                const row = $(this).closest('tr');
                calculateItemTotalEdit(row);
                calculateTotalEdit();
            });

            $(document).on('keyup', modalSelector + ' #ppn-' + id_po, function() {
                calculateTotalEdit();
            });
            $(document).on('keyup', modalSelector + ' #pph-' + id_po, function() {
                calculateTotalEdit();
                console.log('masuk');

            });

            $(modalSelector).on('shown.bs.modal', function() {
                calculateTotalEdit();
            });

            
        }
    </script>


    <script>
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>


@endsection

@section('script')
@endsection
