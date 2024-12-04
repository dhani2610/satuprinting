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
                                <span>All Activity</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $activity->count() }} </h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-universal-access bx-sm"></i>
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
                                    <h4 class="mb-0 me-2">{{ $customer_count->count() }}</h4>
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
                                <span>Division</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $divisi_count->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-briefcase bx-sm"></i>
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
                                <span>Team</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $users->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-user bx-sm"></i>
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
                        <form action="" method="get" id="filter-form">
                            @csrf
                            <h5 class="card-title">Filter</h5>
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-3 user_role">
                                    <select id="customerFilter" name="customer" class="form-select text-capitalize"
                                        fdprocessedid="tdo6sd">
                                        <option value="">All Customer</option>
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ Request::get('customer') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 user_plan">
                                    <select id="teamFilter" name="team" class=" form-select text-capitalize"
                                        fdprocessedid="dzgave">
                                        <option value=""> All Team </option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}"
                                                {{ Request::get('team') == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 activity_divison">
                                    <select id="divisionFilter" name="divisi" class="form-select text-capitalize"
                                        fdprocessedid="ls81at">
                                        <option value=""> All Division </option>
                                        @foreach ($divisi as $dv)
                                            <option value="{{ $dv->id }}"
                                                {{ Request::get('divisi') == $dv->id ? 'selected' : '' }}>
                                                {{ $dv->divisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 activity_date">
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
                            @if (Auth::guard('admin')->user()->can('activity.create'))
                                {{-- <a class="btn btn-primary text-white" style="float: right" href="{{ route('divisi.admins.create') }}" data-bs-toggle="modal" data-bs-target="#exampleModal"> --}}
                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Activity</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('activity.store') }}" method="POST"
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

                                                <div class="mb-4">
                                                    <label class="form-label" for="category">Category</label>
                                                    <select id="category" name="category" class="select2 form-select"
                                                        required onchange="toggleFields(this.value)">
                                                        <option value="">Select</option>
                                                        <option value="External">External</option>
                                                        <option value="Internal">Internal</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4" id="activity-container" style="display: none;">
                                                    <label class="form-label" for="activity_category">Activity
                                                        Internal</label>
                                                    <select id="activity_category" name="activity_category"
                                                        class="select2 form-select">
                                                        <option value="">Select</option>
                                                        <option value="Office">Office</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4" id="customer-container" style="display: none;">
                                                    <label class="form-label" for="customer">Customer</label>
                                                    <select id="customer" name="id_customer" class="select2 form-select"
                                                        onchange="GetProjectCreate(this.value)">
                                                        <option value="">Select</option>
                                                        @foreach ($customers as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4" id="project-container" style="display: none;">
                                                    <label class="form-label" for="project">Project</label>
                                                    <select id="project" name="id_project"
                                                        class="select2 list-project-create form-select">
                                                        <option value="">Select</option>
                                                    </select>
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
                                        <th>Number</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Team</th>
                                        <th>Division</th>
                                        <th>Note</th>
                                        <th>Created Date</th>
                                        <th class="no-print" class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($activity) --}}
                                    @foreach ($activity as $act)
                                        <tr>
                                            @php
                                                $user = \App\Models\Admin::where('id', $act->id_user)->first();
                                                $div = \App\Models\Divisi::where('id', $user->id_divisi)->first();

                                                if ($act->category == 'External' || $act->category == null) {
                                                    $cust = \App\Models\Admin::where('id', $act->id_customer)->first();
                                                    if ($act->id_project != null) {
                                                        $proj = \App\Models\Project::where('id', $act->id_project)->first();
                                                        $detail = App\Models\PurchaseOrderDetail::where(
                                                            'id_po',
                                                            $proj->id_po,
                                                        )->get();
                                                    }
                                                }

                                            @endphp
                                            <td>{{ $act->no_activity }}</td>
                                            <td>
                                                @if ($act->category != null)
                                                    @if ($act->category == 'Internal')
                                                        -
                                                    @else
                                                        {{ $cust->name ?? '-' }}
                                                    @endif
                                                @else
                                                    {{ $cust->name ?? '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($act->category != null)
                                                    @if ($act->category == 'Internal')
                                                        -
                                                    @else
                                                        @if ($act->id_project != null)
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
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($act->id_project != null)
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
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $user->name ?? '-' }}</td>
                                            <td>{{ $div->divisi ?? '-' }}</td>
                                            <td>{{ $act->note }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($act->tanggal)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>
                                                <div class="d-inline-block text-nowrap">
                                                    @if (Auth::guard('admin')->user()->can('activity.edit'))
                                                        <button class="btn btn-sm btn-icon" data-bs-toggle="offcanvas"
                                                            data-bs-target="#edit{{ $act->id }}"
                                                            aria-controls="offcanvasEnd" href="#"
                                                            onclick="GetProjectEdit('{{ $act->id_customer }}','{{ $act->id_project }}')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>

                                                        <div class="offcanvas offcanvas-end" tabindex="-1"
                                                            id="edit{{ $act->id }}"
                                                            aria-labelledby="offcanvasActivityAdd" aria-modal="true"
                                                            role="dialog">
                                                            <div class="offcanvas-header">
                                                                <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                    Activity - {{ $act->no_activity }}</h5>
                                                                <button type="button" class="btn-close text-reset"
                                                                    data-bs-dismiss="offcanvas"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="offcanvas-body mx-0 flex-grow-0">
                                                                <form action="{{ route('activity.update', $act->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                                        <div class="mb-3 fv-plugins-icon-container">
                                                                            <label class="form-label"
                                                                                for="ecommerce-customer-add-name">Name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="ecommerce-customer-add-name"
                                                                                value="{{ $user->name }}"
                                                                                name="customerName" aria-label="John Doe"
                                                                                disabled="">

                                                                        </div>
                                                                        @php
                                                                            if (
                                                                                Auth::guard('admin')->user()
                                                                                    ->id_divisi != null
                                                                            ) {
                                                                                $actV = \App\Models\Divisi::where(
                                                                                    'id',
                                                                                    Auth::guard('admin')->user()
                                                                                        ->id_divisi,
                                                                                )->first();
                                                                            }
                                                                        @endphp
                                                                        <div class="mb-3 fv-plugins-icon-container">
                                                                            <label class="form-label"
                                                                                for="ecommerce-customer-add-email">Division</label>
                                                                            <input type="text"
                                                                                id="ecommerce-customer-add-email"
                                                                                class="form-control"
                                                                                value="{{ $div->divisi }}"
                                                                                name="customerEmail" disabled="">

                                                                        </div>

                                                                        <div class="mb-4">
                                                                            <label class="form-label"
                                                                                for="category">Category</label>
                                                                            <select id="category{{ $act->id }}"
                                                                                name="category" class="form-select"
                                                                                required
                                                                                onchange="toggleFieldsEdit('{{ $act->id }}')">
                                                                                <option value="">Select</option>
                                                                                <option value="External"
                                                                                    {{ $act->category == 'External' ? 'selected' : '' }}>
                                                                                    External</option>
                                                                                <option value="Internal"
                                                                                    {{ $act->category == 'Internal' ? 'selected' : '' }}>
                                                                                    Internal</option>
                                                                            </select>
                                                                        </div>

                                                                        <!-- Internal Activity Dropdown -->
                                                                        <div class="mb-4"
                                                                            id="activity-container{{ $act->id }}"
                                                                            style="{{ $act->category == 'Internal' ? '' : 'display: none;' }}">
                                                                            <label class="form-label"
                                                                                for="activity_category">Activity
                                                                                Internal</label>
                                                                            <select
                                                                                id="activity_category{{ $act->id }}"
                                                                                name="activity_category"
                                                                                class="form-select">
                                                                                <option value="">Select</option>
                                                                                <option value="Office"
                                                                                    {{ $act->activity_category == 'Office' ? 'selected' : '' }}>
                                                                                    Office</option>
                                                                            </select>
                                                                        </div>

                                                                        <!-- Customer Dropdown -->
                                                                        <div class="mb-4"
                                                                            id="customer-container{{ $act->id }}"
                                                                            style="{{ $act->category == 'External' ? '' : 'display: none;' }}">
                                                                            <label class="form-label"
                                                                                for="customer">Customer</label>
                                                                            <select id="customer{{ $act->id }}"
                                                                                name="id_customer" class="form-select"
                                                                                onchange="GetProject(this.value)">
                                                                                <option value="">Select</option>
                                                                                @foreach ($customers as $cst)
                                                                                    <option value="{{ $cst->id }}"
                                                                                        {{ $cst->id == $act->id_customer ? 'selected' : '' }}>
                                                                                        {{ $cst->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <!-- Project Dropdown -->
                                                                        <div class="mb-4"
                                                                            id="project-container{{ $act->id }}"
                                                                            style="{{ $act->id_project ? '' : 'display: none;' }}">
                                                                            <label class="form-label"
                                                                                for="project">Project</label>
                                                                            <select id="project{{ $act->id }}"
                                                                                name="id_project"
                                                                                class="list-project form-select">
                                                                                <option value="">Select</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3 fv-plugins-icon-container">
                                                                            <label class="form-label"
                                                                                for="ecommerce-customer-add-email">Note</label>
                                                                            <textarea id="ecommerce-customer-add-email" class="form-control" name="note">{{ $act->note }}</textarea>

                                                                        </div>

                                                                    </div>

                                                                    <div class="pt-3">
                                                                        <button type="submit"
                                                                            class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
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

                                                    @if (Auth::guard('admin')->user()->can('activity.delete'))
                                                        <button class="btn btn-sm btn-icon"
                                                            onclick="confirmDelete('{{ route('activity.destroy', $act->id) }}')">
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
@endsection


@section('script')
    <script>
        function toggleFieldsEdit(id) {
            const category = document.getElementById(`category${id}`).value;
            document.getElementById(`activity-container${id}`).style.display = 'none';
            document.getElementById(`customer-container${id}`).style.display = 'none';
            document.getElementById(`project-container${id}`).style.display = 'none';

            if (category === 'Internal') {
                document.getElementById(`activity-container${id}`).style.display = 'block';
            } else if (category === 'External') {
                document.getElementById(`customer-container${id}`).style.display = 'block';
                document.getElementById(`project-container${id}`).style.display = 'block';

                // const customerId = document.getElementById(`customer${id}`).value;
                // if (customerId) {
                //     document.getElementById(`project-container${id}`).style.display = 'block';
                // }
            }
        }

        function toggleFields(value) {
            // Hide all fields by default
            document.getElementById('activity-container').style.display = 'none';
            document.getElementById('customer-container').style.display = 'none';
            document.getElementById('project-container').style.display = 'none';

            if (value === 'Internal') {
                // Show only Activity Internal field
                document.getElementById('activity-container').style.display = 'block';
            } else if (value === 'External') {
                // Show Customer and Project fields
                document.getElementById('customer-container').style.display = 'block';
                document.getElementById('project-container').style.display = 'block';
            }
        }
    </script>

    <script>
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }

        function GetProjectCreate(customerId) {
            const projectDropdowns = document.getElementsByClassName('list-project-create');

            Array.from(projectDropdowns).forEach(projectDropdown => {
                projectDropdown.innerHTML = '<option value="">Select Project</option>';

                if (customerId) {
                    $.ajax({
                        url: '{{ route('getProjectByCustomer', ':id') }}'.replace(':id', customerId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            console.log(response, customerId);

                            response.data.forEach(function(project) {
                                const option = document.createElement('option');
                                option.value = project.id;
                                option.text = project.name_project + ' | ' + project.no_project;
                                projectDropdown.appendChild(option);
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Handle any errors here
                        }
                    });
                }
            });
        }
        function GetProject(customerId) {
            const projectDropdowns = document.getElementsByClassName('list-project');

            Array.from(projectDropdowns).forEach(projectDropdown => {
                projectDropdown.innerHTML = '<option value="">Select Project</option>';

                if (customerId) {
                    $.ajax({
                        url: '{{ route('getProjectByCustomer', ':id') }}'.replace(':id', customerId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            console.log(response, customerId);

                            response.data.forEach(function(project) {
                                const option = document.createElement('option');
                                option.value = project.id;
                                option.text = project.name_project + ' | ' + project.no_project;
                                projectDropdown.appendChild(option);
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Handle any errors here
                        }
                    });
                }
            });
        }

        function GetProjectEdit(customerId, projectId) {
            const projectDropdowns = document.getElementsByClassName('list-project');

            Array.from(projectDropdowns).forEach(projectDropdown => {
                projectDropdown.innerHTML = '<option value="">Select Project</option>';

                if (customerId) {
                    $.ajax({
                        url: '{{ route('getProjectByCustomer', ':id') }}'.replace(':id', customerId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            console.log(response);
                            response.data.forEach(function(project) {
                                const option = document.createElement('option');
                                option.value = project.id;
                                option.text = project.name_project + ' | ' + project.no_project;
                                projectDropdown.appendChild(option);
                            });

                            // Set the selected option based on projectId
                            if (projectId) {
                                projectDropdown.value = projectId;
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Handle any errors here
                        }
                    });
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Menangani perubahan filter dengan event change
            $('#UserRole, #UserPlan, #activity_divison').on('change', function() {
                var customerFilter = $('#UserRole').val().toLowerCase();
                var teamFilter = $('#UserPlan').val().toLowerCase();
                var divisionFilter = $('#activity_divison').val().toLowerCase();

                $('#dataTable tbody tr').each(function() {
                    var customerText = $(this).find('td:nth-child(2)').text().toLowerCase();
                    var teamText = $(this).find('td:nth-child(4)').text().toLowerCase();
                    var divisionText = $(this).find('td:nth-child(5)').text().toLowerCase();

                    var customerMatch = customerText.includes(customerFilter);
                    var teamMatch = teamText.includes(teamFilter);
                    var divisionMatch = divisionText.includes(divisionFilter);

                    if (customerMatch && teamMatch && divisionMatch) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filter-form');

            document.getElementById('customerFilter').addEventListener('change', function() {
                form.submit();
            });

            document.getElementById('teamFilter').addEventListener('change', function() {
                form.submit();
            });
            document.getElementById('divisionFilter').addEventListener('change', function() {
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
