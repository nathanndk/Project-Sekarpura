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
