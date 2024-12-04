@extends('backend.layouts-new.app')

@section('content')
<style>
    .custom-option .custom-option-content{
        height: 154px;
    }
    .title-tooltip {
        white-space: nowrap;       /* Mencegah teks membungkus ke baris baru */
        overflow: hidden;          /* Menyembunyikan teks yang melampaui kontainer */
        text-overflow: ellipsis;   /* Menambahkan ellipsis (...) di akhir teks yang terpotong */
        display: inline-block;     /* Mengatur elemen agar properti di atas berfungsi */
        max-width: 100%;           /* Menentukan lebar maksimum kontainer */
        cursor: pointer;           /* Mengubah kursor menjadi pointer untuk menunjukkan bahwa teks memiliki tooltip */
    }
</style>
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

            <!-- /Custom Option Radio Image -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 col-lg-12 d-flex align-items-start justify-content-end mb-3">
                            <button class="btn btn-primary text-white buttonCreate" type="button" data-bs-toggle="offcanvas"
                                style="float: right" data-bs-target="#create" aria-controls="offcanvasEnd">
                                Add Documentation</button>

                            <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                                aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Documentation</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body mx-0 flex-grow-0">
                                    <form action="{{ route('documentation.project.store', $proj->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                            <div class="form-row">
                                                <div class="form-group col-md-12 col-sm-12 mb-3">
                                                    <label for="name" class="mb-3">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title"
                                                        required value="">
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12 mb-3">
                                                    <label for="email" class="mb-3">Photo</label>
                                                    <div class="input-group">
                                                        <input type="file" accept="image/*" class="form-control"
                                                            id="lampiran" name="foto" required value="">
                                                        <button type="button" class="btn btn-primary" id="previewButton">
                                                            Preview
                                                        </button>
                                                    </div>

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
                        </div>
                        <div class="row">
                            @if ($documentations->count() > 0)
                                @foreach ($documentations as $doc)
                                    <div class="col-md-4 mb-md-0 mb-3">
                                        <div
                                            class="form-check custom-option custom-option-image custom-option-image-radio mb-3">
                                            <label class="form-check-label custom-option-content"
                                                for="customRadioImg{{ $doc->id }}">
                                                <span class="custom-option-body">
                                                    <img src="{{ asset('assets/img/documentation/' . ($doc->foto ?? '')) }}"
                                                        alt="radioImg" style="object-fit: cover;">
                                                </span>
                                            </label>
                                            <input name="customRadioImage" class="form-check-input" type="radio"
                                                value="customRadioImg{{ $doc->id }}"
                                                id="customRadioImg{{ $doc->id }}" data-bs-toggle="offcanvas"
                                                data-bs-target="#edit-{{ $doc->id }}" aria-controls="offcanvasEnd">
                                            <div class="text-center mt-2">
                                                <h5 class="mb-2 p-2 title-tooltip">{{ $doc->title }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-{{ $doc->id }}"
                                        aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                                        <div class="offcanvas-header">
                                            <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit Documentation</h5>
                                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                            <form action="{{ route('documentation.project.update', $proj->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="ecommerce-customer-add-shiping mb-3 pt-3">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                            <label for="name" class="mb-3">Title</label>
                                                            <input type="text" class="form-control"
                                                                id="title-{{ $doc->id }}" name="title" required
                                                                value="{{ $doc->title }}">
                                                        </div>
                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                            <label for="email" class="mb-3">Photo</label>
                                                            <div class="input-group">
                                                                <input type="file" accept="image/*"
                                                                    class="form-control"
                                                                    id="lampiran-{{ $doc->id }}" name="foto"
                                                                    value="">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="previewButton"
                                                                    onclick="showLampiranEdit('{{ asset('assets/img/documentation/' . ($doc->foto ?? '')) }}')">
                                                                    Preview
                                                                </button>
                                                            </div>
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
                                @endforeach
                            @else
                                <img src="{{ asset('assets/img/elements/no-data.png') }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--/ Customer Content -->

    </div>

    <!-- Modal for PDF Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Photo Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <img src="" id="pdfViewer" style="max-width: 100%" alt="">
                    </center>
                    {{-- <iframe id="pdfViewer" src="" width="100%" height="600px"></iframe> --}}
                </div>
            </div>
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
    <script>
        // Tombol preview PDF
        $('#previewButton').on('click', function() {
            var file = $('#lampiran').prop('files')[0];
            if (file) {
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    $('#pdfViewer').attr('src', e.target.result);
                    // Setelah memuat file, buka modal preview PDF
                    $('#previewModal').modal('show');
                };
                fileReader.readAsDataURL(file);
            } else {
                alert('Please select a PDF file first.');
            }
        });

        function showLampiranEdit(fileExist) {
            var file = $('#lampiran').prop('files')[0];

            if (file) {
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    $('#pdfViewer').attr('src', e.target.result);
                    // Setelah memuat file, buka modal preview PDF
                    $('#previewModal').modal('show');
                };
                fileReader.readAsDataURL(file);
            } else {
                if (fileExist) {
                    $('#pdfViewer').attr('src', fileExist);
                    $('#previewModal').modal('show');
                    // fileReader.readAsDataURL(file);
                } else {
                    alert('Please select a PDF file first.');
                }
            }

        }

        // Fungsi untuk mengatur fokus modal setelah modal tertutup
        $('#previewModal').on('hidden.bs.modal', function() {
            // Fokus kembali ke modalCreate jika modal previewModal ditutup
            $('#modalCreate').focus();
        });
    </script>
@endsection
