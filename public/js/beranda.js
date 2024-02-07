document.addEventListener('DOMContentLoaded', function () {
    var eventForm = document.getElementById('eventForm');
    var eventListItems = document.querySelectorAll('.event-list-item');
    var selectedEventId;

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
});
