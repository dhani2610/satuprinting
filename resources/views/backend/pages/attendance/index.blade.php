@extends('backend.layouts-new.app')

@section('content')
    <style>
        .create-new {
            display: none;
        }
    </style>
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>All Attendance</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ count($attendance) }} </h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-time-five bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Division</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ count($divisi_count) }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-briefcase bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Team</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ count($team_count) }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-user bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Late</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $late_count }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-timer bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users List Table -->
    <div class="card mb-3">
        <div class="card-header border-bottom">
            <h5 class="card-title">Filter</h5>
            <form action="" method="get" id="filter-form">
                @csrf
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    <div class="col-md-4 attendance_division">
                        <select id="divisionFilter" name="divisi" class="form-select text-capitalize"
                            fdprocessedid="ls81at" onchange="$('#filter-form').submit()">
                            <option value=""> All Division </option>
                            @foreach ($divisi as $dv)
                                <option value="{{ $dv->id }}"
                                    {{ Request::get('divisi') == $dv->id ? 'selected' : '' }}>
                                    {{ $dv->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 attendance_team">
                        <select id="teamFilter" name="team" class=" form-select text-capitalize" fdprocessedid="dzgave"
                            onchange="$('#filter-form').submit()">
                            <option value=""> All Team </option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ Request::get('team') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 attendance_date">
                        <input type="text" id="bs-rangepicker-dropdown" class="bs-rangepicker-dropdown form-control"
                            value="{{ Request::get('date') }}" name="date" />

                    </div>
                    {{-- <div class="col-md-3 attendance_status"><select id="attendance_status" class="form-select text-capitalize"
                        fdprocessedid="hz3owp">
                        <option value=""> Select Status </option>
                        <option value="in"> Clock In </option>
                        <option value="in"> Clock Out </option>
                    </select>
                </div> --}}
                </div>
            </form>
        </div>
    </div>
    <!-- customers List Table -->
    <div class="card">

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
                                    <div class="d-flex justify-content-start align-items-center customer-name">
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
@endsection


@section('script')
    <script>
        function showCapture(fileExist) {
            console.log(fileExist);
            $('#previewModal').show('modal');
            $('#pdfViewer').attr('src', fileExist);
        }


        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('filter-form');

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('applyBtn')) {
                    console.log('apply');
                    var form = document.getElementById('filter-form');
                    form.submit();
                }
            });

        });
    </script>
@endsection
