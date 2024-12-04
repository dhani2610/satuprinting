@extends('backend.layouts-new.app')

@section('content')
    @php
        $po = \App\Models\PurchaseOrder::where('id', $proj->id_po)->first();
        $cust = App\Models\Admin::where('type', 'customer')
            ->where('id', $proj->id_customer)
            ->first();
        $poDetail = \App\Models\PurchaseOrderDetail::where('id_po', $proj->id_po)->get();
        $statecust = \App\Models\State::where('id', $cust->id_state)->first();
        $citycust = \App\Models\City::where('id', $cust->id_city)->first();
        $marketing = App\Models\Admin::where('id', $proj->id_marketing)->first();

    @endphp
    @include('backend.layouts.partials.messages')

    <div class="row">
        <!-- Customer-detail Sidebar -->
        @include('backend.pages.transaction.project.sidebar')
        <!--/ Customer Sidebar -->

        <!-- Customer Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Customer Pills -->
            @include('backend.pages.transaction.project.tabs')
            <!-- Custom Option Radio Image -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body m-0 p-0">
                        <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                            data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                            aria-controls="offcanvasEnd">
                            Create</button>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                            aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                            <div class="offcanvas-header">
                                <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Kajian</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('kajian.project.store',$proj->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                        <div class="form-row">
                                            <div class="form-group mb-3">
                                                <label for="name" class="mb-3">Category</label>
                                                <select id="list-customer" name="id_category" class="select2 form-select" required>
                                                    <option value="">Select</option>
                                                    @foreach ($category_kajian as $tc)
                                                        <option value="{{ $tc->id }}">{{ $tc->category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="email" class="mb-3">Work</label>
                                                <select name="note" class="form-control select2" id="">
                                                    <option value="All">All</option>
                                                    <option value="Arsitektur">Arsitektur</option>
                                                    <option value="Struktur">Struktur</option>
                                                    <option value="MEP">MEP</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="email" class="mb-3">Link Drive</label>
                                                <input type="url" class="form-control" id="description"
                                                    name="link_drive" value="">
                                            </div>
                                            
                                            
                                            <div class="form-group mb-3">
                                                <label for="email" class="mb-3">Status</label>
                                                <select name="status" class="form-control" id="">
                                                    <option value="1">On Progress</option>
                                                    <option value="2">Done</option>
                                                </select>
                                            </div>

                                            <div
                                                class="form-group mb-3">
                                                <label for="email"
                                                    class="mb-3">Note</label>
                                                <textarea name="catatan" class="form-control" id=""></textarea>
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
                        <div class="row">
                            <div class="card-datatable table-responsive">
                                @include('backend.layouts.partials.messages')
                                <table id="dataTable" class="datatables-simply table border-top">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Work</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kajians as $kajian)
                                            <tr>
                                                @php
                                                    $category_v = \App\Models\CategoryKajian::where('id',$kajian->id_category)->first();
                                                    $created_BY = \App\Models\Admin::where('id',$kajian->created_by)->first();
                                                @endphp
                                                <td>{{ $kajian->no_kajian }}</td>
                                                <td>{{ $category_v->category }}</td>
                                                <td>{{ $kajian->note }}</td>
                                                <td>{{ $created_BY->name }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($kajian->created_at)->locale('id')->translatedFormat('l, j F Y') }}
                                                </td>
                                                <td>
                                                    @if ($kajian->status == 1)
                                                        <span class="badge bg-label-warning">ON PROGRESS</span>
                                                    @else
                                                        <span class="badge bg-label-success">Done</span>
                                                    @endif
                                                </td>
                                                <td>{{ $kajian->catatan }}</td>
                                                <td>
                                                    <div class="d-inline-block text-nowrap">
                                                            @if ($kajian->link_drive != null)
                                                                <a class="btn btn-sm btn-icon" href="{{ $kajian->link_drive }}" target="_blank" title="Link Drive">
                                                                    <i class="fa fa-link"></i>
                                                                </a>
                                                            @endif
                                                            <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="offcanvas"
                                                                data-bs-target="#edit-{{ $kajian->id }}"
                                                                aria-controls="offcanvasEnd">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <div class="offcanvas offcanvas-end" tabindex="-1"
                                                                id="edit-{{ $kajian->id }}"
                                                                aria-labelledby="offcanvasActivityAdd" aria-modal="true"
                                                                role="dialog">
                                                                <div class="offcanvas-header">
                                                                    <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                        Kajian - {{ $kajian->no_kajian }}</h5>
                                                                    <button type="button" class="btn-close text-reset"
                                                                        data-bs-dismiss="offcanvas"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="offcanvas-body mx-0 flex-grow-0">
                                                                    <form action="{{ route('kajian.project.update', ['id_project' => $proj->id, 'id' => $kajian->id]) }}" method="POST"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="ecommerce-customer-add-shiping mb-3 pt-3">
                                    
                                                                            <div class="form-row">
                                                                                <div class="form-group mb-3">
                                                                                    <label for="name" class="mb-3">Category</label>
                                                                                    <select id="list-customer" name="id_category" class="select2 form-select" required>
                                                                                        <option value="">Select</option>
                                                                                        @foreach ($category_kajian as $tc)
                                                                                            <option value="{{ $tc->id }}" {{ $tc->id == $kajian->id_category ? 'selected' : '' }}>{{ $tc->category }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group mb-3">
                                                                                    <label for="email" class="mb-3">Work</label>
                                                                                    <select name="note" class="form-control select2" id="">
                                                                                        <option value="All" {{ $kajian->note == 'All' ? 'selected' : '' }} >All</option>
                                                                                        <option value="Arsitektur" {{ $kajian->note == 'Arsitektur' ? 'selected' : '' }} >Arsitektur</option>
                                                                                        <option value="Struktur" {{ $kajian->note == 'Struktur' ? 'selected' : '' }} >Struktur</option>
                                                                                        <option value="MEP" {{ $kajian->note == 'MEP' ? 'selected' : '' }} >MEP</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group mb-3">
                                                                                    <label for="email" class="mb-3">Link Drive</label>
                                                                                    <input type="text" class="form-control" id="description"
                                                                                        name="link_drive" value="{{ $kajian->link_drive }}">
                                                                                </div>
                                                                                
                                                                                
                                                                                <div class="form-group mb-3">
                                                                                    <label for="email" class="mb-3">Status</label>
                                                                                    <select name="status" class="form-control" id="">
                                                                                        <option value="1" {{ $kajian->status == 1 ? 'selected' : ''  }}>On Progress</option>
                                                                                        <option value="2" {{ $kajian->status == 2 ? 'selected' : ''  }}>Done</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div
                                                                                    class="form-group mb-3">
                                                                                    <label for="email"
                                                                                        class="mb-3">Note</label>
                                                                                    <textarea name="catatan" class="form-control" id="">{{ $kajian->catatan }}</textarea>
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

                                                        <button class="btn btn-sm btn-icon"
                                                            onclick="confirmDelete('{{ route('kajian.project.destroy', ['id_project' => $proj->id, 'id' => $kajian->id]) }}')">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
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

            <!-- /Custom Option Radio Image -->
        </div>
        <!--/ Customer Content -->
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
