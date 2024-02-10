@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row">

            @include('layouts.sidebar_cluster')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-4">Users Account</h2>
                </div>

                <div class="card-body">

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
    </div>
</div>
@endsection
