<div class="col-lg-3 col-md-4 col-sm-6 mb-4"> <!-- Sidebar -->
    @auth
    <div class="card border-0 shadow-sm"> <!-- Menambahkan border dan shadow untuk tampilan yang lebih menarik -->
        <div class="card-body pt-3">
            <ul class="nav flex-column fw-bold gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.users') ? 'text-black' : 'text-muted' }}" href="{{ route('admin.users') }}">
                        <i class="fas fa-users me-2"></i> <!-- Tambahkan icon untuk setiap link -->
                        <span>Users Account</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('manageRole') ? 'text-black' : 'text-muted' }}" href="{{ route('manageRole') }}">
                        <i class="fas fa-cogs me-2"></i>
                        <span>Manage Role</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('cluster') ? 'text-black' : 'text-muted' }}" href="{{ route('cluster') }}">
                        <i class="fas fa-database me-2"></i>
                        <span>Data Cluster</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endauth
</div> <!-- End Sidebar -->
