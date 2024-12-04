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
        }
    </style>

    <div class="main-content-inner">
        <div class="row mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Quotation</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($quotation) }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-file bx-sm"></i>
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
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-user bx-sm"></i>
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
                                <span>Item</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $quotationDetailCount }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-list-ul"></i>
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
                                    <h4 class="mb-0 me-2">@currency($quotationAmount)</h4>
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
                                <div class="col-md-4 user_role">
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
                                <div class="col-md-4 user_plan">
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
                                <div class="col-md-4 user_status">
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
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title float-left">{{ $page_title }} List</h4> --}}
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('quotation.edit'))
                                <button class="btn btn-primary text-white mb-3 buttonCreate d-none" style="float: right"
                                    data-bs-toggle="modal" data-bs-target="#modalCreate">
                                    <i class='bx bx-plus'></i>
                                    Create Quotation
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
                                                <form action="{{ route('quotation.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Customer</label>
                                                                    <select name="customer_id"
                                                                        class="select2 form-control" id="">
                                                                        <option value="">-- Choose Customer --
                                                                        </option>
                                                                        @foreach ($customer as $cus)
                                                                            <option value="{{ $cus->id }}">
                                                                                {{ $cus->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Kode</label>
                                                                    <input disabled type="text" class="form-control"
                                                                        id="kode" name="kode"
                                                                        placeholder="Enter Kode Customer" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">No Telepon</label>
                                                                    <input disabled type="number" class="form-control"
                                                                        id="no_tlp" name="no_tlp"
                                                                        placeholder="Enter No Telepon Customer"
                                                                        value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">FAX</label>
                                                                    <input disabled type="text" class="form-control"
                                                                        id="fax" name="fax"
                                                                        placeholder="Enter FAX Customer" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Email</label>
                                                                    <input disabled type="email" class="form-control"
                                                                        id="email" name="email"
                                                                        placeholder="Enter Email Customer" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Attention Name</label>
                                                                    <input disabled type="text" class="form-control"
                                                                        id="att_name" name="att_name"
                                                                        placeholder="Enter Attention Name Customer"
                                                                        value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">CC</label>
                                                                    <input disabled type="text" class="form-control"
                                                                        id="cc" name="cc"
                                                                        placeholder="Enter CC Customer" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Address</label>
                                                                    <textarea disabled name="address" id="" cols="30" rows="8" class="form-control" required></textarea>
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
                                                                <label for="name">Type Quotation</label>
                                                                <select name="type" class="select2 form-control"
                                                                    id="">
                                                                    <option value="New">New</option>
                                                                    @php
                                                                        $loopRev = range(1, 10);
                                                                    @endphp
                                                                    @foreach ($loopRev as $lpr)
                                                                        <option value="REV {{ $lpr }}">REV
                                                                            {{ $lpr }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="lampiran">Lampiran (PDF only)</label>
                                                                <div class="input-group">
                                                                    <input type="file" class="form-control"
                                                                        id="lampiran" name="lampiran" accept=".pdf">
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="previewButton">
                                                                        Preview
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-11">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="state">Marketing
                                                                            HO</label>
                                                                        <select name="marketing_ho"
                                                                            class="stateselect select2 form-control"
                                                                            id="" disabled>
                                                                            <option value="">Choose State</option>
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
                                                                    <input disabled type="checkbox" name="pin_marketing"
                                                                        value="marketing_ho" class="required-checkbox"
                                                                        style="margin-top: 37px;">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-11">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="state">Marketing
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
                                                                        value="marketing_branch" class="required-checkbox"
                                                                        style="margin-top: 37px;" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-11">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="state">Marketing
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
                                                                        <label class="form-label" for="state">Marketing
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
                                                                <label class="form-label" for="state">Marketer</label>
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
                                                            <div class="form-group mb-2">
                                                                <label for="name">Notes</label>
                                                                <textarea name="catatan" class="form-control" required id=""></textarea>
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
                                                            <label class="form-label"
                                                                for="ecommerce-customer-add-name">Total</label>
                                                            <div class="input-group input-group-lg mb-3">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" name="total" class="form-control"
                                                                    id="total" name="total"
                                                                    placeholder="10.000.000" fdprocessedid="vpa282"
                                                                    required>
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
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotation as $quo)
                                        <tr>
                                            @php
                                                if ($quo->type != 'New') {
                                                    $tambahNo = '-' . $quo->type;
                                                } else {
                                                    $tambahNo = '';
                                                }
                                            @endphp
                                            <td>{{ $quo->no_quo . $tambahNo }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center user-name">
                                                    <div class="avatar-wrapper">
                                                        @php
                                                            $custIndex = \App\Models\Admin::where(
                                                                'id',
                                                                $quo->customer_id,
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
                                                    ->where('id', $quo->customer_id)
                                                    ->first();
                                                $detail = App\Models\QuotationDetail::where('id_quo', $quo->id)->get();
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

                                            <td>{{ count($detail) }}</td>
                                            <td>@currency($quo->total)</td>
                                            <td>{{ $quo->name_user }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($quo->date)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>
                                                @if ($quo->status == 1)
                                                    <span class="badge bg-label-warning">Waiting</span>
                                                @elseif ($quo->status == 2)
                                                    <span class="badge bg-label-success">Approve</span>
                                                @elseif ($quo->status == 3)
                                                    <span class="badge bg-label-danger">Cancel</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('quotation.edit'))
                                                    <a class="text-dark" data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit{{ $quo->id }}"
                                                        href="#"onclick="onChangeCusEdit('{{ $cust->id }}','{{ $quo->id }}')">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    <div class="modal fade" id="modalEdit{{ $quo->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Update
                                                                        {{ $page_title }} - {{ $quo->no_quo . $tambahNo }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('quotation.update', $quo->id) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-row">
                                                                                    <div class="form-group mb-2">
                                                                                        <label
                                                                                            for="name">Customer</label>
                                                                                        <select name="customer_id"
                                                                                            class="form-control"
                                                                                            id="">
                                                                                            <option value="">--
                                                                                                Choose Customer --</option>
                                                                                            @foreach ($customer as $cus2)
                                                                                                <option
                                                                                                    value="{{ $cus2->id }}"
                                                                                                    {{ $cus2->id == $quo->customer_id ? 'selected' : '' }}>
                                                                                                    {{ $cus2->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">Kode</label>
                                                                                        <input disabled type="text"
                                                                                            class="form-control"
                                                                                            id="kode" name="kode"
                                                                                            placeholder="Enter Kode Customer"
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">No
                                                                                            Telepon</label>
                                                                                        <input disabled type="number"
                                                                                            class="form-control"
                                                                                            id="no_tlp" name="no_tlp"
                                                                                            placeholder="Enter No Telepon Customer"
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">FAX</label>
                                                                                        <input disabled type="text"
                                                                                            class="form-control"
                                                                                            id="fax" name="fax"
                                                                                            placeholder="Enter FAX Customer"
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">Email</label>
                                                                                        <input disabled type="email"
                                                                                            class="form-control"
                                                                                            id="email" name="email"
                                                                                            placeholder="Enter Email Customer"
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">Attention
                                                                                            Name</label>
                                                                                        <input disabled type="text"
                                                                                            class="form-control"
                                                                                            id="att_name" name="att_name"
                                                                                            placeholder="Enter Attention Name Customer"
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label for="name">CC</label>
                                                                                        <input disabled type="text"
                                                                                            class="form-control"
                                                                                            id="cc" name="cc"
                                                                                            placeholder="Enter CC Customer"
                                                                                            value="">
                                                                                    </div>
                                                                                    <div class="form-group mb-2">
                                                                                        <label
                                                                                            for="name">Address</label>
                                                                                        <textarea disabled name="address" id="" class="form-control" cols="30" rows="8" required></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group mb-2">
                                                                                    <label for="name">Created
                                                                                        Data</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        id="date"
                                                                                        value="{{ $quo->date }}"
                                                                                        name="date" placeholder=""
                                                                                        value="">
                                                                                </div>
                                                                                <div class="form-group mb-2">
                                                                                    <label for="name">Type Quotation</label>
                                                                                    <select name="type" class="select2 form-control"
                                                                                        id="">
                                                                                        <option value="New" {{ $quo->type == 'New' ? 'selected' : '' }}>New</option>
                                                                                        @php
                                                                                            $loopRev = range(1, 10);
                                                                                        @endphp
                                                                                        @foreach ($loopRev as $lpr)
                                                                                            @php
                                                                                                $txtLoop = 'REV '.$lpr;
                                                                                            @endphp
                                                                                            <option value="{{$txtLoop}}" {{ $quo->type == $txtLoop ? 'selected' : '' }}>REV
                                                                                                {{ $lpr }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group mb-2">
                                                                                    <label for="lampiran">Lampiran (PDF
                                                                                        only)</label>
                                                                                    <div class="input-group">
                                                                                        {{-- <input type="text" value="{{ asset('documents/quo/'.$quo->lampiran) }}"> --}}
                                                                                        <input type="file"
                                                                                            class="form-control"
                                                                                            id="lampiran-{{ $quo->id }}"
                                                                                            name="lampiran"
                                                                                            accept=".pdf">
                                                                                        @php
                                                                                            if (
                                                                                                $quo->lampiran != null
                                                                                            ) {
                                                                                                // Path ke file PDF di direktori public
                                                                                                $pathToFile =
                                                                                                    public_path(
                                                                                                        'documents/quo/',
                                                                                                    ) . $quo->lampiran;

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
                                                                                            } else {
                                                                                                $base64PDF = null;
                                                                                            }
                                                                                        @endphp


                                                                                        <button type="button"
                                                                                            class="btn btn-primary"
                                                                                            id="previewButton"
                                                                                            onclick="showLampiranEdit('{{ $base64PDF }}','{{ $quo->id }}')">
                                                                                            Preview
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-11">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="state">Marketing
                                                                                                HO</label>
                                                                                            <select name="marketing_ho"
                                                                                                class="stateselect select2 form-control"
                                                                                                id="" disabled>
                                                                                                <option value="">Choose State</option>
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
                                                                                        <input disabled type="checkbox" name="pin_marketing"
                                                                                            value="marketing_ho" class="required-checkbox"
                                                                                            style="margin-top: 37px;">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-11">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="state">Marketing
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
                                                                                            value="marketing_branch" class="required-checkbox"
                                                                                            style="margin-top: 37px;" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-11">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label" for="state">Marketing
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
                                                                                            <label class="form-label" for="state">Marketing
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
                                                                                    <label class="form-label" for="state">Marketer</label>
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
                                                                                
                                                                                <div class="form-group mb-2">
                                                                                    <label for="name">Notes</label>
                                                                                    <textarea name="catatan" class="form-control" id="">{{ $quo->catatan }}</textarea>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <p class="float-right mb-2">
                                                                                <button type="button"
                                                                                    class="btn btn-primary addItemButton-{{ $quo->id }}"
                                                                                    onclick="addItemEdit('{{ $quo->id }}')"
                                                                                    style="float: right"><i
                                                                                        class="fa fa-plus"></i></button>
                                                                            </p>

                                                                            <div class="table-responsive text-nowrap">
                                                                                <table
                                                                                    class="table-item-{{ $quo->id }} table table-bordered">
                                                                                    <thead>
                                                                                        <tr class="text-nowrap"
                                                                                            style="background: #38b6ff;">
                                                                                            <th style="color: white">ITEM
                                                                                            </th>
                                                                                            <th style="color: white">QTY
                                                                                            </th>
                                                                                            <th style="color: white">PRICE
                                                                                            </th>
                                                                                            <th style="color: white">TOTAL
                                                                                                PRICE</th>
                                                                                            <th style="color: white">ACTION
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
                                                                                                    <input type="number"
                                                                                                        name="qty[]"
                                                                                                        value="{{ $qd->qty }}"
                                                                                                        class="form-control item-qty"
                                                                                                        min="1">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text"
                                                                                                        name="prices[]"
                                                                                                        value="{{ $qd->price }}"
                                                                                                        class="form-control item-price">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input type="text"
                                                                                                        name="total_prices[]"
                                                                                                        value="{{ $qd->total_prices }}"
                                                                                                        class="form-control item-total-price">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <button type="button"
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
                                                                        <!-- Total -->
                                                                        <div class="row mt-2">
                                                                            <div class="col-lg-12">
                                                                                <label class="form-label"
                                                                                    for="total">Total</label>
                                                                                <div
                                                                                    class="input-group input-group-lg mb-3">
                                                                                    <span
                                                                                        class="input-group-text">Rp</span>
                                                                                    <input type="text" name="total"
                                                                                        class="form-control"
                                                                                        id="total-{{ $quo->id }}"
                                                                                        value="{{ $quo->total }}"
                                                                                        placeholder="10.000.000" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-4">
                                                                            <label class="form-label"
                                                                                for="status-{{ $quo->id }}"
                                                                                required>Status</label>
                                                                            <select id="status-{{ $quo->id }}"
                                                                                name="status" class="form-select"
                                                                                onchange="toggleCatatan({{ $quo->id }})">
                                                                                <option value="1"
                                                                                    {{ $quo->status == 1 ? 'selected' : '' }}>
                                                                                    Waiting</option>
                                                                                <option value="2"
                                                                                    {{ $quo->status == 2 ? 'selected' : '' }}>
                                                                                    Approve</option>
                                                                                <option value="3"
                                                                                    {{ $quo->status == 3 ? 'selected' : '' }}>
                                                                                    Cancel</option>
                                                                            </select>
                                                                        </div>

                                                                        <div id="catatan-container-{{ $quo->id }}"
                                                                            class="mb-4"
                                                                            style="display: {{ $quo->status == 3 ? 'block' : 'none' }}">
                                                                            <label class="form-label"
                                                                                for="catatan-{{ $quo->id }}">Notes
                                                                                Cancel</label>
                                                                            <textarea id="catatan-{{ $quo->id }}" name="catatan_cancel" class="form-control">{{ $quo->catatan_cancel }}</textarea>
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

                                                @if (Auth::guard('admin')->user()->can('quotation.delete'))
                                                    <a class="text-dark"
                                                        onclick="confirmDelete('{{ route('quotation.destroy', $quo->id) }}')">
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


    <!-- Template for new item row -->
    <script type="text/template" id="itemRowTemplate">
       <tr>
        <td>
            <select name="services[]" class="form-control service-select">
                <option value="" data-price="0">-- Choose Service --</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->service }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="qty[]" class="form-control item-qty" value="1" min="1"></td>
        <td><input type="text" name="prices[]" class="form-control item-price"></td>
        <td><input type="text" name="total_prices[]" class="form-control item-total-price"></td>
        <td><button type="button" class="btn btn-danger remove-item-button"><i class="fa fa-trash"></i></button></td>
    </tr>
</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-number/2.1.6/jquery.number.min.js"></script>

    <script>
        // Tombol preview PDF
        $('#previewButton').on('click', function() {
            var file = $('#lampiran').prop('files')[0];
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
            var file = $('#lampiran-' + id).prop('files')[0];

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

        $(document).ready(function() {
            const customerSelect = $('select[name="customer_id"]');
            const kodeInput = $('input[name="kode"]');
            const noTlpInput = $('input[name="no_tlp"]');
            const faxInput = $('input[name="fax"]');
            const emailInput = $('input[name="email"]');
            const attNameInput = $('input[name="att_name"]');
            const ccInput = $('input[name="cc"]');
            const addressTextarea = $('textarea[name="address"]');
            const addItemButton = $('.addItemButton');
            const itemTable = $('.table-item tbody');
            const totalInput = $('input[name="total"]');
            const marketingHoSelect = $('select[name="marketing_ho"]');
            const marketingBranchSelect = $('select[name="marketing_branch"]');
            const marketingPicBranchSelect = $('select[name="marketing_pic_branch"]');
            const marketingPerwakilanSelect = $('select[name="marketing_perwakilan"]');
            const marketerSelect = $('select[name="marketer"]');
            const marketingHoCheckbox = $('input[name="pin_marketing"][value="marketing_ho"]');
            const marketingBranchCheckbox = $('input[name="pin_marketing"][value="marketing_branch"]');
            const marketingPicBranchCheckbox = $('input[name="pin_marketing"][value="marketing_pic_branch"]');
            const marketingPerwakilanCheckbox = $('input[name="pin_marketing"][value="marketing_perwakilan"]');


            customerSelect.on('change', function() {
                const selectedCustomerId = $(this).val();
                if (selectedCustomerId) {
                    $.ajax({
                        url: '{{ route('getCustomerDetails') }}',
                        type: 'POST',
                        data: {
                            customer_id: selectedCustomerId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(customer) {
                            kodeInput.val(customer.kode || '');
                            noTlpInput.val(customer.no_tlp || '');
                            faxInput.val(customer.fax || '');
                            emailInput.val(customer.email || '');
                            attNameInput.val(customer.att_name || '');
                            ccInput.val(customer.cc || '');
                            addressTextarea.val(customer.address || '');

                            // Set Select2 values
                            marketingHoSelect.val(customer.marketing_ho || '').trigger(
                                'change');
                            marketingBranchSelect.val(customer.marketing_branch || '').trigger(
                                'change');
                            marketingPicBranchSelect.val(customer.marketing_pic_branch || '')
                                .trigger('change');
                            marketingPerwakilanSelect.val(customer.marketing_perwakilan || '')
                                .trigger('change');
                            marketerSelect.val(customer.marketer || '').trigger('change');

                            // Set checkboxes
                            marketingHoCheckbox.prop('checked', customer.pin_marketing ===
                                'marketing_ho');
                            marketingBranchCheckbox.prop('checked', customer.pin_marketing ===
                                'marketing_branch');
                            marketingPicBranchCheckbox.prop('checked', customer
                                .pin_marketing === 'marketing_pic_branch');
                            marketingPerwakilanCheckbox.prop('checked', customer
                                .pin_marketing === 'marketing_perwakilan');
                        }
                    });
                } else {
                    kodeInput.val('');
                    noTlpInput.val('');
                    faxInput.val('');
                    emailInput.val('');
                    attNameInput.val('');
                    ccInput.val('');
                    addressTextarea.val('');

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
            });


            function parseNumber(numberString) {
                return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
            }

            addItemButton.on('click', function() {
                const newRow = $($('#itemRowTemplate').html());
                itemTable.append(newRow);

                newRow.find('.service-select').on('change', function() {
                    const selectedService = $(this).find(':selected');
                    const price = selectedService.data('price') || 0;
                    $(this).closest('tr').find('.item-price').val(numberFormat(price));
                    updateTotalPrice($(this).closest('tr'));
                    calculateTotal();
                });

                newRow.find('.item-qty').on('change', function() {
                    updateTotalPrice($(this).closest('tr'));
                    calculateTotal();
                });

                newRow.find('.remove-item-button').on('click', function() {
                    $(this).closest('tr').remove();
                    calculateTotal();
                });

                formatNumberInputs();
            });

            function updateTotalPrice(row) {
                const qty = row.find('.item-qty').val();
                const price = parseNumber(row.find('.item-price').val()) || 0;
                const totalPrice = qty * price;
                row.find('.item-total-price').val(numberFormat(totalPrice));
            }

            function calculateTotal() {
                let total = 0;
                itemTable.find('.item-total-price').each(function() {
                    total += parseNumber($(this).val()) || 0;
                });
                totalInput.val(numberFormat(total));
            }

            function formatNumberInputs() {
                $('.item-price, .item-total-price').each(function() {
                    const value = parseNumber($(this).val());
                    if (!isNaN(value) && value !== '') {
                        $(this).val(numberFormat(value));
                    }
                });
            }

            function numberFormat(number) {
                return new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            }

            itemTable.on('keyup change', '.item-price, .item-qty', function() {
                formatNumberInputs();
                updateTotalPrice($(this).closest('tr'));
                calculateTotal();
            });

            // Initial binding for remove buttons on existing rows
            itemTable.on('click', '.remove-item-button', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

            formatNumberInputs();
            calculateTotal();
        });
    </script>

    <script>
        let itemTableEdit;
        let inputTotal;

        function onChangeCusEdit(id, id_quo) {
            const kodeInput = $('input[name="kode"]');
            const noTlpInput = $('input[name="no_tlp"]');
            const faxInput = $('input[name="fax"]');
            const emailInput = $('input[name="email"]');
            const attNameInput = $('input[name="att_name"]');
            const ccInput = $('input[name="cc"]');
            const addressTextarea = $('textarea[name="address"]');
            const marketingHoSelect = $('select[name="marketing_ho"]');
            const marketingBranchSelect = $('select[name="marketing_branch"]');
            const marketingPicBranchSelect = $('select[name="marketing_pic_branch"]');
            const marketingPerwakilanSelect = $('select[name="marketing_perwakilan"]');
            const marketerSelect = $('select[name="marketer"]');
            const marketingHoCheckbox = $('input[name="pin_marketing"][value="marketing_ho"]');
            const marketingBranchCheckbox = $('input[name="pin_marketing"][value="marketing_branch"]');
            const marketingPicBranchCheckbox = $('input[name="pin_marketing"][value="marketing_pic_branch"]');
            const marketingPerwakilanCheckbox = $('input[name="pin_marketing"][value="marketing_perwakilan"]');

            itemTableEdit = $('.table-item-' + id_quo + ' tbody');
            inputTotal = $('#total-' + id_quo);
            calculateTotalEdit();

            const selectedCustomerId = id;
            if (selectedCustomerId) {
                $.ajax({
                    url: '{{ route('getCustomerDetails') }}',
                    type: 'POST',
                    data: {
                        customer_id: selectedCustomerId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(customer) {
                        kodeInput.val(customer.kode || '');
                        noTlpInput.val(customer.no_tlp || '');
                        faxInput.val(customer.fax || '');
                        emailInput.val(customer.email || '');
                        attNameInput.val(customer.att_name || '');
                        ccInput.val(customer.cc || '');
                        addressTextarea.val(customer.address || '');

                        // Set Select2 values
                        marketingHoSelect.val(customer.marketing_ho || '').trigger(
                            'change');
                        marketingBranchSelect.val(customer.marketing_branch || '').trigger(
                            'change');
                        marketingPicBranchSelect.val(customer.marketing_pic_branch || '')
                            .trigger('change');
                        marketingPerwakilanSelect.val(customer.marketing_perwakilan || '')
                            .trigger('change');
                        marketerSelect.val(customer.marketer || '').trigger('change');

                        // Set checkboxes
                        marketingHoCheckbox.prop('checked', customer.pin_marketing ===
                            'marketing_ho');
                        marketingBranchCheckbox.prop('checked', customer.pin_marketing ===
                            'marketing_branch');
                        marketingPicBranchCheckbox.prop('checked', customer
                            .pin_marketing === 'marketing_pic_branch');
                        marketingPerwakilanCheckbox.prop('checked', customer
                            .pin_marketing === 'marketing_perwakilan');
                    }
                });
            } else {
                kodeInput.val('');
                noTlpInput.val('');
                faxInput.val('');
                emailInput.val('');
                attNameInput.val('');
                ccInput.val('');
                addressTextarea.val('');

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
        }

        function addItemEdit(id) {
            const itemTableEdit = $('.table-item-' + id + ' tbody');

            // Clone and append new row
            const newRow = $('#itemRowTemplate').html();
            itemTableEdit.append(newRow);

            // Initialize new row elements
            const newRowElem = itemTableEdit.find('tr:last');
            newRowElem.find('.service-select').on('change', function() {
                updateItemRow(newRowElem);
            });
            newRowElem.find('.item-qty').on('input', function() {
                updateItemRow(newRowElem);
            });
            newRowElem.find('.item-price').on('input', function() {
                updateItemRow(newRowElem);
            });
            newRowElem.find('.remove-item-button').on('click', function() {
                $(this).closest('tr').remove();
                calculateTotalEdit(id);
            });

            // Format number inputs
            formatNumberInputs();
        }

        function parseNumber(numberString) {
            return parseFloat(numberString.replace(/\./g, '').replace(',', '.')) || 0;
        }

        function updateItemRow(row) {
            const qty = parseInt(row.find('.item-qty').val()) || 0;
            const price = parseNumber(row.find('.item-price').val()) || 0;
            const totalPrice = qty * price;
            row.find('.item-total-price').val(numberFormat(totalPrice));
            calculateTotalEdit();
        }

        function calculateTotalEdit() {
            let total = 0;
            itemTableEdit.find('tr').each(function() {
                const totalPrice = parseNumber($(this).find('.item-total-price').val());
                total += totalPrice;
            });
            inputTotal.val(numberFormat(total));
        }

        function formatNumberInputs() {
            $('.item-price').each(function() {
                $(this).val(numberFormat(parseNumber($(this).val())));
            });
        }

        function numberFormat(number) {
            return parseFloat(number).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Initialize
        $(document).ready(function() {
            // Initial binding for remove buttons on existing rows
            $(document).on('click', '.remove-item-button', function() {
                $(this).closest('tr').remove();
                calculateTotalEdit();
            });

            // Initial binding for input item-price and item-qty
            $(document).on('input', '.item-price, .item-qty', function() {
                formatNumberInputs();
                updateItemRow($(this).closest('tr'));
            });
        });
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
