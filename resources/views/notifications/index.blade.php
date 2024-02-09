@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            @include('shared.success_message')
            <div class="mt-3">
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <h5 class="card-title">Notification</h5>
                        @foreach($notifications as $notification)
                        <div class="notification-card mb-3 p-3 border{{ $notification->isRead ? '' : ' bg-warning text-black' }}">
                            <p class="mb-1{{ $notification->isRead ? '' : ' text-black' }}">{{ $notification->keterangan }}</p>
                            <p class="text-muted mb-0{{ $notification->isRead ? '' : ' text-black' }}">{{ $notification->created_at->diffForHumans() }}</p>
                            @if (!$notification->isRead)
                            <form action="{{ route('notifications.update', $notification) }}" method="POST" class="d-flex justify-content-end">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary btn-sm"> Go to the page </button>
                            </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
        </div>

    </div>
</div>
@endsection
