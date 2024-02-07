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
                    <h3 class="welcome-heading">Hi There!</h3>
                    @auth
                    @if (Auth::user()->role == 3)
                    <button id="dragConfirmBtn" style="display: none;" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                        <i class="bi bi-check2 confirm"></i>
                    </button>
                    <button id="cancelConfirmBtn" style="display: none;" class="btn btn-danger">
                        <i class="bi bi-x-lg cancel"></i>
                    </button>
                    <button id="add-event" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <i class="bi bi-plus"></i> Add Event
                    </button>
                    @elseif (Auth::user()->role == 2)
                    <button id="dragConfirmBtn" style="display: none;" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                        <i class="bi bi-check2 confirm"></i>
                    </button>
                    <button id="cancelConfirmBtn" style="display: none;" class="btn btn-danger">
                        <i class="bi bi-x-lg cancel"></i>
                    </button>
                    <button id="add-event" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <i class="bi bi-plus"></i> Add Event
                    </button>
                    @endif
                    @endauth
                </div>
                <div class="d-flex align-items-center">
                    <button id="see-attachment" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seeAttachmentsModal">
                        <i class="bi bi-paperclip"></i> See Attachments and Notes
                    </button>
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
                <ul class="upcoming-agenda">
                <h5 class="agenda-heading">Upcoming Events</h5>
                @foreach($upcomingEvents as $event)
                    <li class="event-list-item" style="background-color: {{ $colors[array_rand($colors)] }};"
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

                    fetch('/update-event', {
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
                fetch('/delete-event/' + eventId, {
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

    <!-- Modal See Attachments and Notes -->
    <div class="modal fade" id="seeAttachmentsModal" tabindex="-1" role="dialog" aria-labelledby="seeAttachmentsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seeAttachmentsModalLabel">Attachments & Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attachmentForm">
                        <div class="mb-3">
                            <label id="searchField" for="eventName" class="form-label">Search or Select Here</label>
                            <select class="form-control" id="eventName">
                                <option value="">-- You can select or search an event here --</option>
                                @foreach($attachmentOptions as $option)
                                    <option style="margin-bottom = 10px;" title="{{ $option['title'] }}" value="{{ $option['id'] }}" style="margin-bottom: -5px;" data-subtext="{{ \Carbon\Carbon::parse($option['start_time'])->locale('id')->format('d/m/Y, H:i') }} to {{ \Carbon\Carbon::parse($option['end_time'])->locale('id')->format('d/m/Y, H:i') }}"> {{ $option['title'] }} </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    @auth
                    @if (Auth::user()->role == 3)
                    <p id="attachmentText" style="display: none;"><strong>Attachment(s)</strong></p>
                    <hr id="attachmentBorder1" style="display: none;">
                    <input type="file" class="form-control" id="addFileButton" style="display: none;" multiple>
                    <button id="uploadConfirmBtn" style="display: none;">
                        <i class="bi bi-check2 confirm"></i>
                    </button>
                    <button id="cancelUploadBtn" style="display: none;">
                        <i class="bi bi-x-lg cancel"></i>
                    </button>
                    <hr id="attachmentBorder2" style="display: none;">
                    @elseif (Auth::user()->role == 2)
                    <p id="attachmentText" style="display: none;"><strong>Attachment(s)</strong></p>
                    <hr id="attachmentBorder1" style="display: none;">
                    <input type="file" class="form-control" id="addFileButton" style="display: none;" multiple>
                    <button id="uploadConfirmBtn" style="display: none;">
                        <i class="bi bi-check2 confirm"></i>
                    </button>
                    <button id="cancelUploadBtn" style="display: none;">
                        <i class="bi bi-x-lg cancel"></i>
                    </button>
                    <hr id="attachmentBorder2" style="display: none;">
                    @elseif (Auth::user()->role == 1)
                    <p id="attachmentText" style="display: none; margin-bottom: 10px"><strong>Attachment(s)</strong></p>
                    @endif
                    @endauth
                    <ul id="additionalElements" style="display: none;">
                        @foreach($files as $attachment)
                            <li class="attachment-list-item"
                                data-attachmentid="{{ $attachment['id'] }}"
                                data-attachmentfile="{{ $attachment['file'] }}"
                                data-attachmentpath="{{ $attachment['path'] }}"
                                data-attachmentcreatedAt="{{ \Carbon\Carbon::parse($attachment['created_at'])->locale('id')->format('l, d/m/Y H:i:s') }}"
                                data-attachmentcreatedBy="{{ $attachment['created_by'] }}"
                                data-attachmenteventsId="{{ $attachment['events_id'] }}"
                                style="display: none;">
                                <i class="bi bi-paperclip"></i> {{ $attachment['file'] }}<br>
                                <i class="bi bi-person"></i> {{ $attachment['created_by'] }}<br>
                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($attachment['created_at'])->locale('id')->format('l, d/m/Y H:i:s') }}<br>
                                <button type="button" class="btn btn-primary downloadFileButton">Download</button>
                                @auth
                                @if (Auth::user()->role == 3)
                                <button type="button" class="btn btn-danger deleteFileButton">Delete</button>
                                @elseif (Auth::user()->role == 2)
                                <button type="button" class="btn btn-danger deleteFileButton">Delete</button>
                                @endif
                                @endauth
                            </li>
                        @endforeach
                    </ul>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            $('#eventName').selectpicker({
                                liveSearch: true,
                                showSubtext: true,
                            });

                            var eventNameSelect = document.getElementById('eventName');
                            var deleteFileButtons = document.querySelectorAll('.deleteFileButton');
                            var closeModalButton = document.getElementById('closeModalButton');
                            var fileInput = document.getElementById('addFileButton');
                            var uploadConfirmBtn = document.getElementById('uploadConfirmBtn');
                            var cancelUploadBtn = document.getElementById('cancelUploadBtn');
                            var downloadFileButtons = document.querySelectorAll('.downloadFileButton');

                            eventNameSelect.addEventListener('change', function () {
                                var selectedEventId = eventNameSelect.value;
                                toggleAdditionalElements(selectedEventId);
                            });

                            deleteFileButtons.forEach(function (button) {
                                button.addEventListener('click', function () {
                                    var attachmentId = button.closest('.attachment-list-item').getAttribute('data-attachmentid');
                                    var attachmentFile = button.closest('.attachment-list-item').getAttribute('data-attachmentfile');
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                    $.ajax({
                                        url: '/delete-attachment/' + attachmentId,
                                        type: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        success: function (response) {
                                            $('#deleteAttachmentModal').modal('hide');
                                            localStorage.setItem('showSuccessModal5', 'true');
                                            location.reload();
                                        },
                                        error: function (error) {
                                            console.error('Error Deleting Attachment:', error);
                                        }
                                    });
                                });
                            });

                            fileInput.addEventListener('change', function (event) {
                                var files = event.target.files;

                                if (files.length > 0) {
                                    uploadConfirmBtn.style.display = 'inline-block';
                                    cancelUploadBtn.style.display = 'inline-block';
                                } else {
                                    uploadConfirmBtn.style.display = 'none';
                                    cancelUploadBtn.style.display = 'none';
                                }
                            });

                            uploadConfirmBtn.addEventListener('click', function () {
                                var files = fileInput.files;

                                if (files.length > 0) {
                                    var selectedEventId = eventNameSelect.value;
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                    var formData = new FormData();
                                    formData.append('file', files[0]);
                                    formData.append('events_id', selectedEventId);

                                    $.ajax({
                                        url: '/upload-attachment',
                                        type: 'POST',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        success: function (response) {
                                            localStorage.setItem('showSuccessModal6', 'true');
                                            location.reload();
                                        },
                                        error: function (error) {
                                            console.error('Error Uploading File:', error);
                                        }
                                    });
                                }
                            });

                            cancelUploadBtn.addEventListener('click', function () {
                                fileInput.value = null;
                                uploadConfirmBtn.style.display = 'none';
                                cancelUploadBtn.style.display = 'none';
                            });

                            downloadFileButtons.forEach(function (button) {
                                button.addEventListener('click', function () {
                                    var attachmentPath = button.closest('.attachment-list-item').getAttribute('data-attachmentpath');
                                    var attachmentFileName = button.closest('.attachment-list-item').getAttribute('data-attachmentfile');

                                    var downloadLink = document.createElement('a');
                                    downloadLink.href = '/storage/' + attachmentPath + '/' + attachmentFileName;
                                    downloadLink.download = attachmentFileName;

                                    downloadLink.click();
                                });
                            });
                        });

                        @auth
                        @if (Auth::user()->role == 3)
                        function toggleAdditionalElements(selectedEventId) {
                            var attachmentText = document.getElementById('attachmentText');
                            var addFileButton = document.getElementById('addFileButton');
                            var attachmentBorder1 = document.getElementById('attachmentBorder1');
                            var attachmentBorder2 = document.getElementById('attachmentBorder2');
                            var additionalElements = document.getElementById('additionalElements');

                            attachmentText.style.display = selectedEventId ? 'block' : 'none';
                            addFileButton.style.display = selectedEventId ? 'block' : 'none';
                            attachmentBorder1.style.display = selectedEventId ? 'block' : 'none';
                            attachmentBorder2.style.display = selectedEventId ? 'block' : 'none';
                            additionalElements.style.display = selectedEventId ? 'block' : 'none';

                            var attachments = document.querySelectorAll('.attachment-list-item');
                            attachments.forEach(function (attachment) {
                                var attachmentEventId = attachment.getAttribute('data-attachmenteventsId');
                                attachment.style.display = attachmentEventId === selectedEventId ? 'block' : 'none';
                            });
                        }
                        @elseif (Auth::user()->role == 2)
                        function toggleAdditionalElements(selectedEventId) {
                            var attachmentText = document.getElementById('attachmentText');
                            var addFileButton = document.getElementById('addFileButton');
                            var attachmentBorder1 = document.getElementById('attachmentBorder1');
                            var attachmentBorder2 = document.getElementById('attachmentBorder2');
                            var additionalElements = document.getElementById('additionalElements');

                            attachmentText.style.display = selectedEventId ? 'block' : 'none';
                            addFileButton.style.display = selectedEventId ? 'block' : 'none';
                            attachmentBorder1.style.display = selectedEventId ? 'block' : 'none';
                            attachmentBorder2.style.display = selectedEventId ? 'block' : 'none';
                            additionalElements.style.display = selectedEventId ? 'block' : 'none';

                            var attachments = document.querySelectorAll('.attachment-list-item');
                            attachments.forEach(function (attachment) {
                                var attachmentEventId = attachment.getAttribute('data-attachmenteventsId');
                                attachment.style.display = attachmentEventId === selectedEventId ? 'block' : 'none';
                            });
                        }
                        @elseif (Auth::user()->role == 1)
                        function toggleAdditionalElements(selectedEventId) {
                            var attachmentText = document.getElementById('attachmentText');
                            var additionalElements = document.getElementById('additionalElements');

                            attachmentText.style.display = selectedEventId ? 'block' : 'none';
                            additionalElements.style.display = selectedEventId ? 'block' : 'none';

                            var attachments = document.querySelectorAll('.attachment-list-item');
                            attachments.forEach(function (attachment) {
                                var attachmentEventId = attachment.getAttribute('data-attachmenteventsId');
                                attachment.style.display = attachmentEventId === selectedEventId ? 'block' : 'none';
                            });
                        }
                        @endif
                        @endauth
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Event -->
    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="description" name="description" maxlength="50"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Start at <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label">End at <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="endTime" name="endTime" required>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                    <button type="button" class="btn btn-danger" id="resetButton">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Event -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailModalLabel" aria-hidden="true" data-event-id="{{ $event->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Event Name</strong> <span id="modalTitle"></span></p>
                    <p><strong>Description</strong> <span id="modalDescription"></span></p>
                    <p><strong>Start at</strong> <span id="modalStart"></span></p>
                    <p><strong>End at</strong> <span id="modalEnd"></span></p>
                    <p><strong>Creator</strong> <span id="modalCreatedBy"></span></p>
                    <p><strong>Created at</strong> <span id="modalCreatedAt"></span></p>
                </div>
                <div class="d-flex justify-content-between">
                    @auth
                    @if (Auth::user()->role == 3)
                    <button type="button" class="btn btn-warning" id="editButton" data-bs-toggle="modal" data-bs-target="#editEventModal" data-event-id="{{ $event->id }}">Edit</button>
                    <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                    @elseif (Auth::user()->role == 2)
                    <button type="button" class="btn btn-warning" id="editButton" data-bs-toggle="modal" data-bs-target="#editEventModal" data-event-id="{{ $event->id }}">Edit</button>
                    <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Event -->
    <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event Details</h5>
                    <button type="button" class="btn-close" id="closeButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm2">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="hidden" id="eventId" name="eventId" value="{{ $event->id }}">
                            <input type="text" class="form-control" id="editTitle" name="title" required maxlength="30">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="editDescription" name="description" maxlength="50"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Start at <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="editStartTime" name="startTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label">End at <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="editEndTime" name="endTime" required>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-primary updateButton" id="updateButton" data-eventid="{{ $event->id }}">Update</button>
                    <button type="button" class="btn btn-danger" id="resetButton2">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                </div>
                <div class="modal-body">
                    <i class="bi bi-x-circle red-icon"></i>
                    <p id="text1">Are you sure?</p>
                    <p id="text2">This event will be deleted permanently.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Drag Event -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Save Changes</h5>
                </div>
                <div class="modal-body">
                    <i class="bi bi-exclamation-triangle yellow-icon"></i>
                    <p id="text1">Are you sure?</p>
                    <p id="text2">You cannot undo this process.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmSaveChanges">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
    </body>
@endsection
