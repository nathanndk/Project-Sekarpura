<div class="row">
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body pt-3">
                <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                    @auth
                    @if (Auth::user()->role == 3)
                    <li class="nav-item">
                        <a class="{{ Route::is('admin.dashboard') ? ' text-black' : ''}}" href="{{route('admin.dashboard')}}">
                            <span>Approval</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::is('terms') ? ' text-black' : ''}}" href="{{route('terms')}}">
                            <span>Terms</span></a>
                    </li>
                    <div class="card-footer text-center py-2">
                        <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    </div>
                    @elseif (Auth::user()->role == 2)
                    <li class="nav-item">
                        <a class="{{ Route::is('forum') ? ' text-black' : ''}}" href="{{route('forum')}}">
                            <span>Internal</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::is('forum') ? ' text-black' : ''}}" href="{{route('forum')}}">
                            <span>External</span></a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="{{ Route::is('kategori') ? ' text-black' : ''}}" href="{{route('kategori')}}">
                            <span>Kategori</span></a>
                    </li> --}}

                    <li class="nav-item">
                        <a class="{{ Route::is('terms') ? ' text-black' : ''}}" href="{{route('terms')}}">
                            <span>Terms</span></a>
                    </li>
                    <div class="card-footer text-center py-2">
                        <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    </div>
                    @else
                    {{-- <li class="nav-item">
                        <a class="{{ Route::is('kategori') ? ' text-black' : ''}}" href="{{route('kategori')}}">
                            <span>Kategori</span></a>
                    </li> --}}
                    <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    @endif
                    @endauth
                    @guest
                    @endguest
                </ul>
            </div>

        </div>
    </div>
