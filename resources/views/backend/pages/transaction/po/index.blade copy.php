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
        <div class="row mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $customerCount }}</h4>
                                </div>
                                <p class="mb-0">Total Customer</p>
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
                                <span>Purchase Order</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($purchaseOrder) }}</h4>
                                </div>
                                <p class="mb-0">Total Purchase Order </p>
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
                                <span>Item Purchase Order</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $purchaseOrderDetailCount }}</h4>
                                </div>
                                <p class="mb-0">Total Item Purchase Order</p>
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
                                    <h4 class="mb-0 me-2">@currency($purchaseOrderAmount)</h4>
                                </div>
                                <p class="mb-0">Total Amount</p>
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
            {{-- filter  --}}
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Search Filter</h5>
                        <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                            <div class="col-md-4 user_role"><select id="UserRole" class="form-select text-capitalize"
                                    fdprocessedid="e9rxo">
                                    <option value=""> Select Role </option>
                                    <option value="Admin">Admin</option>
                                    <option value="Author">Author</option>
                                    <option value="Editor">Editor</option>
                                    <option value="Maintainer">Maintainer</option>
                                    <option value="Subscriber">Subscriber</option>
                                </select></div>
                            <div class="col-md-4 user_plan"><select id="UserPlan" class="form-select text-capitalize"
                                    fdprocessedid="9qbplq">
                                    <option value=""> Select Plan </option>
                                    <option value="Basic">Basic</option>
                                    <option value="Company">Company</option>
                                    <option value="Enterprise">Enterprise</option>
                                    <option value="Team">Team</option>
                                </select></div>
                            <div class="col-md-4 user_status">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">{{ $page_title }} List</h4>
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('purchase.order.create'))
                                <button class="btn btn-primary text-white mb-3 buttonCreate d-none" style="float: right" data-bs-toggle="modal"
                                    data-bs-target="#modalCreate">
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
                                                                        value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Quotation</label>
                                                                    <select name="id_quo" class="form-control id_quo"
                                                                        id="">
                                                                        <option value="">-- Choose Quotation --
                                                                        </option>
                                                                        @foreach ($quotation as $quo)
                                                                            <option value="{{ $quo->id }}">
                                                                                {{ $quo->no_quo }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label for="name">Customer</label>
                                                                    <select name="customer_id" class="form-control"
                                                                        id="customer_id">
                                                                        <option value="">-- Choose Customer --
                                                                        </option>
                                                                        @foreach ($customer as $cus)
                                                                            <option value="{{ $cus->id }}">
                                                                                {{ $cus->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="name">Date</label>
                                                                <input type="date" class="form-control" id="date"
                                                                    name="date" placeholder="" value="">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="name">Lampiran</label>
                                                                <input type="text" class="form-control" id="lampiran"
                                                                    name="lampiran" placeholder="" value="">
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="lampiran">File PO Masuk (PDF only)</label>
                                                                <div class="input-group">
                                                                    <input type="file" class="form-control"
                                                                        id="file_po" name="file_po" accept=".pdf">
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
                                                                    name="ppn">
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
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-2">
                                                                <label for="total">GRAND TOTAL (Rp)</label>
                                                                <input type="number" class="form-control"
                                                                    id="grand_total" name="grand_total" readonly>
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
                                        <th>NO</th>
                                        <th>NO PO</th>
                                        <th>CUSTOMER</th>
                                        <th>DATE</th>
                                        <th>TOTAL ITEM</th>
                                        <th>TOTAL PRICE</th>
                                        <th>TOTAL PPN (Rp)</th>
                                        <th>GRAND TOTAL (Rp)</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseOrder as $po)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $po->no_po }}</td>
                                            @php
                                                $cust = App\Models\Admin::where('type', 'customer')
                                                    ->where('id', $po->customer_id)
                                                    ->first();
                                                $detail = App\Models\QuotationDetail::where('id_quo', $po->id)->get();
                                            @endphp
                                            <td>{{ $cust->name ?? '-' }}</td>
                                            <td>{{ $po->date }}</td>
                                            <td>{{ count($detail) }}</td>
                                            <td>@currency($po->total)</td>
                                            <td>@currency($po->total_ppn)</td>
                                            <td>@currency($po->grand_total)</td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('purchase.order.update'))
                                                    <a class="text-dark" data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit{{ $po->id }}" href="#"
                                                        onclick="onChangeEdit('{{ $po->id }}')">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    <div class="modal fade" id="modalEdit{{ $po->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Update
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
                                                                                        <label for="no_po">NO PURCHASE
                                                                                            ORDER</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="no_po" name="no_po"
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
                                                                                                <option
                                                                                                    value="{{ $quo->id }}"
                                                                                                    {{ $po->id_quo == $quo->id ? 'selected' : '' }}>
                                                                                                    {{ $quo->no_quo }}
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
                                                                                                Choose Customer --</option>
                                                                                            @foreach ($customer as $cus2)
                                                                                                <option
                                                                                                    value="{{ $cus2->id }}"
                                                                                                    {{ $cus2->id == $po->customer_id ? 'selected' : '' }}>
                                                                                                    {{ $cus2->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group mb-2">
                                                                                    <label for="name">Date</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        id="date"
                                                                                        value="{{ $po->date }}"
                                                                                        name="date" placeholder=""
                                                                                        value="">
                                                                                </div>
                                                                                <div class="form-group mb-2">
                                                                                    <label for="name">Lampiran</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="lampiran" name="lampiran"
                                                                                        placeholder=""
                                                                                        value="{{ $quo->lampiran }}">
                                                                                </div>
                                                                                <div class="form-group mb-2">
                                                                                    <label for="lampiran">File PO Masuk
                                                                                        (PDF
                                                                                        only)</label>
                                                                                    <div class="input-group">
                                                                                        {{-- <input type="text" value="{{ asset('documents/quo/'.$po->lampiran) }}"> --}}
                                                                                        <input type="file"
                                                                                            class="form-control"
                                                                                            id="file_po-{{ $po->id }}"
                                                                                            name="file_po" accept=".pdf">
                                                                                        @php
                                                                                            // Path ke file PDF di direktori public
                                                                                            $pathToFile =
                                                                                                public_path(
                                                                                                    'documents/po/',
                                                                                                ) . $po->file_po;

                                                                                            // Cek apakah file ada
                                                                                            if (
                                                                                                file_exists($pathToFile)
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
                                                                                    class="btn btn-primary addItemButton-{{ $po->id }}"
                                                                                    onclick="addItemEdit('{{ $po->id }}')"
                                                                                    style="float: right"><i
                                                                                        class="fa fa-plus"></i></button>
                                                                            </p>
                                                                            <table
                                                                                class="table table-item-{{ $po->id }}">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>ITEM</th>
                                                                                        <th>PRICE</th>
                                                                                        <th class="no-print">Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($detail as $qd)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <select name="services[]"
                                                                                                    class="form-control service-select">
                                                                                                    <option value="">
                                                                                                        -- Choose Service --
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
                                                                                                    name="prices[]"
                                                                                                    value="{{ $qd->price }}"
                                                                                                    class="form-control item-price">
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
                                                                                    <label for="total">PPN (%)</label>
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
                                                                            <div class="col-lg-12">
                                                                                <div class="form-group mb-2">
                                                                                    <label for="total">GRAND TOTAL
                                                                                        (Rp)</label>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        id="grand_total-{{ $po->id }}"
                                                                                        name="grand_total" readonly
                                                                                        value="{{ $po->grand_total }}">
                                                                                </div>
                                                                            </div>
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
                                                    <a class="text-dark"
                                                        onclick="confirmDelete('{{ route('purchase-order.destroy', $po->id) }}')">
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
    <tr class="item-row">
        <td>
            <select name="services[]" class="form-control service-select">
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
                            console.log();
                            customerSelect.val(quotation.customer_id);

                            // Clear current items in table
                            itemTable.empty();

                            // Add items from quotation detail
                            quotationDetail.forEach(detail => {
                                const newRow = $($('#itemRowTemplate').html());
                                newRow.find('.service-select').val(detail.id_item);
                                newRow.find('.item-price').val(detail.price);
                                itemTable.append(newRow);

                                newRow.find('.service-select').on('change', function() {
                                    const selectedService = $(this).find(
                                        ':selected');
                                    const price = selectedService.data(
                                        'price') || 0;
                                    $(this).closest('tr').find('.item-price')
                                        .val(price);
                                    formatNumberInputs();
                                    calculateTotal();
                                });

                                newRow.find('.item-price').on('keyup', function() {
                                    formatNumberInputs();
                                    calculateTotal();
                                });

                                newRow.find('.remove-item-button').on('click',
                                function() {
                                    $(this).closest('tr').remove();
                                    calculateTotal();
                                });
                            });

                            formatNumberInputs();
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
                    formatNumberInputs();
                    calculateTotal();
                });

                newRow.find('.item-price').on('keyup', function() {
                    formatNumberInputs();
                    calculateTotal();
                });

                newRow.find('.remove-item-button').on('click', function() {
                    $(this).closest('tr').remove();
                    calculateTotal();
                });

                formatNumberInputs();
            });

            function calculateTotal() {
                let total = 0;
                itemTable.find('.item-price').each(function() {
                    total += parseFloat($(this).val().replace(/,/g, '')) || 0;
                });
                const ppn = parseFloat(ppnInput.val()) || 0;
                const totalPpn = total * ppn / 100;
                const grandTotal = total + totalPpn;
                totalPpnInput.val(totalPpn);
                totalInput.val(total);
                grandTotalInput.val(grandTotal);
            }

            function formatNumberInputs() {
                $('.item-price').each(function() {
                    $(this).val($(this).val().replace(/,/g, ''));
                });
            }

            itemTable.on('keyup', '.item-price', function() {
                formatNumberInputs();
                calculateTotal();
            });

            itemTable.on('click', '.remove-item-button', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

            ppnInput.on('keyup', function() {
                calculateTotal();
            });

            formatNumberInputs();
            calculateTotal();
        });
    </script>


    <script>
        let itemTableEdit;
        let inputTotal;
        let totalPpnInputEdit;
        let grandTotalInputEdit;
        let ppnInputEdit;
        let customerSelectEdit;

        function onChangeEdit(id_po) {
            const id_quoEdit = $('.id_quo-' + id_po);
            customerSelectEdit = $('#customer_id-' + id_po);

            totalPpnInputEdit = $('#total_ppn-' + id_po); // Corrected selector
            grandTotalInputEdit = $('#grand_total-' + id_po); // Corrected selector
            ppnInputEdit = $('#ppn-' + id_po); // Corrected selector

            itemTableEdit = $('.table-item-' + id_po + ' tbody');
            inputTotal = $('#total-' + id_po);
            calculateTotalEdit();

            id_quoEdit.on('change', function() {
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
                            customerSelectEdit.val(quotation.customer_id);

                            // Clear current items in table
                            itemTableEdit.empty();

                            // Add items from quotation detail
                            quotationDetail.forEach(detail => {
                                const newRow = $($('#itemRowTemplate').html());
                                newRow.find('.service-select').val(detail.id_item);
                                newRow.find('.item-price').val(detail.price);
                                itemTableEdit.append(newRow);

                                newRow.find('.service-select').on('change', function() {
                                    const selectedService = $(this).find(':selected');
                                    const price = selectedService.data('price') || 0;
                                    $(this).closest('tr').find('.item-price').val(
                                    price);
                                    formatNumberInputs();
                                    calculateTotalEdit();
                                });

                                newRow.find('.item-price').on('keyup', function() {
                                    formatNumberInputs();
                                    calculateTotalEdit();
                                });

                                newRow.find('.remove-item-button').on('click', function() {
                                    $(this).closest('tr').remove();
                                    calculateTotalEdit();
                                });
                            });

                            formatNumberInputs();
                            calculateTotalEdit();
                        }
                    });
                } else {
                    // Clear customer and items if no quotation selected
                    customerSelectEdit.val('');
                    itemTableEdit.empty();
                    calculateTotalEdit();
                }
            });
        }

        function addItemEdit(id) {
            const newRow = $($('#itemRowTemplate').html());
            itemTableEdit.append(newRow);

            newRow.find('.service-select').on('change', function() {
                const selectedService = $(this).find(':selected');
                const price = selectedService.data('price') || 0;
                $(this).closest('tr').find('.item-price').val(price);
                formatNumberInputs();
                calculateTotalEdit();
            });

            newRow.find('.item-price').on('keyup', function() {
                formatNumberInputs();
                calculateTotalEdit();
            });

            newRow.find('.remove-item-button').on('click', function() {
                $(this).closest('tr').remove();
                calculateTotalEdit();
            });

            formatNumberInputs();
        }

        function calculateTotalEdit() {
            let total = 0;
            itemTableEdit.find('.item-price').each(function() {
                total += parseFloat($(this).val().replace(/,/g, '')) || 0;
            });

            const ppn = parseFloat(ppnInputEdit.val()) || 0;
            const totalPpn = total * ppn / 100;
            const grandTotal = total + totalPpn;

            totalPpnInputEdit.val(totalPpn); // Update value with correct formatting
            inputTotal.val(total); // Update value with correct formatting
            grandTotalInputEdit.val(grandTotal); // Update value with correct formatting
        }

        function formatNumberInputs() {
            itemTableEdit.find('.item-price').each(function() {
                $(this).val($(this).val().replace(/,/g, ''));
            });
        }

        // Binding for remove item button
        $(document).on('click', '.remove-item-button', function() {
            $(this).closest('tr').remove();
            calculateTotalEdit();
        });

        // Binding for input item-price
        $(document).on('keyup', '.item-price', function() {
            formatNumberInputs();
            calculateTotalEdit();
        });
    </script>
    <script>
        function showCreateButton(){
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>


@endsection

@section('script')
@endsection
