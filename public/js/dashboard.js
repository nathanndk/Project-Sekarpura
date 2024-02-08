document.addEventListener('DOMContentLoaded', function () {
    var eventForm = document.getElementById('eventForm');
    var saveButton = document.getElementById('saveButton');
    var resetButton = document.getElementById('resetButton');
    var editButton = document.getElementById('editButton');
    var updateButton = document.getElementById('updateButton');
    var deleteButton = document.getElementById('deleteButton');
    var eventListItems = document.querySelectorAll('.event-list-item');
    var selectedEventId;

    resetButton.addEventListener('click', function () {
        eventForm.reset();
    });

    saveButton.addEventListener('click', function () {
        var titleInput = document.getElementById('title');
        var startTimeInput = document.getElementById('startTime');
        var endTimeInput = document.getElementById('endTime');

        if (titleInput.value.trim() === '') {
            toastr.warning('Title cannot be empty', 'Warning', {
                timeOut: 2500,
                closeButton: true,
                progressBar: true,
            });
            return;
        }

        if (startTimeInput.value.trim() === '') {
            toastr.warning('Start time cannot be empty', 'Warning', {
                timeOut: 2500,
                closeButton: true,
                progressBar: true,
            });
            return;
        }

        if (endTimeInput.value.trim() === '') {
            toastr.warning('End time cannot be empty', 'Warning', {
                timeOut: 2500,
                closeButton: true,
                progressBar: true,
            });
            return;
        }

        if (endTimeInput.value <= startTimeInput.value) {
            toastr.warning('Invalid end time', 'Warning', {
                timeOut: 2500,
                closeButton: true,
                progressBar: true,
            });
            return;
        }

        var formData = new FormData(eventForm);

        var formDataObject = {};
        formData.forEach(function (value, key) {
            formDataObject[key] = value;
        });

        fetch('/events/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formDataObject)
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                localStorage.setItem('showSuccessModal', 'true');
                location.reload();
            })
            .catch(error => {
                console.error(error);
            });
    });

    window.onload = function () {
        if (localStorage.getItem('showSuccessModal') === 'true') {
            toastr.success('Event Created Successfully', 'Success', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
            localStorage.removeItem('showSuccessModal');
        }

        if (localStorage.getItem('showSuccessModal2') === 'true') {
            toastr.success('Event Updated Successfully', 'Success', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
            localStorage.removeItem('showSuccessModal2');
        }

        if (localStorage.getItem('showSuccessModal3') === 'true') {
            toastr.error('Event Deleted Successfully', 'Attention', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
            localStorage.removeItem('showSuccessModal3');
        }

        if (localStorage.getItem('showSuccessModal4') === 'true') {
            toastr.error('Event Failed to Update', 'Error', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
            localStorage.removeItem('showSuccessModal4');
        }

        if (localStorage.getItem('showSuccessModal5') === 'true') {
            toastr.error('Attachment Deleted Successfully', 'Attention', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
            localStorage.removeItem('showSuccessModal5');
        }

        if (localStorage.getItem('showSuccessModal6') === 'true') {
            toastr.success('Attachment Added Successfully', 'Success', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
            localStorage.removeItem('showSuccessModal6');
        }
    };

    function prefillEditForm(title, description, startTime, endTime) {
        var editTitleInput = document.getElementById('editTitle');
        var editDescriptionInput = document.getElementById('editDescription');
        var editStartTimeInput = document.getElementById('editStartTime');
        var editEndTimeInput = document.getElementById('editEndTime');

        editTitleInput.value = title;
        editDescriptionInput.value = description;
        editStartTimeInput.value = formatDateTime(startTime);
        editEndTimeInput.value = formatDateTime(endTime);
    }

    eventListItems.forEach(function (item) {
        item.addEventListener('click', function () {
            selectedEventId = item.getAttribute('data-eventid');

            var title = item.getAttribute('data-title');
            var description = item.getAttribute('data-description');
            var startTime = item.getAttribute('data-start-time');
            var endTime = item.getAttribute('data-end-time');
            var createdAt = item.getAttribute('data-created_at');
            var createdBy = item.getAttribute('data-created_by');

            showModal(title, description, startTime, endTime, createdAt, createdBy);
            prefillEditForm(title, description, startTime, endTime);
        });
    });

    function showModal(title, description, startTime, endTime, createdAt, createdBy) {
        var modalTitle = document.getElementById('modalTitle');
        var modalDescription = document.getElementById('modalDescription');
        var modalStart = document.getElementById('modalStart');
        var modalEnd = document.getElementById('modalEnd');
        var modalCreatedAt = document.getElementById('modalCreatedAt');
        var modalCreatedBy = document.getElementById('modalCreatedBy');
        var editEventModal = document.getElementById('editEventModal');

        if (modalTitle) modalTitle.innerText = title;
        if (modalDescription) modalDescription.innerText = description;
        if (modalStart) modalStart.innerText = startTime;
        if (modalEnd) modalEnd.innerText = endTime;
        if (modalCreatedAt) modalCreatedAt.innerText = createdAt;
        if (modalCreatedBy) modalCreatedBy.innerText = createdBy;

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

    resetButton2.addEventListener('click', function () {
        var initialTitle = modalTitle.innerText;
        var initialDescription = modalDescription.innerText;
        var initialStartTime = formatDateTime(modalStart.innerText);
        var initialEndTime = formatDateTime(modalEnd.innerText);

        var editTitleInput = document.getElementById('editTitle');
        var editDescriptionInput = document.getElementById('editDescription');
        var editStartTimeInput = document.getElementById('editStartTime');
        var editEndTimeInput = document.getElementById('editEndTime');

        editTitleInput.value = initialTitle;
        editDescriptionInput.value = initialDescription;
        editStartTimeInput.value = initialStartTime;
        editEndTimeInput.value = initialEndTime;
    });

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
});
