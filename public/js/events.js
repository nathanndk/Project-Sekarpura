        // document.addEventListener('DOMContentLoaded', function() {
        //     var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        //     var booking = @json($events);
        //     var calendarEl = document.getElementById('calendar');
        //     var dragConfirmBtn = document.getElementById('dragConfirmBtn');
        //     var cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
        //     var confirmSaveChanges = document.getElementById('confirmSaveChanges');
        //     var updatedEventDetails = [];

        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'dayGridMonth,timeGridWeek,timeGridDay'
        //         },
        //         initialView: 'dayGridMonth',
        //         themeSystem: 'bootstrap5',
        //         fixedWeekCount: false,
        //         events: booking,
        //         eventDisplay: 'block',
        //         timeFormat: null,
        //         @auth
        //         @if (Auth::user()->role == 3)
        //         editable: true,
        //         eventStartEditable: true,
        //         eventResizable: true,
        //         eventResizableFromStart: true,
        //         @elseif (Auth::user()->role == 2)
        //         editable: true,
        //         eventStartEditable: true,
        //         eventResizable: true,
        //         eventResizableFromStart: true,
        //         @endif
        //         @endauth

        //         eventDragStart: function (info) {
        //             dragConfirmBtn.style.display = 'block';
        //             cancelConfirmBtn.style.display = 'block';
        //         },

        //         eventDrop: function (info) {
        //             dragConfirmBtn.style.display = 'block';
        //             cancelConfirmBtn.style.display = 'block';

        //             var eventId = info.event.extendedProps.id || info.event.id;

        //             updatedEventDetails.push({
        //                 eventId: eventId,
        //                 newStart: info.event.start,
        //                 newEnd: info.event.end,
        //             });
        //         },

        //         eventClick: function (info) {
        //             var eventId = info.event.extendedProps.id || info.event.id;
        //             selectedEventId = info.event.extendedProps.id || info.event.id;

        //             var title = info.event.title;
        //             var description = info.event.extendedProps.description;
        //             var start_time = moment(info.event.start).format('dddd, DD/MM/YYYY HH:mm:ss');
        //             var end_time = moment(info.event.end).format('dddd, DD/MM/YYYY HH:mm:ss');
        //             var created_by = info.event.extendedProps.created_by;
        //             var created_at = moment(info.event.extendedProps.created_at).format('dddd, DD/MM/YYYY HH:mm:ss');

        //             showModal(title, description, start_time, end_time, created_by, created_at);
        //             info.jsEvent.preventDefault();
        //         },
        //     });

        //     calendar.render();

        //     function showModal(title, description, startTime, endTime, createdBy, createdAt) {
        //         var editEventModal = document.getElementById('editEventModal');

        //         if (modalTitle) modalTitle.innerText = title;
        //         if (modalDescription) modalDescription.innerText = description;
        //         if (modalStart) modalStart.innerText = startTime;
        //         if (modalEnd) modalEnd.innerText = endTime;
        //         if (modalCreatedBy) modalCreatedBy.innerText = createdBy;
        //         if (modalCreatedAt) modalCreatedAt.innerText = createdAt;

        //         editEventModal.selectedEventDetails = {
        //             title: title,
        //             description: description,
        //             startTime: startTime,
        //             endTime: endTime,
        //         };

        //         $('#editEventModal').on('hidden.bs.modal', function () {
        //             $('#eventDetailModal').modal('show');
        //         });

        //         $('#eventDetailModal').modal('show');
        //     }

        //     editButton.addEventListener('click', function (event) {
        //         var editEventModal = document.getElementById('editEventModal');

        //         if (typeof selectedEventId !== 'undefined') {
        //             var selectedEventDetails = editEventModal.selectedEventDetails;

        //             var editTitleInput = document.getElementById('editTitle');
        //             var editDescriptionInput = document.getElementById('editDescription');
        //             var editStartTimeInput = document.getElementById('editStartTime');
        //             var editEndTimeInput = document.getElementById('editEndTime');
        //             var eventId = selectedEventId;

        //             editTitleInput.value = selectedEventDetails.title;
        //             editDescriptionInput.value = selectedEventDetails.description;
        //             editStartTimeInput.value = formatDateTime(selectedEventDetails.startTime);
        //             editEndTimeInput.value = formatDateTime(selectedEventDetails.endTime);

        //             document.getElementById('eventId').value = eventId;

        //             $('#editEventModal').modal('show');
        //         } else {
        //             console.error('selectedEventId is undefined. Please check the logic for setting it.');
        //         }
        //     });

        //     $('#editEventModal').on('show.bs.modal', function (event) {
        //         var button = $(event.relatedTarget);
        //         var eventId = button.data('event-id');

        //         $('#eventId').val(eventId);
        //     });

        //     $(document).ready(function () {
        //         var editEventModal = $('#editEventModal');

        //         if (editEventModal.length) {
        //             editEventModal.on('hidden.bs.modal', function () {
        //                 $(this).data('bs.modal', null);
        //             });
        //         }
        //     });

        //     function parseDateTimeString(dateTimeString) {
        //         var parts = dateTimeString.split(/[\s,\/:]+/);

        //         var day = parseInt(parts[1], 10);
        //         var month = parseInt(parts[2], 10) - 1;
        //         var year = parseInt(parts[3], 10);
        //         var hour = parseInt(parts[4], 10);
        //         var minute = parseInt(parts[5], 10);

        //         var date = new Date(Date.UTC(year, month, day, hour, minute));
        //         return date;
        //     }

        //     function formatDateTime(dateTimeString) {
        //         var dateTime = parseDateTimeString(dateTimeString);
        //         var formattedDateTime = dateTime.toISOString().slice(0, 16);
        //         return formattedDateTime;
        //     }

        //     updateButton.addEventListener('click', function (event) {
        //         if (typeof selectedEventId !== 'undefined') {
        //             var editTitleInput = document.getElementById('editTitle');
        //             var editDescriptionInput = document.getElementById('editDescription');
        //             var editStartTimeInput = document.getElementById('editStartTime');
        //             var editEndTimeInput = document.getElementById('editEndTime');

        //             if (editTitleInput.value.trim() === '') {
        //                 toastr.warning('Title cannot be empty', 'Warning', {
        //                     timeOut: 2500,
        //                     closeButton: true,
        //                     progressBar: true,
        //                 });
        //                 return;
        //             }

        //             if (editStartTimeInput.value.trim() === '') {
        //                 toastr.warning('Start time cannot be empty', 'Warning', {
        //                     timeOut: 2500,
        //                     closeButton: true,
        //                     progressBar: true,
        //                 });
        //                 return;
        //             }

        //             if (editEndTimeInput.value.trim() === '') {
        //                 toastr.warning('End time cannot be empty', 'Warning', {
        //                     timeOut: 2500,
        //                     closeButton: true,
        //                     progressBar: true,
        //                 });
        //                 return;
        //             }

        //             if (editEndTimeInput.value <= editStartTimeInput.value) {
        //                 toastr.warning('Invalid end time', 'Warning', {
        //                     timeOut: 2500,
        //                     closeButton: true,
        //                     progressBar: true,
        //                 });
        //                 return;
        //             }

        //             var updatedTitle = editTitleInput.value;
        //             var updatedDescription = editDescriptionInput.value;
        //             var updatedStartTime = editStartTimeInput.value;
        //             var updatedEndTime = editEndTimeInput.value;

        //             var updateEventData = {
        //                 id: selectedEventId,
        //                 title: updatedTitle,
        //                 description: updatedDescription,
        //                 startTime: updatedStartTime,
        //                 endTime: updatedEndTime
        //             };

        //             fetch('/events/{event}/edit', {
        //                 method: 'PUT',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //                 },
        //                 body: JSON.stringify(updateEventData)
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 console.log(data);
        //                 localStorage.setItem('showSuccessModal2', 'true');
        //                 location.reload();
        //             })
        //             .catch(error => {
        //                 console.error(error);
        //             });
        //         }
        //     });

        //     deleteButton.addEventListener('click', function () {
        //         $('#deleteConfirmationModal').modal('show');

        //         document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        //             $('#deleteConfirmationModal').modal('hide');
        //             deleteEvent(selectedEventId);
        //         });

        //         document.querySelector('#deleteConfirmationModal .btn-secondary').addEventListener('click', function () {
        //             $('#deleteConfirmationModal').modal('hide');
        //         });
        //     });

        //     function deleteEvent(eventId) {
        //         fetch('/delete/' + eventId, {
        //             method: 'DELETE',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //             },
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             console.log(data);
        //             localStorage.setItem('showSuccessModal3', 'true');
        //             location.reload();
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        //     }

        //     cancelConfirmBtn.addEventListener('click', function() {
        //         calendar.getEvents().forEach(function(event) {
        //             event.remove();
        //         });
        //         calendar.addEventSource(booking);

        //         dragConfirmBtn.style.display = 'none';
        //         cancelConfirmBtn.style.display = 'none';

        //         updatedEventDetails = [];
        //     });

        //     confirmSaveChanges.addEventListener('click', function() {
        //         updatedEventDetails.forEach(function(updatedEvent) {
        //             var formattedStartDate = moment(updatedEvent.newStart).format('YYYY-MM-DD HH:mm:ss');
        //             var formattedEndDate = moment(updatedEvent.newEnd).format('YYYY-MM-DD HH:mm:ss');

        //             $.ajax({
        //                 url: '/drag-event',
        //                 method: 'PUT',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //                 },
        //                 data: JSON.stringify({
        //                     eventId: updatedEvent.eventId,
        //                     newStart: formattedStartDate,
        //                     newEnd: formattedEndDate,
        //                 }),
        //                 success: function(response) {
        //                     console.log(response);
        //                     localStorage.setItem('showSuccessModal2', 'true');
        //                     location.reload();
        //                 },
        //                 error: function(error) {
        //                     console.error(error);
        //                     localStorage.setItem('showSuccessModal4', 'true');
        //                 }
        //             });
        //         });
        //         updatedEventDetails = [];
        //     });
        // });
