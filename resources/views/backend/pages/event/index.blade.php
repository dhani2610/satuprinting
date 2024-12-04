@extends('backend.layouts-new.app')

@section('content')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/fullcalendar/fullcalendar.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-calendar.css')}}" />
@include('backend.layouts.partials.messages')

<div class="card app-calendar-wrapper">
    <div class="row g-0">
        <!-- Calendar Sidebar -->
        <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
            <div class="border-bottom p-4 my-sm-0 mb-3">
                <div class="d-grid">
                    @if (Auth::guard('admin')->user()->can('calendar.create'))
                    <button class="btn btn-primary btn-toggle-sidebar" onclick="addDataEvent()" data-bs-toggle="offcanvas" data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
                        <i class="bx bx-plus me-1"></i>
                        <span class="align-middle">Add Event</span>
                    </button>
                    @endif
                </div>
            </div>
            <div class="p-4">
                <!-- inline calendar (flatpicker) -->
                <div class="ms-n2">
                    <div class="inline-calendar"></div>
                </div>

                <hr class="container-m-nx my-4">

                <!-- Filter -->
                <div class="mb-4">
                    <small class="text-small text-muted text-uppercase align-middle">Filter</small>
                </div>

                <form id="event-filter-form" method="GET" action="">
                    @csrf
                    <div class="form-check mb-2">
                        <input class="form-check-input select-all" type="checkbox" id="selectAll" name="all" data-value="all" checked>
                        <label class="form-check-label" for="selectAll">View All</label>
                    </div>
                
                    <div class="app-calendar-events-filter">
                        <div class="form-check form-check-danger mb-2">
                            <input class="form-check-input input-filter" type="checkbox" id="select-personal" name="personal" value="personal" data-value="personal" checked>
                            <label class="form-check-label" for="select-personal">Personal</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input input-filter" type="checkbox" id="select-business" name="business" value="business" data-value="business" checked>
                            <label class="form-check-label" for="select-business">Business</label>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <!-- /Calendar Sidebar -->

        <!-- Calendar & Modal -->
        <div class="col app-calendar-content">
            <div class="card shadow-none border-0">
                <div class="card-body pb-0">
                    <!-- FullCalendar -->
                    <div id="calendar"></div>
                </div>
            </div>
            <div class="app-overlay"></div>
            <!-- FullCalendar Offcanvas -->
            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar" aria-labelledby="addEventSidebarLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title mb-2" id="addEventSidebarLabel">Add Event</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form class="event-form pt-0" method="POST" action="{{ route('event.store') }}">
                        @csrf
                    {{-- <form class="event-form pt-0" id="eventForm" onsubmit="return false"> --}}
                        <div class="mb-3">
                            <label class="form-label" for="eventTitle">Title</label>
                            <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Event Title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Label</label>
                            <select class="select2 select-event-label form-select" id="eventLabel" name="eventLabel" required>
                                <option data-label="primary" value="Business" selected="">Business</option>
                                <option data-label="danger" value="Personal">Personal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventStartDate">Start Date</label>
                            <input type="text" class="form-control" id="eventStartDate" name="eventStartDate" placeholder="Start Date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventEndDate">End Date</label>
                            <input type="text" class="form-control" id="eventEndDate" name="eventEndDate" placeholder="End Date" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="switch">
                                <input type="checkbox" name="allday" class="switch-input allDay-switch">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label">All Day</span>
                            </label>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label" for="eventURL">Event URL</label>
                            <input type="url" class="form-control" id="eventURL" name="eventURL" placeholder="https://www.google.com" >
                        </div>
                        <div class="mb-3 select2-primary">
                            <label class="form-label" for="eventGuests">Add Guests</label>
                            <select class="select2 select-event-guests form-select" id="eventGuests" name="eventGuests[]" multiple="" >
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLocation">Location</label>
                            <input type="text" class="form-control" id="eventLocation" name="eventLocation" placeholder="Enter Location" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventDescription">Description</label>
                            <textarea class="form-control" name="eventDescription" id="eventDescription" required></textarea>
                        </div>
                        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                            <div>
                                <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1" data-bs-dismiss="offcanvas">Cancel</button>
                            </div>
                            <div><button type="button" class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         
    </div>
</div>
@endsection



@section('script')
<script src="{{asset('assets/vendor/libs/fullcalendar/fullcalendar.js')}}"></script>
@include('backend.pages.event.script-event')
<script>

    function addDataEvent() {
        offcanvasTitle = document.querySelector('.offcanvas-title'),
        btnToggleSidebar = document.querySelector('.btn-toggle-sidebar'),
        btnSubmit = document.querySelector('button[type="submit"]'),
        btnDeleteEvent = document.querySelector('.btn-delete-event'),
        btnCancel = document.querySelector('.btn-cancel'),
        eventTitle = document.querySelector('#eventTitle'),
        eventStartDate = document.querySelector('#eventStartDate'),
        eventEndDate = document.querySelector('#eventEndDate'),
        eventUrl = document.querySelector('#eventURL'),
        eventLabel = $('#eventLabel'), // ! Using jquery vars due to select2 jQuery dependency
        eventGuests = $('#eventGuests'), // ! Using jquery vars due to select2 jQuery dependency
        eventLocation = document.querySelector('#eventLocation'),
        eventDescription = document.querySelector('#eventDescription'),
        allDaySwitch = document.querySelector('.allDay-switch'),
    
        eventEndDate.value = '';
        eventUrl.value = '';
        eventStartDate.value = '';
        eventTitle.value = '';
        eventLocation.value = '';
        allDaySwitch.checked = false;
        eventGuests.val('').trigger('change');
        eventDescription.value = '';
    
        offcanvasTitle.innerHTML = 'Add Event';
        btnSubmit.innerHTML = 'Add';
        btnSubmit.classList.remove('btn-update-event');
        btnSubmit.classList.add('btn-add-event');
        btnDeleteEvent.classList.add('d-none');
    
    }
</script>

@endsection
