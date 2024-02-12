@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row">
@include('layouts.sidebar_cluster')

        <div class="col-lg-9 col-md-8 col-sm-6"> <!-- Main Content -->
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-4">Users Account</h2>
                    <form id="searchForm">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search by name, NIP, or email" name="search" id="searchInput">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->unit }}</td>
                                    <td>{{ $user->roles->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- End Main Content -->
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchForm = document.getElementById('searchForm');
        const usersTable = document.getElementById('usersTable');
        const searchInput = document.getElementById('searchInput');

        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const searchQuery = searchInput.value.trim().toLowerCase();

            Array.from(usersTable.getElementsByTagName('tr')).forEach(function(row, index) {
                if (index === 0) return; // Skip table header row
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let i = 0; i < cells.length; i++) {
                    const cellText = cells[i].textContent.toLowerCase().trim();
                    if (cellText.includes(searchQuery)) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        searchInput.addEventListener('input', function() {
            const searchQuery = searchInput.value.trim().toLowerCase();

            Array.from(usersTable.getElementsByTagName('tr')).forEach(function(row, index) {
                if (index === 0) return; // Skip table header row
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let i = 0; i < cells.length; i++) {
                    const cellText = cells[i].textContent.toLowerCase().trim();
                    if (cellText.includes(searchQuery)) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
