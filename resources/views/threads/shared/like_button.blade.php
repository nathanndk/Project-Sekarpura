

<div>
    @auth

    @if (Auth::user()->likesPost($thread))
    <form method="POST" action="{{route('threads.unlike', $thread->id)}}">
        @csrf
        <button type="submit" class="fw-light nav-link fs-6"> <span class="fas fa-heart me-1">
        </span> {{ $thread->likes()->count() }}
        </button>
    </form>
    @else
    <form method="POST" action="{{route('threads.like', $thread->id)}}">
        @csrf
        <button type="submit" class="fw-light nav-link fs-6"> <span class="far fa-heart me-1">
        </span> {{ $thread->likes()->count() }}
        </button>
    </form>
    @endif
    @endauth
    @guest
    <a href="{{route('login')}}" class="fw-light nav-link fs-6"> <span class="far fa-heart me-1">
        </span> {{ $thread->likes()->count() }}
    </a>
    @endguest
</div>
