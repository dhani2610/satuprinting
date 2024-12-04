
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
                        @if (Auth::guard('admin')->user()->can('category.document.create'))

                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Slider</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('slider.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                <div class="form-row">
                                                    <div class="form-group mb-3">
                                                        <label for="name" class="mb-3">IMAGE</label>
                                                        <input type="file" class="form-control" id="image" name="image" accept="/image" placeholder="Enter Slider" value="" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="name" class="mb-3">TITLE</label>
                                                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter Slider" value="">
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
                                    <th style="width: 10%">IMAGE</th>
                                    <th>TITLE</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    <th>status</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($sliders as $slider)
                               <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <center>
                                            @if ($slider->image != null)
                                            <img src="{{ asset('assets/img/slider/'.$slider->image) }}" alt="" style="max-width: 100px;">
                                            @else
                                            -
                                            @endif
                                        </center>
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->description }}</td>
                                    <td>{{ $slider->created_at }}</td>
                                    <td>
                                        @if ($slider->status == 1)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            @if (Auth::guard('admin')->user()->can('category.document.edit'))
                                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="offcanvas"
                                                    data-bs-target="#edit-{{ $slider->id }}"
                                                    aria-controls="offcanvasEnd">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                                <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-{{ $slider->id }}"
                                                aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                                <div class="offcanvas-header">
                                                    <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit Slider</h5>
                                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="offcanvas-body mx-0 flex-grow-0">
                                                    <form action="{{ route('slider.update',$slider->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="ecommerce-customer-add-shiping mb-3 pt-3">
            
                                                            <div class="form-row">
                                                                <div class="form-group mb-3">
                                                                    <label for="name" class="mb-3">Image</label>
                                                                    <input type="file" class="form-control" id="image" name="image" placeholder="Enter Slider" value="" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="name" class="mb-3">TITLE</label>
                                                                    <input type="text" class="form-control" id="service" value="{{ $slider->title }}" name="category" placeholder="Enter Slider" value="">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="email" class="mb-3">Description</label>
                                                                    <input type="text" class="form-control" id="description" value="{{ $slider->description }}" name="description" placeholder="Enter Description" value="">
                                                                </div>
                                                                <div class="form-group mb-4">
                                                                    <label class="form-label" for="status">Status</label>
                                                                    <select id="status" name="status" class="form-select">
                                                                        <option value="1" {{ $slider->status == '1' ? 'selected' : '' }}>Active</option>
                                                                        <option value="2" {{ $slider->status == '2' ? 'selected' : '' }}>Inactive</option>
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
                                            
                                            @if (Auth::guard('admin')->user()->can('category.document.delete'))
                                            <button class="btn btn-sm btn-icon" onclick="confirmDelete('{{ route('slider.destroy', $slider->id) }}')">
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