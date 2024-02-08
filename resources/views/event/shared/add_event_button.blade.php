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
