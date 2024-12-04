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
                <div class="card ">
                    <div class="card-body m-0 p-0">
                        <button class="btn btn-primary text-white d-none buttonCreate" type="button"
                            data-bs-toggle="offcanvas" style="float: right" data-bs-target="#create"
                            aria-controls="offcanvasEnd">
                            Create</button>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="create"
                            aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                            <div class="offcanvas-header">
                                <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Survey</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('survey.project.store', $proj->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                        <div class="form-row">
                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                <label for="name" class="mb-3">Team</label>
                                                <select id="list-customer" name="id_team[]" multiple
                                                    class="select2 form-select" required>
                                                    <option value="">Select</option>
                                                    @foreach ($list_team as $tc)
                                                        <option value="{{ $tc->id }}">{{ $tc->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                <label for="email" class="mb-3">Photo</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control" id="lampiran" name="photo"
                                                        required value="" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 mb-3">
                                                <label for="email" class="mb-3">Note</label>
                                                <textarea name="note" class="form-control" id="" cols="5" rows="5" required></textarea>
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
                                            <th>Team</th>
                                            <th>Note</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            {{-- <th>Photo</th> --}}
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($surveys as $survey)
                                            <tr>
                                                @php
                                                    $getteam = \App\Models\TeamSurvey::where(
                                                        'id_survey',
                                                        $survey->id,
                                                    )->get();
                                                    $created_BY = \App\Models\Admin::where(
                                                        'id',
                                                        $survey->created_by,
                                                    )->first();

                                                    $gabungTitle = '';
                                                    $detailCount = count($getteam);
                                                    foreach ($getteam as $key => $gt) {
                                                        $teamS = \App\Models\Admin::where('id', $gt->id_team)->first();
                                                        $gabungTitle .= $teamS->name;
                                                        if ($key < $detailCount - 1) {
                                                            $gabungTitle .= ',';
                                                        }
                                                    }
                                                @endphp
                                                <td>{{ $survey->no_survey }}</td>
                                                <td>{{ $gabungTitle }}</td>
                                                <td>{{ $survey->note }}</td>
                                                <td>{{ $created_BY->name }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($survey->created_at)->locale('id')->translatedFormat('l, j F Y') }}
                                                </td>
                                                <td>
                                                <div class="d-inline-block text-nowrap">
                                                    <button class="btn btn-sm btn-icon" onclick="showLampiranEdit('{{ asset('assets/img/photo-survey/' . $survey->photo) }}','{{ $survey->id }}')"
                                                        data-bs-original-title="Photo Survey">
                                                        <i class='bx bx-camera'></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="offcanvas"
                                                        data-bs-target="#edit-{{ $survey->id }}"
                                                        aria-controls="offcanvasEnd">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <div class="offcanvas offcanvas-end" tabindex="-1"
                                                        id="edit-{{ $survey->id }}" aria-labelledby="offcanvasActivityAdd"
                                                        aria-modal="true" role="dialog">
                                                        <div class="offcanvas-header">
                                                            <h5 id="offcanvasActivityAdd" class="offcanvas-title">Edit
                                                                Survey - {{ $survey->no_survey }}</h5>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body mx-0 flex-grow-0">
                                                            <form
                                                                action="{{ route('survey.project.update', ['id_project' => $proj->id, 'id' => $survey->id]) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                            <label for="name"
                                                                                class="mb-3">Team</label>
                                                                            <select id="list-customer" name="id_team[]"
                                                                                multiple class="select2 form-select"
                                                                                required>
                                                                                <option value="">Select</option>
                                                                                @foreach ($list_team as $tc)
                                                                                    <option value="{{ $tc->id }}"
                                                                                        {{ in_array($tc->id, $getteam->pluck('id_team')->toArray()) ? 'selected' : '' }}
                                                                                        {{ $survey->id_team == $tc->id ? 'selected' : '' }}>
                                                                                        {{ $tc->name }}
                                                                                    </option>
                                                                                @endforeach

                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                            <label for="email"
                                                                                class="mb-3">Photo</label>
                                                                            <div class="input-group">
                                                                                <input type="file" class="form-control"
                                                                                    id="lampiran-{{ $survey->id }}"
                                                                                    name="photo" value=""
                                                                                    accept="image/*">
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    id="previewButton"
                                                                                    onclick="showLampiranEdit('{{ asset('assets/img/photo-survey/' . $survey->photo) }}','{{ $survey->id }}')">
                                                                                    Preview
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-12 col-sm-12 mb-3">
                                                                            <label for="email"
                                                                                class="mb-3">Note</label>
                                                                            <textarea name="note" class="form-control" id="" cols="5" rows="5">{{ $survey->note }}</textarea>
                                                                        </div>
                                                                    </div>


                                                                </div>

                                                                <div class="pt-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                                                                    <button type="reset" class="btn bg-label-secondary"
                                                                        data-bs-dismiss="offcanvas">Cancel</button>
                                                                </div>
                                                                <input type="hidden"><input type="hidden"><input
                                                                    type="hidden"><input type="hidden"><input
                                                                    type="hidden">
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-sm btn-icon"
                                                        onclick="confirmDelete('{{ route('survey.project.destroy', ['id_project' => $proj->id, 'id' => $survey->id]) }}')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
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
                    <h5 class="modal-title" id="previewModalLabel">Photo Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <iframe id="pdfViewer" src="" width="100%" height="600px"></iframe>
                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
                alert('Please select a Photo file first.');
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
                    alert('Please select a Photo file first.');
                }
            }

        }

        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>
@endsection
