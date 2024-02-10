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
                        <p id="attachmentText" style="display: none; margin-bottom: 10px"><strong>Attachment(s)</strong></p>
                        <input type="file" class="form-control" id="addFileButton" style="display: none;" multiple>
                        <button id="uploadConfirmBtn" style="display: none;">
                            <i class="bi bi-check2 confirm"></i>
                        </button>
                        <button id="cancelUploadBtn" style="display: none;">
                            <i class="bi bi-x-lg cancel"></i>
                        </button>
                    @elseif (Auth::user()->role == 2)
                        <p id="attachmentText" style="display: none; margin-bottom: 10px"><strong>Attachment(s)</strong></p>
                        <input type="file" class="form-control" id="addFileButton" style="display: none;" multiple>
                        <button id="uploadConfirmBtn" style="display: none;">
                            <i class="bi bi-check2 confirm"></i>
                        </button>
                        <button id="cancelUploadBtn" style="display: none;">
                            <i class="bi bi-x-lg cancel"></i>
                        </button>
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
                                    url: '/attachments',
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

                        deleteFileButtons.forEach(function (button) {
                            button.addEventListener('click', function () {
                                var attachmentId = button.closest('.attachment-list-item').getAttribute('data-attachmentid');
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                $.ajax({
                                    url: '/attachments/' + attachmentId,
                                    type: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    success: function (response) {
                                        localStorage.setItem('showSuccessModal5', 'true');
                                        location.reload();
                                    },
                                    error: function (error) {
                                        console.error('Error Deleting Attachment:', error);
                                    }
                                });
                            });
                        });
                    });

                    @auth
                        @if (Auth::user()->role == 3)
                            function toggleAdditionalElements(selectedEventId) {
                                var attachmentText = document.getElementById('attachmentText');
                                var addFileButton = document.getElementById('addFileButton');
                                var additionalElements = document.getElementById('additionalElements');

                                attachmentText.style.display = selectedEventId ? 'block' : 'none';
                                addFileButton.style.display = selectedEventId ? 'block' : 'none';
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
                                var additionalElements = document.getElementById('additionalElements');

                                attachmentText.style.display = selectedEventId ? 'block' : 'none';
                                addFileButton.style.display = selectedEventId ? 'block' : 'none';
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
