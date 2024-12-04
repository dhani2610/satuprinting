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
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title float-left">{{ $page_title }} List</h4> --}}
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('city.create'))
                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add City</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('city.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                <div class="form-group col-md-12 col-sm-12 mb-3">
                                                    <label for="name" class="mb-3">State</label>
                                                    <select name="id_state" class="select2 form-control" id="" required>
                                                        <option value="">Choose State</option>
                                                        @foreach ($states as $s)
                                                            <option value="{{ $s->id }}">{{ $s->state }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12 mb-3">
                                                    <label for="name" class="mb-3">City</label>
                                                    <input type="text" class="form-control" id="city" required
                                                        name="city" placeholder="Enter city" value="">
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12 mb-3">
                                                    <label for="email" class="mb-3">Description</label>
                                                    <input type="text" class="form-control" id="description" required
                                                        name="description" placeholder="Enter Description"
                                                        value="">
                                                </div>


                                            </div>

                                            <div class="pt-3">
                                                <button type="submit"
                                                    class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                                                <button type="reset" class="btn bg-label-secondary"
                                                    data-bs-dismiss="offcanvas">Cancel</button>
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
                                        <th>NO</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Description</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citys as $city)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            @php
                                                $stateV = \App\Models\State::where('id',$city->id_state)->first();
                                            @endphp
                                            <td>{{ $stateV->state }}</td>
                                            <td>{{ $city->city }}</td>
                                            <td>{{ $city->description }}</td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('city.edit'))
                                                    <a class="text-dark" type="button"
                                                        data-bs-toggle="offcanvas" data-bs-target="#edit-{{ $city->id }}"
                                                        aria-controls="offcanvasEnd" href="#">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-{{ $city->id }}"
                                                        aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                                        <div class="offcanvas-header">
                                                            <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit City</h5>
                                                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                                            <form action="{{ route('city.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="ecommerce-customer-add-shiping mb-3 pt-3">
                    
                                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                        <label for="name" class="mb-3">State</label>
                                                                        <select name="id_state" class="select2 form-control" id="" required>
                                                                            <option value="">Choose State</option>
                                                                            @foreach ($states as $s)
                                                                                <option value="{{ $s->id }}" {{ $city->id_state == $s->id ? 'selected' : '' }}>{{ $s->state }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                        <label for="name" class="mb-3">City</label>
                                                                        <input type="text" class="form-control" id="city" required
                                                                            value="{{ $city->city }}"  name="city" placeholder="Enter City">
                                                                    </div>
                                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                        <label for="email" class="mb-3">Description</label>
                                                                        <input type="text" class="form-control" id="description" required
                                                                            value="{{ $city->description }}"  name="description" placeholder="Enter Description">
                                                                    </div>
                    
                    
                                                                </div>
                    
                                                                <div class="pt-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                                                                    <button type="reset" class="btn bg-label-secondary"
                                                                        data-bs-dismiss="offcanvas">Cancel</button>
                                                                </div>
                                                                <input type="hidden"><input type="hidden"><input type="hidden"><input
                                                                    type="hidden"><input type="hidden">
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('city.delete'))
                                                    <a class="text-dark"
                                                        onclick="confirmDelete('{{ route('city.destroy', $city->id) }}')">
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
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>
@endsection
