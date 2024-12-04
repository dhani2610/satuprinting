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
                        <div class="card-datatable table-responsive">
                            <table class="datatables-simply table border-top">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo In</th>
                                        <th>Photo Out</th>
                                        <th>Team</th>
                                        <th>Divison</th>
                                        <th>Date</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendance as $attend)
                                        <tr>
                                            <td>{{ $attend->no_attend }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center customer-name">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar me-2">
                                                            <a href="{{ asset('assets/img/absensi/' . $attend->foto_in) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('assets/img/absensi/' . $attend->foto_in) }}"
                                                                    alt="Avatar" class="rounded-circle">
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($attend->foto_out == null)
                                                    -
                                                @else
                                                    <div
                                                        class="d-flex justify-content-start align-items-center customer-name">
                                                        <div class="avatar-wrapper">
                                                            <div class="avatar me-2">
                                                                <a href="{{ asset('assets/img/absensi/' . $attend->foto_out) }}"
                                                                    target="_blank">

                                                                    <img src="{{ asset('assets/img/absensi/' . $attend->foto_out) }}"
                                                                        alt="Avatar" class="rounded-circle">
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $attend->name_user }}</td>
                                            <td>{{ $attend->divisi }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($attend->date)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>{{ $attend->time_in }}</td>
                                            <td>{{ $attend->time_out ?? '-' }}</td>
                                            <td>{{ $attend->note ?? '-' }}</td>
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
