<div class="row">
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body pt-3">
                <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                    @if (Auth::user()->role == 3)
                    <li class="nav-item">
                        <a class="{{ Route::is('forum') ? ' text-black' : ''}}" href="{{route('forum')}}">
                            <span>Internal</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::is('forum') ? ' text-black' : ''}}" href="{{route('forum')}}">
                            <span>External</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::is('admin.dashboard') ? ' text-black' : ''}}" href="{{route('admin.dashboard')}}">
                            <span>Approval</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::is('users') ? ' text-black' : ''}}" href="{{route('admin.users')}}">
                            <span>Data Users</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::is('manage-role') ? ' text-black' : ''}}" href="{{route('manageRole')}}">
                            <span>Manage Role</span></a>
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

                    <li class="nav-item">
                        <a class="{{ Route::is('terms') ? ' text-black' : ''}}" href="{{route('terms')}}">
                            <span>Terms</span></a>
                    </li>
                    <div class="card-footer text-center py-2">
                        <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    </div>
                    @else
                    <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    @endif

                </ul>
            </div>

        </div>
    </div>
