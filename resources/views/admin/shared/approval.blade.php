<div class="card mb-3">
    <div class="card-body px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center mb-2">
                <img style="width:50px; height:50px; object-fit: cover;" class="me-2 avatar-sm rounded-circle" src="{{ $thread->user->getImageURL() }}" alt="{{ $thread->user->name }}">
                <div>
                    <h5 class="card-title mb-0"><a href="{{ route('users.show', $thread->user->id) }}" class="text-dark text-decoration-none">{{ $thread->user->name }}</a></h5>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if(Route::currentRouteName() != 'threads.show')
                        <li><a class="dropdown-item" href="{{ route('threads.show', $thread->id) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                    @endif
                    @auth
                        @if(auth()->user()->is($thread->user) || auth()->user()->role == 3)
                            <li><a class="dropdown-item" href="{{ route('threads.edit', $thread->id) }}"><i class="fas fa-pencil-alt me-2"></i>Edit</a></li>
                            <li>
                                <form method="POST" action="{{ route('threads.destroy', $thread->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item" type="submit"><i class="fas fa-times me-2"></i>Delete</button>
                                </form>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
        <hr> <!-- Garis pemisah -->
        <div>
            @if ($editing ?? false)
                <form action="{{ route('threads.update', $thread->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <textarea class="form-control" id="title" name="title" rows="3">{{ $thread->title }}</textarea>
                        @error('title')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                        <textarea class="form-control mt-2" id="content" name="content" rows="3">{{ $thread->content }}</textarea>
                        @error('content')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-dark">Update</button>
                    </div>
                </form>
            @else
                <h5 class="card-title">{{ $thread->title }}</h5>
                <p class="fs-6 fw-light text-muted">
                    {{ $thread->content }}
                </p>
            @endif
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <span class="fs-6 fw-light text-muted">
                <i class="fas fa-clock me-1"></i>{{ $thread->created_at->diffForHumans() }}
            </span>
            @if ($thread->status === 'pending')
            <div>
                <form action="{{ route('threads.approve', $thread->id) }}" method="post" class="mb-2 me-2">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Approve
                    </button>
                </form>
                <form action="{{ route('threads.reject', $thread->id) }}" method="post" class="mb-2">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Reject
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
