
@extends('backend.layouts-new.app')

@section('content')

<style>
  .form-check-label {
      text-transform: capitalize;
  }
  .select2{
    width: 100%!important
  }
  label{
    float: left;
  }
</style>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title float-left">{{ $page_title }} List</h4> --}}
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('category.simbg.create'))

                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Category SIMBG</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('category-simbg.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                <div class="form-row">
                                                    <div class="form-group mb-3">
                                                        <label for="name" class="mb-3">Category</label>
                                                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" value="">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="email" class="mb-3">DESCRIPTION</label>
                                                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="status">Status</label>
                                                        <select id="status" name="status" class="form-select">
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        </select>
                                                    </div>
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
                                    <th>cATEGORY</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    <th>status</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($categorys as $category)
                               <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->category }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        @if ($category->status == 1)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            @if (Auth::guard('admin')->user()->can('category.simbg.edit'))
                                                <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="offcanvas"
                                                    data-bs-target="#edit-{{ $category->id }}"
                                                    aria-controls="offcanvasEnd">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                                <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-{{ $category->id }}"
                                                aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                                <div class="offcanvas-header">
                                                    <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit Category SIMBG</h5>
                                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="offcanvas-body mx-0 flex-grow-0">
                                                    <form action="{{ route('category-simbg.update',$category->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="ecommerce-customer-add-shiping mb-3 pt-3">
            
                                                            <div class="form-row">
                                                                <div class="form-group mb-3">
                                                                    <label for="name" class="mb-3">Category</label>
                                                                    <input type="text" class="form-control" id="service" value="{{ $category->category }}" name="category" placeholder="Enter Category" value="">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="email" class="mb-3">DESCRIPTION</label>
                                                                    <input type="text" class="form-control" id="description" value="{{ $category->description }}" name="description" placeholder="Enter Description" value="">
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label" for="status">Status</label>
                                                                    <select id="status" name="status" class="form-select">
                                                                        <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                                                                        <option value="2" {{ $category->status == '2' ? 'selected' : '' }}>Inactive</option>
                                                                    </select>
                                                                </div>
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
                                            
                                            @if (Auth::guard('admin')->user()->can('category.simbg.delete'))
                                            <button class="btn btn-sm btn-icon"  onclick="confirmDelete('{{ route('category-simbg.destroy', $category->id) }}')">
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
    function showCreateButton(){
        console.log('click');
        $('.buttonCreate').trigger('click');
    }
</script>
@endsection