
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
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">{{ $page_title }} List</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('category.edit'))
                            {{-- <a class="btn btn-primary text-white" style="float: right" href="{{ route('category.admins.create') }}" data-bs-toggle="modal" data-bs-target="#exampleModal"> --}}
                            <a class="btn btn-primary text-white" style="float: right" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                Create  </a>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create {{ $page_title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('category.store') }}" method="POST">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="name">Category</label>
                                                    <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" value="">
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="email">Description</label>
                                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="">
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" style="float: right">Save</button>
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
                                    <th width="5%">NO</th>
                                    <th width="10%">Categorys</th>
                                    <th width="10%">Description</th>
                                    <th width="15%" class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($categorys as $category)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $category->category }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('category.edit'))
                                            <a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $category->id }}" href="#">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalEdit{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                                                            @csrf
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 col-sm-12">
                                                                    <label for="name">Category</label>
                                                                    <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" value="{{ $category->category }}">
                                                                </div>
                                                                <div class="form-group col-md-12 col-sm-12">
                                                                    <label for="email">Description</label>
                                                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ $category->description }}">
                                                                </div>
                                                            </div>
                                    
                                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" style="float: right">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('category.delete'))
                                        <a class="btn btn-danger text-white" href="{{ route('category.destroy', $category->id) }}">
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
   
@endsection