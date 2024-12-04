<div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- Customer-detail Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="customer-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    @if ($user->foto == null)
                        @php
                            $words = explode(' ', $user->name);
                            $initials = '';
                            foreach ($words as $word) {
                                $initials .= strtoupper($word[0]);
                            }
                            // return $initials;
                        @endphp
                        <span class="avatar-initial rounded-circle bg-label-primary"
                            style="    font-size: 43px;">{{ $initials }}</span>
                    @else
                        <img class="img-fluid rounded my-3" src="{{ asset('assets/img/team/' . $user->foto) }}"
                            height="110" width="110" alt="User avatar">
                    @endif
                    <div class="customer-info text-center">
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        @php
                            if ($user->id_divisi != null) {
                                $divisiV = \App\Models\Divisi::where('id', $user->id_divisi)->first();
                            }
                        @endphp
                        <span class="badge bg-label-secondary">{{ !empty($user->id_divisi) ? $divisiV->divisi : '-' }}</span>
                    </div>
                </div>
            </div>
            <h5 class="pb-2 border-bottom mb-4 mt-3"></h5>

            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <span class="fw-medium me-2">Fullname:</span>
                        <span>{{ $user->name }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">Whatsapp:</span>
                        <span>{{ $user->whatsapp ?? '-' }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">Email:</span>
                        <span>{{ $user->email ?? '-' }}</span>
                    </li>

                    <li class="mb-3">
                        <span class="fw-medium me-2">State:</span>
                        @php
                            $datastate = \App\Models\State::where('id', $user->id_state)->first();
                        @endphp
                        <span>{{ $datastate->state ?? '-' }}</span>
                    </li>
                    <li class="mb-3">
                        <span class="fw-medium me-2">City:</span>
                        @php
                            $datacty = \App\Models\City::where('id', $user->id_city)->first();
                        @endphp
                        <span>{{ $datacty->city ?? '-' }}</span>
                    </li>

                    <li class="mb-3">
                        <span class="fw-medium me-2">Status:</span>
                        @if ($user->status == 1)
                            <span class="badge bg-label-success">Active</span>
                        @else
                            <span class="badge bg-label-secondary">Inactive</span>
                        @endif
                    </li>
                </ul>

            </div>
        </div>
    </div>

</div>
