<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width: 150px; height: 150px; object-fit: cover;" class="me-3 avatar-sm rounded-circle"
                src="{{ $user->getImageURL() }}" alt="{{ $user->name }}">
                <div>
                    <h3 class="card-title mb-0"><a href="#" class="text-black text-decoration-none"> {{ $user->name }}</a></h3>
                    <span class="fs-6 text-muted">{{ $user->nip }}</span>
                </div>
            </div>
            @auth
            @if (Auth::id() === $user->id)
            <a href="{{ route('users.edit', $user->id) }}" class="text-black text-decoration-none">Edit</a>
            @endif
            @endauth
        </div>
        <div class="px-2 mt-4">
            <h5 class="fs-5"> Bio : </h5>
            <p class="fs-6 fw-light">
                {{ $user->bio }}
            </p>
            <div class="d-flex justify-content-start">
                @include('users.shared.user_stats')
            </div>

            @auth
            @if (Auth::id() !== $user->id)
            <div class="mt-3">
                <button class="btn btn-primary btn-sm"> Follow </button>
            </div>
            @endif
            @endauth
        </div>
    </div>
</div>

<hr>
