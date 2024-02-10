<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link href="https://bootswatch.com/5/litera/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark ticky-top bg-body-tertiary"
        data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-light" href="/">
                <img src="/sekarpura.png" alt="AP2" class="logo me-1" style="width: 75px; height: auto;">
                {{ config('app.name') }}
            </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        @if (Auth::user()->role == 3)
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('events.index')) ? 'active' : '' }}" href="{{ route('events.index') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('forum', ["forum_type_id"=>2])) ? 'active' : '' }}" href="{{ route('forum', ["forum_type_id"=>2]) }}">Forum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.approval', ["forum_type_id" => 2]) ? 'active' : '' }}" href="{{ route('admin.approval', ["forum_type_id" => 2]) }}">Approval</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('cluster')) ? 'active' : '' }}" href="{{ route('cluster') }}">Admin Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('notifications')) ? 'active' : '' }}" href="{{ route('notifications') }}">Notifications</a>
                        </li>
                        @elseif (Auth::user()->role == 2)
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('forum', ["forum_type_id"=>2])) ? 'active' : '' }}" href="{{ route('forum', ["forum_type_id"=>2]) }}">Forum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (Route::is('notifications')) ? 'active' : '' }}" href="{{ route('notifications') }}">Notifications</a>
                        </li>
                        @elseif (Auth::user()->role == 1)
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::is('forum', ["forum_type_id"=>2])) ? 'active' : '' }}" href="{{ route('forum', ["forum_type_id"=>2]) }}">Forum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::is('notifications')) ? 'active' : '' }}" href="{{ route('notifications') }}">Notifications</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="{{ (Route::is('login')) ? 'active' : '' }} nav-link" aria-current="page" href="{{ route('login')}}">Login</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="{{ (Route::is('profile')) ? 'active' : '' }} nav-link" href="{{ route('profile')}}">{{ Auth::user()->username }}</a>
                        </li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-sm mt-2" type="submit">Logout</button>
                        </form>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

</body>

</html>

<!-- Copyright notice -->

<div class="text-center mt-5">
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
</div>
