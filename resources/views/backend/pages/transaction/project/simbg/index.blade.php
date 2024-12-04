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
                                <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add SIMBG</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('simbg.project.store', $proj->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                        <div class="form-row">
                                            <div class="form-group mb-3">
                                                <label for="name" class="mb-3">PROGRESS</label>
                                                <select id="progress" name="id_category" class=" form-select"
                                                    onchange="toggleDocumentForm()" required>
                                                    <option value="">Select</option>
                                                    @foreach ($category_simbg as $tc)
                                                        <option value="{{ $tc->id }}" data-name="{{ $tc->category }}">
                                                            {{ $tc->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3" id="documentForm"
                                                style="display: none;">
                                                <label for="email" class="mb-3">Upload Document</label>
                                                <div class="input-group">
                                                    <input type="file" accept=".pdf" class="form-control" id="lampiran"
                                                        name="document" value="">
                                                    <button type="button" class="btn btn-primary"
                                                        id="previewButton">Preview</button>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="email" class="mb-3">Note</label>
                                                <textarea name="note" class="form-control" id=""></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="email" class="mb-3">Status</label>
                                                <select name="status" class="form-control" id="">
                                                    <option value="1">On Progress</option>
                                                    <option value="2">Done</option>
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
                        <div class="row">
                            <div class="card-datatable table-responsive">
                                @include('backend.layouts.partials.messages')
                                <table id="dataTable" class="datatables-simply table border-top">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>ID</th>
                                            <th>Progress</th>
                                            <th>Note</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Status</th>
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($simbgs as $simbg)
                                            <tr>
                                                @php
                                                    $category_v = \App\Models\Categorysimbg::where(
                                                        'id',
                                                        $simbg->id_category,
                                                    )->first();
                                                    $created_BY = \App\Models\Admin::where(
                                                        'id',
                                                        $simbg->created_by,
                                                    )->first();
                                                @endphp
                                                <td>{{ $simbg->no_simbg }}</td>
                                                <td>{{ $category_v->category }}</td>
                                                <td>{{ $simbg->note }}</td>
                                                <td>{{ $created_BY->name }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($simbg->created_at)->locale('id')->translatedFormat('l, j F Y') }}
                                                </td>
                                                <td>
                                                    @if ($simbg->status == 1)
                                                        <span class="badge bg-label-warning">ON PROGRESS</span>
                                                    @else
                                                        <span class="badge bg-label-success">Done</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-inline-block text-nowrap">
                                                        @if ($category_v->category == 'Izin Pengambilan Document')
                                                            @php
                                                                if ($simbg->document != null) {
                                                                    $pathToFile =
                                                                        public_path('documents/simbg/') .
                                                                        $simbg->document;
                                                                    if (file_exists($pathToFile)) {
                                                                        $base64 = base64_encode(
                                                                            file_get_contents($pathToFile),
                                                                        );
                                                                        $base64PDF =
                                                                            'data:application/pdf;base64,' . $base64;
                                                                    } else {
                                                                        $base64PDF = null;
                                                                    }
                                                                } else {
                                                                    $base64PDF = null;
                                                                }
                                                            @endphp
                                                            <button class="btn btn-sm btn-icon"
                                                                onclick="showLampiranEdit('{{ $base64PDF }}','{{ $simbg->id }}')"
                                                                data-bs-original-title="Photo Survey">
                                                                <i class='bx bxs-file-pdf'></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-sm btn-icon" type="button"
                                                            data-bs-toggle="offcanvas"
                                                            data-bs-target="#edit-{{ $simbg->id }}"
                                                            aria-controls="offcanvasEnd"
                                                            onclick="toggleDocumentFormEdit('{{ $simbg->id }}')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <div class="offcanvas offcanvas-end" tabindex="-1"
                                                            id="edit-{{ $simbg->id }}"
                                                            aria-labelledby="offcanvasActivityAdd" aria-modal="true"
                                                            role="dialog">
                                                            <div class="offcanvas-header">
                                                                <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                    SIMBG - {{ $simbg->no_simbg }}</h5>
                                                                <button type="button" class="btn-close text-reset"
                                                                    data-bs-dismiss="offcanvas"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="offcanvas-body mx-0 flex-grow-0">
                                                                <form
                                                                    action="{{ route('simbg.project.update', ['id_project' => $proj->id, 'id' => $simbg->id]) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                                        <div class="form-row">
                                                                            <div
                                                                                class="form-group mb-3">
                                                                                <label for="name"
                                                                                    class="mb-3">Progress</label>
                                                                                <select id="progres-{{ $simbg->id }}"
                                                                                    name="id_category"
                                                                                    class="select2 form-select" required
                                                                                    onchange="toggleDocumentFormEdit({{ $simbg->id }})">
                                                                                    <option value="">Select</option>
                                                                                    @foreach ($category_simbg as $tc)
                                                                                        <option
                                                                                            value="{{ $tc->id }}"
                                                                                            data-name="{{ $tc->category }}"
                                                                                            {{ $tc->id == $simbg->id_category ? 'selected' : '' }}>
                                                                                            {{ $tc->category }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mb-3"
                                                                                id="documentForm-{{ $simbg->id }}"
                                                                                style="display: none;">
                                                                                <label for="email"
                                                                                    class="mb-3">Upload
                                                                                    Document</label>
                                                                                <div class="input-group">
                                                                                    <input type="file"
                                                                                        class="form-control"
                                                                                        accept=".pdf"
                                                                                        id="lampiran-{{ $simbg->id }}"
                                                                                        name="document">
                                                                                    @php
                                                                                        if ($simbg->document != null) {
                                                                                            $pathToFile =
                                                                                                public_path(
                                                                                                    'documents/simbg/',
                                                                                                ) . $simbg->document;
                                                                                            if (
                                                                                                file_exists($pathToFile)
                                                                                            ) {
                                                                                                $base64 = base64_encode(
                                                                                                    file_get_contents(
                                                                                                        $pathToFile,
                                                                                                    ),
                                                                                                );
                                                                                                $base64PDF =
                                                                                                    'data:application/pdf;base64,' .
                                                                                                    $base64;
                                                                                            } else {
                                                                                                $base64PDF = null;
                                                                                            }
                                                                                        } else {
                                                                                            $base64PDF = null;
                                                                                        }
                                                                                    @endphp

                                                                                    <button type="button"
                                                                                        class="btn btn-primary"
                                                                                        id="previewButton"
                                                                                        onclick="showLampiranEdit('{{ $base64PDF }}','{{ $simbg->id }}')">
                                                                                        Preview
                                                                                    </button>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="form-group mb-3">
                                                                                <label for="email"
                                                                                    class="mb-3">Note</label>
                                                                                <textarea name="note" class="form-control" id="">{{ $simbg->note }}</textarea>
                                                                            </div>

                                                                            <div
                                                                                class="form-group mb-3">
                                                                                <label for="email"
                                                                                    class="mb-3">Status</label>
                                                                                <select name="status"
                                                                                    class="form-control" id="">
                                                                                    <option value="1"
                                                                                        {{ $simbg->status == 1 ? 'selected' : '' }}>
                                                                                        On Progress</option>
                                                                                    <option value="2"
                                                                                        {{ $simbg->status == 2 ? 'selected' : '' }}>
                                                                                        Done</option>
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

                                                        <button class="btn btn-sm btn-icon"
                                                            onclick="confirmDelete('{{ route('simbg.project.destroy', ['id_project' => $proj->id, 'id' => $simbg->id]) }}')">
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

    <!-- Modal for PDF Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" width="100%" height="600px"></iframe>
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
        function toggleDocumentForm() {
            var select = document.getElementById("progress");
            var selectedOption = select.options[select.selectedIndex];
            var documentForm = document.getElementById("documentForm");
            var lampiran = document.getElementById("lampiran");

            if (selectedOption.getAttribute("data-name") === "Izin Pengambilan Document") {
                documentForm.style.display = "block";
                lampiran.setAttribute("required", "required");
            } else {
                documentForm.style.display = "none";
                lampiran.removeAttribute("required");
            }
        }

        function toggleDocumentFormEdit(id) {
            var select = document.getElementById("progres-" + id);
            var selectedOption = select.options[select.selectedIndex];
            var documentForm = document.getElementById("documentForm-" + id);
            var lampiran = document.getElementById("lampiran-" + id);

            if (selectedOption.getAttribute("data-name") === "Izin Pengambilan Document") {
                documentForm.style.display = "block";
                lampiran.setAttribute("required", "required");
            } else {
                documentForm.style.display = "none";
                lampiran.removeAttribute("required");
            }
        }

        // Memanggil toggleDocumentFormEdit saat offcanvas dibuka untuk mengatur ulang tampilan form
        document.querySelectorAll('[data-bs-toggle="offcanvas"]').forEach(function(button) {
            button.addEventListener('click', function() {
                var targetId = button.getAttribute('data-bs-target').replace('#edit-', '');
                toggleDocumentFormEdit(targetId);
            });
        });
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

        function showLampiranEdit(fileExist, id) {
            var file = $('#lampiran-' + id).prop('files')[0];

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
