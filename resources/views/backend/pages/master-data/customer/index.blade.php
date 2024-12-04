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
                                <span>All Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $customers->count() }}</h4>
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
                                <span>New Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $customers_new->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-user-check bx-sm"></i>
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
                                <span>Active Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $customers_active->count() }}</h4>
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
                                <span>Inactive Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $customers_inactive->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-user-voice bx-sm"></i>
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
                        <form action="" id="filter-form" method="get">
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                @csrf
                                <div class="col-md-3 user_role"><select id="stateFilter"
                                        class="stateselect  form-select text-capitalize" name="state"
                                        fdprocessedid="cmvtx" onchange="$('#filter-form').submit()">
                                        <option value=""> Select State </option>
                                        @foreach ($states as $s)
                                            <option value="{{ $s->id }}"
                                                {{ Request::get('state') == $s->id ? 'selected' : '' }}>{{ $s->state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 user_plan">
                                    <select id="cityFilter" class="cityselect form-select cityselect text-capitalize"
                                        onchange="$('#filter-form').submit()" name="city" fdprocessedid="os5o9">
                                        <option value=""> Select City </option>
                                    </select>
                                </div>
                                <div class="col-md-3 user_status">
                                    <select id="statusFilter" name="status"
                                        class="statusFilter form-select text-capitalize" fdprocessedid="osm3b"
                                        onchange="$('#filter-form').submit()">
                                        <option value=""> Select Status </option>
                                        <option value="1" class="text-capitalize"
                                            {{ Request::get('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" class="text-capitalize"
                                            {{ Request::get('status') == 2 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-3 user_plan">
                                    <input type="text" id="bs-rangepicker-dropdown"
                                        class="bs-rangepicker-dropdown form-control" value="{{ Request::get('date') }}"
                                        name="date" />
                                </div>
                            </div>
                        </form>
                    </div>
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
                            @if (Auth::guard('admin')->user()->can('customer.create'))
                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasEcommerceCustomerAddLabel" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasEcommerceCustomerAddLabel" class="offcanvas-title">Add Customer
                                        </h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('customer.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="ecommerce-customer-add-basic mb-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="add-file">Foto</label>
                                                    <input type="file" class="form-control" id="add-file" required
                                                        placeholder="foto" name="file" aria-label="foto">
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-name">Username</label>
                                                    <input type="text" class="form-control" required
                                                        id="ecommerce-customer-add-name" placeholder="John Doe"
                                                        name="username" aria-label="John Doe">
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-name">Name</label>
                                                    <input type="text" class="form-control" required
                                                        id="ecommerce-customer-add-name" placeholder="John Doe"
                                                        name="name" aria-label="John Doe">
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-email">Email</label>
                                                    <input type="text" id="ecommerce-customer-add-email" required
                                                        class="form-control" placeholder="john.doe@example.com"
                                                        aria-label="john.doe@example.com" name="email">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="">Kode</label>
                                                    <input type="text" required class="form-control"
                                                        placeholder="Kode" aria-label="Kode" name="kode">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="">PIC</label>
                                                    <input type="text" required class="form-control"
                                                        placeholder="Amando" aria-label="Amando" name="pic">
                                                </div>

                                                <div>
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-contact">Whatsapp</label>
                                                    <input type="text" id="ecommerce-customer-add-contact" required
                                                        class="form-control phone-mask" placeholder="08111111112"
                                                        aria-label="08111111112" name="no_tlp">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="state">Marketing HO</label>
                                                        <select name="marketing_ho"
                                                            class="stateselect select2 form-control" id=""
                                                            required>
                                                            <option value="">Choose State</option>
                                                            @foreach ($team as $t)
                                                                <option value="{{ $t->id }}">{{ $t->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                    <input type="checkbox" name="pin_marketing" value="marketing_ho"
                                                        class="required-checkbox" style="margin-top: 37px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="state">Marketing Branch</label>
                                                        <select name="marketing_branch"
                                                            class="stateselect select2 form-control" id=""
                                                            required>
                                                            <option value="">Choose Team</option>
                                                            @foreach ($team as $t)
                                                                <option value="{{ $t->id }}">{{ $t->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                    <input type="checkbox" name="pin_marketing" value="marketing_branch"
                                                        class="required-checkbox" style="margin-top: 37px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="state">Marketing PIC
                                                            Branch</label>
                                                        <select name="marketing_pic_branch"
                                                            class="stateselect select2 form-control" id=""
                                                            required>
                                                            <option value="">Choose Team</option>
                                                            @foreach ($team as $t)
                                                                <option value="{{ $t->id }}">{{ $t->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                    <input type="checkbox" name="pin_marketing"
                                                        value="marketing_pic_branch" class="required-checkbox"
                                                        style="margin-top: 37px;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="state">Marketing
                                                            Perwakilan</label>
                                                        <select name="marketing_perwakilan"
                                                            class="stateselect select2 form-control" id=""
                                                            required>
                                                            <option value="">Choose Team</option>
                                                            @foreach ($team as $t)
                                                                <option value="{{ $t->id }}">{{ $t->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for=""></label>
                                                    <input type="checkbox" name="pin_marketing"
                                                        value="marketing_perwakilan" class="required-checkbox"
                                                        style="margin-top: 37px;">
                                                </div>
                                            </div>

                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                <div class="mb-3">
                                                    <label class="form-label" for="state">Marketer</label>
                                                    <select name="marketer"
                                                        class="stateselect select2 form-control" id="">
                                                        <option value="">Choose Team</option>
                                                        @foreach ($team as $t)
                                                            <option value="{{ $t->id }}">{{ $t->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="state">State</label>
                                                    <select name="id_state" class="stateselect select2 form-control"
                                                        id="" required>
                                                        <option value="">Choose State</option>
                                                        @foreach ($states as $s)
                                                            <option value="{{ $s->id }}">{{ $s->state }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="state">City</label>
                                                    <select name="id_city" class="cityselect select2 form-control"
                                                        id="" required>
                                                        <option value="">Choose City</option>

                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-address">Address</label>
                                                    <input type="text" id="ecommerce-customer-add-address" required
                                                        class="form-control" placeholder="45 Roker Terrace"
                                                        aria-label="45 Roker Terrace" name="address">
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label"
                                                            for="ecommerce-customer-add-state">Password</label>
                                                        <input type="password" id="ecommerce-customer-add-state" required
                                                            class="form-control" placeholder="password"
                                                            aria-label="password" name="password">
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label"
                                                            for="ecommerce-customer-add-post-code">Repeat Password</label>
                                                        <input type="password"
                                                            id="ecommerce-customer-add-post-code"required
                                                            class="form-control" placeholder="password"
                                                            aria-label="repeat-password" name="repeat_password"
                                                            pattern="[0-9]{8}" maxlength="8">
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="status" required>Status</label>
                                                    <select id="status" name="status" class="form-select">
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="pt-3">
                                                <button type="submit"
                                                    class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                                                <button type="reset" class="btn bg-label-danger"
                                                    data-bs-dismiss="offcanvas">Discard</button>
                                            </div>
                                            <input type="hidden"><input type="hidden"><input type="hidden"><input
                                                type="hidden"><input type="hidden"><input type="hidden"><input
                                                type="hidden">
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
                                        <th>NO</th>
                                        <th>Kode</th>
                                        <th>Name</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>WhatsApp</th>
                                        <th>PIC</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $customer->kode ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center user-name">
                                                    <div class="avatar-wrapper">
                                                        @php
                                                            $words = explode(' ', $customer->name);
                                                            $initials = '';
                                                            foreach ($words as $word) {
                                                                $initials .= strtoupper($word[0]);
                                                            }
                                                            // return $initials;
                                                        @endphp
                                                        <div class="avatar avatar-sm me-3">
                                                            @if ($customer->foto == null)
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-primary">{{ $initials }}</span>
                                                            @else
                                                                <img src="{{ asset('assets/img/customer/' . $customer->foto) }}"
                                                                    alt="Avatar" class="rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"><a href="#"
                                                            class="text-body text-truncate"><span
                                                                class="fw-medium">{{ $customer->name }}</span></a><small
                                                            class="text-muted">{{ $customer->email }}</small></div>
                                                </div>
                                            </td>
                                            @if ($customer->id_state != null)
                                                @php
                                                    $stateV = \App\Models\State::where(
                                                        'id',
                                                        $customer->id_state,
                                                    )->first();
                                                @endphp
                                                <td>{{ $stateV->state ?? '-' }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($customer->id_city != null)
                                                @php
                                                    $cityV = \App\Models\City::where('id', $customer->id_city)->first();
                                                @endphp
                                                <td>{{ $cityV->city ?? '-' }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ $customer->no_tlp }}</td>
                                            <td>{{ $customer->pic }}</td>
                                            <td>{{ $customer->created_at }}</td>
                                            <td>
                                                @if ($customer->status == 1)
                                                    <span class="badge bg-label-success">Active</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('customer.edit'))
                                                    <a class="text-dark" data-bs-toggle="offcanvas"
                                                        data-bs-target="#edit-{{ $customer->id }}"
                                                        aria-controls="offcanvasEnd">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    <div class="offcanvas offcanvas-end" tabindex="-1"
                                                        id="edit-{{ $customer->id }}"
                                                        aria-labelledby="offcanvasEcommerceCustomerAddLabel"
                                                        aria-modal="true" role="dialog">
                                                        <div class="offcanvas-header">
                                                            <h5 id="offcanvasEcommerceCustomerAddLabel"
                                                                class="offcanvas-title">Edit Customer
                                                            </h5>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                                            <form action="{{ route('customer.update', $customer->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="ecommerce-customer-add-basic mb-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="add-file">Foto</label>
                                                                        <input type="file" class="form-control"
                                                                            id="add-file" placeholder="foto"
                                                                            name="file" aria-label="foto">
                                                                    </div>
                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-name">Username</label>
                                                                        <input type="text" class="form-control"
                                                                            required id="ecommerce-customer-add-name"
                                                                            placeholder="John Doe"
                                                                            value="{{ $customer->username }}"
                                                                            name="username" aria-label="John Doe">
                                                                    </div>
                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-name">Name</label>
                                                                        <input type="text" class="form-control"
                                                                            required id="ecommerce-customer-add-name"
                                                                            placeholder="John Doe"
                                                                            value="{{ $customer->name }}" name="name"
                                                                            aria-label="John Doe">
                                                                    </div>
                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-email">Email</label>
                                                                        <input type="text"
                                                                            id="ecommerce-customer-add-email" required
                                                                            class="form-control"
                                                                            placeholder="john.doe@example.com"
                                                                            aria-label="john.doe@example.com"
                                                                            value="{{ $customer->email }}"
                                                                            name="email">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="">Kode</label>
                                                                        <input type="text" required
                                                                            class="form-control"
                                                                            value="{{ $customer->kode }}"
                                                                            placeholder="Kode" aria-label="Kode"
                                                                            name="kode">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="">PIC</label>
                                                                        <input type="text" required
                                                                            class="form-control" placeholder="Amando"
                                                                            aria-label="Amando"
                                                                            value="{{ $customer->pic }}" name="pic">
                                                                    </div>

                                                                    <div>
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-contact">Whatsapp</label>
                                                                        <input type="text"
                                                                            id="ecommerce-customer-add-contact" required
                                                                            class="form-control phone-mask"
                                                                            placeholder="08111111112"
                                                                            aria-label="08111111112"
                                                                            value="{{ $customer->no_tlp }}"
                                                                            name="no_tlp">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row" style="flex-wrap :nowrap" >
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="state">Marketing HO</label>
                                                                            <select name="marketing_ho"
                                                                                class="stateselect select2 form-control" id=""
                                                                                required>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($team as $t)
                                                                                    <option value="{{ $t->id }}" {{ $customer->marketing_ho == $t->id ? 'selected' : '' }}>{{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing" value="marketing_ho"
                                                                            class="required-checkbox" {{ $customer->pin_marketing == 'marketing_ho' ? 'checked' : '' }} style="margin-top: 37px;">
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="flex-wrap :nowrap" >
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="state">Marketing Branch</label>
                                                                            <select name="marketing_branch"
                                                                                class="stateselect select2 form-control" id=""
                                                                                required>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($team as $t)
                                                                                    <option value="{{ $t->id }}" {{ $customer->marketing_branch == $t->id ? 'selected' : '' }}>{{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing" {{ $customer->pin_marketing == 'marketing_branch' ? 'checked' : '' }} value="marketing_branch"
                                                                            class="required-checkbox" style="margin-top: 37px;">
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="flex-wrap :nowrap" >
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="state">Marketing PIC
                                                                                Branch</label>
                                                                            <select name="marketing_pic_branch"
                                                                                class="stateselect select2 form-control" id=""
                                                                                required>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($team as $t)
                                                                                    <option value="{{ $t->id }}" {{ $customer->marketing_pic_branch == $t->id ? 'selected' : '' }}>{{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing" {{ $customer->pin_marketing == 'marketing_branch' ? 'checked' : '' }}
                                                                            value="marketing_pic_branch" class="required-checkbox"
                                                                            style="margin-top: 37px;">
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="flex-wrap :nowrap" >
                                                                    <div class="col-md-11">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="state">Marketing
                                                                                Perwakilan</label>
                                                                            <select name="marketing_perwakilan" 
                                                                                class="stateselect select2 form-control" id=""
                                                                                required>
                                                                                <option value="">Choose Team</option>
                                                                                @foreach ($team as $t)
                                                                                    <option value="{{ $t->id }}" {{ $customer->marketing_perwakilan == $t->id ? 'selected' : '' }}>{{ $t->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""></label>
                                                                        <input type="checkbox" name="pin_marketing" {{ $customer->pin_marketing == 'marketing_perwakilan' ? 'checked' : '' }}
                                                                            value="marketing_perwakilan" class="required-checkbox"
                                                                            style="margin-top: 37px;">
                                                                    </div>
                                                                </div>

                                                                <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="state">Marketer</label>
                                                                        <select name="marketer"
                                                                            class="stateselect select2 form-control" id="">
                                                                            <option value="">Choose Team</option>
                                                                            @foreach ($team as $t)
                                                                                <option value="{{ $t->id }}" {{ $customer->marketer == $t->id ? 'selected' : '' }}>{{ $t->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="state">State</label>
                                                                        <select name="id_state"
                                                                            class="select2 stateselect form-control"
                                                                            id="" required>
                                                                            <option value="">Choose State</option>
                                                                            @foreach ($states as $s)
                                                                                <option value="{{ $s->id }}"
                                                                                    {{ $customer->id_state == $s->id ? 'selected' : '' }}>
                                                                                    {{ $s->state }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="state">City</label>
                                                                        <select name="id_city"
                                                                            class="select2 cityselect form-control"
                                                                            data-selected-city-id="{{ $customer->id_city }}"
                                                                            id="" required>
                                                                            <option value="">Choose City</option>

                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-address">Address</label>
                                                                        <input type="text"
                                                                            id="ecommerce-customer-add-address" required
                                                                            class="form-control"
                                                                            placeholder="45 Roker Terrace"
                                                                            aria-label="45 Roker Terrace"
                                                                            value="{{ $customer->address }}"
                                                                            name="address">
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-12 col-sm-6">
                                                                            <label class="form-label"
                                                                                for="ecommerce-customer-add-state">Password</label>
                                                                            <input type="password"
                                                                                id="ecommerce-customer-add-state"
                                                                                class="form-control"
                                                                                placeholder="password"
                                                                                aria-label="password" name="password">
                                                                        </div>
                                                                        <div class="col-12 col-sm-6">
                                                                            <label class="form-label"
                                                                                for="ecommerce-customer-add-post-code">Repeat
                                                                                Password</label>
                                                                            <input type="password"
                                                                                id="ecommerce-customer-add-post-code"
                                                                                class="form-control"
                                                                                placeholder="password"
                                                                                aria-label="repeat-password"
                                                                                name="repeat_password" pattern="[0-9]{8}"
                                                                                maxlength="8">
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label" for="status"
                                                                            required>Status</label>
                                                                        <select id="status" name="status"
                                                                            class="form-select">
                                                                            <option value="1"
                                                                                {{ $customer->status == 1 ? 'selected' : '' }}>
                                                                                Active</option>
                                                                            <option value="2"
                                                                                {{ $customer->status == 2 ? 'selected' : '' }}>
                                                                                Inactive</option>
                                                                        </select>
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
                                                                    type="hidden"><input type="hidden"><input
                                                                    type="hidden">
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('customer.delete'))
                                                    <a class="text-dark"
                                                        onclick="confirmDelete('{{ route('customer.destroy', $customer->id) }}')">
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
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.required-checkbox');
            let isChecked = false;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (isChecked) {
                            isChecked.checked = false; // Uncheck the previously checked checkbox
                        }
                        isChecked = this; // Update the reference to the currently checked checkbox
                    } else {
                        if (isChecked === this) {
                            isChecked =
                            false; // Reset if the currently unchecked checkbox was the previously checked one
                        }
                    }
                });
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(event) {
                if (!isChecked) {
                    event.preventDefault();
                    alert('Please check at least one checkbox.');
                }
            });
        });
    </script>

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
        $(document).ready(function() {
            // Function to fetch and populate cities based on stateId
            function fetchCities(stateId, citySelectElement, selectedCityId = null) {
                if (stateId) {
                    $.ajax({
                        url: '{{ route('get-city') }}',
                        type: 'GET',
                        data: {
                            id_state: stateId
                        },
                        success: function(data) {
                            citySelectElement.empty();
                            citySelectElement.append('<option value=""> Select City </option>');
                            $.each(data.city, function(key, city) {
                                citySelectElement.append('<option value="' + city.id + '">' +
                                    city.city + '</option>');
                            });
                            if (selectedCityId) {
                                citySelectElement.val(selectedCityId);
                            }
                        }
                    });
                } else {
                    citySelectElement.empty();
                    citySelectElement.append('<option value=""> Select City </option>');
                }
            }

            // Event listener for state selection change
            $(document).on('change', '.stateselect', function() {
                var stateId = $(this).val();
                var citySelectElement = $(this).closest('form').find('.cityselect');
                fetchCities(stateId, citySelectElement);
            });

            // Event listener for filter state selection change
            $('#stateFilter').change(function() {
                var stateId = $(this).val();
                var citySelectElement = $('#cityFilter');
                fetchCities(stateId, citySelectElement);
            });

            // Form submit event
            $('#filter-form').on('submit', function(event) {
                event.preventDefault();
                this.submit();
            });

            // Automatically fetch cities based on selected state after page reload
            var preselectedStateId = '{{ Request::get('state') }}';
            var preselectedCityId = '{{ Request::get('city') }}';
            if (preselectedStateId) {
                fetchCities(preselectedStateId, $('#cityFilter'), preselectedCityId);
            }
            // Automatically populate cities in edit form
            $(document).on('show.bs.offcanvas', '.offcanvas', function() {
                var stateSelectElement = $(this).find('.stateselect');
                var citySelectElement = $(this).find('.cityselect');
                var stateId = stateSelectElement.val();
                var selectedCityId = citySelectElement.data('selected-city-id');
                if (stateId) {
                    fetchCities(stateId, citySelectElement, selectedCityId);
                }
            });
        });

        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>
@endsection
