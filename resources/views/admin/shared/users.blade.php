@extends('layouts.header')


@section('content')
<div class="container py-4">
    <div class="row">
        @include('layouts.sidebar_cluster')
        <h2 class="mb-4">Users</h2>

        <table class="table table-bordered">
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
@endsection
