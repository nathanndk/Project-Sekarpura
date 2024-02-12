@php
    $forum_type_id = request()->get('forum_type_id');
@endphp

@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row">
 @include('layouts.sidebar')
        <div class="col-lg-6">
            @include('shared.success_message')
            @auth
            <div class="text-end mb-3">
                <a href="{{ route('threads.category', ["forum_type_id" => $forum_type_id]) }}" class="btn btn-primary">+ Create a Thread</a>
            </div>
            @endauth
            @guest
            <h4 class="text-center">Login to share your ideas</h4>
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

        <div class="col-lg-3"> <!-- Sidebar -->
            @include('shared.search_bar')
            @include('forum.shared.category')
        </div>
    </div>
</div>
@endsection
