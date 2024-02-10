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
                        <label for="title" class="form-label" style="font-weight: 600;">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editTitle" name="title" required maxlength="30">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label" style="font-weight: 600;">Description (Optional)</label>
                        <textarea class="form-control" id="editDescription" name="description" maxlength="50"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label" style="font-weight: 600;">Start at <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="editStartTime" name="startTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label" style="font-weight: 600;">End at <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="editEndTime" name="endTime" required>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary updateButton" id="updateButton">Update</button>
                <button type="button" class="btn btn-danger" id="resetButton2">Reset</button>
            </div>
        </div>
    </div>
</div>
