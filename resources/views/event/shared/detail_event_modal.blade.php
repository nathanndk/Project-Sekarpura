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
