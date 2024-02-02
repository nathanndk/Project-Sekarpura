@extends('layouts.header')

@section('content')
    <div class="container py-4">
            @include('layouts.sidebar')
            <div class="col-6">
                @include('shared.success_message')
                {{-- hilangkan tombol submit thread jika role admin --}}
                @auth()
                @if (Auth::user()->role == 3)
                @else
                <a href="submit_thread" class="btn btn-primary mb-3">+ Create a Thread</a>
                @endif
                @endauth
                @guest()
                <h4>Login to share your ideas</h4>
                @endguest
                @forelse ($threads as $thread)
                <div class="mt-3">
                    @include('threads.shared.thread_card')
                </div>
                @empty
                <p class="text-center my-3">No results found</p>
                @endforelse
                <div class="mt-3">
                    {{ $threads->withQueryString()->links() }}
                </div>
            </div>
            <div class="col-3">
                @include('shared.search_bar')
                {{-- @include('shared.follow_box') --}}
            </div>
        </div>
    </div>
 @endsection
