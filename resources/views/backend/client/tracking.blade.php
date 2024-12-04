{{-- @extends('backend.layouts-new.app') --}}
@extends('backend.layouts-client.app')

@section('content')
<style>
     .row{
            width: 100%;
    }
    .buttons-collection{
        height: 70%;
        margin-top: 5%;
        margin-left: 15%;
    }
    .card-header{
        padding-top: 0;
        padding-bottom: 0;
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
        @include('backend.pages.transaction.project.sidebar_client')
        <!--/ Customer Sidebar -->

        <!-- Customer Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Customer Pills -->
            {{-- @include('backend.pages.transaction.project.tabs') --}}
            <!-- Timeline Advanced-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <table id="" class="datatables-basic-client table border-top">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Date</th>
                                    <th>Progress</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalOverDue = 0;
                                @endphp
                                @foreach ($activity as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('l, j F Y') }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->content }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

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
