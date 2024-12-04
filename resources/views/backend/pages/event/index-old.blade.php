@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important
        }

        label {
            float: left;
        }

        .today {
            background: #38b6ff !important;
        }

        .fc-prev-button {
            background: none !important;
            border: none !important;
            box-shadow: none !important;
        }

        .fc-next-button {
            background: none !important;
            border: none !important;
            box-shadow: none !important;
        }
        .fc-state-highlight{
            background: #38b6ff;
        }
        .select2-primary .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: rgb(3 169 244 / 25%) !important;
            color: #38b6ff !important;
            border: none;
        }
     
        .fc-day-grid-event {
            background: #38b6ff5e!important;
            color: #38b6ff!important;
            padding: 4px!important;
            border: none!important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css"
        rel="stylesheet" />

    <div class="main-content-inner">
        @include('backend.layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3" style="padding: 0;">
                                @if (Auth::guard('admin')->user()->can('calendar.create'))
                                    <button style="width:100%"
                                            class="btn btn-primary"
                                            type="button"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#create"
                                            aria-controls="offcanvasEnd">
                                            <i class="bx bx-plus me-1"></i>
                                            Create Event
                                    </button>
                                    <hr>
                                    <div
                                        class="offcanvas offcanvas-end"
                                        tabindex="-1"
                                        id="create"
                                        aria-labelledby="offcanvasEndLabel">
                                        <div class="offcanvas-header">
                                            <h5 id="offcanvasEndLabel" class="offcanvas-title">Create Event</h5>
                                            <button
                                            type="button"
                                            class="btn-close text-reset"
                                            data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                            <form method="POST" action="{{ route('event.store') }}">
                                                @csrf
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="eventTitle">Title</label>
                                                    <input type="text" class="form-control" id="eventTitle"
                                                        name="eventTitle" placeholder="Event Title">
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="eventStartDate">Start
                                                        Date</label>
                                                    <input type="datetime-local" class="form-control flatpickr-input"
                                                        id="eventStartDate" name="eventStartDate"
                                                        placeholder="Start Date" >
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="mb-3 fv-plugins-icon-container">
                                                    <label class="form-label" for="eventEndDate">End Date</label>
                                                    <input type="datetime-local" class="form-control flatpickr-input"
                                                        id="eventEndDate" name="eventEndDate" placeholder="End Date"
                                                        >
                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="eventURL">Event URL</label>
                                                    <input type="url" class="form-control" id="eventURL"
                                                        name="eventURL" placeholder="https://www.google.com">
                                                </div>
                                                <div class="mb-3 select2-primary">
                                                    <label class="form-label" for="eventGuests">Add Guests</label>
                                                    <select class="select2 select-event-guests form-select" id="eventGuests" name="eventGuests[]" multiple>
                                                        @foreach ($user as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="eventLocation">Location</label>
                                                    <input type="text" class="form-control" id="eventLocation"
                                                        name="eventLocation" placeholder="Enter Location">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="eventDescription">Description</label>
                                                    <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                                </div>
                                                <div
                                                    class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                                    <div>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                                        <button type="reset"
                                                            class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                                            data-bs-dismiss="offcanvas">Cancel</button>
                                                    </div>
                                                    <div><button
                                                            class="btn btn-label-danger btn-delete-event d-none">Delete</button>
                                                    </div>
                                                </div>
                                                <input type="hidden">
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                <center>
                                    <div id="calendar-flat"></div>
                                </center>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="container-calendar" style="width: 100%;">
                                        <div id='calendar' style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($event as $cal)
                                <button style="width:100%" 
                                        class="btn btn-primary d-none"
                                        type="button"
                                        id="edit-event-{{ $cal->id }}"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#edit-{{ $cal->id }}"
                                        aria-controls="offcanvasEnd">
                                        <i class="bx bx-plus me-1"></i>
                                        Edit Event
                                </button>
                                <div
                                    class="offcanvas offcanvas-end"
                                    tabindex="-1"
                                    id="edit-{{ $cal->id }}"
                                    aria-labelledby="offcanvasEndLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasEndLabel" class="offcanvas-title">Edit Event</h5>
                                        <button
                                        type="button"
                                        class="btn-close text-reset"
                                        data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                        <form method="POST" action="{{ route('event.update',$cal->id) }}">
                                            @csrf
                                            <div class="mb-3 fv-plugins-icon-container">
                                                <label class="form-label" for="eventTitle">Title</label>
                                                <input type="text" class="form-control" id="eventTitle"
                                                    name="eventTitle" placeholder="Event Title" value="{{ $cal->title }}">
                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="mb-3 fv-plugins-icon-container">
                                                <label class="form-label" for="eventStartDate">Start
                                                    Date</label>
                                                <input type="datetime-local" class="form-control flatpickr-input"
                                                    id="eventStartDate" name="eventStartDate"
                                                    placeholder="Start Date" value="{{ $cal->start_date }}" >
                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="mb-3 fv-plugins-icon-container">
                                                <label class="form-label" for="eventEndDate">End Date</label>
                                                <input type="datetime-local" class="form-control flatpickr-input"
                                                    id="eventEndDate" name="eventEndDate" placeholder="End Date" value="{{ $cal->end_date }}"
                                                    >
                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventURL">Event URL</label>
                                                <input type="url" class="form-control" id="eventURL" value="{{ $cal->event_url }}"
                                                    name="eventURL" placeholder="https://www.google.com">
                                            </div>
                                            <div class="mb-3 select2-primary">
                                                <label class="form-label" for="eventGuests">Add Guests</label>
                                                @php
                                                    $guestEvent = \App\Models\GuestEvent::where('id_event',$cal->id)->get()->pluck('id_user');
                                                @endphp
                                                <select id="multicol-country" class="select2 select-event-guests form-select" id="eventGuests" name="eventGuests[]" multiple>
                                                    @foreach ($user as $item)
                                                        <option value="{{ $item->id }}" @if(in_array($item->id, $guestEvent->toArray())) selected @endif>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="eventLocation">Location</label>
                                                <input type="text" class="form-control" id="eventLocation"
                                                    name="eventLocation" placeholder="Enter Location" value="{{ $cal->location }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="eventDescription">Description</label>
                                                <textarea class="form-control" name="eventDescription" id="eventDescription">{{ $cal->description }}</textarea>
                                            </div>
                                            <div
                                                class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-add-event me-sm-3 me-1">Save</button>
                                                    <button type="reset"
                                                        class="btn btn-secondary btn-cancel me-sm-0 me-1"
                                                        data-bs-dismiss="offcanvas">Cancel</button>
                                                </div>
                                                <div><button
                                                        class="btn btn-danger btn-delete-event">Delete</button>
                                                </div>
                                            </div>
                                            <input type="hidden">
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('script')
    <!-- Load jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
    <script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale-all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.nl.min.js">
    </script>




    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $(document).ready(function() {


            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '{{ date('Y-m-d') }}',
                dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                dayNamesShort: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                    'Saturday'
                ],
                // navLinks: true, // can click day/week names to navigate views
                // editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    @foreach ($event as $calendar)
                        {
                            id_event: '{{ $calendar->id }}',
                            created_by: '{{ $calendar->created_by }}',
                            title: '{{ $calendar->title }}',
                            start: '{{ $calendar->start_date }}',
                            end: '{{ $calendar->end_date }}',
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    console.log(info);
                    $('#edit-event-'+info.id_event).trigger('click');

                }
            });

            $('#calendar-flat').datepicker({
                language: "en",
                calendarWeeks: true,
                todayHighlight: true
            });


        });
    </script>
@endsection
