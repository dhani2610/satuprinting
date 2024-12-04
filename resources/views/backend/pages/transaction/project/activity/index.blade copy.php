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
            <!-- Timeline Advanced-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="timeline pt-3">
                            @if ($documentations->count() > 0)
                            <li class="timeline-item pb-4 timeline-item-warning border-left-dashed">
                                <span class="timeline-indicator-advanced timeline-indicator-warning">
                                    <i class="bx bx-photo-album"></i>
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header border-bottom mb-3">
                                        <h6 class="mb-0">Documentation</h6>
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($documentations_last->created_at)->locale('id')->translatedFormat('l, j F Y') }}</span>
                                    </div>
                                    <div class="d-flex flex-sm-row flex-column">
                                        @foreach ($documentations as $doc)
                                            <img src="{{ asset('assets/img/documentation/' . ($doc->foto ?? '')) }}" class="rounded me-3" alt="Shoe img"
                                                height="auto" width="100">
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if ($certificate != null)
                            <li class="timeline-item pb-4 timeline-item-primary border-left-dashed">
                                <span class="timeline-indicator-advanced timeline-indicator-primary">
                                    <i class="bx bx-file"></i>
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header border-bottom mb-3">
                                        <h6 class="mb-0">Certificate</h6>
                                            <span class="text-muted">{{ \Carbon\Carbon::parse($certificate->created_at)->locale('id')->translatedFormat('l, j F Y') }}</span>
                                    </div>
                                    @if ($certificate == null)
                                        <p>
                                            Sertifikat belum di upload
                                        </p>
                                    @else
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
                                        
                                        $userCertificate = \App\Models\Admin::where('id',$certificate->created_by)->first();
                                    @endphp
                                        <p>
                                            Sertifikat berhasil di upload
                                        </p>
                                        <a href="javascript:void(0)" onclick="showLampiranEdit('{{ $base64PDF }}')">
                                            <i class="bx bx-link"></i>
                                            Certificate.pdf
                                        </a>
                                    @endif
                                    <hr>
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <div class="d-flex flex-wrap">
                                            <div class="avatar me-3">
                                                <img src="{{ asset('assets/img/team/' . $userCertificate->foto) }}" alt="Avatar"
                                                    class="rounded-circle">
                                            </div>
                                            <div>
                                                <p class="mb-0">{{ $userCertificate->name }}</p>
                                                <span class="text-muted">Project</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if (count($simbgs) > 0)
                            <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                <span class="timeline-indicator-advanced timeline-indicator-success">
                                    <i class="bx bx-message-square-check"></i>
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header border-bottom mb-3">
                                        <h6 class="mb-0">SIMBG</h6>
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($simbgs_last->created_at)->locale('id')->translatedFormat('l, j F Y') }}</span>
                                    </div>
                                    @foreach ($simbgs as $simbg)
                                        @php
                                            $category_v = \App\Models\Categorysimbg::where('id',$simbg->id_category)->first();
                                            $created_BY = \App\Models\Admin::where('id',$simbg->created_by)->first();
                                        @endphp
                                        <div>
                                            <span>{{ $category_v->category }}</span>
                                            <i class="bx bx-right-arrow-alt scaleX-n1-rtl mx-3"></i>
                                            <span>{{ $simbg->status == 1 ? 'Dalam Proses' : 'Sudah Berhasil' }}</span>
                                        </div>
                                    @endforeach
                                    <hr>
                                    <div class="d-flex flex-wrap">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <ul
                                                class="list-unstyled users-list d-flex align-items-center avatar-group m-0 my-3 me-2">
                                                @foreach ($simbgs->pluck('created_by')->unique() as $simbgctb)
                                                @php
                                                    $created_BY = \App\Models\Admin::where('id',$simbgctb)->first();
                                                @endphp
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                    aria-label="Vinnie Mostowy" data-bs-original-title="{{ $created_BY->name }}">
                                                    <img class="rounded-circle" src="{{ asset('assets/img/team/' . $created_BY->foto) }}"
                                                        alt="Avatar">
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div>
                                            @php
                                                $created_bylast = \App\Models\Admin::where('id',$simbgs_last->created_by)->first();
                                            @endphp
                                            <p class="mb-0">{{ $created_bylast->name }}</p>
                                            <span class="text-muted">Project</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if (count($kajians) > 0)
                                <li class="timeline-item pb-4 timeline-item-info border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-info">
                                        <i class="bx bx bx-spreadsheet"></i>
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            <h6 class="mb-0">Kajian</h6>
                                            <span class="text-muted">{{ \Carbon\Carbon::parse($kajians_last->created_at)->locale('id')->translatedFormat('l, j F Y') }}</span>
                                        </div>
                                        @foreach ($kajians as $kajian)
                                            @php
                                                $category_v = \App\Models\CategoryKajian::where('id',$kajian->id_category)->first();
                                            @endphp
                                            <p>
                                                {{$category_v->category}} {{ $kajian->status == 1 ? 'Dalam Proses' : 'Berhasil' }}
                                            </p>
                                        @endforeach
                                        <hr>
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <ul
                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 my-3 me-2">
                                                    @foreach ($kajians->pluck('created_by')->unique() as $kajianctb)
                                                    @php
                                                        $created_BY = \App\Models\Admin::where('id',$kajianctb)->first();
                                                    @endphp
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                        aria-label="Vinnie Mostowy" data-bs-original-title="{{ $created_BY->name }}">
                                                        <img class="rounded-circle" src="{{ asset('assets/img/team/' . $created_BY->foto) }}"
                                                            alt="Avatar">
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div>
                                                @php
                                                    $created_bylast = \App\Models\Admin::where('id',$kajians_last->created_by)->first();
                                                @endphp
                                                <p class="mb-0">{{ $created_bylast->name }}</p>
                                                <span class="text-muted">Project</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if (count($surveys) > 0)
                                <li class="timeline-item pb-4 timeline-item-dark border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-dark">
                                        <i class="bx bx-car"></i>
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            <h6 class="mb-0">Survey</h6>
                                            <span class="text-muted">{{ \Carbon\Carbon::parse($surveys_last->created_at)->locale('id')->translatedFormat('l, j F Y') }}</span>
                                        </div>
                                        <p>
                                            Sudah dilakukan survey lapangan
                                        </p>
                                        <hr>
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <ul
                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 my-3 me-2">
                                                    @foreach ($surveys->pluck('created_by')->unique() as $surveyctb)
                                                    @php
                                                        $created_BY = \App\Models\Admin::where('id',$surveyctb)->first();
                                                    @endphp
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                        aria-label="Vinnie Mostowy" data-bs-original-title="{{ $created_BY->name }}">
                                                        <img class="rounded-circle" src="{{ asset('assets/img/team/' . $created_BY->foto) }}"
                                                            alt="Avatar">
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div>
                                                @php
                                                    $created_bylast = \App\Models\Admin::where('id',$surveys_last->id_team)->first();
                                                @endphp
                                                {{-- @dd($surveys_last,$created_bylast) --}}
                                                <p class="mb-0">{{ $created_bylast->name ?? '-' }}</p>
                                                <span class="text-muted">Project</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if (count($document) > 0)
                                <li class="timeline-item pb-4 timeline-item-danger border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-danger">
                                        <i class="bx bxs-file-image"></i>
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            <h6 class="mb-0">Document</h6>
                                        </div>
                                        <div class="d-flex flex-sm-row flex-column">
                                            {{-- <img src="../../assets/img/ktp.jpg" class="rounded me-3" alt="Shoe img"
                                                height="62" width="100"> --}}
                                            @foreach ($document as $dc)
                                                @php
                                                    $cat = \App\Models\CategoryDocument::where('id',$dc->id_category)->first();
                                                @endphp
                                                <div class="">
                                                    <div class="timeline-header flex-wrap mb-2 mt-3 mt-sm-0">
                                                        <h6 class="mb-0">{{ $cat->category }}</h6>
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($dc->created_at)->locale('id')->translatedFormat('l, j F Y') }}</span>
                                                    </div>
                                                    <p>
                                                        {{ $cat->category }} Berhasil
                                                    </p>
                                                </div>
                                                <br>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <ul
                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 my-3 me-2">
                                                    @foreach ($document->pluck('created_by')->unique() as $dcb)
                                                        @if ($dcb != null)
                                                        @php
                                                            $created_BY = \App\Models\Admin::where('id',$dcb)->first();
                                                        @endphp
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                            aria-label="Vinnie Mostowy" data-bs-original-title="{{ $created_BY->name }}">
                                                            <img class="rounded-circle" src="{{ asset('assets/img/team/' . $created_BY->foto) }}"
                                                                alt="Avatar">
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div>
                                                @php
                                                    $created_bylast = \App\Models\Admin::where('id',$document_last->created_by)->first();
                                                @endphp
                                                <p class="mb-0">{{ $created_bylast->name ?? '-' }}</p>
                                                <span class="text-muted">Project</span>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            @endif
                            <li class="timeline-end-indicator">
                                <i class="bx bx-check-circle"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Timeline Advanced-->


        </div>
        <!--/ Customer Content -->
    </div>
     <!-- Modal for PDF Preview -->
     <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview</h5>
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
function showLampiranEdit(fileExist) {
    $('#pdfViewer').attr('src', fileExist);
    $('#previewModal').modal('show');
}
</script>
@endsection
