@extends('backend.layouts-new.app')

@section('content')
    <style>
        .create-new {
            display: none;
        }
    </style>
    @include('backend.layouts.partials.messages')

    <div class="row">
        <!-- Customer-detail Sidebar -->
        @include('backend.pages.profile.partials.sidebar')
        <!--/ Customer Sidebar -->

        <!-- Customer Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Customer Pills -->
            @include('backend.pages.profile.partials.tabs')
            <!-- Timeline Advanced-->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <div class="card-datatable table-responsive">
                            <table id="dataTable" class="datatables-simply table border-top">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Number</th>
                                        <th>Title</th>
                                        <th>Customer</th>
                                        <th>Project</th>
                                        <th>Team</th>
                                        <th>Division</th>
                                        <th>Date Time</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignment as $asg)
                                        <tr>
                                            @php
                                                $cust = \App\Models\Admin::where('id', $asg->id_customer)->first();
                                                $user = \App\Models\Admin::where('id', $asg->id_user)->first();
                                                $div = \App\Models\Divisi::where('id', $user->id_divisi)->first();
                                            @endphp
                                            <td>{{ $asg->no_assignment }}</td>
                                            <td>{{ $asg->tujuan ?? '-' }}</td>
                                            <td>{{ $cust->name ?? '-' }}</td>
                                            @if ($asg->id_project != null)
                                                @php
                                                    $proj = \App\Models\Project::where('id', $asg->id_project)->first();
                                                @endphp
                                                <td>{{ $proj->name_project . ' | ' . $proj->no_project }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ $user->name ?? '-' }}</td>
                                            <td>{{ $div->divisi ?? '-' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($asg->tanggal)->locale('id')->translatedFormat('l, j F Y') }}
                                                | {{ $asg->time_start }} - {{ $asg->time_end }}
                                            </td>
                                            <td>{{ $asg->note }}</td>
                                            <td>
                                                @if ($asg->status == 1)
                                                    <span class="badge bg-label-warning">Waiting</span>
                                                @elseif ($asg->status == 2)
                                                    <span class="badge bg-label-success">Approve</span>
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
            <!-- /Timeline Advanced-->


        </div>
        <!--/ Customer Content -->
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
