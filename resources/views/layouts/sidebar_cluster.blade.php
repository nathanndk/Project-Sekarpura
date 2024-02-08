@auth
<div class="row">
    <div class="col-3">
        <div class="card overflow-hidden">
            <div class="card-body pt-3">
                <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                    <li class="nav-item">
                        <a class="{{ Route::is('users') ? ' text-black' : ''}}" href="{{route('admin.users')}}">
                            <span>Users Account</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::is('manage-role') ? ' text-black' : ''}}" href="{{route('manageRole')}}">
                            <span>Manage Role</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::is('cluster') ? ' text-black' : ''}}" href="{{route('cluster')}}">
                            <span>Data Cluster</span></a>
                    </li>
                    <div class="card-footer text-center py-2">
                        <a class="btn btn-link btn-sm{{ Route::is('profile') ? ' text-black' : ''}}" href="{{route('profile')}}">View Profile </a>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    @endauth

