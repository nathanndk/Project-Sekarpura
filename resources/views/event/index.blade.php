@extends('layouts.header')

@section('content')
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" crossorigin="anonymous" />
        <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
        <script src="{{ asset('js/dashboard.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <link href="https://bootswatch.com/5/litera/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    </head>
    <body>
    <div class="container-fluid mt-20">
        <div class="row">
        <div class="col-md-8">
            <div class="container" id="calendar-container">
            <div class="row">
                <div class="col-12 mt-3">
                <div id="calendar" class="custom-calendar"></div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="container" id="today-agenda-container">
                <div class="d-flex align-items-center">

                    @auth
                    <h3 id="welcome-heading" class="welcome-heading">Hi {{ Auth::user()->username }}!</h3>
                    @endauth

                    @include('event.shared.add_event_button')

                </div>
                <div class="d-flex align-items-center">

                   @include('event.shared.see_attachments_button')
                </div>

                <ul class="today-agenda">
                    <h5 class="agenda-heading">Today's Agenda</h5>
                    @foreach($todayEvents as $event)
                        <li class="event-list-item" data-event-id="{{ $event->id }}" style="background-color: {{ $colors[array_rand($colors)] }};"
                            data-eventid="{{ $event->id }}"
                            data-title="{{ $event->title }}"
                            data-description="{{ $event->description ? $event->description : '-' }}"
                            data-start-time="{{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format('l, d/m/Y H:i:s') }}"
                            data-end-time="{{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('l, d/m/Y H:i:s') }}"
                            data-created_at="{{ \Carbon\Carbon::parse($event->created_at)->locale('id')->format('l, d/m/Y H:i:s') }}"
                            data-created_by="{{ $event->created_by }}">
                            <i class="bi bi-calendar-event"></i> {{ $event->title }}<br>
                            <i class="bi bi-bookmark-check"></i>
                                @if($event->description)
                                    {{ $event->description }}
                                @else
                                    -
                                @endif
                            <br>
                            <i class="bi bi-alarm"></i> {{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format('l, d/m/Y H:i:s') }} -
                                @if(\Carbon\Carbon::parse($event->start_time)->format('Y-m-d') !== \Carbon\Carbon::parse($event->end_time)->format('Y-m-d'))
                                    {{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('l, d/m/Y H:i:s') }}
                                @else
                                    {{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('H:i:s') }}
                                @endif
                        </li>
                    @endforeach
                </ul>

                @include('event.shared.upcoming_agenda')

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var booking = @json($events);
            var calendarEl = document.getElementById('calendar');
            var dragConfirmBtn = document.getElementById('dragConfirmBtn');
            var cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
            var confirmSaveChanges = document.getElementById('confirmSaveChanges');
            var updatedEventDetails = [];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                fixedWeekCount: false,
                events: booking,
                eventDisplay: 'block',
                timeFormat: null,
                @auth
                @if (Auth::user()->role == 3)
                editable: true,
                eventStartEditable: true,
                eventResizable: true,
                eventResizableFromStart: true,
                @elseif (Auth::user()->role == 2)
                editable: true,
                eventStartEditable: true,
                eventResizable: true,
                eventResizableFromStart: true,
                @endif
                @endauth

                eventDragStart: function (info) {
                    dragConfirmBtn.style.display = 'block';
                    cancelConfirmBtn.style.display = 'block';
                },

                eventDrop: function (info) {
                    dragConfirmBtn.style.display = 'block';
                    cancelConfirmBtn.style.display = 'block';

                    var eventId = info.event.extendedProps.id || info.event.id;

                    updatedEventDetails.push({
                        eventId: eventId,
                        newStart: info.event.start,
                        newEnd: info.event.end,
                    });
                },

                eventClick: function (info) {
                    var eventId = info.event.extendedProps.id || info.event.id;
                    selectedEventId = info.event.extendedProps.id || info.event.id;

                    var title = info.event.title;
                    var description = info.event.extendedProps.description;
                    var start_time = moment(info.event.start).format('dddd, DD/MM/YYYY HH:mm:ss');
                    var end_time = moment(info.event.end).format('dddd, DD/MM/YYYY HH:mm:ss');
                    var created_by = info.event.extendedProps.created_by;
                    var created_at = moment(info.event.extendedProps.created_at).format('dddd, DD/MM/YYYY HH:mm:ss');

                    showModal(title, description, start_time, end_time, created_by, created_at);
                    info.jsEvent.preventDefault();
                },
            });

            calendar.render();

            function showModal(title, description, startTime, endTime, createdBy, createdAt) {
                var editEventModal = document.getElementById('editEventModal');

                if (modalTitle) modalTitle.innerText = title;
                if (modalDescription) modalDescription.innerText = description;
                if (modalStart) modalStart.innerText = startTime;
                if (modalEnd) modalEnd.innerText = endTime;
                if (modalCreatedBy) modalCreatedBy.innerText = createdBy;
                if (modalCreatedAt) modalCreatedAt.innerText = createdAt;

                editEventModal.selectedEventDetails = {
                    title: title,
                    description: description,
                    startTime: startTime,
                    endTime: endTime,
                };

                $('#editEventModal').on('hidden.bs.modal', function () {
                    $('#eventDetailModal').modal('show');
                });

                $('#eventDetailModal').modal('show');
            }

            editButton.addEventListener('click', function (event) {
                var editEventModal = document.getElementById('editEventModal');

                if (typeof selectedEventId !== 'undefined') {
                    var selectedEventDetails = editEventModal.selectedEventDetails;

                    var editTitleInput = document.getElementById('editTitle');
                    var editDescriptionInput = document.getElementById('editDescription');
                    var editStartTimeInput = document.getElementById('editStartTime');
                    var editEndTimeInput = document.getElementById('editEndTime');
                    var eventId = selectedEventId;

                    editTitleInput.value = selectedEventDetails.title;
                    editDescriptionInput.value = selectedEventDetails.description;
                    editStartTimeInput.value = formatDateTime(selectedEventDetails.startTime);
                    editEndTimeInput.value = formatDateTime(selectedEventDetails.endTime);

                    document.getElementById('eventId').value = eventId;

                    $('#editEventModal').modal('show');
                } else {
                    console.error('selectedEventId is undefined. Please check the logic for setting it.');
                }
            });

            $('#editEventModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var eventId = button.data('event-id');

                $('#eventId').val(eventId);
            });

            $(document).ready(function () {
                var editEventModal = $('#editEventModal');

                if (editEventModal.length) {
                    editEventModal.on('hidden.bs.modal', function () {
                        $(this).data('bs.modal', null);
                    });
                }
            });

            function parseDateTimeString(dateTimeString) {
                var parts = dateTimeString.split(/[\s,\/:]+/);

                var day = parseInt(parts[1], 10);
                var month = parseInt(parts[2], 10) - 1;
                var year = parseInt(parts[3], 10);
                var hour = parseInt(parts[4], 10);
                var minute = parseInt(parts[5], 10);

                var date = new Date(Date.UTC(year, month, day, hour, minute));
                return date;
            }

            function formatDateTime(dateTimeString) {
                var dateTime = parseDateTimeString(dateTimeString);
                var formattedDateTime = dateTime.toISOString().slice(0, 16);
                return formattedDateTime;
            }

            updateButton.addEventListener('click', function (event) {
                if (typeof selectedEventId !== 'undefined') {
                    var editTitleInput = document.getElementById('editTitle');
                    var editDescriptionInput = document.getElementById('editDescription');
                    var editStartTimeInput = document.getElementById('editStartTime');
                    var editEndTimeInput = document.getElementById('editEndTime');

                    if (editTitleInput.value.trim() === '') {
                        toastr.warning('Title cannot be empty', 'Warning', {
                            timeOut: 2500,
                            closeButton: true,
                            progressBar: true,
                        });
                        return;
                    }

                    if (editStartTimeInput.value.trim() === '') {
                        toastr.warning('Start time cannot be empty', 'Warning', {
                            timeOut: 2500,
                            closeButton: true,
                            progressBar: true,
                        });
                        return;
                    }

                    if (editEndTimeInput.value.trim() === '') {
                        toastr.warning('End time cannot be empty', 'Warning', {
                            timeOut: 2500,
                            closeButton: true,
                            progressBar: true,
                        });
                        return;
                    }

                    if (editEndTimeInput.value <= editStartTimeInput.value) {
                        toastr.warning('Invalid end time', 'Warning', {
                            timeOut: 2500,
                            closeButton: true,
                            progressBar: true,
                        });
                        return;
                    }

                    var updatedTitle = editTitleInput.value;
                    var updatedDescription = editDescriptionInput.value;
                    var updatedStartTime = editStartTimeInput.value;
                    var updatedEndTime = editEndTimeInput.value;

                    var updateEventData = {
                        id: selectedEventId,
                        title: updatedTitle,
                        description: updatedDescription,
                        startTime: updatedStartTime,
                        endTime: updatedEndTime
                    };

                    fetch('/events/{event}/edit', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(updateEventData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        localStorage.setItem('showSuccessModal2', 'true');
                        location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
            });

            deleteButton.addEventListener('click', function () {
                $('#deleteConfirmationModal').modal('show');

                document.getElementById('confirmDeleteButton').addEventListener('click', function () {
                    $('#deleteConfirmationModal').modal('hide');
                    deleteEvent(selectedEventId);
                });

                document.querySelector('#deleteConfirmationModal .btn-secondary').addEventListener('click', function () {
                    $('#deleteConfirmationModal').modal('hide');
                });
            });

            function deleteEvent(eventId) {
                fetch('/delete/' + eventId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    localStorage.setItem('showSuccessModal3', 'true');
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
            }

            cancelConfirmBtn.addEventListener('click', function() {
                calendar.getEvents().forEach(function(event) {
                    event.remove();
                });
                calendar.addEventSource(booking);

                dragConfirmBtn.style.display = 'none';
                cancelConfirmBtn.style.display = 'none';

                updatedEventDetails = [];
            });

            confirmSaveChanges.addEventListener('click', function() {
                updatedEventDetails.forEach(function(updatedEvent) {
                    var formattedStartDate = moment(updatedEvent.newStart).format('YYYY-MM-DD HH:mm:ss');
                    var formattedEndDate = moment(updatedEvent.newEnd).format('YYYY-MM-DD HH:mm:ss');

                    $.ajax({
                        url: '/drag-event',
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        data: JSON.stringify({
                            eventId: updatedEvent.eventId,
                            newStart: formattedStartDate,
                            newEnd: formattedEndDate,
                        }),
                        success: function(response) {
                            console.log(response);
                            localStorage.setItem('showSuccessModal2', 'true');
                            location.reload();
                        },
                        error: function(error) {
                            console.error(error);
                            localStorage.setItem('showSuccessModal4', 'true');
                        }
                    });
                });
                updatedEventDetails = [];
            });
        });
    </script>

    @include('event.shared.see_attachments_modal')

    @include('event.shared.add_event_modal')

    @include('event.shared.detail_event_modal')

    @include('event.shared.edit_modal_event')

    @include('event.shared.delete_confirmation_modal')

    @include('event.shared.drag_confirmation_modal')

    @stack('scripts')
    </body>
@endsection
