
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
                        <span class="fw-medium me-2">Marketing:</span>
                        <span>{{ $marketing->name }}</span>
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

</div>