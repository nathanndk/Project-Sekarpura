@auth
<div class="row">
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body pt-3">
                <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                    @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                    <li class="nav-item">
                        <a class="{{ Route::is('forum') ? ' text-black' : ''}}" href="{{route('forum')}}">
                            <span>Internal</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::is('forum') ? ' text-black' : ''}}" href="{{route('forum')}}">
                            <span>External</span></a>
                    </li>
                    @else
                    @endif
                    <div class="card-footer text-center py-2">
                        <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    @endauth

