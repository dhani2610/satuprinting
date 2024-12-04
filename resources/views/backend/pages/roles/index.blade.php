{{-- @extends('backend.layouts.master') --}}
@extends('backend.layouts-new.app')

@section('content')
    <style>
        .text-left {
            float: left;
        }

        .dataTableRole {
            width: 100%;
        }
    </style>

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title float-left">Roles List</h4> --}}
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('role.create'))
                                <button class="btn btn-primary text-white buttonCreate d-none" style="float: right"
                                    data-bs-toggle="modal" data-bs-target="#modalCreate">
                                    Create</button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-4">
                                                    <h3 class="role-title">Add New Role</h3>
                                                </div>
                                                <!-- Add role form -->
                                                <form action="{{ route('admin.roles.store') }}" method="POST">
                                                    @csrf
                                                    <div class="col-12 mb-4">
                                                        <label class="form-label" for="modalRoleName">Role Name</label>
                                                        <input type="text" id="modalRoleName" name="name"
                                                            class="form-control" placeholder="Enter a role name"
                                                            tabindex="-1">
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <label class="form-label" for="status">Status</label>
                                                        <select id="status" name="status" class="form-select">
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <h4>Role Permissions</h4>
                                                        <!-- Permission table -->
                                                        <div class="card-datatable table-responsive">
                                                            <table class="table table-flush-spacing">
                                                                <tbody>
                                                                    @php $i = 1; @endphp
                                                                    @foreach ($permission_groups as $group)
                                                                        <tr>
                                                                            <td
                                                                                class="text-nowrap fw-medium text-capitalize">
                                                                                {{ $group->name }}</td>
                                                                            <td>
                                                                                @php
                                                                                    $permissions = App\User::getpermissionsByGroupName(
                                                                                        $group->name,
                                                                                    );
                                                                                    $j = 1;
                                                                                @endphp
                                                                                <div class="d-flex">
                                                                                    @foreach ($permissions as $permission)
                                                                                        <div
                                                                                            class="form-check me-3 me-lg-5">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input"
                                                                                                name="permissions[]"
                                                                                                id="checkPermission{{ $permission->id }}"
                                                                                                value="{{ $permission->name }}">
                                                                                            <label
                                                                                                class="form-check-label text-capitalize"
                                                                                                for="checkPermission{{ $permission->id }}">
                                                                                                {{ ucfirst(last(explode(' ', str_replace('.', ' ', $permission->name)))) }}
                                                                                            </label>
                                                                                        </div>
                                                                                        @php $j++; @endphp
                                                                                    @endforeach
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        @php  $i++; @endphp
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- Permission table -->
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <button type="submit"
                                                            class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                        <button type="reset" class="btn btn-label-secondary"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                                <!--/ Add role form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </p>
                        <div class="clearfix"></div>
                        <div class="card-datatable table-responsive">
                            @include('backend.layouts.partials.messages')
                            <div class="card-datatable table-responsive">
                                <table id="dataTable" class="datatables-simply table border-top">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>NO</th>
                                            <th>Role</th>
                                            <th>Created Date</th>
                                            <th>Status</th>

                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->created_at }}</td>
                                                <td>
                                                    @if ($role->status == 1)
                                                        <span class="badge bg-label-success">Active</span>
                                                    @else
                                                        <span class="badge bg-label-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-inline-block text-nowrap">
                                                        @if (Auth::guard('admin')->user()->can('role.edit'))
                                                            <button class="btn btn-sm btn-icon" fdprocessedid="401des"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalEdit{{ $role->id }}"><i
                                                                    class="bx bx-edit"></i></button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="modalEdit{{ $role->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="text-center mb-4">
                                                                                <h3 class="role-title">Edit Role</h3>
                                                                            </div>
                                                                            <!-- edit role form -->
                                                                            <form
                                                                                action="{{ route('admin.roles.update', $role->id) }}"
                                                                                method="POST">
                                                                                @method('PUT')
                                                                                @csrf
                                                                                <div class="col-12 mb-4">
                                                                                    <label class="form-label"
                                                                                        for="modalRoleName">Role
                                                                                        Name</label>
                                                                                    <input type="text"
                                                                                        id="modalRoleName" name="name"
                                                                                        class="form-control"
                                                                                        value="{{ $role->name }}"
                                                                                        placeholder="Enter a role name"
                                                                                        tabindex="-1">
                                                                                </div>
                                                                                <div class="col-12 mb-4">
                                                                                    <label class="form-label"
                                                                                        for="status">Status</label>
                                                                                    <select id="status" name="status"
                                                                                        class="form-select">
                                                                                        <option value="1"
                                                                                            {{ $role->status == '1' ? 'selected' : '' }}>
                                                                                            Active</option>
                                                                                        <option value="2"
                                                                                            {{ $role->status == '2' ? 'selected' : '' }}>
                                                                                            Inactive</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <h4>Role Permissions</h4>
                                                                                    <!-- Permission table -->
                                                                                    <div class="card-datatable table-responsive">
                                                                                        <table
                                                                                            class="table table-flush-spacing">
                                                                                            <tbody>
                                                                                                @php $i = 1; @endphp
                                                                                                @foreach ($permission_groups as $group)
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            class="text-nowrap fw-medium text-capitalize">
                                                                                                            {{ $group->name }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            @php
                                                                                                                $permissions = App\User::getpermissionsByGroupName(
                                                                                                                    $group->name,
                                                                                                                );
                                                                                                                $j = 1;
                                                                                                            @endphp
                                                                                                            <div
                                                                                                                class="d-flex">
                                                                                                                @foreach ($permissions as $permission)
                                                                                                                    <div
                                                                                                                        class="form-check me-3 me-lg-5">
                                                                                                                        <input
                                                                                                                            type="checkbox"
                                                                                                                            class="form-check-input text-capitalize"
                                                                                                                            onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})"
                                                                                                                            name="permissions[]"
                                                                                                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                                                                            id="checkPermission{{ $permission->id }}"
                                                                                                                            value="{{ $permission->name }}">
                                                                                                                        <label
                                                                                                                            class="form-check-label text-capitalize"
                                                                                                                            for="checkPermission{{ $permission->id }}">
                                                                                                                            {{ ucfirst(last(explode(' ', str_replace('.', ' ', $permission->name)))) }}
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                    @php $j++; @endphp
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @php  $i++; @endphp
                                                                                                @endforeach

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <!-- Permission table -->
                                                                                </div>
                                                                                <div class="col-12 text-center">
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                                                    <button type="reset"
                                                                                        class="btn btn-label-secondary"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        Cancel
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                            <!--/ Add role form -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                                            <button class="btn btn-sm btn-icon delete-record"
                                                                    fdprocessedid="2r98p" onclick="event.preventDefault(); confirmDelete('{{ route('admin.roles.destroy', $role->id) }}', 'delete-form-{{ $role->id }}');"><i class="bx bx-trash"></i>
                                                            </button>
                                                            <form id="delete-form-{{ $role->id }}"
                                                                action="{{ route('admin.roles.destroy', $role->id) }}"
                                                                method="POST" style="display: none;">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
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
            </div>
            <!-- data table end -->

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    @include('backend.pages.roles.partials.scripts')
@endsection


@section('script')
    <script>
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
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
