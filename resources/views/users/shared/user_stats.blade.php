
<a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-brain me-1">
</span> {{ $user->threads()->count() }} </a>
<a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-comment me-1">
</span> {{ $user->comments()->count() }} </a>
<a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-heart me-1">
</span> {{ $user->likes()->count() }} </a>
