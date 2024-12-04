
<div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- Customer-detail Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="customer-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    @if ($cust->foto == null)
                        @php
                            $words = explode(' ', $cust->name);
                            $initials = '';
                            foreach ($words as $word) {
                                $initials .= strtoupper($word[0]);
                            }
                            // return $initials;
                        @endphp
                        <span class="avatar-initial rounded-circle bg-label-primary"
                            style="    font-size: 43px;">{{ $initials }}</span>
                    @else
                        <img class="img-fluid rounded my-3" src="{{ asset('assets/img/customer/' . $cust->foto) }}"
                            height="110" width="110" alt="User avatar">
                    @endif
                    <div class="customer-info text-center">
                        <h4 class="mb-1">{{ $cust->name }}</h4>
                        <small>No PO : {{ $po->no_po }}</small>
                    </div>
                </div>
            </div>

            <div class="info-container">
                <small class="d-block pt-4 border-top fw-normal text-uppercase text-muted my-3">DETAILS</small>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <span class="fw-medium me-2">Title:</span>
                        <span>{{ $proj->name_project }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">State:</span>
                        <span>{{ $statecust->state ?? '-' }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">City:</span>
                        <span>{{ $citycust->city ?? '-' }}</span>
                    </li>

                    <li class="mb-3">
                        @php
                            // PIN CUSTOMER 
                            $pin = $cust->pin_marketing;
                            $idPin = $cust->$pin;
                            $teamPin = \App\Models\Admin::where('id',$idPin)->first();
                        @endphp
                        <span class="fw-medium me-2">Marketing:</span>
                        {{-- <span>{{ $marketing->name }}</span> --}}
                        <span>{{ $teamPin->name ?? '-' }}</span>
                    </li>

                    <li class="mb-3">
                        <span class="fw-medium me-2">Start Date:</span>
                        <span>
                            {{ \Carbon\Carbon::parse($proj->start_date)->locale('id')->translatedFormat('l, j F Y') }}
                        </span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">Deadline:</span>
                        <span>
                            {{ \Carbon\Carbon::parse($proj->end_date)->locale('id')->translatedFormat('l, j F Y') }}
                        </span>
                    </li>
                    @php
                        $start_date = \Carbon\Carbon::parse($proj->start_date);
                        $deadline = \Carbon\Carbon::parse($proj->deadline);
                        $remaining = $start_date->diffInDays($deadline, false); // false to get negative value if past
                    @endphp
                    <li class="mb-3">
                        <span class="fw-medium me-2">Remaining:</span>
                        <span>{{ $remaining }} day</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">Progress:</span>
                        <span>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ getProgresPercentageProject($proj->id) }}%;" aria-valuenow="{{ getProgresPercentageProject($proj->id) }}"
                                    aria-valuemin="0" aria-valuemax="100">{{ getProgresPercentageProject($proj->id) }} %</div>
                            </div>
                        </span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">Created Date:</span>
                        <span>{{ \Carbon\Carbon::parse($proj->created_date)->locale('id')->translatedFormat('l, j F Y') }}</span>
                    </li>

                    <li class="mb-3">
                        <span class="fw-medium me-2">Status:</span>
                        @if (getProgresPercentageProject($proj->id) < 100)
                            @if (date('Y-m-d') > $proj->deadline)
                                <span class="badge bg-label-danger">Overdue</span>
                            @else
                                <span class="badge bg-label-warning">On Progress</span>
                            @endif
                        @else
                            <span class="badge bg-label-success">Done</span>
                        @endif
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="col-md-12mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Team</h5>
                <button class="btn btn-primary d-flex send-msg-btn" data-bs-toggle="offcanvas"
                    data-bs-target="#createTeam" aria-controls="offcanvasEnd">
                    <i class="bx bx-plus me-md-1 me-0"></i>
                    <span class="align-middle d-md-inline-block d-none">Add</span>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="createTeam"
                    aria-labelledby="offcanvasActivityAdd" aria-modal="true" role="dialog">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasActivityAdd" class="offcanvas-title">Add Team</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form action="{{ route('project.create.team', $proj->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                <div class="mb-4">
                                    <label class="form-label" for="customer">Team</label>
                                    <select id="list-customer" name="id_team" class=" form-select" required>
                                        <option value="">Select</option>
                                        @foreach ($team as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                                <button type="reset" class="btn bg-label-danger"
                                    data-bs-dismiss="offcanvas">Discard</button>
                            </div>
                            <input type="hidden"><input type="hidden"><input type="hidden"><input
                                type="hidden"><input type="hidden">
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Division</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_team as $lt)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar me-2">
                                            @php
                                                $words = explode(' ', $lt->name);
                                                $initialsTeam = '';
                                                foreach ($words as $word) {
                                                    $initialsTeam .= strtoupper($word[0]);
                                                }
                                                // return $initials;
                                            @endphp
                                            @if ($lt->foto == null)
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-primary">{{ $initialsTeam }}</span>
                                            @else
                                                <img src="{{ asset('assets/img/team/' . $lt->foto) }}"
                                                    alt="Avatar" class="rounded-circle">
                                            @endif
                                        </div>
                                        @php
                                            if ($lt->id_divisi != null) {
                                                $divisiV = \App\Models\Divisi::where(
                                                    'id',
                                                    $lt->id_divisi,
                                                )->first();
                                            }
                                        @endphp
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-truncate">{{ $lt->name }}</h6><small
                                                class="text-truncate text-muted">{{ $lt->no_tlp }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span
                                        class="badge bg-label-primary rounded-pill text-uppercase">{{ $divisiV->divisi }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Team Members -->
</div>