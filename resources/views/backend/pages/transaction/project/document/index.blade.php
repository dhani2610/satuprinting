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
                    <div class="card-body">
                        <div class="row">
                            @foreach ($categoryDocument as $category)
                                @php
                                    $cp = \App\Models\DocumentProject::where('id_project',$proj->id)->where('id_category',$category->id)->first();
                                @endphp
                               
                                @php
                                    if ($cp != null) {
                                        // Path ke file PDF di direktori public
                                        $pathToFile =
                                            public_path(
                                                'documents/project/',
                                            ) . $cp->file;
    
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
                                    }
                                @endphp
                                <div class="col-md mb-md-0 mb-2">
                                    <div class="form-check custom-option custom-option-image custom-option-image-radio checked">
                                        <label class="form-check-label custom-option-content" for="customRadioImg{{ $category->id }}">
                                            <span class="custom-option-body" data-bs-toggle="modal" data-bs-target="#modal{{ $category->id }}">
                                                <img src="{{ asset('assets/img/project/file-pdf.jpeg') }}" alt="radioImg">
                                            </span>
                                        </label>
                                        <input name="customRadioImage" class="form-check-input" type="radio" value="customRadioImg{{ $category->id }}" id="customRadioImg{{ $category->id }}" checked="">
                                        <input type="hidden" name="category_id" id="category_id_{{ $category->id }}" value="{{ $category->id }}" id="">
                                        <div class="text-center" style="padding: 10px;">
                                            @if ($cp != null)
                                            <button data-bs-toggle="modal" data-bs-target="#modal{{ $category->id }}" onclick="showLampiranEdit('{{ $base64PDF }}','{{ $category->id }}')" id="btn-category-{{ $category->id }}" class="btn {{ $cp != null ? 'btn-success' : ' btn-danger' }} d-grid w-100">
                                            @else
                                            <button data-bs-toggle="modal" data-bs-target="#modal{{ $category->id }}" id="btn-category-{{ $category->id }}" class="btn {{ $cp != null ? 'btn-success' : ' btn-danger' }} d-grid w-100">
                                            @endif
                                                <strong style="font-size: 18px;">{{ $category->category }}</strong>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Modal -->
                                <div class="modal fade" id="modal{{ $category->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">
                                        <div class="modal-content" style="padding: 20px;">
                                            <div class="modal-body p-2">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                                <div class="text-center">
                                                    <h3 class="mb-2">{{ $category->category }}</h3>
                                                </div>
                                                <div class="col-md-12 mb-4">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <iframe id="docPreview{{ $category->id }}" frameborder="0" scrolling="auto" height="450" width="100%" src=""></iframe>
                        
                                                            <div class="col-12 text-center mt-3">
                                                                <input class="btn btn-primary w-100 d-grid" type="file" id="formFile{{ $category->id }}" accept=".pdf" onchange="uploadFile({{ $category->id }})">
                                                            </div>
                                                            <small class="text-success-{{ $category->id }} " style="color: green"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let is_update = false;
    function closeModal(){
        if (is_update == true) {
            window.location.reload();
        }
    }
    function showLampiranEdit(fileExist, id) {
        $('#docPreview'+ id).attr('src', fileExist);
    }

    function uploadFile(categoryId) {
        var fileInput = document.getElementById('formFile' + categoryId);
        var category_id = document.getElementById('category_id_' + categoryId);
        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('lampiran', file);
        formData.append('category_id', category_id.value);
        console.log(formData);

        if (file) {
            var fileReader = new FileReader();
            fileReader.onload = function(e) {
                $('#docPreview'+ categoryId).attr('src', e.target.result);
            };
            fileReader.readAsDataURL(file);
        } else {
            alert('Please select a PDF file first.');
        }

         // Show success message
         var successMessage = document.querySelector('.text-success-' + categoryId);
        successMessage.innerHTML = 'Please Wait saving data..';
        successMessage.style.display = 'block';
        
        fetch('{{ route('project.document.store', $proj->id) }}', {
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
                var fileUrl = '{{asset('documents/project/')}}' + data.file;
                console.log(data.file);
                // document.getElementById('docPreview' + categoryId).src = fileUrl;

                // Show success message
                var successMessage = document.querySelector('.text-success-' + categoryId);
                successMessage.innerHTML = 'Document has been saved successfully';
                successMessage.style.display = 'block';

                is_update = true;

                // // Hide success message after 3 seconds
                // setTimeout(function() {
                //     successMessage.style.display = 'none';
                //     window.location.reload();

                // }, 3000);

                // Change button background color
                var button = document.querySelector('.btn-category-' + categoryId);
                button.style.backgroundColor = '#71dd37';
                button.style.setProperty('background-color', '#71dd37', 'important');


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
