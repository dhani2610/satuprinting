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
                                <span>All Team</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ count($admins) }}</h4>
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
                                <span>All Division</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $division->count() }}</h4>
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
                                <span>Active Users</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $active_user->count() }}</h4>
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
                                <span>Inactive Users</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $inactive_user->count() }}</h4>
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
                        <form action="" method="get" id="filter-form">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                                <div class="col-md-4 user_role">
                                    <select id="divisiFilter" class="form-select text-capitalize" fdprocessedid="nlf1qq"
                                        name="divisi">
                                        <option value="">All Division</option>
                                        @foreach ($divisi as $d)
                                            <option value="{{ $d->id }}"
                                                {{ Request::get('divisi') == $d->id ? 'selected' : '' }}>{{ $d->divisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 user_plan">
                                    <input type="text" id="bs-rangepicker-dropdown"
                                        class="bs-rangepicker-dropdown form-control" value="{{ Request::get('date') }}"
                                        name="date" />
                                </div>
                                <div class="col-md-4 user_status">
                                    <select id="statusFilter" name="status" class="form-select text-capitalize"
                                        fdprocessedid="ls1u3a">
                                        <option value=""> Select Status </option>
                                        <option value="1" {{ Request::get('status') == '1' ? 'selected' : '' }}
                                            class="text-capitalize">Active</option>
                                        <option value="2" {{ Request::get('status') == '2' ? 'selected' : '' }}
                                            class="text-capitalize">Inactive</option>
                                    </select>
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
                        {{-- <h4 class="header-title float-left">Team List</h4> --}}
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('team.create'))
                                <button class="btn btn-primary mt-2 d-none" id="buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    <i class="bx bx-plus me-1"></i>
                                    Create New Team
                                </button>
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasEndLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasEndLabel" class="offcanvas-title">Create New Team</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('admin.admins.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row mb-2">
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="name">Foto</label>
                                                    <input type="file" class="form-control" id="foto"
                                                        name="foto" required accept="image/*">
                                                </div>
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="username">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Enter Username" required>
                                                </div>
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="name">Full Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" placeholder="Enter Full Name" required>
                                                </div>
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="email">Email</label>
                                                    <input type="text" class="form-control" id="email"
                                                        name="email" placeholder="Enter Email" required>
                                                </div>
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="email">WhatsApp</label>
                                                    <input type="number" class="form-control" id="whatsapp"
                                                        name="whatsapp" placeholder="Enter WhatsApp" required>
                                                </div>
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="email">Division</label>
                                                    <select name="id_divisi" class="select2 form-control" id="">
                                                        <option value="">Choose Division</option>
                                                        @foreach ($divisi as $d)
                                                            <option value="{{ $d->id }}">{{ $d->divisi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row mb-2">
                                                <div class="row">
                                                    <div class="form-group mb-2 col-md-6 col-sm-6">
                                                        <label class="mb-2" for="password">Password</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="Enter Password" required>
                                                    </div>
                                                    <div class="form-group mb-2 col-md-6 col-sm-6">
                                                        <label class="mb-2" for="password_confirmation">Confirm
                                                            Password</label>
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation"
                                                            placeholder="Enter Password" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row mb-2">
                                                {{-- <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="password">Assign Roles</label>
                                                    <select name="roles[]" id="roles" class="select2 form-control"
                                                        required>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                                    <label class="mb-2" for="email">Status</label>
                                                    <select name="status" class=" form-control" id="" required>
                                                        <option value="">Choose Status</option>
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"
                                                style="float: right">Save</button>
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
                                        <th width="5%">No</th>
                                        <th>User</th>
                                        <th>WhatsApp</th>
                                        <th>Division</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center user-name">
                                                    <div class="avatar-wrapper">
                                                        @php
                                                            $words = explode(' ', $admin->name);
                                                            $initials = '';
                                                            foreach ($words as $word) {
                                                                $initials .= strtoupper($word[0]);
                                                            }
                                                            // return $initials;
                                                        @endphp
                                                        <div class="avatar avatar-sm me-3">
                                                            @if ($admin->foto == null)
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-primary">{{ $initials }}</span>
                                                            @else
                                                                <img src="{{ asset('assets/img/team/' . $admin->foto) }}"
                                                                    alt="Avatar" class="rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"><a href="#"
                                                            class="text-body text-truncate"><span
                                                                class="fw-medium">{{ $admin->name }}</span></a><small
                                                            class="text-muted">{{ $admin->email }}</small></div>
                                                </div>
                                            </td>
                                            <td>{{ $admin->whatsapp ?? '-' }}</td>
                                            @php
                                                if ($admin->id_divisi != null) {
                                                    $divisiV = \App\Models\Divisi::where(
                                                        'id',
                                                        $admin->id_divisi,
                                                    )->first();
                                                }
                                            @endphp
                                            <td>
                                                <span class="text-truncate d-flex align-items-center"><span
                                                        class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i
                                                            class="bx bx-cog bx-xs"></i></span>{{ !empty($admin->id_divisi) ? $divisiV->divisi : '-' }}</span>
                                            </td>
                                            <td>
                                                @if ($admin->status == 1)
                                                    <span class="badge bg-label-success">Active</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $admin->created_at }}</td>
                                            <td>
                                                <div class="d-inline-block text-nowrap">
                                                    @if (Auth::guard('admin')->user()->can('team.edit'))
                                                        <button class="btn btn-sm btn-icon" fdprocessedid="401des" data-bs-toggle="offcanvas"
                                                        data-bs-target="#create2-{{ $admin->id }}"
                                                        aria-controls="offcanvasEnd"><i
                                                                class="bx bx-edit"></i></button>
                                                    @endif

                                                    @if ($admin->id != 1)
                                                        @if (Auth::guard('admin')->user()->can('team.delete'))
                                                            <button class="btn btn-sm btn-icon delete-record"
                                                                fdprocessedid="2r98p" onclick="event.preventDefault(); confirmDelete('{{ route('admin.admins.destroy', $admin->id) }}', 'delete-form-{{ $admin->id }}');"><i class="bx bx-trash"></i></button>
                                                            <form id="delete-form-{{ $admin->id }}"
                                                                action="{{ route('admin.admins.destroy', $admin->id) }}"
                                                                method="POST" style="display: none;">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                        @endif
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
            @foreach ($admins as $admin)
                <div class="offcanvas offcanvas-end" tabindex="-1" id="create2-{{ $admin->id }}"
                    aria-labelledby="offcanvasEndLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEndLabel" class="offcanvas-title">Edit Team</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-row mb-2">
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="name">Foto</label>
                                    <input type="file" class="form-control" id="foto"
                                        value="{{ $admin->foto }}" name="foto" accept="image/*">
                                </div>
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="username">Username</label>
                                    <input type="text" class="form-control" id="username"
                                        value="{{ $admin->username }}" name="username" placeholder="Enter Username"
                                        required>
                                </div>
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="name">Full
                                        Name</label>
                                    <input type="text" class="form-control" id="name"
                                        value="{{ $admin->name }}" name="name" placeholder="Enter Full Name"
                                        required>
                                </div>
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="email">Email</label>
                                    <input type="text" class="form-control" id="email"
                                        value="{{ $admin->email }}" name="email" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="email">WhatsApp</label>
                                    <input type="number" class="form-control" id="whatsapp"
                                        value="{{ $admin->whatsapp }}" name="whatsapp" placeholder="Enter WhatsApp"
                                        required>
                                </div>
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="email">Division</label>
                                    <select name="id_divisi" class="select2 form-control" id="" required>
                                        <option value="">Choose Division</option>
                                        @foreach ($divisi as $d)
                                            <option value="{{ $d->id }}"
                                                {{ $admin->id_divisi == $d->id ? 'selected' : '' }}>
                                                {{ $d->divisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="row">
                                    <div class="form-group mb-2 col-md-6 col-sm-6">
                                        <label class="mb-2" for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter Password" >
                                    </div>
                                    <div class="form-group mb-2 col-md-6 col-sm-6">
                                        <label class="mb-2" for="password_confirmation">Confirm
                                            Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Enter Password">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                {{-- <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="password">Assign
                                        Roles</label>
                                    <select name="roles[]" id="roles" class="select2 form-control" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group mb-2 col-md-12 col-sm-12">
                                    <label class="mb-2" for="email">Status</label>
                                    <select name="status" class=" form-control" id="" required>
                                        <option value="">Choose Status</option>
                                        <option value="1" {{ $admin->status == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="2" {{ $admin->status == '2' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"
                                style="float: right">Save</button>
                        </form>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

@endsection


@section('script')
    <script>
        function showCreateButton() {
            $('#buttonCreate').trigger('click');
        }
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
        function confirmDelete(deleteUrl, formId) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure delete this data?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

@endsection
