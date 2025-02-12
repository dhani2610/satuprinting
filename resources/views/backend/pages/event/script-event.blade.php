<script>
    const loggedInUserId = @json(Auth::guard('admin')->user()->id);

    let date = new Date();
    let nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
    // prettier-ignore
    let nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date
        .getMonth() + 1, 1);
    // prettier-ignore
    let prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date
        .getMonth() - 1, 1);

    window.events = [
        @foreach ($event as $calendar)
            {
                id: '{{ $calendar->id }}',
                // url: '{{ $calendar->event_url }}',
                title: '{{ $calendar->title }}',
                start: '{{ $calendar->start_date }}',
                end: '{{ $calendar->end_date }}',
                created_by: '{{ $calendar->created_by }}',
                allDay: '{{ $calendar->allday == 1 ? 'true' : 'false' }}',
                extendedProps: {
                    calendar: '{{ $calendar->eventLabel }}',
                    created_by: '{{ $calendar->created_by }}',
                }
            },
        @endforeach
    ];

    let direction = 'ltr';

    if (isRtl) {
        direction = 'rtl';
    }



    document.addEventListener('DOMContentLoaded', function() {
        (function() {
            const calendarEl = document.getElementById('calendar'),
                appCalendarSidebar = document.querySelector('.app-calendar-sidebar'),
                addEventSidebar = document.getElementById('addEventSidebar'),
                appOverlay = document.querySelector('.app-overlay'),
                calendarsColor = {
                    Business: 'primary',
                    Personal: 'danger',
                },
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
                selectAll = document.querySelector('.select-all'),
                filterInput = [].slice.call(document.querySelectorAll('.input-filter')),
                inlineCalendar = document.querySelector('.inline-calendar');
            console.log(selectAll);

            let eventToUpdate,
                currentEvents =
                events, // Assign app-calendar-events.js file events (assume events from API) to currentEvents (browser store/object) to manage and update calender events
                isFormValid = false,
                inlineCalInstance;

            // Init event Offcanvas
            const bsAddEventSidebar = new bootstrap.Offcanvas(addEventSidebar);

            //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
            // Event Label (select2)
            if (eventLabel.length) {
                function renderBadges(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var $badge =
                        "<span class='badge badge-dot bg-" + $(option.element).data('label') + " me-2'> " +
                        '</span>' + option.text;

                    return $badge;
                }
                eventLabel.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select value',
                    dropdownParent: eventLabel.parent(),
                    templateResult: renderBadges,
                    templateSelection: renderBadges,
                    minimumResultsForSearch: -1,
                    escapeMarkup: function(es) {
                        return es;
                    }
                });
            }

            // Event Guests (select2)
            if (eventGuests.length) {
                function renderGuestAvatar(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var $avatar =
                        "<div class='d-flex flex-wrap align-items-center'>" +
                        "<div class='avatar avatar-xs me-2'>" +
                        "<img src='" +
                        assetsPath +
                        'img/avatars/' +
                        $(option.element).data('avatar') +
                        "' alt='avatar' class='rounded-circle' />" +
                        '</div>' +
                        option.text +
                        '</div>';

                    return $avatar;
                }
                eventGuests.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select value',
                    dropdownParent: eventGuests.parent(),
                    closeOnSelect: false,
                    templateResult: renderGuestAvatar,
                    templateSelection: renderGuestAvatar,
                    escapeMarkup: function(es) {
                        return es;
                    }
                });
            }

            // Event start (flatpicker)
            if (eventStartDate) {
                var start = eventStartDate.flatpickr({
                    enableTime: true,
                    altFormat: 'Y-m-dTH:i:S',
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }
                    }
                });
            }

            // Event end (flatpicker)
            if (eventEndDate) {
                var end = eventEndDate.flatpickr({
                    enableTime: true,
                    altFormat: 'Y-m-dTH:i:S',
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }
                    }
                });
            }

            // Inline sidebar calendar (flatpicker)
            if (inlineCalendar) {
                inlineCalInstance = inlineCalendar.flatpickr({
                    monthSelectorType: 'static',
                    inline: true
                });
            }

            // Event click function
            function eventClick(info) {
                var eventToUpdate = info.event;
                if (eventToUpdate.url) {
                    info.jsEvent.preventDefault();
                    window.open(eventToUpdate.url, '_blank');
                }

                bsAddEventSidebar.show();
                if (offcanvasTitle) {
                    offcanvasTitle.innerHTML = 'Update Event';
                }
                btnSubmit.innerHTML = 'Update';
                btnSubmit.classList.add('btn-update-event');
                btnSubmit.classList.remove('btn-add-event');
                btnDeleteEvent.classList.remove('d-none');




                // Fetch event data using AJAX
                $.ajax({
                    url: '{{ route('get-event', '') }}/' + eventToUpdate.id,
                    method: 'GET',
                    success: function(response) {
                        // Populate the form with the event data
                        $('.event-form').attr('action', '{{ url('admin/event/update') }}/' +
                            response.event.id);
                        $('#eventTitle').val(response.event.title);
                        $('#eventLabel').val(response.event.eventLabel).trigger('change');
                        $('#eventStartDate').val(response.event.start_date);
                        $('#eventEndDate').val(response.event.end_date);
                        if (response.event.allday) {
                            $('.allDay-switch').prop('checked', true);
                        } else {
                            $('.allDay-switch').prop('checked', false);
                        }
                        $('#eventURL').val(response.event.event_url);
                        $('#eventLocation').val(response.event.location);
                        $('#eventDescription').val(response.event.description);

                        var guestIds = response.guest.map(guest => guest.id_user);
                        $('#eventGuests').val(guestIds).trigger('change');

                        console.log('ud user', loggedInUserId, response.event.created_by);
                        // Check if the event's creator is not the logged-in user
                        if (response.event.created_by !== loggedInUserId) {
                            btnSubmit.classList.add('d-none');
                            btnDeleteEvent.classList.add('d-none');
                        } else {
                            btnSubmit.classList.remove('d-none');
                            btnDeleteEvent.classList.remove('d-none');
                        }

                    }
                });

                btnDeleteEvent.addEventListener('click', function() {
                    removeEvent(eventToUpdate.id);
                    bsAddEventSidebar.hide();
                });
            }



            // Modify sidebar toggler
            function modifyToggler() {
                const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
                fcSidebarToggleButton.classList.remove('fc-button-primary');
                fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
                while (fcSidebarToggleButton.firstChild) {
                    fcSidebarToggleButton.firstChild.remove();
                }
                fcSidebarToggleButton.setAttribute('data-bs-toggle', 'sidebar');
                fcSidebarToggleButton.setAttribute('data-overlay', '');
                fcSidebarToggleButton.setAttribute('data-target', '#app-calendar-sidebar');
                fcSidebarToggleButton.insertAdjacentHTML('beforeend',
                    '<i class="bx bx-menu bx-sm text-heading"></i>');
            }

            // Filter events by calender
            function selectedCalendars() {
                let selected = [],
                    filterInputChecked = [].slice.call(document.querySelectorAll('.input-filter:checked'));

                filterInputChecked.forEach(item => {
                    selected.push(item.getAttribute('data-value'));
                    console.log('value');
                });

                return selected;
            }

            // --------------------------------------------------------------------------------------------------
            // AXIOS: fetchEvents
            // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
            // --------------------------------------------------------------------------------------------------
            function fetchEvents(info, successCallback) {
                let calendars = selectedCalendars();
                let selectedEvents = currentEvents.filter(function(event) {
                    return calendars.includes(event.extendedProps.calendar.toLowerCase());
                });
                successCallback(selectedEvents);
            }

            // Init FullCalendar
            // ------------------------------------------------
            let calendar = new Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: fetchEvents,
                plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
                editable: true,
                dragScroll: true,
                dayMaxEvents: 2,
                eventResizableFromStart: true,
                customButtons: {
                    sidebarToggle: {
                        text: 'Sidebar'
                    }
                },
                headerToolbar: {
                    start: 'sidebarToggle, prev,next, title',
                    end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                direction: direction,
                initialDate: new Date(),
                navLinks: true, // can click day/week names to navigate views
                eventClassNames: function({
                    event: calendarEvent
                }) {
                    const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
                    // Background Color
                    return ['fc-event-' + colorName];
                },
                dateClick: function(info) {
                    let date = moment(info.date).format('YYYY-MM-DD');
                    resetValues();
                    bsAddEventSidebar.show();

                    // For new event set offcanvas title text: Add Event
                    if (offcanvasTitle) {
                        offcanvasTitle.innerHTML = 'Add Event';
                    }
                    btnSubmit.innerHTML = 'Add';
                    btnSubmit.classList.remove('btn-update-event');
                    btnSubmit.classList.add('btn-add-event');
                    btnDeleteEvent.classList.add('d-none');
                    eventStartDate.value = date;
                    eventEndDate.value = date;
                },
                eventClick: function(info) {
                    eventClick(info);
                },
                datesSet: function() {
                    modifyToggler();
                },
                viewDidMount: function() {
                    modifyToggler();
                }
            });

            // Render calendar
            calendar.render();
            // Modify sidebar toggler
            modifyToggler();

            const eventForm = document.getElementById('eventForm');
            const fv = FormValidation.formValidation(eventForm, {
                    fields: {
                        eventTitle: {
                            validators: {
                                notEmpty: {
                                    message: 'Please enter event title '
                                }
                            }
                        },
                        eventStartDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Please enter start date '
                                }
                            }
                        },
                        eventEndDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Please enter end date '
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            // Use this for enabling/changing valid/invalid class
                            eleValidClass: '',
                            rowSelector: function(field, ele) {
                                // field is the field name & ele is the field element
                                return '.mb-3';
                            }
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        // Submit the form when all fields are valid
                        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        autoFocus: new FormValidation.plugins.AutoFocus()
                    }
                })
                .on('core.form.valid', function() {
                    // Jump to the next step when all fields in the current step are valid
                    isFormValid = true;
                })
                .on('core.form.invalid', function() {
                    // if fields are invalid
                    isFormValid = false;
                });

            // Sidebar Toggle Btn
            if (btnToggleSidebar) {
                btnToggleSidebar.addEventListener('click', e => {
                    btnCancel.classList.remove('d-none');
                });
            }

            // Add Event
            // ------------------------------------------------
            function addEvent(eventData) {
                // ? Add new event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response

                currentEvents.push(eventData);
                calendar.refetchEvents();

                // ? To add event directly to calender (won't update currentEvents object)
                // calendar.addEvent(eventData);
            }

            // Update Event
            // ------------------------------------------------
            function updateEvent(eventData) {
                // ? Update existing event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response
                eventData.id = parseInt(eventData.id);
                currentEvents[currentEvents.findIndex(el => el.id === eventData.id)] =
                    eventData; // Update event by id
                calendar.refetchEvents();

                // ? To update event directly to calender (won't update currentEvents object)
                // let propsToUpdate = ['id', 'title', 'url'];
                // let extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];

                // updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            }

            // Remove Event
            // ------------------------------------------------

            function removeEvent(eventId) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Are you sure delete this data?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete URL if confirmed
                        window.location.href = '{{ url('admin/event/destroy') }}/' + eventId;
                    }
                });
            }

            // (Update Event In Calendar (UI Only)
            // ------------------------------------------------
            const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
                const existingEvent = calendar.getEventById(updatedEventData.id);

                // --- Set event properties except date related ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setProp
                // dateRelatedProps => ['start', 'end', 'allDay']
                // eslint-disable-next-line no-plusplus
                for (var index = 0; index < propsToUpdate.length; index++) {
                    var propName = propsToUpdate[index];
                    existingEvent.setProp(propName, updatedEventData[propName]);
                }

                // --- Set date related props ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setDates
                existingEvent.setDates(updatedEventData.start, updatedEventData.end, {
                    allDay: updatedEventData.allDay
                });

                // --- Set event's extendedProps ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp
                // eslint-disable-next-line no-plusplus
                for (var index = 0; index < extendedPropsToUpdate.length; index++) {
                    var propName = extendedPropsToUpdate[index];
                    existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
                }
            };

            // Remove Event In Calendar (UI Only)
            // ------------------------------------------------
            function removeEventInCalendar(eventId) {
                calendar.getEventById(eventId).remove();
            }

            // Add new event
            // ------------------------------------------------
            btnSubmit.addEventListener('click', e => {
                if (btnSubmit.classList.contains('btn-add-event')) {
                    if (isFormValid) {
                        let newEvent = {
                            id: calendar.getEvents().length + 1,
                            title: eventTitle.value,
                            start: eventStartDate.value,
                            end: eventEndDate.value,
                            startStr: eventStartDate.value,
                            endStr: eventEndDate.value,
                            display: 'block',
                            extendedProps: {
                                location: eventLocation.value,
                                guests: eventGuests.val(),
                                calendar: eventLabel.val(),
                                description: eventDescription.value
                            }
                        };
                        if (eventUrl.value) {
                            newEvent.url = eventUrl.value;
                        }
                        if (allDaySwitch.checked) {
                            newEvent.allDay = true;
                        }
                        addEvent(newEvent);
                        bsAddEventSidebar.hide();
                    }
                } else {
                    // Update event
                    // ------------------------------------------------
                    if (isFormValid) {
                        let eventData = {
                            id: eventToUpdate.id,
                            title: eventTitle.value,
                            start: eventStartDate.value,
                            end: eventEndDate.value,
                            url: event_url.value,
                            extendedProps: {
                                location: eventLocation.value,
                                guests: eventGuests.val(),
                                calendar: eventLabel.val(),
                                description: eventDescription.value
                            },
                            display: 'block',
                            allDay: allDaySwitch.checked ? true : false
                        };

                        updateEvent(eventData);
                        bsAddEventSidebar.hide();
                    }
                }
            });

            // Call removeEvent function
            btnDeleteEvent.addEventListener('click', e => {
                removeEvent(parseInt(eventToUpdate.id));
                // eventToUpdate.remove();
                bsAddEventSidebar.hide();
            });

            // Reset event form inputs values
            // ------------------------------------------------
            function addDataEvent() {
                resetValues();
            }

            function resetValues() {
                eventEndDate.value = '';
                eventUrl.value = '';
                eventStartDate.value = '';
                eventTitle.value = '';
                eventLocation.value = '';
                allDaySwitch.checked = false;
                eventGuests.val('').trigger('change');
                eventDescription.value = '';
            }

            // When modal hides reset input values
            addEventSidebar.addEventListener('hidden.bs.offcanvas', function() {
                resetValues();
            });

            // Hide left sidebar if the right sidebar is open
            btnToggleSidebar.addEventListener('click', e => {
                if (offcanvasTitle) {
                    offcanvasTitle.innerHTML = 'Add Event';
                }
                btnSubmit.innerHTML = 'Add';
                btnSubmit.classList.remove('btn-update-event');
                btnSubmit.classList.add('btn-add-event');
                btnDeleteEvent.classList.add('d-none');
                appCalendarSidebar.classList.remove('show');
                appOverlay.classList.remove('show');
            });

            // Calender filter functionality
            // ------------------------------------------------
            if (selectAll) {
                selectAll.addEventListener('click', e => {
                    console.log('masuk');
                    if (e.currentTarget.checked) {
                        document.querySelectorAll('.input-filter').forEach(c => (c.checked = 1));
                    } else {
                        document.querySelectorAll('.input-filter').forEach(c => (c.checked = 0));
                    }
                    calendar.refetchEvents();
                });
            }

            if (filterInput) {
                console.log(filterInput);
                filterInput.forEach(item => {
                    item.addEventListener('click', () => {
                        document.querySelectorAll('.input-filter:checked').length < document
                            .querySelectorAll('.input-filter').length ?
                            (selectAll.checked = false) :
                            (selectAll.checked = true);
                        calendar.refetchEvents();
                    });
                });
            }

            // Jump to date on sidebar(inline) calendar change
            inlineCalInstance.config.onChange.push(function(date) {
                calendar.changeView(calendar.view.type, moment(date[0]).format('YYYY-MM-DD'));
                modifyToggler();
                appCalendarSidebar.classList.remove('show');
                appOverlay.classList.remove('show');
            });
        })();
    });
</script>
