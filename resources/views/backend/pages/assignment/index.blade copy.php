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
                                <span>All Assignment</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $assignment->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
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
                                <span>Customer</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $customer_count->count() }}</h4>
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
                                <span>Team</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $users->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
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
                                <span>Waiting</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $assignment_waiting->count() }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-timer bx-sm"></i>
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
                        <form action="" id="filter-form" method="get">
                            @csrf
                            <h5 class="card-title">Filter</h5>
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-3 user_role">
                                    <select id="customerFilter" name="customer" class="form-select text-capitalize"
                                        fdprocessedid="tdo6sd">
                                        <option value="">Choose Customer</option>
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}" {{ Request::get('customer') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 user_plan">
                                    <select id="teamFilter" name="team" class=" form-select text-capitalize"
                                        fdprocessedid="dzgave">
                                        <option value=""> Select Team </option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}" {{ Request::get('team') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 activity_date">
                                    <input type="text" id="bs-rangepicker-dropdown"
                                        class="bs-rangepicker-dropdown form-control" value="{{ Request::get('date') }}"
                                        name="date" />
                                </div>
                                <div class="col-md-3 statusFilter">
                                    <select id="statusFilter" name="status" class=" form-select text-capitalize"
                                        fdprocessedid="dzgave">
                                        <option value=""> Select Status </option>
                                        <option value="2" {{ Request::get('status') == 2 ? 'selected' : '' }}>Approve</option>
                                        <option value="1" {{ Request::get('status') == 1 ? 'selected' : '' }}>Waiting</option>
                                    </select>
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
                            @if (Auth::guard('admin')->user()->can('assignment.create'))
                                {{-- <a class="btn btn-primary text-white" style="float: right" href="{{ route('divisi.admins.create') }}" data-bs-toggle="modal" data-bs-target="#exampleModal"> --}}
                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Assignment</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('assignment.store') }}" method="POST"
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
                                                        $asgV = \App\Models\Divisi::where(
                                                            'id',
                                                            Auth::guard('admin')->user()->id_divisi,
                                                        )->first();
                                                    }
                                                @endphp
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-email">Division</label>
                                                    <input type="text" id="ecommerce-customer-add-email"
                                                        class="form-control" value="{{ $asgV->divisi }}"
                                                        name="customerEmail" disabled="">

                                                </div>

                                                <div class="mb-2">
                                                    <div class="form-group mb-2">
                                                        <label class="mb-2" for="password">Title</label>
                                                        <input type="text" class="form-control" name="tujuan"
                                                            required>
                                                    </div>
                                                </div>


                                                <div class="mb-4">
                                                    <label class="form-label" for="customer">Customer</label>
                                                    <select id="list-customer" name="id_customer"
                                                        class="select2 form-select" required
                                                        onchange="GetProject(this.value)">
                                                        <option value="">Select</option>
                                                        @foreach ($customers as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label" for="project">Project</label>
                                                    <select id="list-project" name="id_project"
                                                        class="select2 list-project form-select" >
                                                    </select>
                                                </div>

                                                <div class="mb-2">
                                                    <div class="form-group mb-2 col-md-12 col-sm-6">
                                                        <label class="mb-2" for="Location">Date</label>
                                                        <input type="date" class="form-control" name="date"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="mb-2">
                                                    <div class="row">
                                                        <div class="form-group mb-2 col-md-6 col-sm-6">
                                                            <label class="mb-2" for="password">Start Time</label>
                                                            <input type="time" class="form-control" name="time_start"
                                                                required>
                                                        </div>
                                                        <div class="form-group mb-2 col-md-6 col-sm-6">
                                                            <label class="mb-2" for="password_confirmation">End
                                                                Time</label>
                                                            <input type="time" class="form-control" name="time_end"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="mb-2">
                                                    <div class="form-group mb-2 col-md-12 col-sm-6">
                                                        <label class="mb-2" for="Location">Status</label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="1">
                                                                Waiting</option>
                                                            <option value="2">
                                                                Approve</option>
                                                        </select>
                                                    </div>
                                                </div> --}}

                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label"
                                                        for="ecommerce-customer-add-email">Note</label>
                                                    <textarea id="ecommerce-customer-add-email" class="form-control" name="note" required></textarea>
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
                                        <th>Title</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Team</th>
                                        <th>Division</th>
                                        <th>Date Time</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th class="no-print" class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignment as $asg)
                                        <tr>
                                            @php
                                                $cust = \App\Models\Admin::where('id', $asg->id_customer)->first();
                                                $user = \App\Models\Admin::where('id', $asg->id_user)->first();
                                                $div = \App\Models\Divisi::where('id', $user->id_divisi)->first();
                                            @endphp
                                            <td>{{ $asg->no_assignment }}</td>
                                            <td>{{ $asg->tujuan ?? '-' }}</td>
                                            <td>{{ $cust->name ?? '-' }}</td>
                                            @if ($asg->id_project != null)
                                                @php
                                                    $proj = \App\Models\Project::where('id', $asg->id_project)->first();
                                                @endphp
                                            <td>{{ $proj->name_project . ' | ' . $proj->no_project }}</td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            <td>{{ $user->name ?? '-' }}</td>
                                            <td>{{ $div->divisi ?? '-' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($asg->tanggal)->locale('id')->translatedFormat('l, j F Y') }}
                                                | {{ $asg->time_start }} - {{ $asg->time_end }}
                                            </td>
                                            <td>{{ $asg->note }}</td>
                                            <td>
                                                @if ($asg->status == 1)
                                                    <span class="badge bg-label-warning">Waiting</span>
                                                @elseif ($asg->status == 2)
                                                    <span class="badge bg-label-success">Approve</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline-block text-nowrap">

                                                @if (Auth::guard('admin')->user()->can('assignment.edit'))
                                                    <a href="{{ route('assignment.print',$asg->id) }}" target="_blank" class="btn btn-sm btn-icon"><i class="bx bx-printer"></i></a>

                                                    <button class="btn btn-sm btn-icon" data-bs-toggle="offcanvas"
                                                        data-bs-target="#edit{{ $asg->id }}"
                                                        aria-controls="offcanvasEnd" href="#"
                                                        onclick="GetProjectEdit('{{ $asg->id_customer }}','{{ $asg->id_project }}')">
                                                        <i class="bx bx-edit"></i>
                                                    </button>

                                                    <div class="offcanvas offcanvas-end" tabindex="-1"
                                                        id="edit{{ $asg->id }}"
                                                        aria-labelledby="offcanvasActivityAdd" aria-modal="true"
                                                        role="dialog">
                                                        <div class="offcanvas-header">
                                                            <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                Assignment</h5>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                                            <form action="{{ route('assignment.update', $asg->id) }}"
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
                                                                            Auth::guard('admin')->user()->id_divisi !=
                                                                            null
                                                                        ) {
                                                                            $asgV = \App\Models\Divisi::where(
                                                                                'id',
                                                                                Auth::guard('admin')->user()->id_divisi,
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

                                                                    <div class="mb-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="mb-2"
                                                                                for="password">Title</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asg->tujuan }}"
                                                                                name="tujuan">
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <label class="form-label"
                                                                            for="customer">Customer</label>
                                                                        <select id="list-customer" name="id_customer"
                                                                            class="select2 form-select" required
                                                                            onchange="GetProject(this.value)">
                                                                            <option value="">Select</option>
                                                                            @foreach ($customers as $item)
                                                                                <option value="{{ $item->id }}"
                                                                                    {{ $asg->id_customer == $item->id ? 'selected' : '' }}>
                                                                                    {{ $item->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <label class="form-label"
                                                                            for="project">Project</label>
                                                                        <select id="list-project" name="id_project"
                                                                            class="select2 list-project form-select"
                                                                            >
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="mb-2" for="Location">Date
                                                                            </label>
                                                                            <input type="date" class="form-control"
                                                                                value="{{ $asg->tanggal }}"
                                                                                name="date">
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <div class="row">
                                                                            <div class="form-group mb-2 col-md-6 col-sm-6">
                                                                                <label class="mb-2" for="password">Start
                                                                                    Time</label>
                                                                                <input type="time" class="form-control"
                                                                                    value="{{ $asg->time_start }}"
                                                                                    name="time_start">
                                                                            </div>
                                                                            <div class="form-group mb-2 col-md-6 col-sm-6">
                                                                                <label class="mb-2"
                                                                                    for="password_confirmation">End
                                                                                    Time</label>
                                                                                <input type="time" class="form-control"
                                                                                    value="{{ $asg->time_end }}"
                                                                                    name="time_end">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    @if (Auth::guard('admin')->user()->can('assignment.approval'))
                                                                    <div class="mb-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="mb-2"
                                                                                for="Location">Status</label>
                                                                            <select name="status" id=""
                                                                                class="form-control">
                                                                                <option value="1"
                                                                                    {{ $asg->status == 1 ? 'selected' : '' }}>
                                                                                    Waiting</option>
                                                                                <option value="2"
                                                                                    {{ $asg->status == 2 ? 'selected' : '' }}>
                                                                                    Approve</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    <div class="mb-3 fv-plugins-icon-container">
                                                                        <label class="form-label"
                                                                            for="ecommerce-customer-add-email">Note</label>
                                                                        <textarea id="ecommerce-customer-add-email" class="form-control" name="note">{{ $asg->note }}</textarea>
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

                                                @if (Auth::guard('admin')->user()->can('assignment.delete'))
                                                    <button class="btn btn-sm btn-icon"
                                                        onclick="confirmDelete('{{ route('assignment.destroy', $asg->id) }}')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
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
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
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
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filter-form');

            document.getElementById('customerFilter').addEventListener('change', function() {
                form.submit();
            });

            document.getElementById('teamFilter').addEventListener('change', function() {
                form.submit();
            });

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
    
@endsection
