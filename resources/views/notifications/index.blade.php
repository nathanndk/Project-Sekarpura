@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8"> <!-- Adjust column width as needed -->
            @include('shared.success_message')
            <div class="mt-3">
                @foreach($notifications as $notification)
                <div class="card mb-3{{ $notification->isRead ? '' : ' bg-secondary' }}">
                    <div class="card-body">
                        {{-- <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3> --}}
                        <div class="notification-list{{ $notification->isRead ? '' : ' notification-list--unread' }}">
                            <div class="notification-list_content d-flex align-items-center">
                                <div class="notification-list_img me-3">
                                    <img style="width:50px; height:50px; object-fit: cover;" class="me-2 avatar-sm rounded-circle" src="{{ $notification->user->getImageURL() }}" alt="{{ $notification->user->name }}">
                                </div>
                                <div class="notification-list_detail flex-grow-1">
                                    <p><b>{{ $notification->user_name }}</b> {{ $notification->action }}</p>
                                    <p class="text-muted">{{ $notification->keterangan }}</p>
                                    <p class="text-muted"><small>{{ $notification->created_at->diffForHumans() }}</small></p>
                                </div>
                            </div>
                            @if (!$notification->isRead)
                            <form action="{{ route('notifications.update', $notification) }}" method="POST" class="d-flex justify-content-end">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary btn-sm"> Go to the page </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
