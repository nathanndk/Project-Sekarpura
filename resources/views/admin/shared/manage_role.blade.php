
@extends('layouts.header')


@section('content')
<div class="container py-4">
    <div class="row">
        @include('layouts.sidebar')

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-4">Manage Role</h2>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('updateRole') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">Select User</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="user_id" required class="form-control" style="border: 1px solid;">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <label for="">Select Role</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="role_id" required class="form-control" style="border: 1px solid;">
                                        <option value="">Select Role</option>
                                        @foreach ($roles->where('id', '!=', 3) as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="submit" value="Update Role" class="btn btn-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
