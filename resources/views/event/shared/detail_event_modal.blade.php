<!-- Modal Detail Event -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong style="font-family: 'Trebuchet MS', sans-serif; font-size: 18px; margin-left: 5px; margin-right: 5px">Event Name</strong> : <span id="modalTitle"></span></p>
                <p><strong style="font-family: 'Trebuchet MS', sans-serif; font-size: 18px; margin-left: 5px; margin-right: 10px">Description</strong> : <span id="modalDescription"></span></p>
                <p><strong style="font-family: 'Trebuchet MS', sans-serif; font-size: 18px; margin-left: 5px; margin-right: 42px">Start at</strong> : <span id="modalStart"></span></p>
                <p><strong style="font-family: 'Trebuchet MS', sans-serif; font-size: 18px; margin-left: 5px; margin-right: 51px">End at</strong> : <span id="modalEnd"></span></p>
                <p><strong style="font-family: 'Trebuchet MS', sans-serif; font-size: 18px; margin-left: 5px; margin-right: 40px">Creator</strong> : <span id="modalCreatedBy"></span></p>
                <p><strong style="font-family: 'Trebuchet MS', sans-serif; font-size: 18px; margin-left: 5px; margin-right: 15px">Created at</strong> : <span id="modalCreatedAt"></span></p>
            </div>
            <div class="d-flex justify-content-between">
                @auth
                    @if (Auth::user()->role == 3 || Auth::user()->role == 2)
                        <button type="button" class="btn btn-warning" id="editButton" data-bs-toggle="modal" data-bs-target="#editEventModal">Edit</button>
                        <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
