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
            <div class="col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        @php
                            if ($certificate != null) {
                                // Path ke file PDF di direktori public
                                $pathToFile =
                                    public_path(
                                        'documents/certificate/',
                                    ) . $certificate->certificate;

                                // Cek apakah file ada
                                if (
                                    file_exists($pathToFile)
                                ) {
                                    // Baca file dan konversi ke base64
                                    $base64 = base64_encode(
                                        file_get_contents(
                                            $pathToFile,
                                        ),
                                    );
                                    // Format base64 untuk ditampilkan di iframe
                                    $base64PDF =
                                        'data:application/pdf;base64,' .
                                        $base64;
                                } else {
                                    // File tidak ditemukan, beri pesan kesalahan atau fallback
                                    $base64PDF = null;
                                }
                            }else{
                                $base64PDF = null;
                            }
                        @endphp
                        <iframe frameborder="0" scrolling="auto" id="certificate-show" height="600" width="100%" src="{{ $base64PDF }}"></iframe>
                        <div class="col-12 text-center mt-3">
                            <input class="btn btn-primary w-100 d-grid" accept=".pdf" type="file" id="formFile" onchange="uploadFile()">
                        </div>
                        <small class="text-success" style="color: green"></small>
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
        function showCreateButton(){
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

    <script>
        function uploadFile() {
            var fileInput = document.getElementById('formFile');
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('lampiran', file);
            console.log(formData);

            if (file) {
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    $('#certificate-show').attr('src', e.target.result);
                };
                fileReader.readAsDataURL(file);
            } else {
                alert('Please select a PDF file first.');
            }

            // Show success message
            var successMessage = document.querySelector('.text-success');
            successMessage.innerHTML = 'Please Wait saving data..';
            successMessage.style.display = 'block';
            
            fetch('{{ route('certificate.project.store', $proj->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    // Show success message
                    var successMessage = document.querySelector('.text-success');
                    successMessage.innerHTML = 'Certificate has been saved successfully';
                    successMessage.style.display = 'block';

                } else {
                    
                }
            })
            .catch(error => {
                // Swal.fire({
                //     icon: 'error',
                //     title: 'Error',
                //     text: 'An error occurred while saving the document.'
                // });
            });
        }
    </script>
@endsection
