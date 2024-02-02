<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">

                    <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                        src="{{ $thread->user-> getImageURL()}}" alt="{{  $thread->created_by }}">
                    <div>
                        <h5 class="card-title mb-0"><a href="{{route('users.show', $thread->user->id)}}">{{  $thread->created_by }}</a></h5>
                    </div>

            </div>
            <div class="d-flex">
                <a href="{{ route('threads.show', $thread->id) }}"> View </a>
                @auth
                    @if(auth()->user()->is($thread->user) || auth()->user()->role == 3)
                        <a class="mx-2" href="{{ route('threads.edit', $thread->id) }}"> Edit </a>
                        <form method="POST" action="{{ route('threads.destroy', $thread->id) }}">
                            @csrf
                            @method('delete')
                            <button class="ms-1 btn btn-danger btn-sm"> X </button>
                        </form>
                    @endif
                @endauth
            </div>


        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        @if ($editing ?? false)
            <form action="{{ route('threads.update', $thread->id) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <textarea class="form-control" id="title" name="title" rows="3">{{ $thread->title }}</textarea>
                    @error('title')
                    <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                    @enderror
                    <textarea class="form-control" id="content" name="content" rows="3">{{ $thread->content }}</textarea>
                    @error('content')
                    <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <button type="submit" class="btn btn-dark"> Update </button>
                </div>
            </form>
        @else
            <h5 class="card-title">{{ $thread->title }}</h5>
            <p class="fs-6 fw-light text-muted">
                {{ $thread->content }}
            </p>
        @endif
        <div class="d-flex justify-content-between">
            @include('threads.shared.like_button')
            <div>
                <span class="fs-6 fw-light text-muted">
                    <span class="fas fa-clock"></span> {{ $thread->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        <div>
            @include('threads.shared.comment_box')
        </div>
    </div>
</div>
