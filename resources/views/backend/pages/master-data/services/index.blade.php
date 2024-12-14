@extends('backend.layouts-new.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">


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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title float-left">{{ $page_title }} List</h4> --}}
                        <p class="float-right mb-2">
                            @if (Auth::guard('admin')->user()->can('services.create'))
                                <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                                    data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                                    aria-controls="offcanvasEnd">
                                    Create</button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Product</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0">
                                        <form action="{{ route('services.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="name" class="mb-3">Category</label>
                                                        <select name="id_category" required class="form-control"
                                                            id="">
                                                            <option value="" disabled>Chooose Category</option>
                                                            @foreach ($category as $cat)
                                                                <option value="{{ $cat->id }}">{{ $cat->category }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="name" class="mb-3">IMAGE</label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image" placeholder="Enter Name" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="name" class="mb-3">NAME</label>
                                                        <input type="text" class="form-control" id="service"
                                                            name="service" placeholder="Enter Name" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="name" class="mb-3">PRICE (Rp.)</label>
                                                        <input type="number" class="form-control" id="price"
                                                            name="price" placeholder="Enter Price" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="name" class="mb-3">Shopee</label>
                                                        <input type="text" class="form-control" id="shopee"
                                                            name="shopee" placeholder="Enter Link Shopee" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="name" class="mb-3">Tokopedia</label>
                                                        <input type="text" class="form-control" id="tokopedia"
                                                            name="tokopedia" placeholder="Enter Link Tokopedia" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <label for="email" class="mb-3">DESCRIPTION SMALL</label>
                                                        <input type="text" class="form-control" id="description"
                                                            name="description" placeholder="Enter Description"
                                                            value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                                        <textarea name="content" required class="summernote" id="" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="status">Diskon?</label>
                                                        <select id="status" name="status" class="form-select">
                                                            <option value="1">Ya</option>
                                                            <option value="0">Tidak</option>
                                                        </select>
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
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Diskon</th>
                                        <th>status</th>
                                        <th>Shopee</th>
                                        <th>Tokopedia</th>
                                        <th>Created Date</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <center>
                                                    @if ($service->image != null)
                                                    <img src="{{ asset('assets/img/product/'.$service->image) }}" alt="" style="max-width: 100px;">
                                                    @else
                                                    -
                                                    @endif
                                                </center>
                                            </td>
                                            <td>
                                                @php
                                                    $catview = \App\Models\CategoryDocument::where('id',$service->id_category)->first();
                                                @endphp
                                                @if ($catview != null)
                                                    {{ $catview->category }}
                                                @endif
                                            </td>
                                            <td>{{ $service->service }}</td>
                                            <td>{{ $service->description }}</td>
                                            <td>@currency($service->price)</td>
                                            <td>
                                                @if ($service->status == 1)
                                                    <span class="badge bg-label-success">Active</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($service->is_diskon == 1)
                                                    <span class="badge bg-label-success">Ya</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Tidak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ $service->shopee }}">Shopee</a>
                                            </td>
                                            <td>
                                                <a href="{{ $service->shopee }}">Tokopedia</a>
                                            </td>
                                            <td>{{ $service->created_at }}</td>

                                            <td>
                                                <div class="d-inline-block text-nowrap">
                                                    @if (Auth::guard('admin')->user()->can('services.edit'))
                                                        <button class="btn btn-sm btn-icon" type="button"
                                                            data-bs-toggle="offcanvas"
                                                            data-bs-target="#edit-{{ $service->id }}"
                                                            aria-controls="offcanvasEnd">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <div class="offcanvas offcanvas-end" tabindex="-1"
                                                            id="edit-{{ $service->id }}"
                                                            aria-labelledby="offcanvasActivityAdd" aria-modal="true"
                                                            role="dialog">
                                                            <div class="offcanvas-header">
                                                                <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                    Product</h5>
                                                                <button type="button" class="btn-close text-reset"
                                                                    data-bs-dismiss="offcanvas"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="offcanvas-body mx-0 flex-grow-0">
                                                                <form action="{{ route('services.update', $service->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                            <label for="name" class="mb-3">Category</label>
                                                                            <select name="id_category" required class="form-control"
                                                                                id="">
                                                                                <option value="" disabled>Chooose Category</option>
                                                                                @foreach ($category as $cat)
                                                                                    <option value="{{ $cat->id }}" {{ $service->id_category == $cat->id ? 'selected' : '' }}>{{ $cat->category }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                            <label for="name" class="mb-3">IMAGE</label>
                                                                            <input type="file" class="form-control" id="image"
                                                                                name="image" placeholder="Enter Name" value="">
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div
                                                                                class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label for="name"
                                                                                    class="mb-3">NAME</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="service"
                                                                                    value="{{ $service->service }}"
                                                                                    name="service"
                                                                                    placeholder="Enter Name"
                                                                                    value="">
                                                                            </div>
                                                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label for="name" class="mb-3">PRICE (Rp.)</label>
                                                                                <input type="text" class="form-control" id="price"
                                                                                    name="price" placeholder="Enter Price" value="{{ $service->price }}">
                                                                            </div>
                                                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label for="name" class="mb-3">Shopee</label>
                                                                                <input type="text" class="form-control" id="shopee"
                                                                                    value="{{ $service->shopee }}" name="shopee" placeholder="Enter Link Shopee" value="">
                                                                            </div>
                                                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label for="name" class="mb-3">Tokopedia</label>
                                                                                <input type="text" class="form-control" id="tokopedia"
                                                                                    value="{{ $service->tokopedia }}" name="tokopedia" placeholder="Enter Link Tokopedia" value="">
                                                                            </div>
                                                                            <div
                                                                                class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label for="email"
                                                                                    class="mb-3">DESCRIPTION SMALL</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="description"
                                                                                    value="{{ $service->description }}"
                                                                                    name="description"
                                                                                    placeholder="Enter Description"
                                                                                    value="">
                                                                            </div>
                                                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <textarea name="content" required class="summernote" id="" cols="30" rows="10">{{ $service->content }}</textarea>
                                                                            </div>
                                                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label class="form-label"
                                                                                    for="status">Diskon ?</label>
                                                                                <select id="is_diskon" name="is_diskon"
                                                                                    class="form-select">
                                                                                    <option value="1"
                                                                                        {{ $service->status == '1' ? 'selected' : '' }}>
                                                                                        Ya</option>
                                                                                    <option value="0"
                                                                                        {{ $service->status == '0' ? 'selected' : '' }}>
                                                                                        Tidak</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                                <label class="form-label"
                                                                                    for="status">Status</label>
                                                                                <select id="status" name="status"
                                                                                    class="form-select">
                                                                                    <option value="1"
                                                                                        {{ $service->status == '1' ? 'selected' : '' }}>
                                                                                        Active</option>
                                                                                    <option value="2"
                                                                                        {{ $service->status == '2' ? 'selected' : '' }}>
                                                                                        Inactive</option>
                                                                                </select>
                                                                            </div>
                                                                            
                                                                        </div>


                                                                    </div>

                                                                    <div class="pt-3">
                                                                        <button type="submit"
                                                                            class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                                                                        <button type="reset"
                                                                            class="btn bg-label-secondary"
                                                                            data-bs-dismiss="offcanvas">Cancel</button>
                                                                    </div>
                                                                    <input type="hidden"><input type="hidden"><input
                                                                        type="hidden"><input type="hidden"><input
                                                                        type="hidden">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if (Auth::guard('admin')->user()->can('services.delete'))
                                                        <button class="btn btn-sm btn-icon"
                                                            onclick="confirmDelete('{{ route('services.destroy', $service->id) }}')">
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
<!-- jQuery (Wajib sebelum Bootstrap JS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <script>
          $(function () {
                $('[data-toggle="tooltip"]').tooltip(); // Inisialisasi tooltip secara manual
            });
        $('.summernote').summernote({
            placeholder: 'Content Here',
            tabsize: 2,
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                //['fontname', ['fontname']],
                // ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                //['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
    </script>
    <script>
         function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>
@endsection
